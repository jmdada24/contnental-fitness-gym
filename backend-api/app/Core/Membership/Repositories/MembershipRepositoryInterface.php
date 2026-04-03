<?php

namespace App\Core\Membership\Repositories;

interface MembershipRepositoryInterface{

    public function findById(int $id): ?object;

    /**
     * @param array<int, string> $relations
     */
    public function findByIdWithRelations(int $id, array $relations = []): ?object;

    public function findByIdWithPlanForUpdate(int $id): ?object;

    public function findActiveByMemberId(int $memberId): ?object;

    public function findActiveByMemberIdAndDateForUpdate(int $memberId, string $date): ?object;

    public function findActiveWithPlanAndQrCodesByMemberId(int $memberId): ?object;

    public function existsActiveForMemberIdForUpdate(int $memberId, string $activeOnDate): bool;

    public function create(array $payload): object;

    public function updateStatus(int $id, string $status): object;

}