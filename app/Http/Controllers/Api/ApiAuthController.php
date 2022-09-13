<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends ApiGeneralController
{
    /**
     * Function description
     *
     * @param int variable Description $variable comment about this variable
     *
     * @return array
     */
    public function register(Request $request)
    {
        $success = false;
        $message = "User Registration Failed !";
        $data = $request->validate([
            'fname' => 'required|max:255',
            'lname' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $data['password'] = bcrypt($request->password);
        $user = User::create($data);
        if($user) {
            $success = true;
            $message = "User Registration Success !";
        }


        return $this->returnResponse([
            'message' => $message,
            'userDetail' => $user,
        ], $success);
    }

    public function login(Request $request)
    {
        $accessToken = "";
        $success = false;
        $message = "Email/Password is Incorrect.Please try again";
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (auth()->attempt($data)) {
            $accessToken = auth()->user()->createToken('API Token')->accessToken;
            $success = true;
            $message = "Login Success";
            $user = auth()->user();
            $user->access_token  = $accessToken;
        }

        return $this->returnResponse([
            'message' => $message,
            'userDetail' => $user,
        ], $success);
    }
}
