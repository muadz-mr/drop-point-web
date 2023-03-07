<?php

namespace App\Http\Requests\Unit;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'block' => 'required|string|max:10|bail',
            'level' => 'required|string|max:5|bail',
            'number' => 'required|string|max:4|bail',
        ];
    }
}
