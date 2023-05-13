<?php

namespace App\Service;

interface RetrieveInterface
{
    public function get(): ?array;

    public function getByID(int $id): ?object;
}
