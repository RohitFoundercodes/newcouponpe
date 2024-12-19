<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Traits\DateHelperTrait;

class Payin extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, DateHelperTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'amount',
        'transaction_id',
        'paymode_id',
        'send_response',
        'get_response',
        'payment_status',
        'getway_status',
        'image',
        'status'
    ];
    
    
    
    //  public function user(): HasOne
    // {
    //     return $this->hasOne(User::class, 'id');
    // }
    
    
      public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
    
}