<?php

namespace App\Controller;

use App\Controller\Trait\JsonResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\IngredientService;
use Exception;
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

    public function getByID(string $guid): JsonResponse
    {
        try {
            return $this->jsonResponse($this->service->getByID($guid));
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

    public function update(string $guid, IngredientRequest $request): JsonResponse
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
}
