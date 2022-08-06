<?php

namespace App\Http\Controllers\admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateAdminRequest;
use App\Http\Controllers\Traits\GeneralClass;

class AdminController extends FilterController
{
    use GeneralClass;

    public function admin(Request $request)
    {
        abort_unless($this->checkPermission('View Admin'), 403);
        $query = $this->filterAdminData($request);
        $data['pageData'] = $query->paginate(10);
        $data['pageTitle'] = "Admin Users";

        return view('admin.user.admin', compact('data'));
    }

    public function create_admin()
    {
        abort_unless($this->checkPermission('Create Admin'), 403);
        $data['action'] = "Add";
        $data['pageTitle'] = "Add Admin User";
        $data['roleList'] = Role::all();

        return view('admin.user.admin_action', compact('data'));
    }

    public function store_admin(CreateAdminRequest $request)
    {
        abort_unless($this->checkPermission('Create Admin'), 403);
        $input = $request->all();
        $ROLE_OF_ADMIN = $input['role'];
        unset($input['role']);
        Admin::Create($input)->assignRole($ROLE_OF_ADMIN);

        return redirect()->route('admin.admin')->with('success', 'Data Added Successfuly');
    }

    public function edit_admin($id)
    {
        abort_unless($this->checkPermission('Edit Admin'), 403);
        $data['action'] = "Edit";
        $data['pageData'] = Admin::find($id);
        $data['pageTitle'] = "Edit Admin";
        $data['RollName'] = $data['pageData']->getRoleNames()->toArray()[0];
        $data['roleList'] = Role::all();

        return view('admin.user.admin_action',compact('data'));
    }

    public function update_admin($id, CreateAdminRequest $request)
    {
        abort_unless($this->checkPermission('Edit Admin'), 403);
        $adminUser = Admin::find($id);
        $input = $request->input();
        $roleOfAdmin = Role::where('name', $input['role'])->get();
        unset($input['role']);
        $input['password'] = (! empty($input['password'])) ? Hash::make($input['password']) : $adminUser->password;
        $adminUser->update($input);
        $adminUser->assignRole($roleOfAdmin);

        return redirect()->route('admin.admin')->with('success', 'Data Updated Successfuly');
    }

    public function destroy_admin(Request $request)
    {
        abort_unless($this->checkPermission('Delete Admin'), 403);
        $dataTobeDelete = Admin::find($request->dataId);
        $dataTobeDelete->delete();
        echo 1;
    }
}
