<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class LegalOwnership extends BaseModel
{
use HasTranslations;
//    use HasFactory;
    protected $translatable = ['title'];

    protected $fillable = [
        'title',
    ];

    protected $casts = [];
    public function realStates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RealState::class,'legal_ownership_id');
    }
}
