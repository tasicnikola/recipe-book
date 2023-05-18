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

    public function get(): JsonResponse
    {
        try {
            return $this->jsonResponse($this->service->get());
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function getByID(int $id): JsonResponse
    {
        try {
            return $this->jsonResponse($this->service->getByID($id));
        } catch (Exception $e) {
            return $this->exceptionJsonResponse($e);
        }
    }

    public function create(RecipeRequest $request): JsonResponse
    {
        try {
            $id = $this->service->create($request->params());

            return $this->jsonResponseCreated($id);
        } catch (Exception $e) {
            return  $this->exceptionJsonResponse($e);
        }
    }

    public function update(int $id, RecipeRequest $request): JsonResponse
    {
        try {
            $this->service->update($id, $request->params());

            return $this->jsonResponseNoContent();
        } catch (Exception $e) {
            return  $this->exceptionJsonResponse($e);
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
}
