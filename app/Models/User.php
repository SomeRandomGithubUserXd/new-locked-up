<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserStatusEnum;
use App\Traits\HasTimestamps;
use App\Traits\InteractsWithTimestamps;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'logged_at'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'status' => UserStatusEnum::class,
    ];

    public function loggedAt(): Attribute
    {
        return $this->getTimeMutator();
    }
}
