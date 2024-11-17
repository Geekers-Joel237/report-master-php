<?php

namespace App\Core\Project\Infrastructure\Models;

use App\Core\Project\Domain\Entities\Project as ProjectDomain;
use App\Core\Project\Infrastructure\database\factories\ProjectFactory;
use App\Core\Shared\Infrastructure\Models\BaseModel;
use App\Core\Shared\Infrastructure\Models\Years;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Project
 *
 * Represents a project entity in the application.
 *
 * @OA\Schema(
 *     schema="Project",
 *     title="Project Model",
 *     description="Representation of a project entity.",
 *     required={"id", "name", "status", "slug", "year_id"},
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         description="Unique identifier for the project",
 *         example="123e4567-e89b-12d3-a456-426614174000"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the project",
 *         example="Project Alpha"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Detailed description of the project",
 *         example="This is a sample project used for testing."
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Current status of the project",
 *         example="active"
 *     ),
 *     @OA\Property(
 *         property="slug",
 *         type="string",
 *         description="Unique slug for the project",
 *         example="project-alpha"
 *     ),
 *     @OA\Property(
 *         property="year_id",
 *         type="string",
 *         description="ID of the associated year",
 *         example="2024"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the project was created",
 *         example="2023-01-01T12:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the project was last updated",
 *         example="2023-06-01T15:00:00Z"
 *     )
 * )
 */
class Project extends BaseModel
{
    use HasFactory;

    protected static function newFactory(): ProjectFactory
    {
        return ProjectFactory::new();
    }

    public function year(): HasOne
    {
        return $this->hasOne(Years::class);
    }

    /**
     * @throws Exception
     */
    public function createFromModel(): ProjectDomain
    {
        return ProjectDomain::createFromAdapter(
            id: $this->id,
            name: $this->name,
            status: $this->status,
            slug: $this->slug,
            description: $this->description,
            createdAt: $this->created_at,
            updatedAt: $this->updated_at
        );
    }
}
