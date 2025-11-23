<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractPartyDetail extends Model
{
    protected $fillable = [
        'contract_id',
        'party_name',
        'party_nation_id',
        'party_phone',
        'party_email',
        'party_address',
        'party_type',
        'model_id',
        'model_type',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function model()
    {
        return $this->morphTo();
    }
}
