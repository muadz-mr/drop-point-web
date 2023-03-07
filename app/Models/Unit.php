<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['block', 'level', 'number'];

    protected function fullUnitName(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => "{$attributes['block']}-{$attributes['level']}-{$attributes['number']}",
        );
    }
}
