<?php

namespace App\Models;

use App\Factories\PlanningConditionFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceModel extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'condition',
        'calculation',
        'are_items_independent',
        'non_prescription',
        'calculation',
        'isActive',
        'items',
        'are_items_independent',
        'non_prescription',
        'form_id',
        'service_category_id'
    ];
    public function serviceCategory() : BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function services() : HasMany
    {
        return $this->hasMany(Service::class);
    }

    public  function serviceModelItems() : HasMany
    {
        return  $this->hasMany(ServiceModelItem::class);
    }

//    protected function errors(): Attribute
//    {
//        return Attribute::make(
//            get: fn($value, array $attributes) => !is_null($this->condition) ? PlanningConditionFactory::build($this->condition,request('patient_id')) : [],
//            set: fn($value) => $value,
//        );
//    }

}
