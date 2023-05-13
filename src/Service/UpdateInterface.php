<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use App\DTO\Parameters;

interface UpdateInterface
{
    public function update(int $id, Parameters $params): void;
}
