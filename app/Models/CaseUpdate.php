<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CaseUpdate extends BaseModel
{
    use HasFactory, HasTranslations;

    protected $translatable = ["title"];

    protected $fillable = ["title",  'court_cases_id', "creator_id", "creator_type", "case_update_type_id", "end_date", "description"];


    public function caseUpdateType()
    {
        return $this->belongsTo(CaseUpdateType::class, "case_update_type_id");
    }

    public function creator()
    {
        return $this->morphTo();
    }
}
