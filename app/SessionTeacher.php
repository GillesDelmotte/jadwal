<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SessionTeacher extends Model
{

    protected $fillable = [
        'session_id', 'teacher_id'
    ];
}
