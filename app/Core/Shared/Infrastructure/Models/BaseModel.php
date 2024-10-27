<?php

namespace App\Core\Shared\Infrastructure\Models;

use App\Core\Shared\Infrastructure\Scope\NotSoftDeleteScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property bool $is_deleted
 */
#[ScopedBy([NotSoftDeleteScope::class])]
class BaseModel extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public function softDelete(): void
    {
        $this->is_deleted = true;
        $this->runSoftDelete();
    }
}
