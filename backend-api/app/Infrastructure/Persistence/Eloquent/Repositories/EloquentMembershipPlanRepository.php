<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Core\Membership\Repositories\MembershipPlanRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\MembershipPlan;

class EloquentMembershipPlanRepository implements MembershipPlanRepositoryInterface{

    public function findActiveById(int $id): ?object{
        return MembershipPlan::query()
            ->where('is_active', true)
            ->find($id);
    }
    
    public function listActiveOrderedByPrice(): array{
        return MembershipPlan::query()
            ->where('is_active', true)
            ->orderBy('price')
            ->get([
                'id',
                'code',
                'name',
                'description',
                'price',
                'duration_days',
                'includes_qr',
            ])
            ->all();

    }

}