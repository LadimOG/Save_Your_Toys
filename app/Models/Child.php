<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    protected $fillable = [
        'name',

    ];
    public function toys()
    {
        return $this->hasMany(Toy::class);
    }
}
