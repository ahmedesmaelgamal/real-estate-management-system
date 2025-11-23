<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealStateOwnerShop extends Model
{
    use HasFactory;

    protected $table = 'real_state_owners';

    protected $fillable = ["user_id", "real_state_id"];


}
