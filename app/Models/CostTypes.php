<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostTypes extends Model
{
    use HasFactory;
    protected $primaryKey = 'costID';
    public function expense()
    {
        return $this->belongsTo(ExpenseBadgets::class, 'expID','expID');
    }
}
