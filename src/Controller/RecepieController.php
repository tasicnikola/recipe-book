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
use App\Service\RecipeService;
use Exception;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Flex\Recipe;
use App\DTO\RecipeParams;
use App\Entitiy\User;

class RecepieController extends AbstractController
{
    public function __construct(private RecipeService $service)
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

    public function getByID($id): JsonResponse
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
            $recipeDto = new RecipeParams(
                $content['title'],
                $content['image'],
                $content['description'],
                $content['user'],
                $content['ingredients']
            );

            return $this->json($this->service->create($recipeDto));
        } catch (CustomException $e) {
            return  ($e->errorMessage());
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
            return  ($e->errorMessage());
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            return $this->json($this->service->delete($id));
        } catch (CustomException $e) {
            return  ($e->errorMessage());
        }
    }
}
