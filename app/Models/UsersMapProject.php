<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersMapProject extends Model
{
    protected $primaryKey = 'userMapID';
    public function projects()
    {
        return $this->hasMany(Projects::class, 'proID', 'proID'); 
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'userID', 'userID'); 
    }
}
