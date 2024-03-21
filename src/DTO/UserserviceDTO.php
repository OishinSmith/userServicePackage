<?php

namespace Oishin\Userservice\DTO;

class UserserviceDTO implements \JsonSerializable
{
    public int $id;
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $avatar;

    public function __construct(int $id, string $firstName, string $lastName, string $email, string $avatar)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->avatar = $avatar;
    }
    
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'avatar' => $this->avatar,
        ];
    }
}