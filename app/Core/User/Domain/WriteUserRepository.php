<?php

namespace App\Core\User\Domain;

interface WriteUserRepository
{
    /**
     * @param  string[]  $participantIds
     * @return string[]
     */
    public function allExists(array $participantIds): array;
}
