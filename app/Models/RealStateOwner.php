<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class RealStateOwner extends BaseModel
{
    use HasFactory;
    protected $fillable = ["user_id" , "real_state_id"];
    protected $casts = [];
    protected $table ="real_state_owners";


    public function user()
    {
        return $this->belongsTo(User::class , "user_id");
    }
    public function realState()
    {
        return $this->belongsTo(RealState::class,'real_state_id');
    }





}
