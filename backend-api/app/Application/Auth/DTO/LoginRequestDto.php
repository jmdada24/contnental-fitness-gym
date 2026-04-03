<?php

namespace App\Application\Auth\DTO;


class LoginRequestDto{

    public function __construct(  
        public readonly string $email,
        public readonly string $password,
        public readonly array $allowedRoles,
        public readonly string $portal,
)
    {}

    public static function fromArray(array $payload, array $allowedRoles, string $portal):self{

        return new self(
            email: (string) ($payload['email'] ?? ''),
            password: (string) ($payload['password'] ?? ''),
            allowedRoles: $allowedRoles,
            portal: $portal,
        );

    }   

}