<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class topic_has_meet extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'meet_id',
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
    

    
}
