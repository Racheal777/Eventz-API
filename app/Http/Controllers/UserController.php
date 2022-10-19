<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\UserRequest;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ImageUploadTrait;
    //register function
    public function register(Request $request)
    {
        $user = new User();
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users', 'string'],
            'password' => ['min: 6', 'required', 'confirmed'],
            'username' => ['required', 'string'],
            'is_organizer' => ['sometimes', 'boolean'],
            'location' => ['string', 'required_if:is_organizer,true'],
            'contact' => ['min:10', 'required_if:is_organizer,true'],
            //'image' => ['image|mimes:jpg,png,jpeg,gif,svg|max:2048', 'required_if:is_organizer,true'],
            'description' => ['string', 'required_if:is_organizer,true']
        ]);

        //$user = new User();

        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        //$user->is_organizer = false;
        $user->save();

        if ($request->is_organizer) {
            //return 'organizer';
            $organizer = new Organizer();

            $file = '';
            if ($request->hasFile('image')) {
                $flier = $request->file('image');
                $new_name = rand() . '.' . $flier->getClientOriginalExtension();
                $folder = 'public/organizer';
                $file = $this->uploadSingle($flier, $folder, $new_name);
                $organizer->image = $file;
            }

            $organizer->location = $request->input('location');
            $organizer->contact = $request->input('contact');
            $organizer->description = $request->input('description');
            $organizer->image = $file;
            $organizer->user_id = $user->id;

            $user->update(['is_organizer' => $request->input('is_organizer')]);
            $organizer->save();

        }

        //if user is saved, create a token for them
        $token = $user->createToken($user->username);

        // dd($token);
        $accessToken = $token->accessToken;


        if ($request->is_organizer) {
            return response()->json([
                'data' => $user,
                'token' => $accessToken,
                'organizer' => $organizer

            ]);
        } else {
            return response()->json([
                'data' => $user,
                'token' => $accessToken
            ]);
        };
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
