<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Testing\Fluent\Concerns\Has;

class UnitOwner extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'user_id',
        'percentage'
    ];
    protected $casts = [];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
