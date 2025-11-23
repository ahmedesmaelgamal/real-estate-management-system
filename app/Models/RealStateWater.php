<?php

namespace App\Models;

use Faker\Provider\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealStateWater extends BaseModel
{
    protected $guarded = [];
    use HasFactory;


    public function RealState()
    {
        return $this->belongsTo(RealState::class,'real_state_id');
    }

}
