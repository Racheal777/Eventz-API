<?php

namespace App\Http\Controllers;

//use App\Models\Subcriber;
use App\Models\Subscriber;
use Illuminate\Http\Request;

use Spatie\Newsletter\NewsletterFacade as Newsletter;


class SubscriberController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate request
        $request->validate([
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
            'email' => ['required', 'email','string'],
            
        ]);

        //add user
        $subscriber = new Subscriber();

        $subscriber->firstname = $request->input('firstname');
        $subscriber->lastname = $request->input('lastname');
        $subscriber->email = $request->input('email');
        $subscriber->tags = 'Visitor';

        //return $subscriber;

        

        //add to the mailchimp
       
        if(Newsletter::isSubscribed($request->email)) {
            return response()->json([
                'message'=> "user already subscribed"
            ], 401);
            
        }else{
            Newsletter::subscribe($request->email, 
            ['FNAME'=>$request->firstname, 'LNAME'=>$request->lastname], 'subscribers',  ['tags' => ['Visitor', 'Visitor']]);
            $subscriber->save();

    
            return response()->json([
                'message' => "email subscribed",
                'data' => $subscriber
            ]);
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
    public function destroy($id)
    {
        //
    }
}
