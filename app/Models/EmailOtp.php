<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailOtp extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'otp',
        'is_verified',
        'created_at',
        'updated_at',
        'otp_expire',
    ];
}
