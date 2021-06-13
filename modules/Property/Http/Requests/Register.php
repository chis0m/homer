<?php

namespace Modules\Property\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Register extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:500', 'regex:/^[0-9a-z\sA-Z\-\.]+$/'],
            'purpose' => ['nullable', 'string'],
            'bedroom' => ['required', 'integer', 'numeric'],
            'bathroom' => ['required', 'integer', 'numeric'],
            'kitchen' => ['required', 'integer', 'numeric'],
            'toilet' => ['required', 'integer', 'numeric'],
            'size' => ['nullable', 'integer', 'numeric'],
            'furnished' => ['nullable', 'boolean'],
            'serviced' => ['nullable', 'boolean'],
            'newly_built' => ['nullable', 'boolean'],
            'price' => ['required', 'numeric'],
            'description' => ['nullable', 'string', 'max:1024'],
            'street_no' => ['required', 'alpha_num'],
            'street_name' => ['required', 'string'],
            'lga' => ['required'],
            'state' => ['required', 'string']
        ];
    }
}
