<?php

namespace App\Controller;

use App\Exception\CustomException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Service\RecipeService;
use App\DTO\RequestParams\RecipeParams;
use Exception;
use App\Controller\Trait\JsonResponseTrait;

class RecepieController extends AbstractController
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

    public function create(Request $request): JsonResponse
    {
        try {
            $content = json_decode($request->getContent(), true);
            $recipeDto = new RecipeParams(
                $content['title'],
                $content['image'],
                $content['description'],
                $content['user'],
                $content['ingredients']
            );

            return $this->json($this->service->create($recipeDto));
        } catch (CustomException $e) {
            return ($e->errorMessage());
        }
    }

    public function update(Request $request): JsonResponse
    {
        try {
            $id = $request->get('id');
            $content = json_decode($request->getContent(), true);
            $recipeDto = new RecipeParams(
                $content['title'],
                $content['image'],
                $content['description'],
                $content['user'],
                $content['ingredients']
            );

            return $this->json($this->service->update($id, $recipeDto));
        } catch (CustomException $e) {
            return ($e->errorMessage());
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
