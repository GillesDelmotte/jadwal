<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'title', 'content', 'user_id', 'date'
    ];


    public function teachers()
    {
        return $this->hasMany(SessionTeacher::class);
    }
}
