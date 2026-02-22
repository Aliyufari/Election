<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'name'     => ['required', 'string', 'min:3'],
            'username' => ['required', 'string', Rule::unique('users', 'username')->ignore($userId)],
            'email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($userId)],
            'password' => ['nullable', 'string', 'min:8'], // nullable on update
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
