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
        'organizer'
    ];

    //relationship
    public function user(){
        return $this->belongsTo(User::class);
    }
}
