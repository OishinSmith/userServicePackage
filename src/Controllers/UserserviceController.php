<?php

namespace Oishin\Userservice\Controllers;

use Oishin\Userservice\DTO\UserserviceDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Oishin\Userservice\Interfaces\UserserviceInterface;

class UserserviceController implements UserserviceInterface
{

    public function getUserById(int $id)
    {
        try {
            $response = Http::get("https://reqres.in/api/users/{$id}");
            $responseJson = $response->json();
            if (empty($responseJson)) {
                return response()->json($responseJson, 200);
            }

            $userData = $responseJson['data']; // Access response as array directly
        
            return new UserserviceDTO(
                $userData['id'] ?? null,
                $userData['first_name'] ?? null,
                $userData['last_name'] ?? null,
                $userData['email'] ?? null,
                $userData['avatar'] ?? null
            );
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function getUsers(int $page = 1)
    {
        try {
            $response = Http::get("https://reqres.in/api/users?page={$page}");
            $responseJson = $response->json();
            if (empty($responseJson)) {
                return response()->json($responseJson, 200);
            }
            $userData = $responseJson['data']; // Access response as array directly
            
            $users = [];
            foreach ($userData as $user) {
                $users[] = new UserserviceDTO(
                    $user['id'] ?? null,
                    $user['first_name'] ?? null,
                    $user['last_name'] ?? null,
                    $user['email'] ?? null,
                    $user['avatar'] ?? null
                );
            }
            
            return $users;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function createUser(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'job' => 'required|string',
        ]);

        $response = Http::post('https://reqres.in/api/users', [
            'name' => $validatedData['name'],
            'job' => $validatedData['job'],
        ]);

        $userId = $response->json('id');

        $message = "User created successfully.";

        return response()->json(['user_id' => $userId, 'message' => $message], 201);
    }

}
