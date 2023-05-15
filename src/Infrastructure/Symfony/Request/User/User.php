<?php

namespace App\Infrastructure\Symfony\Request\User;

use App\DTO\RequestParams\UserParams;
use App\Request\User\User as UserRequestInterface;
use App\Infrastructure\Symfony\Request\Request;
use Symfony\Component\Validator\Constraints\Collection;
use App\Infrastructure\Symfony\Request\NameRequirements;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

class User extends Request implements UserRequestInterface
{
    public function params(): UserParams
    {
        return new UserParams(
            $this->getParameter(self::FIELD_NAME),
            $this->getParameter(self::FIELD_SURNAME),
            $this->getParameter(self::FIELD_EMAIL),
            $this->getParameter(self::FIELD_USERNAME),
            $this->getParameter(self::FIELD_PASSWORD),
        );
    }

    protected function getTableName(): string
    {
        return 'users';
    }

    protected function getUnique(): array
    {
        return [self::FIELD_EMAIL, self::FIELD_USERNAME];
    }


    protected function rules(): Collection
    {
        return new Collection(
            [
                self::FIELD_NAME     => [
                    new NameRequirements(),
                ],
                self::FIELD_SURNAME  => [
                    new NameRequirements(),
                ],
                self::FIELD_EMAIL    => [
                    new Type('string'),
                    new Length(
                        min: 22,
                        max: 50,
                        minMessage: 'Your email must be at least {{ limit }} characters long',
                        maxMessage: 'Your email cannot be longer than {{ limit }} characters',
                    ),
                    new Email(),
                ],
                self::FIELD_USERNAME => [
                    new Type('string'),
                    new Length(
                        min: 5,
                        max: 25,
                        minMessage: 'Your username must be at least {{ limit }} characters long',
                        maxMessage: 'Your username cannot be longer than {{ limit }} characters',
                    ),
                ],
                self::FIELD_PASSWORD => [
                    new Type('string'),
                ],
            ]
        );
    }
}
