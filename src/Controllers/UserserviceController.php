<?php

namespace Oishin\Userservice\Controllers;

use Oishin\Userservice\DTO\UserserviceDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Oishin\Userservice\Interfaces\UserserviceInterface;

class UserserviceController implements UserserviceInterface
{

    public function getUserById(int $id): UserserviceDTO|array
    {
        try {
            $response = Http::get("https://reqres.in/api/users/{$id}");
            $responseJson = $response->json();
            if (empty($responseJson)) {
                return [];
            }

            $userData = $responseJson['data'];
        
            $dto = new UserserviceDTO(
                $userData['id'] ?? null,
                $userData['first_name'] ?? null,
                $userData['last_name'] ?? null,
                $userData['email'] ?? null,
                $userData['avatar'] ?? null
            );
            
            return $dto->createUser();
        }  catch (\Exception $e) {

            return response()->json(['error' => 'Failed to fetch user data'], 500);
        }
    }

    public function getUsers(int $page = 1): UserserviceDTO|array
    {
        try {
            $response = Http::get("https://reqres.in/api/users?page={$page}");
            $responseJson = $response->json();
            if (empty($responseJson)) {
                return $responseJson;
            }
            $userData = $responseJson['data']; // Access response as array directly
           
            $users = [];
            foreach ($userData as $user) {
                $dto = new UserserviceDTO(
                    $user['id'] ?? null,
                    $user['first_name'] ?? null,
                    $user['last_name'] ?? null,
                    $user['email'] ?? null,
                    $user['avatar'] ?? null
                );
                $users[] = $dto;
            }
            
            return $users;
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
            $response = Http::post('https://reqres.in/api/users', [
                'name' => $validatedData['name'],
                'job' => $validatedData['job'],
            ]);
    
            $userId = $response->json('id');
    
            $message = "User created successfully.";
    
            return response()->json(['user_id' => $userId, 'message' => $message], 201);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Failed to create user'], 500);
        }

    }

}
