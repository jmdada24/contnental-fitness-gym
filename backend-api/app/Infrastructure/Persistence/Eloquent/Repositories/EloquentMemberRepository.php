<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Core\Membership\Repositories\MemberRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\Member;
use Illuminate\Database\Eloquent\Builder;

class EloquentMemberRepository implements MemberRepositoryInterface{


    public function findByID(int $id): ?object{
        return Member::query()->find($id);

    }

    public function findByIdForUpdate(int $id): ?object{
        return Member::query()->lockForUpdate()->find($id);

    }

    public function findByUserId(int $userId): ?object{
        return Member::query()->where('user_id', $userId)->first();


    }

    public function findByMemberCode(string $memberCode): ?object{
        return Member::query()->where('member_code', $memberCode)->first();


    }

    public function findByMemberForUpdateCode(string $memberCode): ?object{
        return Member::query()->where('member_code', $memberCode)->lockForUpdate()->first();

    }


    public function existByMemberCode(string $memberCode): ?object{
        return Member::query()->where('member_code', $memberCode)->exists();


    }

    public function paginate(int $perPage = 10): array{
        return Member::query()->latest('id')->paginate($perPage)->items();

    }

    public function paginateWithLatestMembership(int $perPage = 20, int $page = 1): object{
        $safePerPage = max(1, min($perPage, 100));
        $safePage = max(1, $page);

        return Member::query()
            ->with([
                'memberships' => static fn ($query) => $query
                    ->with('plan:id,name')->latest('id'),

            ])
            ->latest('id')
            ->paginate($safePerPage, ['*'], 'page', $safePage);

    }

    public function listWithLatestMembershipForExport(
        ?string $createdFrom = null, 
        ?string $createdTo = null, 
        ?int $page = null, 
        ?int $perPage = null
        ): array
    {
        $query = Member::query()
            ->with([
                'memberships' => static fn ($membershipQuery) => $membershipQuery
                    ->with('plan:id,name')
                    ->latest('id'),
            ])
            ->latest('id');

        $this->applyCreatedAtRange($query, $createdFrom, $createdTo);

        if ($page !== null && $perPage !== null) {
            $safePage = max(1, $page);
            $safePerPage = max(1, min($perPage, 500));

            return $query->paginate($safePerPage, ['*'], 'page', $safePage)
                ->getCollection()
                ->all();
        }

        return $query->get()->all();

    }

    public function membershipGrowthByDate(
        ?string $createdFrom = null,
        ?string $createdTo = null,
    ): array {
        $query = Member::query();
        $this->applyCreatedAtRange($query, $createdFrom, $createdTo);

        return $query
            ->selectRaw('DATE(created_at) as period_date, COUNT(*) as new_members')
            ->groupBy('period_date')
            ->orderBy('period_date')
            ->get()
            ->all();
    }


    public function countCreatedBefore(string $dateTime): int
    {
        return Member::query()->where('created_at', '<', $dateTime)->count();
    }

    public function create(array $payload): object
    {
        return Member::query()->create($payload);
    }

    public function update(int $id, array $payload): object
    {
        $member = Member::query()->findOrFail($id);
        $member->update($payload);

        return $member->fresh();
    }

    public function markArchived(int $id): object
    {
        $member = Member::query()->findOrFail($id);
        $member->update([
            'is_archived' => true,
            'archived_at' => now(),
        ]);

        return $member;
    }

    public function delete(int $id): void
    {
        Member::query()->findOrFail($id)->delete();
    }

    private function applyCreatedAtRange(Builder $query, ?string $createdFrom, ?string $createdTo): void
    {
        if ($createdFrom) {
            $query->where('created_at', '>=', $createdFrom);
        }

        if ($createdTo) {
            $query->where('created_at', '<=', $createdTo);
        }
    }

}
