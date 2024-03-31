<?php

namespace Oishin\Userservice\tests;

use PHPUnit\Framework\TestCase;
use Oishin\Userservice\Controllers\UserserviceController;
use Oishin\Userservice\DTO\UserserviceDTO;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Stream;

class unitTests extends TestCase
{
    public function testUserServiceDTO()
    {
        // cant really test api calls using phpunit. But I can test the dto which is returned
        // by the Userservice package apis
        $user = new UserserviceDTO(1, "Oishin", "Smith", "o@gmail.com", null);
        
        $this->assertNotNull($user->id);
        $this->assertNotNull($user->firstName);
        $this->assertNotNull($user->lastName);
        $this->assertNotNull($user->email);
        $this->assertNull($user->avatar);
    }

    public function testGetUserById()
    {
        $userService = new UserserviceController();

        $result = $userService->getUserById(1);

        $expectedResult = '{"id":1,"firstName":"George","lastName":"Bluth","email":"george.bluth@reqres.in","avatar":"https:\/\/reqres.in\/img\/faces\/1-image.jpg"}';
        $this->assertEquals($expectedResult, $result);
    }

    
    public function testGetUsers()
    {
        $userService = new UserserviceController();

        $result = $userService->getUsers(1);
        $this->assertNotEquals('{}', $result);

        $result = $userService->getUsers(123);
        $this->assertEquals('{}', $result);
    }
}
