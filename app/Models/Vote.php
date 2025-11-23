<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Vote extends Model
{
    use HasFactory, HasTranslations;

    protected $translatable = ['title', 'description'];

    protected $fillable = [
        'association_id',
        'status',
        'first_detail_id',
        'second_detail_id',
        'third_detail_id',
        'vote_percentage',
        'stage_number',
        'audience_number',
        'title',
        'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    public function voteDetails()
    {
        return $this->hasMany(VoteDetail::class);
    }

    public function firstDetail()
    {
        return $this->belongsTo(VoteDetail::class, 'first_detail_id');
    }

    public function secondDetail()
    {
        return $this->belongsTo(VoteDetail::class, 'second_detail_id');
    }

    public function thirdDetail()
    {
        return $this->belongsTo(VoteDetail::class, 'third_detail_id');
    }

    public function getTitleTransAttribute()
    {
        return $this->getTranslation('title', app()->getLocale());
    }

    public function getDescriptionTransAttribute()
    {
        return $this->getTranslation('description', app()->getLocale());
    }

    public function voteDetailHasUsers(){
        return $this->hasMany(VoteDetailHasUser::class);
    }
}
