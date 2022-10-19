<?php

namespace App\Http\Resources;

use App\Models\Organizer;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)

   
    {
        // $user = new UserResource($this->user);
        // $organizer = Organizer::find($user);
       
        return 
        [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
           'email' => $this->email,
            'is_organizer' => $this->is_organizer,
            'image' => $this->image,
            'location' => $this->location,
            'contact' => $this->contact,
            'description' => $this->description
        ];
    }
}
