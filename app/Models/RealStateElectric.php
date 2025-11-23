<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class RealStateElectric extends BaseModel
{
    use HasFactory, HasTranslations;

    protected $translatable = ['name'];


    protected $fillable = ["real_state_id","electric_name","electric_account_number","electric_meter_number","electric_subscription_number"];

    protected $casts = [
    ];


    protected $table = "real_state_electrics";

    public function realState()
    {
        return $this->belongsTo(RealState::class, 'real_state_id');
    }
}
