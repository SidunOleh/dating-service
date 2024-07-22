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

        $images = Image::all();

        for ($i=0; $i < 100; $i++) { 
            try {
                Creator::factory()->create([
                    'photos' => $images->random(rand(1, $images->count()))->pluck('id')->all(),
                    'verification_photo' => $images->random()->id,
                    'id_photo' => $images->random()->id,
                    'street_photo' => $images->random()->id,
                    'show_on_site' => true,
                    'play_roulette' => true,
                    'profile_is_created' => true,
                ]);
            } catch (Exception) {
                
            }
        }

        for ($i=0; $i < 30; $i++) { 
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
