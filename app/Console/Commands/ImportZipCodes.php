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
        
        while (($row = fgetcsv($file, null, "\t")) !== false) {
            $zip = ZipCode::create([
                'zip' => $row[1],
                'city' => $row[2],
                'state' => $row[4],
                'latitude' => $row[9],
                'longitude' => $row[10],
            ]);

            $this->info("zip: {$zip->zip}");
        }
    }
}
