<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class UnitFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function block(string $value): self
    {
        return $this->where('block', $value);
    }

    public function level(string $value): self
    {
        return $this->where('level', $value);
    }

    public function number(string $value): self
    {
        return $this->where('number', $value);
    }

    public function unitName(string $value): self
    {
        return $this->where(function ($query) use ($value) {
            $query->where('block', 'LIKE', "%{$value}%")
                ->orWhere('level', 'LIKE', "%{$value}%")
                ->orWhere('number', 'LIKE', "%{$value}%");
        });
    }
}
