<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\DateHelperTrait;
use Carbon\Carbon;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasRoles, DateHelperTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'mobile',
        'otp',
        'email',
        'password',
        'state',
        'city',
        'address',
        'show_pwd',
        'wallet',
        'date_of_birth',
        'uuid',
        'username',
        'role_id',
        'referral_user_id',
        'profile_image',
        'status'
    ];

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
    
    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referral_user_id');
    }
    
    public function profileImage(): BelongsTo
    {
        return $this->belongsTo(ProfileImage::class, 'profile_image_id');
    }
    
    public function Payin(): BelongsTo
    {
        return $this->belongsTo(Payin::class,'user_id');
    }
}

