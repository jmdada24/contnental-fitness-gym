<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MembershipPlan extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'price',
        'duration_days',
        'includes_qr',
        'features',
        'is_active',


    ];

    protected function casts(): array{

        return[
            'price' => 'decimal:2',
            'includes_qr' => 'boolean',
            'features' => 'array',
            'is_active' => 'boolean',


        ];

    }

    public function memberships(): HasMany{
        return $this->hasMany(Membership::class);

    }

}
