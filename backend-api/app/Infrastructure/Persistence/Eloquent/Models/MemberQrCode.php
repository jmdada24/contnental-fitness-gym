<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MemberQrCode extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'member_id',
        'membership_id',
        'token',
        'status',
        'issued_at',
        'expires_at',
        'revoked_at',
        'issued_by_user_id',

    ];  

    protected function casts(): array{

        return [
            'issued_at' => 'datetime',
            'expires_at' => 'datetime',
            'revoked_at' => 'datetime',

        ];
    }

    public function member(): BelongsTo{
        return $this->belongsTo(Member::class);

    }

    public function membership(): BelongsTo{
        return $this->belongsTo(Membership::class);

    }

    // public function scans(): HasMany{
    //     return $this->hasMany();

    // }

    public function issuedBy(): BelongsTo{
        return $this->belongsTo(\App\Infrastructure\Persistence\Eloquent\Models\User::class, 'issued_by_user_id');

    }

}
