<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'category',
        'date',
        'time',
        'flier',
        'organizer_id',
        'published_at'
    ];

    //relationship
    public function organizer(){
        return $this->belongsTo(Organizer::class);
    }

    //describe the relationship
    public function review()
    {
        return $this->morphOne(Review::class, 'reviewable');
    }
}
