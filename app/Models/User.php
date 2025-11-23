<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Translatable\HasTranslations;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ["name", "email", "password", "national_id", "phone", "status"];
    protected $appends = ['has_relations'];

    public function realStateOwners()
    {
        return $this->hasMany(RealStateOwner::class, 'user_id');
    }

    public function voteDetails()
    {
        return $this->belongsToMany(VoteDetail::class, 'vote_details_has_users', 'user_id', 'vote_detail_id')
            ->withPivot(['stage_number', 'vote_action', 'vote_creator', 'admin_id'])
            ->withTimestamps();
    }


    public function realStates()
    {
        return $this->belongsToMany(RealState::class);
    }

    public function unitOwners()
    {
        return $this->hasMany(UnitOwner::class, 'user_id');
    }

    // إذا لم تستخدم الـ Trait، يمكنك تعريف الدالة مباشرة

    // في موديل User

    public function getHasRelationsAttribute()
    {
        return $this->realStateOwners()->exists() ||
            $this->unitOwners()->exists();
    }

    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($model) {
            $model->append('has_relations');
        });
    }

    public function contracts()
    {
        return $this->belongsToMany(
            Contract::class,
            'contract_has_user',
            'user_id',
            'contract_id'
        );
    }


    public function contractPartyDetails()
    {
        return $this->morphMany(ContractPartyDetail::class, 'model')
            ->where('model_type', self::class);
    }

    public function firstContractPartyDetail()
    {
        return $this->morphOne(ContractPartyDetail::class, 'model')
            ->where('model_type', self::class)
            ->where('party_type', 'first');
    }

    public function secondContractPartyDetail()
    {
        return $this->morphOne(ContractPartyDetail::class, 'model')
            ->where('model_type', self::class)
            ->where('party_type', 'second');
    }
}
