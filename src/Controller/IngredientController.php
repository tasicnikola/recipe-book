<?php

namespace App\Controller;

use App\Exception\CustomException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\IngredientService;
use Exception;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Flex\Recipe;
use App\DTO\IngredientParams;

class IngredientController extends AbstractController
{
    public function __construct(private IngredientService $service)
    {
    }

    public function get(): JsonResponse
    {
        try {
            return $this->json($this->service->get());
        } catch (CustomException $e) {
            return  ($e->errorMessage());
        }
    }

    public function getByID(int $id): JsonResponse
    {
        try {
            return $this->json($this->service->getByID($id));
        } catch (CustomException $e) {
            return  ($e->errorMessage());
        }
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $content = json_decode($request->getContent(), true);
            $ingredient = new IngredientParams($content['name']);

            return $this->json($this->service->create($ingredient));
        } catch (CustomException $e) {
            return  ($e->errorMessage());
        }
    }

    public function update(int $id, Request $request): JsonResponse
    {
        try {
            $content = json_decode($request->getContent(), true);
            $ingredient = new IngredientParams($content['name']);

            return $this->json($this->service->update($id, $ingredient));
        } catch (CustomException $e) {
            return  ($e->errorMessage());
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            return $this->json($this->service->delete($id));
        } catch (CustomException $e) {
            return  ($e->errorMessage());
        }
    }
}
