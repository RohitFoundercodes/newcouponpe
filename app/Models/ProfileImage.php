<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\DateHelperTrait;

class ProfileImage extends Model
{
    use HasFactory,DateHelperTrait;

    protected $fillable = [
        'user_id',
        'panImage',
        'status'
    ];
}
