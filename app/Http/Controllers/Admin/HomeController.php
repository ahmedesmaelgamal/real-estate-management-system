<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\HomeService as ObjService;

class HomeController extends Controller
{
    public function __construct(protected ObjService $objService) {}

    public function index()
    {
        return $this->objService->index();
    }

    public function getNewAssocationsDate(int $year) {
        return $this->objService->getNewAssocationsDate($year);
    }
    
    public function getNewrealState(int $year) {
        return $this->objService->getNewrealState($year);
    }
   
    public function getNewUnits(int $year) {
        return $this->objService->getNewUnits($year);
    }

}
