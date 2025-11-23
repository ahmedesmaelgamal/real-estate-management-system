<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetHasAgenda extends Model
{
    use HasFactory;

    protected $table = 'meet_has_agenda'; //
    public $timestamps = false; 

    protected $fillable = ['meeting_id', 'agenda_id'];
}
