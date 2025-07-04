<?php

namespace App\Console\Commands;

use App\Models\Ad;
use App\Models\Creator;
use App\Models\Image;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Process\Pool;
use Illuminate\Support\Facades\Process;

class SeedApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed {--processes=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed app test data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($processes = (int) $this->option('processes')) {
            return $this->spawn($processes);
        }

        $this->createCreators(100);

        $this->createAds(30);
    }

    private function createCreators(int $count): void
    {
        $images = Image::all();

        for ($i=0; $i < $count; $i++) { 
            try {
                Creator::factory()->create([
                    'photos' => $images->random(rand(1, 12))->pluck('id')->all(),
                    'verification_photo' => [$images->random()->id, null][rand(0, 1)],
                    'id_photo' => [$images->random()->id, null][rand(0, 1)],
                    'street_photo' => [$images->random()->id, null][rand(0, 1)],
                    'show_on_site' => true,
                    'play_roulette' => true,
                    'profile_is_created' => true,
                ]);
            } catch (Exception) {

            }
        }
    }

    private function createAds(int $count): void
    {
        $images = Image::all();

        for ($i=0; $i < $count; $i++) { 
            try {
                Ad::factory()->create([
                    'image_id' => $images->random()->id,
                ]);
            } catch (Exception) {

            }
        }
    }

    public function spawn(int $processes)
    {
        Process::pool(function (Pool $pool) use($processes) {
            for ($i=0; $i < $processes; $i++) { 
                $pool->timeout(600)->command('php artisan app:seed');
            }
        })->start()->wait();
    }
}
