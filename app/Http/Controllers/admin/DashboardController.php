<?php

namespace App\Http\Controllers\admin;

use App\User;
use App\Product;
use App\Category;
use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DashboardController extends Controller
{
    public function initializeApp()
    {
        $user = Auth::user();
        $role = Role::create(['name' => 'Super Admin']);
        $role->givePermissionTo('Create Role');
        $role->givePermissionTo('View Role');
        $role->givePermissionTo('Edit Role');
        $role->givePermissionTo('Delete Role');
        $role->givePermissionTo('Create Admin');
        $role->givePermissionTo('View Admin');
        $role->givePermissionTo('Edit Admin');
        $role->givePermissionTo('Delete Admin');
        $user->assignRole('Super Admin');
    }

    public function index()
    {
        $data['userCount'] = User::all()->whereNull('deleted_at')->count();
        $data['productCount'] = Product::all()->whereNull('deleted_at')->count();
        $data['categoryCount'] = Category::all()->where('parent_id',0)->whereNull('deleted_at')->count();
        $data['subCategoryCount'] = Category::all()->where('parent_id','!=',0)->whereNull('deleted_at')->count();
        return view('admin.dashboard')->with('data',$data);
    }

    public function getUserData()
    {
        $data['userData'] = User::all()->whereNull('deleted_at')->take(10);
        return $data;
    }
}
