<?php

namespace App\Core\Project\Domain\Vo;

use App\Core\Shared\Domain\Exceptions\InvalidCommandException;

readonly class NameVo
{
    private string $value;

    /**
     * @throws InvalidCommandException
     */
    public function __construct(string $name)
    {
        self::validate($name);
        $this->value = self::filter($name);
    }

    /**
     * @throws InvalidCommandException
     */
    private static function validate(string $name): void
    {
        if (empty(trim($name))) {
            throw new InvalidCommandException('Cette chaîne ne peut être vide !');
        }
    }

    private static function filter(string $name): string
    {
        return strtolower(trim(htmlspecialchars($name)));
    }

    public function value(): string
    {
        return $this->value;
    }
}
