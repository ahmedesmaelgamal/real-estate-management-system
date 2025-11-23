<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoteDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'vote_id',
        'start_date',
        'end_date',
        'yes_audience',
        'no_audience',
        "vote_percentage", 
        "file"
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];


    public function vote()
    {
        return $this->belongsTo(Vote::class);
    }


}
