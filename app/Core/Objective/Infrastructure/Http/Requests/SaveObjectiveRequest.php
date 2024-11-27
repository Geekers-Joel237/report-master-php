<?php

namespace App\Core\Objective\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveObjectiveRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tasks' => 'required|array',
            'tasks.*' => 'required|string',
            'participantIds' => 'sometimes|array',
            'projectId' => 'required|string',
        ];
    }
}
