<?php

namespace App\Core\Report\Infrastructure\Http\Requests;

use App\Core\Shared\Infrastructure\Http\Request\HttpDataRequest;

class SaveReportRequest extends HttpDataRequest
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
