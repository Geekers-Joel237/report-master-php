<?php

namespace App\Core\Report\Infrastructure\Models;

use App\Core\Report\Domain\Entities\DailyReport;
use App\Core\Report\Infrastructure\database\factory\ReportFactory;
use App\Core\Shared\Infrastructure\Models\BaseModel;
use App\Core\User\Infrastructure\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $id
 * @property string $project_id
 * @property array $tasks
 * @property string $created_at
 * @property string $updated_at
 * @property string $owner_id
 */
class Report extends BaseModel
{
    use HasFactory;

    protected $casts = [
        'tasks' => 'array',
    ];

    /**
     * @throws Exception
     */
    public function toDomain(): DailyReport
    {
        return DailyReport::createFromDb(
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
        return $this->belongsToMany(User::class, 'participant_report', 'report_id', 'participant_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    protected static function newFactory(): ReportFactory
    {
        return ReportFactory::new();
    }
}
