<?php

namespace App\Core\Report\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveReportRequest extends FormRequest
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
