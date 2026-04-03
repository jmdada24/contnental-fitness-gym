<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    //
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'member_code',
        'first_name',
        'last_name',
        'email',
        'phone',
        'birth_date',
        'gender',
        'address',
        'emergency_contact_name',
        'emergency_contact_phone',
        'notes',
        'profile_photo_data',
        'is_archived',
        'archive_at',


    ];  

    protected function casts(): array{

        return[
            'birth_date' => 'date',
            'is_archived' => 'boolean',
            'archived_at' => 'datetime',

        ];
    }

    public function user(): BelongsTo{
        return $this->belongsTo(\App\Infrastructure\Persistence\Eloquent\Models\User::class);

    }

    public function memberships(): HasMany{

        return $this->hasMany(Membership::class);

    }

}