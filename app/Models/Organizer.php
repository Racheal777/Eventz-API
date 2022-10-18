<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organizer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'contact',
        'password',
        'image',
        'location',
        'description',
        
    ];

    //describe the relationship
    public function review()
    {
        return $this->morphOne(Review::class, 'reviewable');
    }

    //events relationship
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
