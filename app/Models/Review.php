<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'ratings',
        'user_id'
    ];

    //create the polymorphic relationship between the other models
    public function reviewable()
    {
       return $this->morphTo();
    }

    //define the user and the review relationship
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
