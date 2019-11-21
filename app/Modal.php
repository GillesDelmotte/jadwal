<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modal extends Model
{
    protected $fillable = [
        'session_id', 'teacher_id', 'name', 'group', 'group_infos', 'local', 'supervisor'
    ];
}
