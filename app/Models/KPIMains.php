<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KPIMains extends Model
{
    use HasFactory;
    protected $primaryKey = 'KPIMainID';
    public function goal()
    {
        return $this->belongsTo(Goals::class, 'goalID','goalID');
    }

    public function director()
    {
        return $this->belongsTo(Users::class, 'directorID','userID');
    }

    public function recorder()
    {
        return $this->belongsTo(Users::class, 'recorderID','userID');
    }
}
