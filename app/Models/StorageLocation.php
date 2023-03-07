<?php

namespace App\Models;

use App\Enums\StorageLocationStatus;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StorageLocation extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['name', 'building', 'building_level', 'room', 'shelf', 'space', 'status'];

    protected $casts = [
        'status' => StorageLocationStatus::class
    ];

    public function packagesAtLocation(): HasMany
    {
        return $this->hasMany(Package::class);
    }
}
