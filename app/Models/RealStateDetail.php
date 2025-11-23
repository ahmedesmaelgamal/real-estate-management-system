<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealStateDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "association_id",
        "real_state_id",
        "lat",
        "long",
        "street",
        "space",
        "flat_space",
        "part_number",
        "bank_account_number",
        "mint_number",
        "mint_source",
        "floor_count",
        "elevator_count",
        "northern_border",
        "southern_border",
        "eastern_border",
        "western_border",
        "area",
        "building_year",
        "building_type",
        "building_count",
        "building_type"
    ];
    public function RealState()
    {
        return $this->belongsTo(RealState::class,'real_state_id');
    }

    protected $table = "real_state_details";
}
