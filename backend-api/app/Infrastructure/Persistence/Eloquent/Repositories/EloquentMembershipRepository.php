<?php

use App\Core\Membership\Repositories\MembershipRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\Membership;

class EloquentMembershipRepository implements MembershipRepositoryInterface{


    public function findById(int $id): ?object{
        return Membership::query()->find($id);

    }

    public function findByIdWithRelations(int $id, array $relations = []): ?object{

        return Membership::query()->with($relations)->find($id);

    }

    public function findByIdWithPlanForUpdate(int $id): ?object{
        return Membership::query()
            ->with('plan')
            ->lockForUpdate()
            ->find($id);

    }

    public function findActiveByMemberId(int $memberId): ?object{
        return Membership::query()
            ->where('member_id', $memberId)
            ->where('status', 'active')
            ->whereDate('end_date', '>=', now()->toDateString())
            ->latest('id')
            ->first();

    }

    public function findActiveByMemberIdAndDateForUpdate(int $memberId, string $date): ?object{

        return Membership::query()
            ->where('member_id', $memberId)
            ->where('status', 'active')
            ->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date)
            ->lockForUpdate()
            ->latest('id')
            ->first();

    }

    public function findActiveWithPlanAndQrCodesByMemberId(int $memberId): ?object{

        return Membership::query()
            ->with(['plan', 'qrCodes'])
            ->where('member_id', $memberId)
            ->where('status', 'active')
            ->whereDate('end_date', '>=', now()->toDateString())
            ->latest('id')
            ->first();

    }

    public function existsActiveForMemberIdForUpdate(int $memberId, string $activeOnDate): bool{

        return Membership::query()
            ->where('member_id', $memberId)
            ->where('status', 'active')
            ->whereDate('end_date', '>=', $activeOnDate)
            ->lockForUpdate()
            ->exists();

    }

    public function create(array $payload): object{
        return Membership::query()->create($payload);

    }

    public function updateStatus(int $id, string $status): object{
        $membership = Membership::query()->findOrFail($id);
        $membership->update(['status' => $status]);

        return $membership->fresh();

    }



}