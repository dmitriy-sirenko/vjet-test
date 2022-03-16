<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['title', 'phone', 'description', 'user_id'];

    public function company()
    {
        return $this->belongsTo(User::class);
    }
}
