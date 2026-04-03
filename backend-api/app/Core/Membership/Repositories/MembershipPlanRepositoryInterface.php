<?php

namespace App\Core\Membership\Repositories;

interface MembershipPlanRepositoryInterface
{
    public function findActiveById(int $id): ?object;

    /**
     * @return list<object>
     */
    public function listActiveOrderedByPrice(): array;
}
