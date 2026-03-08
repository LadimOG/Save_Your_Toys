<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Toy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_path',
        'child_id'
    ];

    public function imagePath(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? Storage::url($value) : null
        );
    }

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}
