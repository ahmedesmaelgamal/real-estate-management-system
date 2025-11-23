<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class JudiciatyType extends Model
{
    use HasFactory , HasTranslations;

    protected $translatable = ['title'];

    protected $fillable = ['title' , "status"];
}
