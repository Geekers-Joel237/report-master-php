<?php

namespace App\Core\Domain\Vo;

use InvalidArgumentException;

class NameVo
{
    private string $value;

    public function __construct(string $name)
    {
        self::validate($name);
        $this->value = self::filter($name);
    }

    private static function validate(string $name): void
    {
        if (empty($name)) {
            throw new InvalidArgumentException('Cette chaîne ne peut être vide !');
        }
    }

    private static function filter(string $name): string
    {
        return strtolower(trim($name));
    }

    public function value(): string
    {
        return $this->value;
    }
}
