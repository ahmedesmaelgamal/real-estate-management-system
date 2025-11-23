<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class AssociationModel extends BaseModel
{
    use HasTranslations;
//    use HasFactory;
    protected $translatable = ['title', 'description'];

    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    protected $appends = ['has_relations'];

    protected $casts = [];
    public function Association(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Association::class,'association_model_id');
    }

    public function getHasRelationsAttribute()
    {
        return $this->Association()->exists();
    }
}
