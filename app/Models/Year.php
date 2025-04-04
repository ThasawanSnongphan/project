<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $primaryKey = 'yearID';
    use HasFactory;
    public function projects()
    {
        return $this->hasMany(Projects::class, 'yearID', 'yearID'); 
    }
}
