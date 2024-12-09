<?php

namespace App\Core\Project\Infrastructure\Http\Requests;

use App\Core\Shared\Infrastructure\Http\Request\HttpDataRequest;

class SaveProjectRequest extends HttpDataRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|between:2,100',
            'description' => 'sometimes|string|between:2,100',
        ];
    }
}
