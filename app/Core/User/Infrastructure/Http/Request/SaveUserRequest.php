<?php

namespace App\Core\User\Infrastructure\Http\Request;

use App\Core\Shared\Infrastructure\Http\Request\HttpDataRequest;

class SaveUserRequest extends HttpDataRequest
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
