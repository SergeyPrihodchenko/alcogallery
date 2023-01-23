<?php

namespace Alco\Market\Class\Token;

use DateTimeImmutable;

class Token {

    public function __construct(
        private string $token,
        private int $id_user,
        private DateTimeImmutable $expires_on
    )
    {
    }

    public function token(): string
    {
        return $this->token;
    }

    public function id_user(): int 
    {
        return $this->id_user;
    }

    public function expires_on(): DateTimeImmutable
    {
        return $this->expires_on;
    }

    public function set_expires_on(DateTimeImmutable $date): void
    {
        $this->expires_on = $date;
    }
}