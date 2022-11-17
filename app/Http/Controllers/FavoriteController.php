<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
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
        //
        $favorite = new Favorite();

        //auth user
        $user = auth()->user();

        // return $user;
        //fetch all user favorites evnt id and put it in an array
        //favorites is from the relationship name
        $userFavorites = $user->favorites()->pluck('event_id')->toArray();

       // return $userFavorites;
        if(in_array($request->event_id, $userFavorites)){
            return response()->json([
                "message" => "Event Already added to favorites"
            ]);
        }

        $favorite->event_id = $request->input('event_id');
        $favorite->user_id = $user->id;

        $favorite->save();

        return response()->json([
            'data' => $favorite
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
