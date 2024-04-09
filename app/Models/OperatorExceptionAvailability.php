<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OperatorExceptionAvailability extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'service_application_id',
        'place_id',
        'from',
        'to',
        'online',
        'onAnotherSite',
        'isAvailable'
    ];
    public function serviceApplication()
    {
        return $this->belongsTo(ServiceApplication::class);
    }

    public function serviceApplicationPlace()
    {
        return $this->belongsTo(ServiceApplicationPlace::class);
    }

}
