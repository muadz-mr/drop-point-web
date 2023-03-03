<?php

namespace App\Models;

use App\Models\SlugModel;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryCompany extends SlugModel
{
    use HasFactory, Filterable;

    protected $fillable = ['name', 'slug'];

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }
}
