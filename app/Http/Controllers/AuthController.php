<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Bridge\AccessToken;

class AuthController extends RestController
{
    /**
     * @bodyParam username string
     * @bodyParam email string
     * @bodyParam password string
     * @bodyParam r_password string Repeat the password
     */
    public function signup(Request $request)
    {
        Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => 'required',
            'r_password' => 'required|same:password',
        ])->validate();

        return User::create([
            'name' => $request['username'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
    }

    /**
     * @bodyParam email string
     * @bodyParam password string
     */
    public function login(Request $request)
    {
        if (Auth::attempt($request->all())) {
            $user = Auth::user();
            $data['token'] = $user->createToken('Bearer')->accessToken;
            $data['username'] = $user['name'];
            return $this->response($data, '');
        } else {
            return $this->error('Unauthorised');
        }
    }
}
