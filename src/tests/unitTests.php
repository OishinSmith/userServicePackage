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

    protected $controller;

    protected function setUp(): void
    {
        $clientMock = $this->createMock(Client::class);
        $this->controller = new UserserviceController($clientMock);
    }

 public function testGetUserById()
    {
        $userId = 1;
        $userData = [
            'id' => $userId,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'avatar' => 'https://example.com/avatar.jpg',
        ];
        $response = new Response(200, [], json_encode(['data' => $userData]));

        $this->controller->client->expects($this->once())
            ->method('request')
            ->with('GET', 'https://reqres.in/api/users/' . $userId, ['http_errors' => false])
            ->willReturn($response);

        $result = $this->controller->getUserById($userId);

        $expectedUser = new \Oishin\Userservice\Models\User();
        $expectedUser->id = $userData['id'];
        $expectedUser->firstName = $userData['first_name'];
        $expectedUser->lastName = $userData['last_name'];
        $expectedUser->email = $userData['email'];
        $expectedUser->avatar = $userData['avatar'];

        $this->assertEquals(json_encode($expectedUser), $result);
    }

    public function testGetUsers()
    {
        $page = 1;
        $userData = [
            [
                'id' => 1,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'avatar' => 'https://example.com/avatar.jpg',
            ],
            [
                'id' => 2,
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'email' => 'jane@example.com',
                'avatar' => 'https://example.com/avatar.jpg',
            ],
        ];
        $response = new Response(200, [], json_encode(['data' => $userData]));
        $this->controller->client->expects($this->once())
            ->method('request')
            ->with('GET', 'https://reqres.in/api/users?page=' . $page, ['http_errors' => false])
            ->willReturn($response);

        $expectedUsers = [];
        foreach ($userData as $data) {
            $user = new \Oishin\Userservice\Models\User();
            $user->id = $data['id'];
            $user->firstName = $data['first_name'];
            $user->lastName = $data['last_name'];
            $user->email = $data['email'];
            $user->avatar = $data['avatar'];
            $expectedUsers[] = $user;
        }

        $result = $this->controller->getUsers($page);

        $this->assertEquals(json_encode($expectedUsers), $result);
    }

    // Write test cases for other methods like createUser()
}
