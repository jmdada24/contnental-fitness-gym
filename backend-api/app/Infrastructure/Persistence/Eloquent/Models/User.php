<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use App\Core\User\Enums\UserRole;
use App\Core\User\Enums\UserStatus;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable{

    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    protected string $guard_name = "web";

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'must_create_password',
        'created_by_admin',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */

    protected $hidden = [
        'password',
        'remember_token'

    ];
    
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array{
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatus::class,
            'must_change_password' => 'boolean',
            'created_by_admin' => 'boolean',
            
        ];

    }

    public function isActive(){
        return($this->status ?? UserStatus::Active) === UserStatus::Active;

    }

    public function canAccessManagementPortal(): bool{
        return $this->hasAnyRole(UserRole::managementValues());

    }

    public function canAccessMemberPortal(): bool{
        return $this->hasRole(UserRole::Member->value);

    }

    protected function email(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value): ?string => $value === null ? null : strtolower(trim($value)),

        );
    
    }
    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value): ?string => $value === null ? null : trim(preg_replace('/\s+/',' ', $value) ?? $value),
        );

    }

    protected static function newFactory():Factory
    {
        return UserFactory::new();
    }

    public function getMorphClass()
    {
        return \App\Models\User::class;
    }

}