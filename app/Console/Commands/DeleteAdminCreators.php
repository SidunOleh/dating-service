<?php

namespace App\Console\Commands;

use App\Models\Creator;
use Illuminate\Console\Command;

class DeleteAdminCreators extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin-creators:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete admin creators';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $affected = Creator::where('created_by_admin', true)->delete();

        $this->info("Deleted {$affected} rows.");
    }
}
