<?php

namespace App\Core\User\Infrastructure\Http\Request;

use App\Core\Shared\Infrastructure\Http\Request\HttpDataRequest;

class UpdateUserRequest extends HttpDataRequest
{
    public function rules(): array
    {

        return [
            'name' => 'required|string',
            'email' => 'required|email:rfc,dns',
            'userId' => 'required|string',
        ];

    }
}
