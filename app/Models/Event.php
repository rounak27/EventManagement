<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    use HasFactory;
    protected $fillable = [
        'title', 'description', 'start_date', 'end_date', 'user_id'
    ];

    // Define relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);

    }
    public function hashtags()
    {
        return $this->hasMany(Hashtag::class);
    }
}
