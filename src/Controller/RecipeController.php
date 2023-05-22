<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\RecipeService;
use Exception;
use App\Controller\Trait\JsonResponseTrait;
use App\Request\Recipe\Recipe as RecipeRequest;

class RecipeController extends AbstractController
{
    use JsonResponseTrait;

    public function __construct(private RecipeService $service)
    {
    }

    public function getAll(): JsonResponse
    {
        try {
            return $this->jsonResponse($this->service->getAll());
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function get(string $guid): JsonResponse
    {
        try {
            return $this->jsonResponse($this->service->get($guid));
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function create(RecipeRequest $request): JsonResponse
    {
        try {
            $guid = $this->service->create($request->params());

            return $this->jsonResponseCreated($guid);
        } catch (Exception $e) {
            return  $this->exceptionJsonResponse($e);
        }
    }

    public function update(string $guid, RecipeRequest $request): JsonResponse
    {
        try {
            $this->service->update($guid, $request->params());

            return $this->jsonResponseNoContent();
        } catch (Exception $e) {
            return  $this->exceptionJsonResponse($e);
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
}
