<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use App\Exception\CustomException;
use Symfony\Bundle\MakerBundle\Validator;
use App\Validators\RecipeValidator;
use App\Validators\UserValidator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;




class EventSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                ['onKernelRequest', 255]
            ]
        ];
    }

    public function onKernelRequest(RequestEvent $request) : void
    {
        if ($request->getRequest()->isMethod('POST') || $request->getRequest()->isMethod('PUT')) {
            $content = json_decode(($request->getRequest()->getContent()), true);

            if (strpos($request->getRequest()->getPathInfo(), '/recipes') === 0) {
                $recipeValidator = new RecipeValidator();
                $recipeValidator->validate($content);
            }
        }
    }

}
