<?php

namespace App\Validators;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Validation;
use App\Exceptions\InvalidParameterException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use App\Exception\CustomException;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserValidator
{
    public function validate(array $parameters)
    {
        $constraint = new Assert\Collection(
            [
                'username' => [
                            new Assert\NotBlank(),
                            new Assert\NotNull(),
                            new Assert\Type(type:'string'),
                           ],
                'password' => [
                            new Assert\NotNull(),
                            new Assert\Type(type:'string'),
                            new Assert\NotBlank(),
                           ],
                'name'     => [
                            new Assert\NotNull(),
                            new Assert\NotBlank(),
                            new Assert\Type(type:'string'),
                           ],
                'surname'  => [
                            new Assert\NotBlank(),
                            new Assert\NotNull(),
                            new Assert\Type(type:'string'),
                           ],
                'email'    => [
                            new Assert\Email(),
                            new Assert\NotBlank(),
                            new Assert\Type(type:'string'),
                            new Assert\NotNull(),
                           ],
                'role'     => [
                            new Assert\NotBlank(),
                            new Assert\Type(type:'integer'),
                            new Assert\NotNull(),
                           ],
            ]
        );

        $validator = Validation::createValidator();
        $violations = $validator->validate($parameters, $constraint);
        if (0 < count($violations)) {
            $accessor = PropertyAccess::createPropertyAccessor();
                $errorMessages = [];
            foreach ($violations as $violation) {
                $accessor->setValue(
                    $errorMessages,
                    $violation->getPropertyPath(),
                    $violation->getMessage()
                );
            }
            foreach ($errorMessages as $error) {
                throw new Exception($error);
            }
        }
    }
}
