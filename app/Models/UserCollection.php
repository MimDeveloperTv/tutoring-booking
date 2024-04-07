<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCollection extends Model
{
    use HasFactory,SoftDeletes;

    protected $connection = 'mysql_iam';

    protected $keyType = 'uuid';

    public $incrementing = false;
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function operators() : HasMany
    {
        return $this->hasMany(Operator::class);
    }
}
