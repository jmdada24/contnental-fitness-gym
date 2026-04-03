<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Membership extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'member_id',
        'membership_plan_id',
        'subscribed_by_user_id',
        'renewed_from_membership',
        'start_date',
        'end_date',
        'status',
        'auto_renew',
        'last_payment_at',
        'notes',
    ];

    protected function casts(): array{

        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'auto_renew' => 'boolean',
            'last_payment_at' => 'datetime',
        ];
    }


    public function member(): BelongsTo{
        return $this->belongsTo(Member::class);

    }

    public function plan(): BelongsTo{
        return $this->belongsTo(MembershipPlan::class, 'membership_plan_id');

    }

    // public function payments(): HasMany{
    //     return $this->hasMany(Payment::class);

    // }

    public function qrCodes(): HasMany{
        return $this->hasMany(MemberQrCode::class);

    }

    public function subscribeBy(): BelongsTo{
        return $this->belongsTo(\App\Infrastructure\Persistence\Eloquent\Models\User::class, 'subscribed_by_user_id');

    }

    public function renewedFrom(): BelongsTo{
        return $this->belongsTo(self::class, 'renewed_from_membership_id');

    }

}
