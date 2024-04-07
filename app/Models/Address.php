<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory,SoftDeletes;

    protected $connection = 'mysql';

    protected $fillable = [
        'title',
       'addressable_id',
        'addressable_type',
       'latitude',
       'longitude',
       'description',
       'phone'
    ];
    public function addressable()
    {
        return $this->morphTo();
    }
}
