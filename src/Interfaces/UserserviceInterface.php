<?php

namespace Oishin\Userservice\Interfaces;

use Oishin\Userservice\DTO\UserserviceDTO;
use Illuminate\Http\Request;

interface UserServiceInterface
{

    public function getUserById(int $id);

    public function getUsers(int $page = 1);

    public function createUser(Request $request);
}
