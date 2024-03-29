<?php

namespace Oishin\Userservice\Controllers;

use Oishin\Userservice\DTO\UserserviceDTO;
use GuzzleHttp\Client;
use Oishin\Userservice\Interfaces\UserserviceInterface;
use Oishin\Userservice\Models\User;

class UserserviceController implements UserserviceInterface
{

    public function getUserById(int $id): string
    {
        try {
            // Create instance of Guzzle client
            $client = new Client();
            // Url + Urn
            $uri = 'https://reqres.in/api/users/'.$id;
            // A GuzzleHttp\Exception\ClientException is thrown for 400 level errors 
            // if the http_errors request option is set to true.
            try {
                $response = $client->request('GET', $uri, ['http_errors' => false]);
            } catch (RequestException $e) {
                // Return non 400 type errors
                return response()->json(['error' => $e->getMessage()], 500);
            }

            $responseCode = $response->getStatusCode();
            
            if ($responseCode == 404) {
                return '{}';
            }
            
            $userData = json_decode($response->getBody(), true);
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
            // Create instance of Guzzle client
            $client = new Client();
            // Url + Urn
            $uri = 'https://reqres.in/api/users?page='.$page;
            
            // A GuzzleHttp\Exception\ClientException is thrown for 400 level errors 
            // if the http_errors request option is set to true.
            try {
                $response = $client->request('GET', $uri, ['http_errors' => false]);
            } catch (RequestException $e) {
                // Return non 400 type errors
                return response()->json(['error' => $e->getMessage()], 500);
            }

            $responseCode = $response->getStatusCode();
            
            if ($responseCode == 404) {
                return '{}';
            }
            
            $userData = json_decode($response->getBody(), true);
            $userData = $userData['data'];
            
            if (empty($userData)) {
                return '{}';
            }
           
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

    public function createUser()
    {
        $requestBody = file_get_contents('php://input');
        $requestJson = json_decode($requestBody);

        try {

            
            try {
                $client = new Client();
                $uri = 'https://reqres.in/api/users';
                $response = $client->post($uri, [
                    'json' => [
                        'name' => $requestJson->name,
                        'job' => $requestJson->job,
                    ]
                ]);
    
            } catch (RequestException $e) {
                // Return non 400 type errors
                return response()->json(['error' => $e->getMessage()], 500);
            }

            $responseCode = $response->getStatusCode();
            $userId = json_decode($response->getBody(), true);
    
            $message = "User created successfully.";
    
            return response()->json($userId, $responseCode);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Failed to create user'], 500);
        }

    }

}
