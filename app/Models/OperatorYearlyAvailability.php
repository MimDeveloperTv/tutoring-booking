<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OperatorYearlyAvailability extends Model
{
    use HasFactory,SoftDeletes;

    public function serviceApplication()
    {
        return $this->belongsTo(ServiceApplication::class);
    }

    public function serviceApplicationPlace()
    {
        return $this->belongsTo(ServiceApplicationPlace::class);
    }
}
