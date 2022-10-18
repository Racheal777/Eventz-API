<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizerRequest;
use App\Models\Organizer;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    //

    use ImageUploadTrait;

    //add organizer
    public function created(OrganizerRequest $request)
    {
        $organizer = new Organizer();

        //add image
        $file = '';
        if($request->hasFile('image')){
           $flier = $request->file('image');
           $new_name = rand() . '.' .$flier->getClientOriginalExtension();
           $folder = 'public/organizer';
           $file = $this->uploadSingle($flier, $folder, $new_name);
           $organizer->flier = $file;     
       }

        $organizer->name = $request->input('name');
        $organizer->email = $request->input('email');
        $organizer->password = $request->input('password');
        $organizer->location = $request->input('location');
        $organizer->contact = $request->input('contact');
        $organizer->descrition = $request->input('description');
        $organizer->image = $file;

        $organizer->save();

        $token = $organizer->createToken($organizer->name);
        $accessToken = $token->accessToken;

      
        return response()->json([
            'data' => $organizer,
            'token' => $accessToken,

        ]);

    }
}
