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

    public function get(): JsonResponse
    {
        try {
            return $this->jsonResponse($this->service->get());
        } catch (Exception $e) {
            return  $this->exceptionJsonResponse($e);
        }
    }

    public function getByID(int $id): JsonResponse
    {
        try {
            return $this->jsonResponse($this->service->getByID($id));
        } catch (Exception $e) {
            return  $this->exceptionJsonResponse($e);
        }
    }

    public function create(UserRequest $request): JsonResponse
    {
        try {
            $id = $this->service->create($request->params());

            return $this->jsonResponseCreated($id);
        } catch (Exception $e) {
            return  $this->exceptionJsonResponse($e);
        }
    }

    public function update(int $id, UserRequest $request): JsonResponse
    {
        try {
            $this->service->update($id, $request->params());

            return $this->jsonResponseNoContent();
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $this->service->delete($id);

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
