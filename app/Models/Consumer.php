<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Consumer extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_collection_id',
        'user_id',
        'fullname',
        'avatar'
    ];

    protected $keyType = 'uuid';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }

    public function reserves()
    {
        return $this->hasMany(Reserve::class);
    }

    public function serviceRequests() : HasMany
    {
        return $this->hasMany(ServiceRequest::class,'consumer_id');
    }

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
