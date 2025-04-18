<?php

namespace App\Services\Posts;

use App\Constants\Posts;
use App\Constants\Transactions;
use App\Events\PostApproved;
use App\Events\PostOpenDebitMoney;
use App\Events\PostRejected;
use App\Exceptions\ButtonNotAllowedException;
use App\Exceptions\ButtonWasPressedException;
use App\Exceptions\NotEnoughMoneyException;
use App\Exceptions\PostIsOpenException;
use App\Models\Creator;
use App\Models\Post;
use App\Models\PostsOpen;
use App\Services\Balances\BalancesService;
use App\Services\Images\ImagesService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class PostsService
{
    public function __construct(
        private ImagesService $imagesService,
        private BalancesService $balancesService,
    )
    {
        
    }

    public function create(Creator $creator, array $data): Post
    {
        $images = [];
        foreach ($data['images'] as $image) {
            $images[] = $this->imagesService->upload($creator, $image, true);
        }

        $imagesIds = array_map(fn ($image) => $image->id, $images);

        $post = Post::create([
            'images' => $imagesIds,
            'text' => $data['text'] ?? '',
            'button_number' => $data['button_number'],
            'status' => Posts::STATUS['pending'],
            'creator_id' => $creator->id,
        ]);

        return $post;
    }

    public function approve(Post $post): void
    {
        $post->update(['status' => Posts::STATUS['approved']]);

        PostApproved::dispatch($post);
    }

    public function reject(Post $post, ?string $comment = null): void
    {
        $post->update([
            'status' => Posts::STATUS['rejected'],
            'approve_comment' => $comment,
        ]);

        PostRejected::dispatch($post);
    }

    public function delete(Post $post): void
    {
        $post->delete();
    }

    public function open(Post $post, Creator $creator, int $pressedButton): bool
    {
        if (! $creator->hasEnoughMoney(Posts::POST_OPEN_PRICE, 'balance_2_total')) {
            throw new NotEnoughMoneyException();
        }

        DB::beginTransaction();

        $postsOpen = PostsOpen::firstOrCreate([
            'post_id' => $post->id,
            'creator_id' => $creator->id,
        ]);

        if ($postsOpen->open) {
            throw new PostIsOpenException();
        }

        if (! in_array($pressedButton, [1, 2, 3])) {
            throw new ButtonNotAllowedException();
        }

        $pressedButtons = $postsOpen->pressed_buttons ?? [];

        if (in_array($pressedButton, $pressedButtons)) {
            throw new ButtonWasPressedException();
        }

        $pressedButtons[] = $pressedButton;
        $postsOpen->update(['pressed_buttons' => $pressedButtons]);

        $tryCount = count($pressedButtons);
        $guessed = $pressedButton == $post->button_number;

        if (($tryCount == 1 and $guessed) or $tryCount == 3) {
            $postsOpen->update(['post_open' => true]);
        }

        if ($tryCount == 1 && $guessed) {
            $this->balancesService->creditBalance2($creator, Posts::POST_OPEN_PRICE, Transactions::BALANCE_2_TYPE['blog_open_credit']);
        } else {
            $result = $this->balancesService->debitBalance2($creator, Posts::POST_OPEN_PRICE, Transactions::BALANCE_2_TYPE['blog_open_debit']);
        
            PostOpenDebitMoney::dispatch($creator, $post, $result[1]);
        }
        
        DB::commit();

        $postsOpen->refresh();

        return $postsOpen->post_open;
    }

    public function getPosts(Creator $creator, int $page): Paginator
    {
        $posts = Post::with([
            'postOpen',
            'imagesModels',
        ])->where('status', Posts::STATUS['approved'])
            ->where('creator_id', $creator->id)
            ->orderBy('id', 'DESC')
            ->paginate(perPage: 10, page: $page);

        return $posts;
    }

    public function getMyPosts(Creator $creator, int $page): Paginator
    {
        $posts = Post::with([
            'imagesModels',
        ])->whereIn('status', [Posts::STATUS['approved'], Posts::STATUS['pending']])
            ->where('creator_id', $creator->id)
            ->orderBy('id', 'DESC')
            ->paginate(perPage: 10, page: $page);

        if (
            $page == 1 && 
            $creator->lastPost?->status == Posts::STATUS['rejected'] &&
            now()->subHours(72)->lt($creator->lastPost->created_at)
        ) {
            $posts->prepend($creator->lastPost); 
        }

        return $posts;
    }   
}