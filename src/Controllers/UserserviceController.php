<?php

namespace Oishin\Userservice\Controllers;

use Oishin\Userservice\DTO\UserserviceDTO;
use GuzzleHttp\Client;
use Oishin\Userservice\Interfaces\UserserviceInterface;
use Oishin\Userservice\Models\User;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class UserserviceController implements UserserviceInterface
{

    public $client;

    public function __construct(Client $client = null)
    {
        $client ?? new Client();
        $this->client = $client;
    }

    public function getUserById(int $id): string|User
    {
        try {
            // Create instance of Guzzle client
            // Url + Urn
            $uri = 'https://reqres.in/api/users/'.$id;
            // A GuzzleHttp\Exception\ClientException is thrown for 400 level errors 
            // if the http_errors request option is set to true.
            try {
                $this->client = $this->client ?? new Client();
                $response = $this->client->request('GET', $uri, ['http_errors' => false]);
            } catch (RequestException $e) {
                // Return non 400 type errors
                throw new \RuntimeException($e->getMessage(), 0, $e);
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

            // user dto to transfere object to user model
            $user = new User();
            $user->id = $dto->id;
            $user->firstName = $dto->firstName;
            $user->lastName = $dto->lastName;
            $user->email = $dto->email;
            $user->avatar = $dto->avatar;

            return $user;

        }  catch (RequestException $e) {
            // Handle Guzzle HTTP errors (e.g., network issues, timeouts)
            throw new \RuntimeException($e->getMessage(), 0, $e);
        } catch (\Throwable $e) {
            // Handle other unexpected errors
            throw new \RuntimeException('An unexpected error occurred', 0, $e);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getUsers(int $page = 1): string|array
    {
        try {
            // Url + Urn
            $uri = 'https://reqres.in/api/users?page='.$page;
            
            // A GuzzleHttp\Exception\ClientException is thrown for 400 level errors 
            // if the http_errors request option is set to true.
            try {
                $this->client = $this->client ?? new Client();
                $response = $this->client->request('GET', $uri, ['http_errors' => false]);
            } catch (RequestException $e) {
                // Return non 400 type errors
                throw new \RuntimeException($e->getMessage(), 0, $e);
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

                // user dto to transfere object to user model
                $user = new User();
                $user->id = $dto->id;
                $user->firstName = $dto->firstName;
                $user->lastName = $dto->lastName;
                $user->email = $dto->email;
                $user->avatar = $dto->avatar;

                $users[] = $user;
            }
            
            return $users;
        } catch (RequestException $e) {
            // Handle Guzzle HTTP errors (e.g., network issues, timeouts)
            throw new \RuntimeException($e->getMessage(), 0, $e);
        } catch (\Throwable $e) {
            // Handle other unexpected errors
            throw new \RuntimeException('An unexpected error occurred', 0, $e);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function createUser(string $name, string $job): Response|User
    {
        try {
            $this->client = $this->client ?? new Client();
    
            $response = $this->client->post('https://reqres.in/api/users', [
                'json' => [
                    'name' => $name,
                    'job' => $job,
                ]
            ]);
    
            $responseCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody(), true);
    
            if ($responseCode !== 201) {
                // Handle non-201 status codes (e.g., 4xx, 5xx errors)
                $errorMessage = $responseBody['error'] ?? 'Unknown error occurred';
                throw new \Exception($errorMessage, $responseCode); 
            }
    
            $dto = new UserserviceDTO(
                $responseBody['id'] ?? null,
                $responseBody['name'] ?? null,
                $responseBody['job'] ?? null,
                null,
                null
            );
            // user dto to transfere object to user model
            $user = new User();
            $user->id = $dto->id;
            $user->firstName = $dto->firstName;
            $user->lastName = $dto->lastName;
            $user->email = $dto->email;
            $user->avatar = $dto->avatar;

            return $user;
        } catch (RequestException $e) {
            // Handle Guzzle HTTP errors (e.g., network issues, timeouts)
            throw new \RuntimeException($e->getMessage(), 0, $e);
        } catch (\Throwable $e) {
            // Handle other unexpected errors
            throw new \RuntimeException('An unexpected error occurred', 0, $e);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
