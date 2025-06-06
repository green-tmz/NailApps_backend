<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class setAdminPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-admin-permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'NailApps. Setting administrator rights';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $role = Role::firstOrCreate(['name' => 'admin']);
        $permissioms = Permission::all();
        $role->givePermissionTo($permissioms);

        $this->call('permission:show');
    }
}
