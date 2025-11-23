<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetHasUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'meet_id',
        'user_id',
    ];
}
