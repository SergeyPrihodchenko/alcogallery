<?php

namespace Alco\Market\Class\Repository;

use Alco\Market\Class\Users\User;
use DateTimeImmutable;
use Exception;
use PDO;

class UsersRepository {

    function __construct(
        private PDO $connect
    )
    {     
    }

    public function getUser($nickName, $pass): User
    {
        try {
            $password = hash('sha3-256', $nickName . $pass);
            $statement = $this->connect->prepare("SELECT * FROM users WHERE password = :password;");
            $statement->execute([':password' => $password]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return new User(
            $result['id'],
            $result['nickName'],
            $result['password']
        );
    } 
}