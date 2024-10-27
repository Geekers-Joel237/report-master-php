<?php

namespace App\Core\Shared\Infrastructure\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class NotSoftDeleteScope implements Scope
{
    public function apply(Builder $builder, Model $model): Builder
    {
        return $builder->whereNull('deleted_at')->where(['is_deleted' => false]);
    }
}
