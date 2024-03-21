<?php

namespace Oishin\Userservice\Controllers;

use Illuminate\Http\Request;
use Oishin\Userservice\Userservice;

class UserserviceController
{
    public function __invoke(Userservice $userservice) {
        
        $user = $userservice->getUserById(1);

        return $user;
    }
}
