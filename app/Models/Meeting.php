<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'association_id',
        'owner_id',
        'agenda_id',
        // 'topic_id',
        'date',
        'address',
        'created_by' ,
        "other_topic",
        "meet_number",
        "topic"
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    public function owner()
    {
        return $this->belongsTo(Admin::class, 'owner_id');
    }
    
    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    public function agendas()
    {
        return $this->belongsToMany(Agenda::class, 'meet_has_agenda', 'meeting_id', 'agenda_id')
                    ->withTimestamps();
    }

    public function topic()
    {
        return $this->belongsToMany(Topic::class, 'topic_has_meets', 'meet_id', 'topic_id');
    }

    public function meetSummary(){
        return $this->hasMany(MeetSummary::class , "meet_id");
    }


    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'topic_has_meets', 'meet_id', 'topic_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'meet_has_users', 'meet_id', 'user_id');
    }

}
