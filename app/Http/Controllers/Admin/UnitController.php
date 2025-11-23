<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ElectricsRequest;
use App\Http\Requests\UnitRequest as ObjRequest;
use App\Http\Requests\WatersRequest;
use App\Models\Unit as ObjModel;
use App\Services\Admin\UnitService as ObjService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function __construct(protected ObjService $objService) {}

    public function index(Request $request)
    {
        return $this->objService->index($request);
    }

    public function create()
    {
        return $this->objService->create();
    }

    public function showCreate($realState_id)
    {
        return $this->objService->showCreate($realState_id);
    }
    public function stopReason(Request $request): \Illuminate\Http\JsonResponse
    {

        return $this->objService->stopReason($request);
    }


    public function addExcel()
    {
        return $this->objService->addExcel();
    }

    public function storeExcel(Request $request)
    {
        return $this->objService->storeExcel($request);
    }
    public function exportExcel(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return $this->objService->exportExcel();
    }

    public function show($id)
    {
        return $this->objService->show($id);
    }

    public function singleCreate()
    {
        return $this->objService->singleCreate();
    }
    public function store(ObjRequest $data)
    {

        return $this->objService->store($data);
    }





    public function edit(ObjModel $unit)
    {
        return $this->objService->edit($unit);
    }

    public function update(ObjRequest $request, $id)
    {
        $data = $request->validated();
        return $this->objService->update($data, $id);
    }

    public function destroy($id)
    {
        return $this->objService->delete($id);
    }

    public function updateColumnSelected(Request $request)
    {
        return $this->objService->updateColumnSelected($request, 'status');
    }

    public function deleteSelected(Request $request)
    {
        return $this->objService->deleteSelected($request);
    }

    public function editOwners($id)
    {
        //        dd($unit->get());
        return $this->objService->editOwners($id);
    }

    public function updateOwners(Request $request, $id)
    {
        return $this->objService->updateOwners($request, $id);
    }

    public function unitOwners(Request $request, $id)
    {
        return $this->objService->unitOwners($request, $id);
    }

    public function unitOwnersByUnit(Request $request, $id)
    {
        return $this->objService->unitOwnersByUnit($request, $id);
    }
    public function getRealState(Request $request)
    {
        return $this->objService->getRealState($request);
    }



    public function imagesShow($id)
    {
        return $this->objService->imagesShow($id);
    }

    public function unitsDeleteImages(Request $request)
    {
        return $this->objService->unitsDeleteImages($request);
    }



    public function createInShow(Request $request)
    {
        return $this->objService->create($request);
    }


    public function getElectrics(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        return $this->objService->getElectrics($request, $id);
    }

    public function getWaters(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        return $this->objService->getWaters($request, $id);
    }



    public function createElectricsToUnit($id)
    {
        return $this->objService->createElectricsToUnit($id);
    }

    public function storeElectricsToUnit(ElectricsRequest $request): JsonResponse
    {
        return $this->objService->storeElectricsToUnit($request->validated());
    }


    public function createWatersToUnit($id)
    {
        return $this->objService->createWatersToUnit($id);
    }

    public function storeWatersToUnit(WatersRequest $request): JsonResponse
    {
        return $this->objService->storeWatersToUnit($request->validated());
    }

    public function editElectricsToUnit($id)
    {
        return $this->objService->editElectricsToUnit($id);
    }


    public function updateElectricsToUnit(ElectricsRequest $request, $id): JsonResponse
    {
        return $this->objService->updateElectricsToUnit($request->validated(), $id);
    }

    public function editWatersToUnit($id)
    {
        return $this->objService->editWatersToUnit($id);
    }


    public function updateWatersToUnit(WatersRequest $request, $id): JsonResponse
    {
        return $this->objService->updateWatersToUnit($request->validated(), $id);
    }

    public function deleteElectrics($id): JsonResponse
    {
        return $this->objService->deleteElectrics($id);
    }

    public function deleteWaters($id): JsonResponse
    {
        return $this->objService->deleteWaters($id);
    }
    public function deleteSelectedElectricsOrWaters(Request $request)
    {
        return $this->objService->deleteSelectedElectricsOrWaters($request);
    }


    public function addExcelElectricOrWater()
    {
        return $this->objService->addExcelElectricOrWater();
    }

    public function storeExcelElectricOrWater(Request $request)
    {
        return $this->objService->storeExcelElectricOrWater($request);
    }
}
