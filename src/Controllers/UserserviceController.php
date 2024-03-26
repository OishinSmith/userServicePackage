<?php

namespace Oishin\Userservice\Controllers;

use Oishin\Userservice\DTO\UserserviceDTO;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Oishin\Userservice\Interfaces\UserserviceInterface;
use Oishin\Userservice\Models\User;

class UserserviceController implements UserserviceInterface
{

    public function getUserById(int $id): string
    {
        try {
            $client = new Client();
            $response = $client->get("https://reqres.in/api/users/{$id}");
            $userData = json_decode($response->getBody(), true);
            
            if (empty($userData)) {
                return json_encode($user);
            }
            
            $userData = $userData['data'];

            $dto = new UserserviceDTO(
                $userData['id'] ?? null,
                $userData['first_name'] ?? null,
                $userData['last_name'] ?? null,
                $userData['email'] ?? null,
                $userData['avatar'] ?? null
            );

            $user = new User();
            $user->id = $dto->id;
            $user->firstName = $dto->firstName;
            $user->lastName = $dto->lastName;
            $user->email = $dto->email;
            $user->avatar = $dto->avatar;

            return json_encode($user);

        }  catch (\Exception $e) {

            return response()->json(['error' => 'Failed to fetch user data'], 500);
        }
    }

    public function getUsers(int $page = 1): string
    {
        try {
            $client = new Client();
            $response = $client->get("https://reqres.in/api/users?page={$page}");
            $responseJson = json_decode($response->getBody(), true);
            if (empty($responseJson)) {
                return [];
            }
            $userData = $responseJson['data'];
           
            $users = [];
            foreach ($userData as $user) {
                $dto = new UserserviceDTO(
                    $user['id'] ?? null,
                    $user['first_name'] ?? null,
                    $user['last_name'] ?? null,
                    $user['email'] ?? null,
                    $user['avatar'] ?? null
                );

                $user = new User();
                $user->id = $dto->id;
                $user->firstName = $dto->firstName;
                $user->lastName = $dto->lastName;
                $user->email = $dto->email;
                $user->avatar = $dto->avatar;

                $users[] = $user;
            }
            
            return json_encode($users);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch user data'], 500);
        }
    }

    public function createUser(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'job' => 'required|string',
        ]);

        try {
            $client = new Client();
            $response = $client->post('https://reqres.in/api/users', [
                'json' => [
                    'name' => $validatedData['name'],
                    'job' => $validatedData['job'],
                ]
            ]);
    
            $userId = json_decode($response->getBody(), true)['id'];
    
            $message = "User created successfully.";
    
            return response()->json(['user_id' => $userId, 'message' => $message], 201);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Failed to create user'], 500);
        }

    }

}
