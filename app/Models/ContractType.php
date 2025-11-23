<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ContractType extends Model
{
    use HasFactory , HasTranslations;

    protected $translatable = ["title"];

    protected  $fillable = ["title"];

    public function Contracts(){
        return $this->hasMany(Contract::class , "contract_type_id");
    }

    public function Names(){
        return $this->hasMany(ContractName::class);
    }
}
