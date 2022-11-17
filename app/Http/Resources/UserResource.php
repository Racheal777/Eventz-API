<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $favorite = new FavoriteCollection($this->favorites);
        return 
        [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'is_organizer' =>  $this->is_organizer,
            'image' => $this->is_organizer ? $this->organizer->image : null,
            'location' => $this->is_organizer ? $this->organizer->location : null,
            'contact' => $this->is_organizer ? $this->organizer->contact : null,
            'description' => $this->is_organizer ? $this->organizer->description : null,
            "Favorites" => $favorite,
             'reviews' => $this->reviews,
        ];
    }
}
