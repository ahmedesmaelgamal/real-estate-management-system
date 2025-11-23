<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CourtCase extends BaseModel
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'case_number',
        "case_type_id",
        "judiciaty_type_id",
        "association_id",
        "owner_id",
        "unit_id",
        "case_date",
        "case_price",
        "judiciaty_date",
        "topic",
        "description",
    ];

    public function caseType()
    {
        return $this->belongsTo(CaseType::class);
    }

    public function judiciatyType()
    {
        return $this->belongsTo(JudiciatyType::class);
    }

    public function association()
    {
        return $this->belongsTo(Association::class, "association_id");
    }

    public function owner()
    {
        return $this->belongsTo(User::class, "owner_id");
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, "unit_id");
    }

    public function caseUpdates()
    {
        return $this->hasMany(CaseUpdate::class, "court_cases_id");
    }

    public function realState()
    {
        return $this->hasOneThrough(
            RealState::class,
            Unit::class,
            'id',           
            'id',           
            'unit_id',      
            'real_state_id' 
        );
    }
}
