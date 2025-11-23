<?php

namespace App\Services\Admin;

use App\Models\Admin as ObjModel;
use App\Models\Association;
use App\Models\RealState;
use App\Models\Unit;
use App\Models\User;
use App\Services\BaseService;

class HomeService extends BaseService
{

    public function __construct(
        ObjModel $objModel,
        protected User $users,
        protected Association $Associations,
        protected RealState $RealStates,
        protected Unit $units,

    ) {
        parent::__construct($objModel);
    }

    public function index()
    {

        $monthlyAssociations = $this->Associations->selectRaw('MONTH(created_at) as months, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('months')
            ->pluck('count', 'months');

        $associationData = [];
        for ($i = 1; $i <= 12; $i++) {
            $associationData[] = $monthlyAssociations[$i] ?? 0;
        }


        $monthlyRealStete = $this->RealStates->selectRaw('MONTH(created_at) as months, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('months')
            ->pluck('count', 'months');

        $realStateData = [];
        for ($i = 1; $i <= 12; $i++) {
            $realStateData[] = $monthlyRealStete[$i] ?? 0;
        }

        $monthlyunitsDate = $this->units->selectRaw('MONTH(created_at) as months, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('months')
            ->pluck('count', 'months');

        $UnitsDate = [];
        for ($i = 1; $i <= 12; $i++) {
            $UnitsDate[] = $monthlyunitsDate[$i] ?? 0;
        }


        $months = [
            trns('january'),
            trns('february'),
            trns('march'),
            trns('april'),
            trns('may'),
            trns('june'),
            trns('july'),
            trns('august'),
            trns('september'),
            trns('october'),
            trns('november'),
            trns('december'),
        ];

        // Calculate user change percentage
        $currentUsers = $this->users->count();
        $previousUsers = $this->users->where('created_at', '<', now()->subDay())->count();
        $userChange = $previousUsers ? (($currentUsers - $previousUsers) / $previousUsers * 100) : 0;


        // Calculate change percentage for Associations
        $currentAssociations = $this->Associations->count();
        $previousAssociations = $this->Associations->where('created_at', '<', now()->subDay())->count();
        $associationChange = $previousAssociations ? (($currentAssociations - $previousAssociations) / $previousAssociations * 100) : 0;

        // Calculate change percentage for RealStates
        $currentRealStates = $this->RealStates->count();
        $previousRealStates = $this->RealStates->where('created_at', '<', now()->subDay())->count();
        $realStateChange = $previousRealStates ? (($currentRealStates - $previousRealStates) / $previousRealStates * 100) : 0;

        // Calculate change percentage for Units
        $currentUnits = $this->units->count();
        $previousUnits = $this->units->where('created_at', '<', now()->subDay())->count();
        $unitChange = $previousUnits ? (($currentUnits - $previousUnits) / $previousUnits * 100) : 0;

        return view('admin.index', [
            "users" => $currentUsers,
            "Associations" => $currentAssociations,
            "RealStates" => $currentRealStates,
            "units" => $currentUnits,
            "associationData" => $associationData,
            "realStateData" => $realStateData,
            "unitsDate" => $UnitsDate,
            "months" => $months,
            "userChange" => number_format($userChange,1),
            "associationChange" => number_format($associationChange,1),
            "realStateChange" => number_format($realStateChange,1),
            "unitChange" => number_format($unitChange,1),
        ]);
    }

    public function getNewAssocationsDate($year)
    {
        $monthly = $this->Associations->selectRaw('MONTH(created_at) months, COUNT(*) count')
            ->whereYear('created_at', $year)
            ->groupBy('months')
            ->pluck('count', 'months');

        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $monthly[$i] ?? 0;
        }

        return response()->json(['data' => $data]);
    }

    public function getNewrealState($year)
    {
        $monthly = $this->RealStates->selectRaw('MONTH(created_at) months, COUNT(*) count')
            ->whereYear('created_at', $year)
            ->groupBy('months')
            ->pluck('count', 'months');

        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $monthly[$i] ?? 0;
        }

        return response()->json(['data' => $data]);
    }

    public function getNewUnits($year)
    {
        $monthly = $this->units->selectRaw('MONTH(created_at) months, COUNT(*) count')
            ->whereYear('created_at', $year)
            ->groupBy('months')
            ->pluck('count', 'months');

        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $monthly[$i] ?? 0;
        }

        return response()->json(['data' => $data]);
    }
}
