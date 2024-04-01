<?php

namespace Oishin\Userservice\Models;

// this is going to act as our model which will receive data from the DTO
class User implements \JsonSerializable
{
    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $avatar;

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