<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\Translatable\HasTranslations;

class RealState extends BaseModel
{
    use HasFactory, HasTranslations;

    protected $translatable = ['name'];

    protected $appends = ['has_relations'];

    protected $fillable = ["name", "number", "association_id", "status", "lat", "long", "stop_reason", 'real_state_number', "admin_id", "legal_ownership_id", "legal_ownership_other"];

    protected $casts = [
        'name' => 'array',
    ];


    protected $table = "real_state";


    public function realStateElectric()
    {
        return $this->hasMany(RealStateElectric::class, 'real_state_id');
    }



    public function realStateWater()
    {
        return $this->hasMany(RealStateWater::class, 'real_state_id');
    }

    public function realStateOwners()
    {
        return $this->hasMany(RealStateOwner::class, 'real_state_id');
    }


    public function admin()
    {
        return $this->belongsTo(Admin::class, "admin_id");
    }
    public function association()
    {
        return $this->belongsTo(Association::class, 'association_id');
    }

    public function realStateDetails()
    {
        return $this->hasOne(RealStateDetail::class, "real_state_id");
    }

    public function RealStateOwnerShips()
    {
        return $this->hasMany(RealStateOwner::class, 'real_state_id');
    }
    public function Units()
    {
        return $this->hasMany(Unit::class, 'real_state_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'real_state_owners');
    }

    public function legalOwnership()
    {
        return $this->belongsTo(LegalOwnership::class, 'legal_ownership_id');
    }

      public function getHasRelationsAttribute()
    {
        return $this->Units()->exists();
    }

    // the booted function to add admin_id
    // public static function booted(){
    //     static::created(function ($model) {
    //         $model->admin_id = auth()->user()->id;
    //     });
    //     static::updated(function ($model) {
    //         $model->admin_id = auth()->user()->id;
    //     });
    // }
}
