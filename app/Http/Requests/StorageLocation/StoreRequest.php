<?php

namespace App\Http\Requests\StorageLocation;

use App\Enums\StorageLocationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50|bail',
            'building' => 'nullable|string|max:20|bail',
            'building_level' => 'nullable|string|max:10|bail',
            'room' => 'nullable|string|max:20|bail',
            'shelf' => 'nullable|string|max:10|bail',
            'space' => 'nullable|string|max:10|bail',
            'status' => [
                'required',
                'integer',
                'bail',
                Rule::in(StorageLocationStatus::getValues()),
            ],
        ];
    }
}
