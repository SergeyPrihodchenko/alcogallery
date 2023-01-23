<?php

namespace Alco\Market\Class\Users;

class User {

    function __construct(
        private int $id,
        private string $nickName,
        private string $hashPass
    )
    {
    }

    public function id(): int 
    {
        return $this->id;
    }

    public function nickName(): string 
    {
        return $this->nickName;
    }

    public function hashPass(): string 
    {
        return $this->hashPass;
    } 

    private static function hashedPass($password, $nickName): string 
    {
        return hash('sha3-256', $password . $nickName);
    }

    public static function getUser($id, $nickName, $password): User
    {
        return new User(
            $id,
            $nickName,
            static::hashedPass($password, $nickName)
        );
    }
}