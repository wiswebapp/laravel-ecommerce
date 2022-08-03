<?php

namespace App\Http\Controllers\admin;

use App\User;
use Illuminate\Http\Request;
use App\Events\UserRegister;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Controllers\Traits\GeneralClass;

class UserController extends FilterController
{
    use GeneralClass;

    public function user(Request $request) {
        abort_unless($this->checkPermission('View User'), 403);
        $query = $this->filterUserData($request);
        $data = $this->renderResponse('Register Users', [
            'pageData' => $query->paginate(10)->appends($request->query()),
        ]);

        return view('admin.user.users')->with('data', $data);
    }

    public function create_user() {
        abort_unless($this->checkPermission('Create User'), 403);
        $data = $this->renderResponse('Add Register User', [
            'action' => "Add",
            'country' => $this->getCountry(),
        ]);

        return view('admin.user.users_action')->with('data', $data);
    }

    public function store_user(UserStoreRequest $request) {
        abort_unless($this->checkPermission('Create User'), 403);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        if ($user) {
            if ($user->status == "Active"){
                UserRegister::dispatch($user);
            }
            return redirect()->route('admin.user')->with('success','Data Updated Successfuly');
        } else {
            return redirect()->route('admin.user')->with('danger','Whoops..! Some error occured !');
        }
    }

    public function edit_user($id) {
        abort_unless($this->checkPermission('Edit User'), 403);
        $data = $this->renderResponse('Edit Register User', [
            'action' => "Edit",
            'pageData' => User::find($id),
            'country' => $this->getCountry(),
        ]);

        return view('admin.user.users_action')->with('data', $data);
    }

    public function update_user(UserStoreRequest $request, $id) {
        abort_unless($this->checkPermission('Edit User'), 403);
        $user = User::find($id);
        $input = $request->all();
        if ($input['password'] == null) {
            unset($input['password']);
        } else {
            $input['password'] = Hash::make($input['password']);
        }
        $user->update($input);

        return redirect()->route('admin.user')->with('success', 'Data Updated Successfuly');
    }

    public function destroy_user(Request $request) {
        abort_unless($this->checkPermission('Delete User'), 403);
        $dataTobeDelete = User::find($request->dataId);
        if ($dataTobeDelete->delete()) {
            return true;
        }

        return false;
    }

    public function destroy_multiple_user(Request $request) {
        abort_unless($this->checkPermission('Delete User'), 403);
        $requestData = $request->all();
        $selectedIds = $requestData['selectedIds'];

        $dataTobeDelete = User::whereIn('id', $selectedIds);
        if ($dataTobeDelete->delete()) {
            return true;
        }

        return false;
    }
}
