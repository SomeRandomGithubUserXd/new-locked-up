<?php

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRoleEnum;
use App\Enums\UserStatusEnum;
use App\Models\Location;
use App\Models\Quests\Quest;
use App\Models\Sales\SaleQuest;
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
    use HasApiTokens, HasFactory, Notifiable, InteractsWithTimestamps, HasTimestamps;

    // Since table in the old DB is called that ridiculous way
    protected $table = 'user';

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
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'status' => UserStatusEnum::class,
        'role' => UserRoleEnum::class,
    ];

    public function loggedAt(): Attribute
    {
        return $this->getTimeMutator();
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(
            Location::class, 'user_locations',
            'user_id',
            'locations_id'
        )->using(UserLocations::class);
    }
}
