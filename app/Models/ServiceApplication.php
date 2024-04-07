<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceApplication extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'operator_id',
        'service_id',
        'form_id',
        'duration',
        'price',
        'break',
        'capacity',
        'online',
        'onAnotherSite',
        'isActive'
    ];
    public function service() : BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function operator() : BelongsTo
    {
        return $this->belongsTo(Operator::class);
    }

    public function places() : HasMany
    {
        return $this->hasMany(ServiceApplicationPlace::class);
    }

    public function getCapacity() : int
    {
        return $this->capacity ? $this->capacity : $this->service->default_capacity;
    }
}
