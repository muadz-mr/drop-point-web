<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class PackageFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [
        'recipientUnit' => ['unit_name'],
    ];

    public function deliveryCompany(int $value): self
    {
        return $this->where('delivery_company_id', $value);
    }

    public function storageLocation(int $value): self
    {
        return $this->where('storage_location_id', $value);
    }

    public function collectorName(string $value): self
    {
        return $this->related('collector', 'name', 'LIKE', "%{$value}%");
    }

    public function collectorPhoneNo(string $value): self
    {
        return $this->related('collector', 'phone_no', '=', $value);
    }

    public function status(int $value): self
    {
        return $this->where('status', $value);
    }

    // public function fromDate(string $value): self
    // {
    //     return $this->whereDate('arrived_at', '>=', $value);
    // }

    // public function toDate(string $value): self
    // {
    //     return $this->whereDate('arrived_at', '<=', $value);
    // }

    public function arrivedAtDateRange(string $dateRange): self
    {
        [$startDate, $endDate] = explode("~", $dateRange);
        $startDate = trim($startDate) . " 00:00:00";
        $endDate = trim($endDate) . " 23:59:59";

        return $this->whereBetween('arrived_at', [$startDate, $endDate]);
    }

    public function collectedAtDateRange(string $dateRange): self
    {
        [$startDate, $endDate] = explode("~", $dateRange);
        $startDate = trim($startDate) . " 00:00:00";
        $endDate = trim($endDate) . " 23:59:59";

        return $this->whereBetween('collected_at', [$startDate, $endDate]);
    }

    public function packageNo(string $value): self
    {
        return $this->whereLike('package_no', $value);
    }

    public function phoneNo(string $value): self
    {
        return $this->where('recipient_phone_no', $value);
    }
}
