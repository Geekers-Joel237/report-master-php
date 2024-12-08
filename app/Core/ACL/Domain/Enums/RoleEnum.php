<?php

namespace App\Core\ACL\Domain\Enums;

use App\Core\Shared\Domain\Exceptions\InvalidCommandException;

enum RoleEnum: string
{
    case DEVELOPER = 'developer';
    case DESIGNER = 'designer';
    case RH = 'rh';
    case ADMIN = 'admin';
    case SUPER_ADMIN = 'super_admin';

    /**
     * @throws InvalidCommandException
     */
    public static function in(string $value): self
    {
        $role = self::tryFrom($value);
        if ($role === null) {
            throw new InvalidCommandException("Role '$value' not found");
        }

        return $role;
    }

    public static function values(): array
    {
        return array_map(fn ($e) => $e->value, self::cases());
    }
}
