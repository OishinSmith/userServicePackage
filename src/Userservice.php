<?php

namespace Oishin\Userservice;

use Illuminate\Support\Facades\Http;

class Userservice {
    public function getUserById($id)
    {
        $response = Http::get("https://reqres.in/api/users/{$id}");
        return $response->json();
    }

    public function getUsers($page = 1)
    {
        $response = Http::get("https://reqres.in/api/users?page={$page}");
        return $response->json();
    }

    public function createUser($name, $job)
    {
        $response = Http::post("https://reqres.in/api/users", [
            'name' => $name,
            'job' => $job,
        ]);
        return $response->json();
    }
}