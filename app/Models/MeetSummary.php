<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class MeetSummary extends Model
{
    use HasFactory, HasTranslations;

    protected $translatable = ['title', 'description'];

    protected $fillable = ['meet_id', 'title', 'description', 'user_id' , "date"];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meet_id');
    }

    public function getTitleTransAttribute()
    {
        return $this->getTranslation('title', app()->getLocale());
    }
}
