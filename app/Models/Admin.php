<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $appends = ['has_relations'];

    protected $fillable = [
        'name',
        "status",
        'user_name',
        'code',
        'email',
        'password',
        'role_id',
        'image',
        'phone',
        "national_id",
        "last_logout_at",
        "last_login_at"
    ];

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id');
    }

    public function association()
    {
        return $this->hasMany(Association::class, 'association_manager_id');
    }

    public function getHasRelationsAttribute()
    {
        return $this->association()->exists();
    }

    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($model) {
            $model->append('has_relations');
        });
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

    public function caseUpdates()
    {
        return $this->morphMany(CaseUpdate::class, 'creator');
    }
}//end class
