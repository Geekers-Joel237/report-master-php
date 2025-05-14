<?php

namespace App\Core\Auth\Infrastructure\Http\Requests;

use App\Core\Shared\Infrastructure\Http\Request\HttpDataRequest;

class LoginUserRequest extends HttpDataRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email:rfc,dns',
            'password' => 'required|string|min:8',
        ];

    }
}
