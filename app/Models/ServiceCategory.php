<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCategory extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['type','parent_id','name', ''];
    public function serviceModels()
    {
        return $this->hasMany(ServiceModel::class);
    }

    public function subCategories()
    {
        return $this->hasMany(ServiceCategory::class,'parent_id');
    }

    public function parentCategory()
    {
        return $this->belongsTo(ServiceCategory::class,'parent_id');
    }
}
