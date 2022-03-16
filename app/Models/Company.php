<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function company()
    {
        return $this->belongsTo(User::class);
    }
}
