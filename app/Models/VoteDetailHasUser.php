<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoteDetailHasUser extends Model
{
    use HasFactory;

    protected $table = 'vote_details_has_users';

    protected $fillable = [
        'user_id',
        'vote_id',
        'vote_detail_id',
        'stage_number',
        'vote_action',
        'vote_creator',
        'admin_id',
        "file"
    ];

    

    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function vote()
    {
        return $this->belongsTo(Vote::class);
    }

    
    public function voteDetail()
    {
        return $this->belongsTo(VoteDetail::class);
    }

    
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }


    
    public function getIsAdminVoteAttribute(): bool
    {
        return $this->vote_creator == 'admin';
    }

    
    public function getIsUserVoteAttribute(): bool
    {
        return $this->vote_creator == 'user';
    }
}
