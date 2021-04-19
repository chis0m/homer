<?php

namespace App\Http\Requests\Auth;

use App\Exceptions\ApplicationExcepiton;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $table = 'users';
        $path = strtolower($this->url());
        if (Str::contains($path, 'admin')) {
            $table = 'admins';
        }

        if (Str::contains($path, 'agent')) {
            $table = 'agents';
        }

        return [
            'first_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\-\.]+$/'],
            'last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\-\.]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', "unique:{$table},email"],
            'password' => ['required', 'string', 'min:6']
        ];
    }
}
