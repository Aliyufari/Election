<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'min:3'],
            'username' => ['required', 'string', Rule::unique('users', 'username')],
            'email'    => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8'],
            'gender'   => ['required', Rule::in(['male', 'female'])],
            'phone'    => ['nullable', 'string'],
            'image'    => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'role'     => ['nullable', 'string'],
            'role_id'  => ['required', 'integer', Rule::exists('roles', 'id')],
            'state_id' => ['nullable', 'integer', Rule::exists('states', 'id')],
            'zone_id'  => ['nullable', 'integer', Rule::exists('zones', 'id')],
            'lga_id'   => ['nullable', 'integer', Rule::exists('lgas', 'id')],
            'ward_id'  => ['nullable', 'integer', Rule::exists('wards', 'id')],
            'pu_id'    => ['nullable', 'integer', Rule::exists('pus', 'id')],
        ];
    }
}
