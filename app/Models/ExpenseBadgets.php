<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseBadgets extends Model
{
    use HasFactory;
    public function fund()
    {
        return $this->belongsTo(Funds::class, 'fundID','fundID');
    }
}
