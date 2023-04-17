<?php

namespace App\Models;

use App\Enums\UserRoleEnum;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public static string $morph_key = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthdate' => 'datetime',
        'is_banned' => 'boolean',
    ];

    protected $appends = [
        'full_name',
    ];

    public function getFullNameAttribute(): string
    {
        return ucfirst($this->name) . ' ' . ucfirst($this->lastname);
    }

    public function isUser(): bool
    {
        return $this->role == UserRoleEnum::USER;
    }

    public function isAdmin(): bool
    {
        return $this->role == UserRoleEnum::ADMIN;
    }

    public function isBanned(): bool
    {
        return $this->is_banned;
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class, 'user_id', 'id');
    }

    public function scopeSearch(Builder $query, ?string $keyword = null, ?int $id = null): Builder
    {
        if (is_numeric($id)) {
            return $query->where('id', $id)->limit(1);
        }

        if ($keyword == null) {
            return $query->limit(15);
        }

        $keywords = explode(' ', $keyword);

        if (($key = array_search('-', $keywords)) !== false) {
            unset($keywords[$key]);
        }

        foreach ($keywords as $keyword) {
            $query = $query->where(function (Builder $query) use ($keyword) {
                return $query
                    ->orWhere('name', 'LIKE', "%$keyword%")
                    ->orWhere('lastname', 'LIKE', "%$keyword%")
                    ->orWhere('email', 'LIKE', "%$keyword%");
            });
        }

        return $query->limit(15);
    }
}
