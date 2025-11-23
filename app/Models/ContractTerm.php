<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ContractTerm extends Model
{
    use HasFactory , HasTranslations;

    protected $translatable = ['title' , "description"];
    protected  $fillable = ['title' , "description" , "taken" , "session_id"];

    public function contracts()
    {
        return $this->belongsToMany(
            Contract::class,
            'contract_has_terms',
            'contract_term_id',
            'contract_id'
        );
    }


    public function getTrnsTitleAttribute()
    {
        return $this->getTranslation('title', app()->getLocale());
    }

    public function getTrnsDescAttribute()
    {
        return $this->getTranslation('description', app()->getLocale());
    }


}
