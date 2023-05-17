<?php

namespace App\Controller;

use App\Controller\Trait\JsonResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Service\IngredientService;
use Exception;
use App\DTO\IngredientParams;
use App\Request\Ingredient\Ingredient as IngredientRequest;

class IngredientController extends AbstractController
{
    use JsonResponseTrait;

    public function __construct(private IngredientService $service)
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

    public function create(IngredientRequest $request): JsonResponse
    {
        try {
            $id = $this->service->create($request->params());

            return $this->jsonResponseCreated($id);
        } catch (Exception $e) {
            return  $this->exceptionJsonResponse($e);
        }
    }

    public function update(int $id, IngredientRequest $request): JsonResponse
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
}
