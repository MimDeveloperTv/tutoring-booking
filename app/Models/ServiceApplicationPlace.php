<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceApplicationPlace extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'address_id','service_application_id','isActive'
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function operatorExeptionAvailability()
    {
        return $this->belongsTo(OperatorExceptionAvailability::class,'place_id');
    }

    public function operatorWeeklyAvailability()
    {
        return $this->belongsTo(OperatorWeeklyAvailability::class,'place_id');
    }

    public function operatorYearlyAvailability()
    {
        return $this->belongsTo(OperatorYearlyAvailability::class,'place_id');
    }

    public function serviceApplication()
    {
        return $this->belongsTo(ServiceApplication::class);
    }

    public function reserves()
    {
        return $this->hasMany(Reserve::class);
    }
}
