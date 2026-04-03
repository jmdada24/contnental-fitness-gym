<?php

namespace App\Application\Auth\UseCases;

use App\Application\Membership\UseCases\CreateMemberUseCase;
use App\Core\User\Repositories\UserRepositoryInterface;

class RegisterMemberUseCase{

    public function __construct(
        private readonly CreateMemberUseCase $createMemberUseCase,
        private readonly UserRepositoryInterface $userRepository,

    )
    {
      

    }


}