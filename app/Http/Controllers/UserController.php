<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //register function
    public function register(UserRequest $request)
    {
        $user = new User();

        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->role = $request->input('role');

        $user->save();

        //if user is saved, create a token for them
        $token = $user->createToken($user->username);

        // dd($token);
        $accessToken = $token->accessToken;



        return response()->json([
            'data' => $user,
            'token' => $accessToken,

        ]);
    }


    //login
    public function login(Request $request, User $user)
    {


        $loginDetails = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        //if the user attempts to login with these details and also make remember me to be true
        if (auth()->attempt($loginDetails, $request->get('remember'))) {

            //create a token for the authenticated user
            $user = auth()->user();
            //if user is saved, create a token for them
            $token = $user->createToken($user->username);
            // dd($token);
            $accessToken = $token->accessToken;

            return response()->json([
                'data' => $user,
                'token' => $accessToken,

            ]);
        } else {
            return response()->json([
                'message' => 'incorrect credentials'
            ]);
        }
    }
}
