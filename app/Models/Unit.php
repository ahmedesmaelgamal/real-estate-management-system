<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends BaseModel
{
    use HasFactory;

    protected $table = 'units';
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

//    public function users()
//    {
//        return $this->hasMany(UnitOwner::class, 'user_id');
//    }




    public function getOwners()
    {
        return $this->belongsToMany(User::class, 'unit_owners', 'unit_id', 'user_id');
    }

    public function RealState()
    {
        return $this->belongsTo(RealState::class, 'real_state_id');
    }

    public function association()
    {
        return $this->hasOneThrough(
            Association::class,
            RealState::class,
            'id',
            'id',
            'real_state_id',
            'association_id'
        );
    }



    public function realStateDetails()
    {
        return $this->RealState ? $this->RealState->realStateDetails : collect();
    }

    public function unitOwners()
    {
        return $this->hasMany(UnitOwner::class, 'unit_id');
    }

      public function unitElectric()
    {
        return $this->hasMany(UnitElectric::class, 'unit_id');
    }
    public function unitWater()
    {
        return $this->hasMany( UnitWater::class, 'unit_id');
    }



}
