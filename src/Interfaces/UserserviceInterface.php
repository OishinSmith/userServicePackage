<?php

namespace Oishin\Userservice\Interfaces;

use Oishin\Userservice\DTO\UserserviceDTO;
use Oishin\Userservice\Models\User;
use Illuminate\Http\Request;

interface UserserviceInterface
{

    public function getUserById(int $id): string|User;

    public function getUsers(int $page = 1): string|array;

    public function createUser(string $name, string $job): string|User;
}
