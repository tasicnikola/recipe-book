<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

interface DeleteInterface
{
    public function delete(int $id): void;
}
