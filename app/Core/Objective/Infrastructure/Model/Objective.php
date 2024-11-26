<?php

namespace App\Core\Objective\Infrastructure\Model;

use App\Core\Objective\Infrastructure\database\factory\ObjectiveFactory;
use App\Core\Shared\Infrastructure\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Objective extends BaseModel
{
    use HasFactory;

    public static function newFactory(): ObjectiveFactory {
        return ObjectiveFactory::new();
    }
}
