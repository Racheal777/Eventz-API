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
use Illuminate\Support\Facades\Crypt;
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

        //Encrtption
        // $token = Crypt::encryptString('racheal');

        // $decripted = Crypt::decryptString($token);

        // return response()->json([
        //     'crypted' => $token,
        //     'decrypted' => $decripted
        // ]);

    //     $event = '';
    //     $events = DB::table('events')->pluck('date');

    //     foreach($events as $event){   
    //     }

    //     $allDays = [];
    //     for($i = 0; $i < 7; $i++){
    //         $allDays[] = Carbon::now()->addDays($i)->format('Y/M/d');   
    //     }

    //     $str = implode(',  ',  $allDays);

    //     if(in_array($event, $allDays)){
    //         return $event;
    //     }else{
    //         return 'not found';
    //     }
    //    // return $str;
    //     return $events;

        // $events = DB::table('events')->orderBy('date')->lazy()->count();

        // return $events;



        //display all events
        $events = Event::all();

        //cache the data from the database
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
       

    }


    public function daysEvent(Request $request)
    {
        $filter = $request->input('date');
       
       
        //get events that has todays date
         $event = DB::table('events')->where('date', $filter)->get();

         if(count($event) === 0){
            $event = DB::table('events')->where('date', Carbon::now()->format('Y-m-d'))->get();
            return response()->json([
                'data' => $event
            ]);
         }

         return response()->json([
            'data' => $event
        ]);
    }


   

    //function to display all events in a week
    public function weeklyEvents()
    {
        $allDays = [];
        for($i = 0; $i < 7; $i++){
            $allDays[] = Carbon::now()->addDays($i)->format('Y-m-d');   
        }

        $str = implode(',  ',  $allDays);
      
        $events = DB::table('events')->pluck('date');

        $array = (array) $events;
        foreach($array as $num) {
           
           $results = array_intersect($num, $allDays);
                foreach($results as $result){ 
                    
                    $recentEvent = Event::whereIn('date', $results)->orderBy('date')->get();
                    return response()->json([
                        'weeklyEvents' => $recentEvent
                    ]);
                }
           return $results;
            
        }
    
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
     *  Display Events based on categories
     * @param string $category
     */


     public function eventsBaseOnCategory(Request $request)
     {
        $category = $request->input('category');
        $event = DB::table('events')->where('category', $category)->orderBy('date')->orderBy('time')->get();

        if(count($event) === 0){
            return response()->json([
                'message' => 'No event available'
            ]);
        }

        return response()->json([
            'data' => $event
        ]);
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
