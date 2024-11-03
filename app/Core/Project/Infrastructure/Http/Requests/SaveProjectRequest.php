<?php

namespace App\Core\Project\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveProjectRequest extends FormRequest
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
