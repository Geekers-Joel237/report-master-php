<?php

namespace App\Core\ACL\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];
}
