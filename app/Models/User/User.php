<?php

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRoleEnum;
use App\Enums\UserStatusEnum;
use App\Models\Locations\Location;
use App\Traits\HasTimestamps;
use App\Traits\InteractsWithTimestamps;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'status',
        'password',
        'logged_at',
        'name',
        'surname',
        'patronymic',
        'phone',
        'passport',
        'birth_date',
        'role',
        'get_time_mutator',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'status' => UserStatusEnum::class,
        'role' => UserRoleEnum::class,
        'logged_at' => 'datetime',
    ];

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(
            Location::class, 'users_locations',
            'user_id',
            'location_id'
        )->using(UserLocations::class);
    }
}
