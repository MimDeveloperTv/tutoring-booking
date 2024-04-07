<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OperatorWeeklyAvailability extends Model
{
    use HasFactory;

    protected $fillable = ['service_application_id','place_id','weekday','from','to','online','inAnotherSite'];
    public function serviceApplication()
    {
        return $this->belongsTo(ServiceApplication::class);
    }

    public function serviceApplicationPlace()
    {
        return $this->belongsTo(ServiceApplicationPlace::class,'place_id');
    }
}
