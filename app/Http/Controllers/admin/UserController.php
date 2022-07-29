<?php

namespace App\Http\Controllers\admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\GeneralClass;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;

class UserController extends FilterController
{
    use GeneralClass;

    public function user(Request $request) {
        abort_unless($this->checkPermission('View User'), 403);
        $query = $this->filterUserData($request);
        //Assiging Data to context
        $data['pageData'] = $query->paginate(10)->appends($request->query());
        $data['pageTitle'] = "Register Users";

        return view('admin.user.users')->with('data', $data);
    }

    public function create_user() {
        abort_unless($this->checkPermission('Create User'), 403);
        $data['action'] = "Add";
        $data['pageTitle'] = "Add Register User";
        $data['country'] = $this->getCountry();

        return view('admin.user.users_action')->with('data',$data);
    }

    public function store_user(UserStoreRequest $request) {
        abort_unless($this->checkPermission('Create User'), 403);
        $user = new User();
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user->fill($input)->save();

        return redirect()->route('admin.user')->with('success','Data Updated Successfuly');
    }

    public function edit_user($id) {
        abort_unless($this->checkPermission('Edit User'), 403);
        $data['action'] = "Edit";
        $data['pageData'] = User::find($id);
        $data['pageTitle'] = "Edit Register User";
        $data['country'] = $this->getCountry();

        return view('admin.user.users_action')->with('data',$data);
    }

    public function update_user(UserStoreRequest $request,$id) {
        abort_unless($this->checkPermission('Edit User'), 403);
        $user = User::find($id);
        $input = $request->all();
        if($input['password'] == null){
            unset($input['password']);
        }else{
            $input['password'] = Hash::make($input['password']);
        }
        $user->fill($input)->save();

        return redirect()->route('admin.user')->with('success','Data Updated Successfuly');
    }

    public function destroy_user(Request $request) {
        abort_unless($this->checkPermission('Delete User'), 403);
        $dataTobeDelete = User::find($request->dataId);
        if($dataTobeDelete->delete()) {
            return true;
        }

        return false;
    }

    public function destroy_multiple_user(Request $request) {
        abort_unless($this->checkPermission('Delete User'), 403);
        $requestData = $request->all();
        $selectedIds = $requestData['selectedIds'];

        $dataTobeDelete = User::whereIn('id', $selectedIds);
        if($dataTobeDelete->delete()) {
            return true;
        }

        return false;
    }
}
