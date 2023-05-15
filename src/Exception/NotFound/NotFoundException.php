<?php

namespace App\Exception\NotFound;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class NotFoundException extends Exception
{
    public function __construct(readonly int $id, readonly string $entityName)
    {
        parent::__construct("There is no {$entityName} with id: {$id}", JsonResponse::HTTP_NOT_FOUND);
    }
}
