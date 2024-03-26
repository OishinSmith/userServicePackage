<?php

namespace Oishin\Userservice\Interfaces;

use Oishin\Userservice\DTO\UserserviceDTO;
use Illuminate\Http\Request;

interface UserserviceInterface
{

    public function getUserById(int $id): string;

    public function getUsers(int $page = 1): string;

    public function createUser(Request $request);
}
