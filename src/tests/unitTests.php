<?php

namespace Oishin\Userservice\tests;

use PHPUnit\Framework\TestCase;
use Oishin\Userservice\Controllers\UserserviceController;
use Oishin\Userservice\DTO\UserserviceDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class unitTests extends TestCase
{
    public function testApis()
    {
        // cant really test api calls using phpunit. But I can test the dto which is returned
        // by the Userservice package apis
        $user = new UserserviceDTO(1, "Oishin", "Smith", "o@gmail.com", null);
        
        $this->assertNotNull($user->id);
        $this->assertNotNull($user->firstName);
        $this->assertNotNull($user->lastName);
        $this->assertNotNull($user->email);
        $this->assertNull($user->avatar);

        $users = 
        [
            new UserserviceDTO(1, "Oishin", "Smith", "o@gmail.com", "not null"),
            new UserserviceDTO(2, "Joe", "Smith", "j@gmail.com", "vatar")
        ];
        $this->assertNotEmpty($users);
        foreach ($users as $user) {
            $this->assertNotNull($user->id);
            $this->assertNotNull($user->firstName);
            $this->assertNotNull($user->lastName);
            $this->assertNotNull($user->email);
            $this->assertNotNull($user->avatar);
        }
    }
}
