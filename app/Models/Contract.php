<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Contract extends Model
{
    use HasFactory, HasTranslations;

    protected $translatable = ["title"];

    protected $casts = [
        'date' => 'datetime',
    ];

    protected $fillable = [
        //        main info
        "contract_type_id",
        "contract_name_id",
        "date",
        "contract_location_id",
        "contract_terms_id",
        "contract_address",
        "introduction",
        "contract_type",
        "contract_first_party_id",
        "contract_second_party_id",
        "contract_location",
        "association_id",
    ];

    public function contractType()
    {
        return $this->belongsTo(ContractType::class, 'contract_type_id');
    }


    public function association()
    {
        return $this->belongsTo(Association::class);
    }
    /**
     * Relation with ContractName
     */
    public function contractName()
    {
        return $this->belongsTo(ContractName::class, 'contract_name_id');
    }


    public function contractLocation()
    {
        return $this->belongsTo(ContractLocation::class, 'contract_location_id');
    }

    /**
     * Relation with ContractTerms
     */
    public function contractTerms()
    {
        return $this->belongsToMany(
            ContractTerm::class,
            'contract_has_terms',
            'contract_id',
            'contract_term_id'
        );
    }

    /**
     * Relation with ContractParty
     */
    public function contractParty()
    {
        return $this->belongsTo(ContractParty::class, 'contract_party_id');
    }




    // public function users()
    // {
    //     return $this->belongsToMany(
    //         User::class,              
    //         'contract_has_user',      
    //         'contract_id',            
    //         'user_id'                 
    //     );
    // }




    // the general party details relation


    public function contractPartyDetails()
    {
        return $this->hasMany(ContractPartyDetail::class, 'contract_id');
    }


    //  first and second party details relations
    public function firstParties()
    {
        return $this->hasMany(ContractPartyDetail::class, 'contract_id')
            ->where('party_type', 'first');
    }

    public function secondParties()
    {
        return $this->hasMany(ContractPartyDetail::class, 'contract_id')
            ->where('party_type', 'second');
    }

    public function firstPartyContract()
    {
        return $this->hasOneThrough(
            ContractParty::class,
            ContractPartyDetail::class,
            'contract_id',   // Foreign key on ContractPartyDetail
            'id',            // Foreign key on ContractParty
            'id',            // Local key on Contract
            'model_id'       // Local key on ContractPartyDetail
        )->where('contract_party_details.party_type', 'first')
            ->where('contract_party_details.model_type', ContractParty::class);
    }

    public function secondPartyContract()
    {
        return $this->hasOneThrough(
            ContractParty::class,
            ContractPartyDetail::class,
            'contract_id',
            'id',
            'id',
            'model_id'
        )->where('contract_party_details.party_type', 'second')
            ->where('contract_party_details.model_type', ContractParty::class);
    }


    public function secondPartyParty()
    {
        return $this->hasOne(ContractPartyDetail::class, 'contract_id')
            ->where('party_type', 'second')
            ->where('model_type', ContractParty::class);
    }

    public function firstUserParty()
    {
        return $this->hasOne(ContractPartyDetail::class, 'contract_id')
            ->where('party_type', 'first')
            ->where('model_type', User::class);
    }

    public function secondUserParty()
    {
        return $this->hasOne(ContractPartyDetail::class, 'contract_id')
            ->where('party_type', 'second')
            ->where('model_type', User::class);
    }

    public function firstAdminParty()
    {
        return $this->hasOne(ContractPartyDetail::class, 'contract_id')
            ->where('party_type', 'first')
            ->where('model_type', Admin::class);
    }

    public function secondAdminParty()
    {
        return $this->hasOne(ContractPartyDetail::class, 'contract_id')
            ->where('party_type', 'second')
            ->where('model_type', Admin::class);
    }
}
