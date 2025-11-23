<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Association extends BaseModel
{
    use HasFactory, HasTranslations;

    protected $translatable = ['name'];

    protected $appends = ['has_relations'];

    public function getLocalizedNameAttribute(){
        return $this->getTranslation("name" , app()->getLocale());
    }
    protected $fillable = [
        'name',
        'number',
        'unit_count',
        'association_model_id',
        'real_state_count',
        'approval_date',
        'establish_date',
        'due_date',
        'unified_number',
        'establish_number',
        'status',
        'interception_reason',
        'association_manager_id',
        'appointment_start_date',
        'appointment_end_date',
        'monthly_fees',
        'is_commission',
        'commission_name',
        'commission_type',
        'commission_percentage',
        'lat',
        'long',
        'monthly_pay',
        'logo',
        'admin_id'
    ];
    protected $casts = [];

    public function AssociationManager()
    {
        return $this->belongsTo(Admin::class, 'association_manager_id');
    }

    public function RealStates()
    {
        return $this->hasMany(RealState::class, 'association_id')->withCount('Units');
    }

    public function RealStateDetails()
    {
        return $this->hasManyThrough(RealStateDetail::class, RealState::class, 'association_id', 'real_state_id');
    }


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'association_manager_id');
    }
    public function getTotalUnitsCountAttribute()
    {
        return $this->RealStates()->withCount('units')->get()->sum('units_count');
    }

    public function AssociationModel()
    {
        return $this->belongsTo(AssociationModel::class, 'association_model_id');
    }



    public function getHasRelationsAttribute()
    {
        return $this->RealStates()->exists();
    }

    public function users()
    {
        return \App\Models\User::whereIn('id', function ($query) {
            $query->select('user_id')
                ->from('unit_owners')
                ->whereIn('unit_id', function ($subQuery) {
                    $subQuery->select('id')
                        ->from('units')
                        ->whereIn('real_state_id', function ($subSubQuery) {
                            $subSubQuery->select('id')
                                ->from('real_state')
                                ->where('association_id', $this->id);
                        });
                });
        });
    }




    public function getUsers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'unit_owners',
            'user_id',
            'user_id' // dummy, لن يستخدم، فقط لتكوين العلاقة
        )->join('units', 'unit_owners.unit_id', '=', 'units.id')
        ->join('real_state', 'units.real_state_id', '=', 'real_state.id')
        ->whereColumn('real_state.association_id', 'associations.id')
        ->select('users.*')
        ->distinct();
    }






    // the booted function to add admin_id
    //    public static function booted()
    //     {
    //         static::created(function ($model) {
    //             $model->admin_id = auth()->user()->id;
    //         });

    //         static::updated(function ($model) {
    //             if ($model->isDirty()) {
    //                 $model->admin_id = auth()->user()->id;
    //             }
    //         });
    //     }


}
