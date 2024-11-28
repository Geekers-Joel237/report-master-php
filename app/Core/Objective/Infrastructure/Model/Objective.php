<?php

namespace App\Core\Objective\Infrastructure\Model;

use App\Core\Objective\Domain\Entities\Objective as ObjectiveDomain;
use App\Core\Objective\Infrastructure\database\factory\ObjectiveFactory;
use App\Core\Shared\Infrastructure\Models\BaseModel;
use App\Core\User\Infrastructure\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *  Class Objectives
 *
 *  Represents a Objective entity in the application.
 *
 *
 * @property string $id
 * @property string $project_id
 * @property array $tasks
 * @property string $created_at
 * @property string $updated_at
 * @property string $owner_id
 *
 * @OA\Schema(
 *      schema="Objective",
 *      description="Objective model representation",
 *      type="object",
 *
 *      @OA\Property(property="id", type="string", description="The ID of the objective"),
 *      @OA\Property(property="project_id", type="string", description="The ID of the associated project"),
 *      @OA\Property(property="tasks", type="array", description="The list of tasks",
 *
 *          @OA\Items(type="string")
 *      ),
 *
 *      @OA\Property(property="owner_id", type="string", description="The ID of the owner of the objective"),
 *      @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
 *      @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp")
 *  )
 */
class Objective extends BaseModel
{
    use HasFactory;

    public static function newFactory(): ObjectiveFactory
    {
        return ObjectiveFactory::new();
    }

    /**
     * @throws Exception
     */
    public function toDomain(): ObjectiveDomain
    {
        return ObjectiveDomain::createFromDb(
            id: $this->id,
            projectId: $this->project_id,
            ownerId: $this->owner_id,
            tasks: $this->tasks,
            participantIds: $this->participants()->pluck('id')->toArray(),
            createdAt: $this->created_at,
            updatedAt: $this->updated_at
        );
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'participant_objective', 'objective_id', 'participant_id');
    }
}
