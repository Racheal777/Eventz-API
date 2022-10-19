<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EventRequest;
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
        
        $event = new Event();

        //check the authenticated organizer
        $user = auth()->user();

        if(!$user->is_organizer){
            //return 'not organizer';
            return response()->json([
                'error' => 'user is not an organizer'
               
            ], 401);
        }else{
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
          $event->flier = $file;
         // $event->published = $request->input('published');
          $event->organizer_id = $user->id;

          if($event->save()){
            return $event;
          } else{
            return 'nothing saved';
          };
        }
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
    public function update(Request $request, Event $event)
    {
        //
        $events = $event->update(['name' => $request->input('name')]);

        return $events;
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
       
            //return 'yeieeiie';
             $user = auth()->user();
             $events = DB::table('events')->where('organizer_id', $user->id)->get();

             return $events;
        }

    
}
