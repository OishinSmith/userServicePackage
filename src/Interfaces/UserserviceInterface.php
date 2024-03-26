<?php

namespace Oishin\Userservice\Interfaces;

use Oishin\Userservice\DTO\UserserviceDTO;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface UserserviceInterface
{

    public function getUserById(int $id): JsonResponse;

    public function getUsers(int $page = 1): JsonResponse;

    public function createUser(Request $request): JsonResponse;
}
