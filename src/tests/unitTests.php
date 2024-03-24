<?php

namespace Oishin\Userservice\tests;

use PHPUnit\Framework\TestCase;
use Oishin\Userservice\Controllers\UserserviceController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class unitTests extends TestCase
{
    public function testGetUserById()
    {
        $controller = new UserserviceController();

        $user = $controller->getUserById(1);
        $this->assertNotNull($user->id);
        $this->assertNotNull($user->firstName);
        $this->assertNotNull($user->lastName);
        $this->assertNotNull($user->email);
        $this->assertNotNull($user->avatar);

        $user = $controller->getUserById(1000);
        $content = $user->getContent();
        $this->assertSame('[]', $content);
    }

    public function testGetUsers()
    {
        $controller = new UserserviceController();

        $users = $controller->getUsers(1);
        $this->assertNotEmpty($users);
        foreach ($users as $user) {
            $this->assertNotNull($user->id);
            $this->assertNotNull($user->firstName);
            $this->assertNotNull($user->lastName);
            $this->assertNotNull($user->email);
            $this->assertNotNull($user->avatar);
        }
    
        $response = $controller->getUsers(1000);
        $this->assertSame(200, $response->getStatusCode()); // Ensure status is OK
        $this->assertSame([], json_decode($response->getContent(), true));
    }

    public function testCreateUser()
    {
        $controller = new UserserviceController();

        $request = new Request(['name' => 'Oishin', 'job' => 'Dev']);
        $response = $controller->createUser($request);
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode()); // Ensure status code is 201
        $responseData = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('user_id', $responseData);
        $this->assertArrayHasKey('message', $responseData);
    }
}
