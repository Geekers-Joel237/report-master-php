<?php

namespace App\Core\User\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class SaveUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
        ];
    }
}
