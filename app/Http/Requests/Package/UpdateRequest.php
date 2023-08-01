<?php

namespace App\Http\Requests\Package;

use App\Enums\PackageStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'delivery_company_id' => 'required|integer|exists:delivery_companies,id|bail',
            'package_no' => 'nullable|string|bail',
            'recipient_phone_no' => 'nullable|numeric|digits_between:5,30|bail',
            'recipient_unit_id' => 'required|integer|exists:units,id|bail',
            'storage_location_id' => 'nullable|integer|exists:storage_locations,id|bail',
            'arrived_at' => 'required|string|bail',
            'status' => [
                'required',
                'integer',
                'bail',
                Rule::in(PackageStatus::getValues()),
            ],
            'one_time_storage_fee' => 'nullable|integer|bail',
            'daily_storage_fee' => 'nullable|integer|bail',
            'image_path' => 'nullable|string|bail',
        ];
    }
}
