<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;


class Topic extends Model
{
    use HasFactory , HasTranslations;

    public $translatable = ['title'];



    protected $fillable = ['title'  ];



    public function meetings()
    {
        return $this->belongsToMany(Meeting::class, 'topic_has_meets', 'topic_id', 'meet_id');
    }
}
