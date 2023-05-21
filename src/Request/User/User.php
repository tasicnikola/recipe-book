<?php

declare(strict_types=1);

namespace App\Request\User;

use App\DTO\RequestParams\UserParams;
use App\Request\Field\Guid;
use App\Request\Field\Name;
use App\Request\Field\Surname;
use App\Request\Field\Email;
use App\Request\Field\Username;
use App\Request\Field\Password;

interface User extends Guid, Name, Surname, Email, Username, Password
{
    public function params(): UserParams;
}
