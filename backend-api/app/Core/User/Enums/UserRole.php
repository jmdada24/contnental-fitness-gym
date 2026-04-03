<?php

namespace App\Core\User\Enums;

enum UserRole: string{

    case Admin = 'admin';
    case Staff = 'staff';
    case Trainer = 'trainer';
    case Member = 'member';

    public static function managementValues(): array{

        return [
            self::Admin->value,
            self::Staff->value,
            self::Trainer->value,

        ];  
    }

}