<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function sender(){
        return $this->belongsTo(\App\Models\User::class, 'userId');
    }

    public function receiver(){
        return $this->belongsTo(\App\Models\User::class, 'userId');
    }

}
