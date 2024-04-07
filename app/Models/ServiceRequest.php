<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceRequest extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'consumer_id',
        'operator_id',
//        'service_model_id',
        'service_model_item_id',
        'visibility',
        'status',
        'accepted_by',
        'accepted_at'
    ];

    public function consumer() : BelongsTo
    {
        return  $this->belongsTo(Consumer::class,'consumer_id');
    }

    public function operator() : BelongsTo
    {
        return $this->belongsTo(Operator::class,'operator_id');
    }

    public function serviceModelItem() : BelongsTo
    {
       return $this->belongsTo(ServiceModelItem::class,'service_model_item_id');
    }

    public function functor() : BelongsTo
    {
        return $this->belongsTo(Operator::class,'accepted_by');
    }

    //scopes

    public function scopeAllowed(Builder $query,$collection_id): Builder
    {
        return $query->whereHas('operator',function ($query)use ($collection_id){
            return $query->where('user_collection_id',$collection_id);
        })->orWhere('visibility','PUBLIC');
    }
}
