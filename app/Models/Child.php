<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    protected $fillable = [
        'name',

    ];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucfirst($value)
        );
    }

    public function toys()
    {
        return $this->hasMany(Toy::class);
    }
}
