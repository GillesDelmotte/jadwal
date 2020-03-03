<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'title', 'content', 'user_id', 'date'
    ];

    protected $dates = ['created_at', 'published_at', 'updated_at', 'date'];


    public function teachers()
    {
        return $this->belongsToMany(Teacher::class)->withPivot('send', 'token');
    }
}
