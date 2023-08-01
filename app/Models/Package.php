<?php

namespace App\Models;

use App\Enums\PackageStatus;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $fillable = [
        'delivery_company_id',
        'package_no',
        'image_path',
        'recipient_phone_no',
        'recipient_unit_id',
        'storage_location_id',
        'arrived_at',
        'collected_at',
        'collected_by_id',
        'status',
        'one_time_storage_fee',
        'daily_storage_fee',
    ];

    protected $casts = [
        'arrived_at' => 'datetime',
        'collected_at' => 'datetime',
        'status' => PackageStatus::class
    ];

    public function deliveryCompany(): BelongsTo
    {
        return $this->belongsTo(DeliveryCompany::class, 'delivery_company_id');
    }

    public function recipientUnit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'recipient_unit_id');
    }

    public function storageLocation(): BelongsTo
    {
        return $this->belongsTo(StorageLocation::class);
    }

    public function collector(): BelongsTo
    {
        return $this->belongsTo(Collector::class, 'collected_by_id');
    }
}
