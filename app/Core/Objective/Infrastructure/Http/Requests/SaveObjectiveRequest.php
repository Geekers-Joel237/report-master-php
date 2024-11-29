<?php

namespace App\Core\Objective\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SaveObjectiveRequest",
 *     description="Request body for saving an objective",
 *     type="object",
 *
 *     @OA\Property(property="tasks", type="array", description="List of tasks associated with the objective",
 *
 *         @OA\Items(type="string")
 *     ),
 *
 *     @OA\Property(property="participantIds", type="array", description="IDs of participants involved in the objective",
 *
 *         @OA\Items(type="string")
 *     ),
 *
 *     @OA\Property(property="projectId", type="string", description="The ID of the associated project")
 * )
 */
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
