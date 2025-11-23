<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ContractParty extends Model
{
    use HasFactory, HasTranslations;

    protected $translatable = ['title'];
    protected $fillable = ['title'];


    public function firstContracts()
    {
        return $this->hasMany(Contract::class, 'contract_first_party_id');
    }


    public function secondContracts()
    {
        return $this->hasMany(Contract::class, 'contract_second_party_id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
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
