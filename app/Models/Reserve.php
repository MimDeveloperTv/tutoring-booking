<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Reserve extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'service_application_place_id',
        'service_model_item_id',
        'consumer_id',
        'operator_id',
        'payment_status',
        'status',
        'amount',
        'currency',
        'from',
        'to',
    ];
    use HasFactory,SoftDeletes;
    protected $keyType = 'uuid';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
            if(!$model->payment_status)
                $model->payment_status = 'PENDING';

            if(!$model->status)
                $model->status = 'NEW';
        });
    }
    public function serviceApplicationPlace() : BelongsTo
    {
        return $this->belongsTo(ServiceApplicationPlace::class);
    }

    public function operator() : BelongsTo
    {
        return $this->belongsTo(Operator::class);
    }

    public function serviceModelItem() : BelongsTo
    {
        return $this->belongsTo(ServiceModelItem::class);
    }

    public function consumer() : BelongsTo
    {
        return $this->belongsTo(Consumer::class);
    }



    // public function reserveItems()
    // {
    //     return $this->hasMany(ReserveItems::class);
    // }



}
