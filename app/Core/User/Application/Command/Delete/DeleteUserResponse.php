<?php

namespace App\Core\User\Application\Command\Delete;

class DeleteUserResponse
{
    public int $isdeleted = 1;

    public int $code = 500;

    public string $message = 'Deleted succefull';

}
