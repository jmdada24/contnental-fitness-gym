<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Core\User\Repositories\UserRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\User;

class EloquentUserRepository implements UserRepositoryInterface{

    public function findById(int $id): ?object{

        return User::query()->find($id);    
    }

    public function findByEmail(string $email): ?object
    {
        return User::query()->where('email', $email)->first();
    }

    public function create(array $payload): object
    {
        return User::query()->create($payload);

    }

    public function save(object $user): object
    {
        $user->save();

        return $user->fresh() ?? $user;
    }


}