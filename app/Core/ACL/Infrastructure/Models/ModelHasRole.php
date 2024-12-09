<?php

namespace App\Core\ACL\Infrastructure\Models;

use App\Core\User\Infrastructure\Models\User;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ModelHasRole extends Pivot
{
    protected $fillable = [
        'role_id',
        'model_id',
        'model_type',
    ];

    protected static function booted(): void
    {
        static::creating(function ($pivot) {
            if (!$pivot->model_type) {
                $pivot->model_type = User::class;
            }
        });
    }
}
