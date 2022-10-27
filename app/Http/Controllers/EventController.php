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
use App\Http\Resources\EventCollection;
use Illuminate\Support\Facades\Cache;
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

        //cache the data from the database

        //$value = Cache::store('file')->get('foo');
       $cached = Cache::store('file')->put( 'events', $events, 600);

       //if data is cached, return the cached data else return from the database
       if($cached){
        $value = Cache::get('events');

        return response()->json([
            'cached data' => $value
        ]) ;
       }else{
        return $events;
       }
       
    //if item is not cached, remember to cach it and return it
    // 'events is the key, 400 is the seconds
    //    $value = Cache::remember('events', 400, function () {
    //     DB::table('events')->get();

       
    // });

    // return $value;
       
       
        //return $cachedItem;
        //return $events;
    }


    public function daysEvent()
    {

        //get todays event
       // $events = Event::all();
        
        //get the date
        $carbon = new Carbon();
        $today = $carbon::today();

        //get events that has todays date
        $event = DB::table('events')->where('date',$today)->get();

        return $event;
    }


    //function to display all events in a week
    public function weeklyEvents()
    {
        
        //create an empty array
        //loop for the number of days in a week
        // $name = [];
        // $names = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        // for($i = 0; $i < count($names); $i++) {
        //    $name[] = $i;
            
        // }

        $allDays = [];
        for($i = 0; $i < 7; $i++){
            $allDays[] = Carbon::now()->addDays($i)->format('Y/M/d');   
        }

        $str = implode(',  ',  $allDays);

        return $str;

        $events = DB::table('events')->get();

       // return $event;

        foreach($events as $event){
            $event = DB::table('events')->where('date', $allDays)->get();
   
            return  response()->json([
                'Today' => $event
            ]);
        }
        //$event = DB::table('events')->where('date',Carbon::now())->get();

        return $event;



    
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request, User $user)
    {
        
        $event = new Event();

        //check the authenticated organizer
        $user = auth()->user();

        if(!$user->is_organizer){
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
