<?php

namespace App\Exception;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class CustomException extends Exception
{
    public function errorMessage(): JsonResponse
    {
        return new JsonResponse('Error in ' . $this->getFile() . " , on line " .  $this->getLine());
    }
}
