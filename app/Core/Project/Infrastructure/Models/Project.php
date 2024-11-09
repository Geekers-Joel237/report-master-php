<?php

namespace App\Core\Project\Infrastructure\Models;

use App\Core\Project\Domain\Entities\Project as ProjectDomain;
use App\Core\Project\Infrastructure\database\factories\ProjectFactory;
use App\Core\Shared\Infrastructure\Models\BaseModel;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $status
 * @property ?string $created_at
 * @property ?string $updated_at
 * @property string $slug
 * @property string $year_id
 */
class Project extends BaseModel
{
    use HasFactory;

    protected static function newFactory(): ProjectFactory
    {
        return ProjectFactory::new();
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
