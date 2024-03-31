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
        // Mock the Guzzle client
        $clientMock = $this->createMock(Client::class);

        // Create an instance of Response with desired data
        $userData = [
            'id' => 1,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'avatar' => 'https://example.com/avatar.jpg',
        ];
        $response = new Response(200, [], json_encode(['data' => $userData]));

        // Set up the mock to return the response
        $clientMock->method('request')->willReturn($response);

        $controller = new UserserviceController($clientMock);

        // Call the method being tested
        $result = $controller->getUserById(1);

        // Assertions
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
        $clientMock = $this->createMock(Client::class);
        $response = new Response(200, [], json_encode(['data' => $userData]));
        $clientMock->method('request')->willReturn($response);
        $controller = new UserserviceController($clientMock);

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

        $result = $controller->getUsers($page);
        $this->assertEquals(json_encode($expectedUsers), $result);
    }

    
    public function testCreateUser()
    {
        // Mock the Guzzle client
        $clientMock = $this->createMock(Client::class);

        // Mocked request body
        $requestBody = json_encode([
            'name' => 'John Doe',
            'job' => 'Developer'
        ]);

        $responseData = [
            'id' => 123,
            'name' => 'John Doe',
            'job' => 'Developer',
            'createdAt' => '2024-03-31T12:00:00Z'
        ];

        $response = new Response(201, [], json_encode(['data' => $responseData]));

        $clientMock->method('request')->willReturn($response);

        $controller = new UserserviceController($clientMock);

        // Call the method being tested
        $result = $controller->createUser();

        // Assertions
        $expectedUser = new \Oishin\Userservice\Models\User();
        $expectedUser->id = $userData['id'];
        $expectedUser->firstName = $userData['first_name'];
        $expectedUser->lastName = $userData['last_name'];
        $expectedUser->email = $userData['email'];
        $expectedUser->avatar = $userData['avatar'];

        $body = $result->getBody()->getContents();
        $expectedResult = '{"error":"Empty body"}';
        $this->assertEquals($expectedResult, $body);
    }
}
