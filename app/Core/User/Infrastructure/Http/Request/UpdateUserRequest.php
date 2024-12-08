<?php

namespace App\Core\User\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
