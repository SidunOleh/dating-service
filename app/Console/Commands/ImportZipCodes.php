<?php

namespace App\Console\Commands;

use App\Models\ZipCode;
use Illuminate\Console\Command;

class ImportZipCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zip:import {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import zip codes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ZipCode::truncate();

        $file = fopen($this->argument('path'), 'r');
        
        while (($row = fgetcsv($file)) !== false) {
            $zip = ZipCode::create([
                'zip' => $row[0],
                'latitude' => $row[1],
                'longitude' => $row[2],
            ]);
            $this->info("zip: {$zip->zip}");
        }
    }
}
