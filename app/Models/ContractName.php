<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ContractName extends Model
{
    use HasFactory , HasTranslations;

    protected $translatable = ["name"];

    protected $fillable = ["name" , "contract_type_id"];

    public function contractType(){
        return $this->belongsTo(ContractType::class);
    }

    public function contracts(){
        return $this->hasMany(Contract::class);
    }
}
