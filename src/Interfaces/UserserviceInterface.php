<?php

namespace Oishin\Userservice\Interfaces;

use Oishin\Userservice\DTO\UserserviceDTO;
use Illuminate\Http\Request;

interface UserServiceInterface
{

    public function getUserById(int $id): ?UserserviceDTO;

    public function getUsers(int $page = 1): ?UserserviceDTO;

    public function createUser(Request $request): ?array;
}
