<?php

namespace App\Services\Posts;

use App\Constants\Posts;
use App\Constants\Transactions;
use App\Events\PostApproved;
use App\Events\PostRejected;
use App\Exceptions\ButtonWasPressedException;
use App\Exceptions\PostIsOpenException;
use App\Exceptions\TooManyAttempsException;
use App\Models\Creator;
use App\Models\Post;
use App\Models\PostsOpen;
use App\Services\Balances\BalancesService;
use App\Services\Images\ImagesService;
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
        DB::beginTransaction();

        $postsOpen = PostsOpen::firstOrCreate([
            'post_id' => $post->id,
            'creator_id' => $creator->id,
        ]);

        if ($postsOpen->open) {
            throw new PostIsOpenException();
        }

        $pressedButtons = $postsOpen->pressed_buttons ?? [];

        if (count($pressedButtons) == 3) {
            throw new TooManyAttempsException();
        }

        if (in_array($pressedButton, $pressedButtons)) {
            throw new ButtonWasPressedException();
        }

        $pressedButtons[] = $pressedButton;
        $postsOpen->update(['pressed_buttons' => $pressedButtons]);

        $tryCount = count($pressedButtons);
        $guessed = $pressedButton == $post->button_number;

        if (($tryCount == 1 or $tryCount == 3) && $guessed) {
            $postsOpen->update(['open' => true]);
        }

        if ($tryCount == 1 && $guessed) {
            $this->balancesService->creditBalance2($creator, 1, Transactions::BALANCE_2_TYPE['blog_open_credit']);
        } else {
            $this->balancesService->debitBalance2($creator, 1, Transactions::BALANCE_2_TYPE['blog_open_debit']);
        }
        
        DB::commit();

        return $post->open;
    }
}