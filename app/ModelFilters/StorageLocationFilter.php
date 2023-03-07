<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class StorageLocationFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function name($value)
    {
        return $this->whereLike('name', $value);
    }

    public function building($value)
    {
        return $this->whereLike('building', $value);
    }

    public function buildingLevel($value)
    {
        return $this->whereLike('building_level', $value);
    }

    public function room($value)
    {
        return $this->whereLike('room', $value);
    }

    public function shelf($value)
    {
        return $this->whereLike('shelf', $value);
    }

    public function space($value)
    {
        return $this->whereLike('space', $value);
    }

    public function status($value)
    {
        return $this->where('status', $value);
    }
}
