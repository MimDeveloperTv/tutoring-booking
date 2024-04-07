<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReserveItems extends Model
{
    use HasFactory,SoftDeletes;

    public function reserve()
    {
        return $this->belongsTo(Reserve::class);
    }
}
