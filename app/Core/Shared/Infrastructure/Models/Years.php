<?php

namespace App\Core\Shared\Infrastructure\Models;

use App\Core\Shared\Infrastructure\database\factory\YearsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $year
 */
class Years extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function newFactory(): YearsFactory
    {
        return YearsFactory::new();
    }
}
