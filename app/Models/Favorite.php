<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
       
    ];


    //relationship with the users
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }
}
