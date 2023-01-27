<?php

namespace Alco\Market\Class\Repository;

use Alco\Market\Class\Token\Token;
use DateTimeImmutable;
use Exception;
use PDO;

class TokensRepository {

    public function __construct(
        private PDO $connect
    )
    {
    }

    public function save(Token $token): void 
    {
        $query = <<<SQL
        INSERT INTO tokens (
            token,
            id_user,
            expires_on
        ) VALUES (
            :token,
            :id_user,
            :expires_on
        )
    SQL;
            
        try {

            $statement = $this->connect->prepare($query);
            $statement->execute([
                ':token' => $token->token(),
                ':id_user' => $token->id_user(),
                ':expires_on' => ($token->expires_on())->format(DateTimeImmutable::ATOM)
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    public function getTokenById($id): mixed 
    {
        $query = <<< 'SQL'
            SELECT * FROM tokens
            WHERE id_user = :id_user;
        SQL;

        try {
            $statement = $this->connect->prepare($query);
            $statement->execute([
                ':id_user' => $id
            ]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        if($result === false) {
            return false;
        } 
           
        return new Token(
            $result['token'],
            $result['id_user'],
            new DateTimeImmutable($result['expires_on'])
        );
        
    }

    public function updateExpires($token, $expires) {

        $query = <<< 'SQL'
            UPDATE tokens
            SET expires_on = :expires_on
            WHERE token = :token
        SQL;

        try {
            $statement = $this->connect->prepare($query);
            $statement->execute([
                ':expires_on' => $expires,
                ':token' => $token
            ]);
            } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getTokenByToken(string $token): Token 
    {
        try {

            $statement = $this->connect->prepare("SELECT * FROM tokens WHERE token = :token;");
            $statement->execute([
                ':token' => $token
            ]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return new Token(
            $result['token'],
            $result['id_user'],
            new DateTimeImmutable($result['expires_on'])
        );
    } 
}