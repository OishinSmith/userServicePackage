<?php

namespace Oishin\Userservice\Interfaces;

use Oishin\Userservice\DTO\UserserviceDTO;
use Illuminate\Http\Request;

interface UserserviceInterface
{

    public function getUserById(int $id): UserserviceDTO|array;

    public function getUsers(int $page = 1): UserserviceDTO|array;

    public function createUser(Request $request);
}
