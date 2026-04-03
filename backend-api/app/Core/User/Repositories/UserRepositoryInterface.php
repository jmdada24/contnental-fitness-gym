<?php

namespace App\Core\User\Repositories;

interface UserRepositoryInterface{

    public function findById(int $id): ?object;

    public function findByEmail(string $email): ?object;

    public function create(array $payload): object;

    public function save(object $user): object;


}