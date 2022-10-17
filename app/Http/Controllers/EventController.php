<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allEvents()
    {
        //display all events
        $events = Event::all();
        // $carbon = new Carbon();
        // $today=  $carbon::today();
        // $events = DB::table('events')->where('date', $today)->get();

        // $carbon = new Carbon();
        // return $carbon::yesterday();
        return $events;
    }


    public function daysEvent()
    {

    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        //
        //check if user is an authenticated
        

        // //check if user is an agent
        // $agent = $user->role;

        // //if the role is user dont authorize
        // if($agent === 'user'){

        //    // return $user;
        //     return 'not authorized';

        // }else{

            //return $user;

        
        $event = new Event();

        $user = auth()->user();
        //image upload 
        //using the image trait upload single which is a function that takes the file, path and filename
      
        $file = '';
         if($request->hasFile('flier')){
            $flier = $request->file('flier');
            $new_name = rand() . '.' .$flier->getClientOriginalExtension();
            $folder = 'public/uploads';
            $file = $this->uploadSingle($flier, $folder, $new_name);
            $event->flier = $file;     
        }

          $event->name = $request->input('name');
          $event->location = $request->input('location');
          $event->date = $request->input('date');
          $event->time = $request->input('time');
          $event->category = $request->input('category');
          $event->organizer = $request->input('organizer');
          $event->flier = $file;
          $event->user_id = $user->id;

          if($event->save()){
            return $event;
          } else{
            return 'nothing saved';
          };

        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
        $event->delete();
    }



    public function byAdmin(User $user)
    {
        //find if the user is authenticated
        // $user = auth()->user();
   
        // //check if user is an agent
        // $agent = $user->role;

        // //if the role is user dont authorize
        // if($agent === 'user'){
        //     return 'not authorized';

        // }else{

            //return 'yeieeiie';
             $events = DB::table('events')->where('user_id', $user->id)->get();

             return $events;
        }

    
}
