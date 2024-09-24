<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $permission = Permission::firstOrCreate([
            'name' => '*',
            'guard_name' => 'admin',
        ]);

        $role = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'admin',
        ]);
        $role->syncPermissions($permission);

        $user = User::firstOrCreate([
            'email' => config('mail.mailers.smtp.username'),
        ], [
            'password' => Hash::make(
                $password = Str::random(6),
            ),
        ]);
        $user->assignRole($role->name);

        $this->info("Login: {$user->email}.");
        $this->info("Password: {$password}.");
    }
}
