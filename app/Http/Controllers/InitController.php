<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class InitController extends Controller
{
    public function initialize()
    {
        //Permission Creation
        if (DB::table('permissions')->get()->count() == 0 ) {
            $modules = [
                'Role',
                'Admin',
                'User',
                'Category',
                'SubCategory',
                'Product',
                'Pages',
                'Store',
                'Banner',
            ];

            foreach ($modules as $moduleName) {

                Permission::create([
                    'name' => 'Create ' . $moduleName,
                    'guard_name' => 'admin'
                ]);

                Permission::create([
                    'name' => 'View ' . $moduleName,
                    'guard_name' => 'admin'
                ]);

                Permission::create([
                    'name' => 'Edit ' . $moduleName,
                    'guard_name' => 'admin'
                ]);

                Permission::create([
                    'name' => 'Delete ' . $moduleName,
                    'guard_name' => 'admin'
                ]);
            }
        }

        //Role Creation
        if (DB::table('roles')->get()->count()  == 0) {
            $role = Role::create([
                'name' => 'Super Admin',
                'guard_name' => 'admin',
            ]);
        }

        //Role Permission Creation
        if (DB::table('role_has_permissions')->get()->count() == 0) {
            $user = DB::table('admin')->where(['status' => 'Active'])->get();
            $role = Role::first();
            $role->givePermissionTo('Create Role');
            $role->givePermissionTo('View Role');
            $role->givePermissionTo('Edit Role');
            $role->givePermissionTo('Delete Role');
            $role->givePermissionTo('Create Admin');
            $role->givePermissionTo('View Admin');
            $role->givePermissionTo('Edit Admin');
            $role->givePermissionTo('Delete Admin');
        }

        if (DB::table('model_has_roles')->get()->count() == 0) {
            $role = Role::first();
            $user = Admin::first();
            $user->assignRole($role);
        }

        return true;
    }

}
