<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session as PHPSession;

class Teacher extends Model
{


    public function modals()
    {
        return $this->hasMany(Modal::class)
            ->where('session_id', PHPSession::get('session')->id)
            ->where('send', true);
    }

    public function sessions()
    {
        return $this->belongsToMany(Session::class);
    }
}
