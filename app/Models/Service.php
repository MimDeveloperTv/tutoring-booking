<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory,SoftDeletes;

    private $type;

    protected $fillable = [
        'user_collection_id',
        'form_id',
        'default_price',
        'default_duration',
        'default_break',
        'default_capacity'
    ];
    public function serviceModel()
    {
        return $this->belongsTo(ServiceModel::class);
    }

    public function serviceApplications()
    {
        return $this->hasMany(ServiceApplication::class);
    }



}
