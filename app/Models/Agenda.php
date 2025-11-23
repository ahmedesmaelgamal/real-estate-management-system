<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Agenda extends Model
{
    use HasFactory, HasTranslations;

    protected $translatable = ['name', 'description'];

    protected $fillable = [
        'name',
        'description',
        'date',
        "taken",
        "session_id"
    ];

    public function meetings()
    {
        return $this->belongsToMany(Meeting::class, 'meet_has_agenda', 'agenda_id', 'meeting_id');
    }
}
