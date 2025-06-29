<?php

namespace App\Console\Commands;

use App\Constants\Posts;
use App\Models\Creator;
use App\Models\Post;
use App\Models\ZipCode;
use App\Services\Images\ImagesService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Str;

class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data';

    public function __construct(
        public ImagesService $imagesService
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $spreadsheet = IOFactory::load(storage_path('app/source/data.xlsx'));
        
        $worksheet = $spreadsheet->getActiveSheet();
        
        $i = 0;
        foreach ($worksheet->getRowIterator() as $row) {
            if (++$i < 3) {
                continue;
            }

            try {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
            
                $rowData = [];
                foreach ($cellIterator as $cell) {
                    $rowData[] = $cell->getValue();
                }
            
                $creator = $this->createCreator($rowData);
    
                $this->info("{$i}. Creator: ". $creator->name);
            } catch (Exception $e) {
                Log::error($e);

                $this->error($e->getMessage());
            }
        }
    }

    private function createCreator(array $data): Creator
    {
        $email = strtolower($data[1]).$data[2].'@mail.com';

        $zip = ZipCode::where(['zip' => $data[2]])->firstOrFail();

        $creatorData = [
            'email' => $email,
            'password' => Str::random(10),
            'show_on_site' => true,
            'play_roulette' => true,
            'created_by_admin' => true,
            'profile_is_created' => true,
            'name' => $data[1],
            'age' => $data[4],
            'gender' => 'Woman',
            'description' => $data[3],
            'phone' => $data[5],
            'profile_email' => $data[11],
            'instagram' => $data[9],
            'telegram' => $data[6],
            'snapchat' => $data[8],
            'onlyfans' => $data[10],
            'whatsapp' => $data[7],
            'twitter' => $data[12],
            'zip' => $zip->zip,
            'city' => $zip->city,
            'state' => $zip->state,
            'latitude' => $zip->latitude,
            'longitude' => $zip->longitude,
        ];

        $creator = Creator::firstWhere(['email' => $creatorData['email']]);

        if ($creator) {
            $creator->update($creatorData);
        } else {
            $creator = Creator::create($creatorData);
        }

        $this->updateProfilePhotos($creator, $data);

        $this->updateVerificationStatus($creator);

        $this->upsertPosts($creator, $data);

        return $creator;
    }

    private function updateProfilePhotos(Creator $creator, array $data): void
    {
        $photosDir = $this->getPhotosDir($data);
        $photosNames = scandir($photosDir);
        $photosNames = array_filter($photosNames, fn ($path) => ! in_array($path, ['.', '..',]));
        
        if (count($photosNames) > 4) {
            $photosNames = array_slice($photosNames, 0, round(count($photosNames) / 2));
        }

        $images = [];
        foreach ($photosNames as $photosName) {
            $image = $this->imagesService->createFromLocal($photosDir.'/'.$photosName, $creator);

            $images[] = $image->id;
        }

        $creator->update(['photos' => $images]);
    }

    private function updateVerificationStatus(Creator $creator): void
    {
        if (
            ! $creator->profile_email and
            ! $creator->instagram and
            ! $creator->telegram and
            ! $creator->snapchat and
            ! $creator->onlyfans  and
            ! $creator->whatsapp and
            ! $creator->twitter
        ) {
            return;
        }

        $photo = $creator->photos[0] ?? null;

        if (! $photo) {
            return;
        }

        $creator->update([
            'first_name' => $creator->name,
            'last_name' => $creator->name,
            'birthday' => now()->subYears($creator->age),
            'verification_photo' => $photo,
            'id_photo' => $photo,
            'street_photo' => $photo,
        ]);
    }

    private function upsertPosts(Creator $creator, array $data): void
    {
        $photosDir = $this->getPhotosDir($data);
        $photosNames = scandir($photosDir);
        $photosNames = array_filter($photosNames, fn ($path) => ! in_array($path, ['.', '..',]));
        $photosNames = array_slice($photosNames, round(count($photosNames) / 2));

        foreach ($photosNames as $photosName) {
            $image = $this->imagesService->createFromLocal($photosDir.'/'.$photosName, $creator);

            $post = Post::whereJsonContains('images', $image->id)->first();

            if ($post) {
                continue;
            }

            Post::create([
                'images' => [$image->id],
                'text' => '',
                'button_number' => rand(1, 3),
                'status' => Posts::STATUS['approved'],
                'creator_id' => $creator->id,
                'created_at' => now()->subDays(rand(1, 30)),
            ]);
        }
    }
    
    private function getPhotosDir(array $data): string
    {
        $i = ltrim($data[0], '0');
        $dir = scandir(storage_path('app/source'));
        $path = '';
        foreach ($dir as $item) {
            if (preg_match("/^{$i}(\-| )/", $item)) {
                $path = $item;
            }
        }

        return storage_path('app/source/'.$path);
    }
}
