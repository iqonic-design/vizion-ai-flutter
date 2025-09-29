<?php

namespace Database\Seeders\Auth;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $admin = Role::firstOrCreate(['name' => 'admin', 'title' => 'Admin', 'is_fixed' => true]);
        $demo_admin = Role::firstOrCreate(['name' => 'demo_admin', 'title' => 'Demo Admin', 'is_fixed' => true]);
        $user = Role::firstOrCreate(['name' => 'user', 'title' => 'Customer', 'is_fixed' => true]);
    
        // Permission::firstOrCreate(['name' => 'view_backend', 'is_fixed' => true]);
        Permission::firstOrCreate(['name' => 'edit_settings', 'is_fixed' => true]);
        Permission::firstOrCreate(['name' => 'view_logs', 'is_fixed' => true]);

        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $key => $perms) {
            Permission::firstOrCreate(['name' => $key, 'is_fixed' => true]);
        }

        // Assign Permissions to Roles
        $admin->givePermissionTo(Permission::get());
        
        $demo_admin->givePermissionTo(Permission::get());

        $permissionsToRemove = ['view_permission','edit_permission'];
        $demo_admin->revokePermissionTo($permissionsToRemove);
       
      
        Schema::enableForeignKeyConstraints();
         
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('config:cache');

    }
}
