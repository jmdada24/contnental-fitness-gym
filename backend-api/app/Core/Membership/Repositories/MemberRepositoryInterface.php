<?php

namespace App\Core\Membership\Repositories;

interface MemberRepositoryInterface{

    public function findByID(int $id): ?object;

    public function findByIdForUpdate(int $id): ?object;

    public function findByUserId(int $userId): ?object;

    public function findByMemberCode(string $memberCode): ?object;

    public function findByMemberForUpdateCode(string $memberCode): ?object;

    public function existByMemberCode(string $memberCode): ?object;

    /**
     * @return array<int, object>
     */
    public function paginate(int $perPage = 10): array;

    public function paginateWithLatestMembership(int $perPage = 20, int $page = 1): object;


    /**
     * @return array<int, object>
     */
    public function listWithLatestMembershipForExport(
        ?string $createdFrom = null,
        ?string $createdTo = null,
        ?int $page = null,
        ?int $perPage = null,

    ): array;


    /**
     * @return array<int, object>
     */
    public function membershipGrowthByDate(
        ?string $createdFrom = null,
        ?string $createdTo = null,

    ): array;

    public function countCreatedBefore(string $dateTime): int;


    public function create(array $payload): object;

    public function update(int $id, array $payload ): object;

    public function markArchived(int $id): object;

    public function delete(int $id): void;


}