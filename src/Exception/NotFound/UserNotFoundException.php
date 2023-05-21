<?php

declare(strict_types=1);

namespace App\Exception\NotFound;

class UserNotFoundException extends NotFoundException
{
    public function __construct(readonly int | string $userId)
    {
        parent::__construct($userId, 'user');
    }
}
