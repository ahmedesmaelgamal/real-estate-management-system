<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ElectricsRequest;
use App\Http\Requests\RealStateRequest as ObjRequest;
use App\Http\Requests\WatersRequest;
use App\Models\RealState;
use App\Services\Admin\RealStateService as ObjService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RealStateController extends Controller
{
    public function __construct(protected ObjService $objService, public RealState $realState) {}

    public function index(Request $request)
    {
        return $this->objService->index($request);
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
    public function unitState(Request $request, $realStateId)
    {
        return $this->objService->unitState($request, $realStateId);
    }

    public function show($id)
    {

        return $this->objService->show($id);
    }


    public function create()
    {
        return $this->objService->create();
    }


    public function createInShow(Request $request)
    {
        return $this->objService->create($request);
    }
    public function singlePageCreate()
    {
        return $this->objService->singlePageCreate();
    }

    public function store(ObjRequest $data)
    {
        return $this->objService->store($data->all());
    }

    public function edit($id)
    {
        $model = $this->objService->model->with("realStateDetails", 'RealStateOwnerShips')->find($id);
        return $this->objService->edit($model);
    }
    public function RealStateOwners(Request $request, $id): ?\Illuminate\Http\JsonResponse
    {
        return $this->objService->RealStateOwners($request, $id);
    }


    public function update(ObjRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        if ($request->update === 'status') {
            return $this->objService->updateStatus($request->status, $id);
        }
        $data = $request->validated();

        return $this->objService->update($data, $id);
    }

    public function destroy($id)
    {
        return $this->objService->delete($id);
    }

    public function updateColumnSelected(Request $request)
    {
        return $this->objService->updateColumnSelected($request, "status");
    }

    public function StopReason(Request $request)
    {
        return $this->objService->StopReason($request);
    }

    public function deleteSelected(Request $request)
    {
        return $this->objService->deleteSelected($request);
    }


    public function showMainInformation($id)
    {
        return $this->objService->showMainInformation($id);
    }

    // Show Property Info
    public function showProperty(Request $request, $id)
    {
        return $this->objService->showProperty($request, $id);
    }

    // Show Association Info
    public function showAssociation($id)
    {
        return $this->objService->showAssociation($id);
    }

    // Show Images
    public function showImages($id)
    {
        return $this->objService->showImages($id);
    }

    // Show Documents
    public function showDocuments($id)
    {
        return $this->objService->showDocuments($id);
    }

    public function getRealStates(Request $request)
    {
        return $this->objService->getRealStates($request);
    }


    public function imagesShow($id)
    {
        return $this->objService->imagesShow($id);
    }

    public function RealStateDeleteImages(Request $request)
    {
        return $this->objService->RealStateDeleteImages($request);
    }

    public function getRealStatesByAssociation(Request $request)
    {
        return $this->objService->getRealStatesByAssociation($request);
    }



    public function toggleStatus(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        return $this->objService->updateStatus($request->status, $id);
    }

    public function getElectrics(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        return $this->objService->getElectrics($request, $id);
    }

    public function getWaters(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        return $this->objService->getWaters($request, $id);
    }








    public function createElectricsToRealState($id)
    {
        return $this->objService->createElectricsToRealState($id);
    }

    public function storeElectricsToRealState(ElectricsRequest $request): JsonResponse
    {
        return $this->objService->storeElectricsToRealState($request->validated());
    }


    public function createWatersToRealState($id)
    {
        return $this->objService->createWatersToRealState($id);
    }

    public function storeWatersToRealState(WatersRequest $request): JsonResponse
    {
        return $this->objService->storeWatersToRealState($request->validated());
    }

    public function editElectricsToRealState($id)
    {
        return $this->objService->editElectricsToRealState($id);
    }


    public function updateElectricsToRealState(ElectricsRequest $request, $id): JsonResponse
    {
        return $this->objService->updateElectricsToRealState($request->validated(), $id);
    }

    public function editWatersToRealState($id)
    {
        return $this->objService->editWatersToRealState($id);
    }


    public function updateWatersToRealState(WatersRequest $request, $id): JsonResponse
    {
        return $this->objService->updateWatersToRealState($request->validated(), $id);
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
