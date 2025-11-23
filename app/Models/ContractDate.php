<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ContractDate extends Model
{
    use HasFactory , HasTranslations;

    protected $casts = [
        'date' => 'date',
    ];

    protected $translatable =["title"];


    protected $fillable = ["title" , "date"];
}
