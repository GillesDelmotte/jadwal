<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public function modals()
    {
        return $this->hasMany(Modal::class);
    }
}
