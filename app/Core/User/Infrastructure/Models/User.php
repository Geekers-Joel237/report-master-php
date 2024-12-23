<?php

namespace App\Core\User\Infrastructure\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Core\ACL\Infrastructure\Models\ModelHasRole;
use App\Core\ACL\Infrastructure\Models\Role;
use App\Core\Shared\Domain\Exceptions\InvalidCommandException;
use App\Core\User\Infrastructure\database\factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id')
            ->using(ModelHasRole::class)
            ->withTimestamps();
    }

    /**
     * @throws InvalidCommandException
     */
    public function toDomain(): \App\Core\User\Domain\Entities\User
    {
        return \App\Core\User\Domain\Entities\User::createFromAdapter(
            id: $this->id,
            name: $this->name,
            email: $this->email,
            password: $this->password,
            roles: $this->roles->pluck('name')->toArray(),
        );
    }

    public function softDelete(): void
    {
        $this->fill([
            'is_deleted' => 1,
            'deleted_at' => date('Y-m-d H:i:s'),
        ])->save();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
