<?php

namespace App\Controller;

use App\Controller\Trait\JsonResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\UserService;
use Exception;
use App\Request\User\User as UserRequest;
use App\Request\User\UserByEmail;

class UserController extends AbstractController
{
    use JsonResponseTrait;

    public function __construct(private UserService $service)
    {
    }

    public function getAll(): JsonResponse
    {
        try {
            return $this->jsonResponse($this->service->getAll());
        } catch (Exception $e) {
            return  $this->exceptionJsonResponse($e);
        }
    }

    public function get(string $guid): JsonResponse
    {
        try {
            return $this->jsonResponse($this->service->get($guid));
        } catch (Exception $e) {
            return  $this->exceptionJsonResponse($e);
        }
    }

    public function create(UserRequest $request): JsonResponse
    {
        try {
            $guid = $this->service->create($request->params());

            return $this->jsonResponseCreated($guid);
        } catch (Exception $e) {
            return  $this->exceptionJsonResponse($e);
        }
    }

    public function update(string $guid, UserRequest $request): JsonResponse
    {
        try {
            $this->service->update($guid, $request->params());

            return $this->jsonResponseNoContent();
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function delete(string $guid): JsonResponse
    {
        try {
            $this->service->delete($guid);

            return $this->jsonResponseNoContent();
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function getByEmail(UserByEmail $request): JsonResponse
    {
        try {
            return $this->jsonResponse($this->service->getByEmail($request->params()));
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }
}
