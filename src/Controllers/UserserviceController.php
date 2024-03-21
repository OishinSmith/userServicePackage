<?php

namespace Oishin\Userservice\Controllers;

use Oishin\Userservice\DTO\UserserviceDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Oishin\Userservice\Interfaces\UserServiceInterface;

class UserserviceController implements UserserviceInterface
{

    public function getUserById(int $id): ?UserserviceDTO
    {
        $response = Http::get("https://reqres.in/api/users/{$id}");
        $userData = $response->json()['data']; // Assuming the ID is under 'data' key

        return $userDTO = new UserserviceDTO(
            $userData['id'],
            $userData['first_name'],
            $userData['last_name'],
            $userData['email'],
            $userData['avatar']
        );
    }

    public function getUsers(int $page = 1): ?UserserviceDTO
    {
        $response = Http::get("https://reqres.in/api/users?page={$page}");
        $userData = $response->json()['data'];

        return $userDTO = new UserserviceDTO(
            $userData['id'],
            $userData['first_name'],
            $userData['last_name'],
            $userData['email'],
            $userData['avatar']
        );
    }

    public function createUser(Request $request): ?array
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'job' => 'required|string',
        ]);

        $userId = $this->userService->createUser($validatedData['name'], $validatedData['job']);
    
        return response()->json(['user_id' => $userId], 201);
    }

}
