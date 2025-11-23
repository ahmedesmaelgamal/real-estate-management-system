<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssociationRequest as ObjRequest;
use App\Models\Association as ObjModel;
use App\Services\Admin\AssociationService as ObjService;
use Illuminate\Http\Request;

class AssociationController extends Controller
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
    public function addExcel()
    {
        return $this->objService->addExcel();

    }
    public function stopReason(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->objService->stopReason($request);
    }

    public function getAssociationById($id){
        return $this->objService->getAssociationById($id);
    }

    public function storeExcel(Request $request)
    {
        return $this->objService->storeExcel($request);
    }

    public function exportExcel(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return $this->objService->exportExcel();
    }


    public function singleCreate()
    {
        return $this->objService->singlePageCreate();
    }

    public function show($id)
    {
        return $this->objService->show($id);
    }


    public function store(ObjRequest $data)
    {
        $data = $data->validated();
        return $this->objService->store($data);
    }

    public function storeSinglePageCreate(Request $request)
    {
            return $this->objService->storeSinglePageCreate($request);
    }

    public function edit(ObjModel $association)
    {
        return $this->objService->edit($association);
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

    public function associationDeleteImages(Request $request)
    {
        return $this->objService->associationDeleteImages($request, 'status');
    }

    public function deleteSelected(Request $request)
    {
        return $this->objService->deleteSelected($request);
    }

    public function realStates(Request $request)
    {
        return $this->objService->realStateShow($request);
    }

    public function units(Request $request, $id)
    {
        return $this->objService->units($request, $id);
    }
    public function unitData($id)
    {
        return $this->objService->unitData($id);
    }
    public function associationData(Request $request, $id)
    {
        return $this->objService->associationData($request, $id);
    }

    public function RealStateOwners(Request $request, $id): ?\Illuminate\Http\JsonResponse
    {
        return $this->objService->RealStateOwners($request, $id);
    }

    public function realStateData(Request $request, $id)
    {
        return $this->objService->realStateData($request, $id);
    }
    public function realStateShow(Request $request, $id)
    {
        return $this->objService->realStateShow($request, $id);
    }
    public function real_statesOwwnerShip(Request $request, $id)
    {
        return $this->objService->real_statesOwwnerShip($request, $id);
    }
    public function unitsTableOwnerShip(Request $request, $id)
    {
        return $this->objService->unitsTableOwnerShip($request, $id);
    }


    public function imagesShow(Request $request, $id)
    {
        return $this->objService->imagesShow($request, $id);
    }

    public function getUnits($association_id)
    {
        return $this->objService->getUnits($association_id);
    }

    public function showImages($id)
    {
        return $this->objService->showImages($id);
    }

    public function filesShow($id)
    {
        return $this->objService->filesShow($id);
    }

    public function associationDeleteFiles(Request $request)
    {
        return $this->objService->associationDeleteImages($request, 'status');
    }

    // Show Documents
    public function showDocuments($id)
    {
        return $this->objService->showDocuments($id);
    }

        public function AssociationDeletefile(Request $request)
    {
        return $this->objService->AssociationDeletefile($request);
    }

    public function getUsers($id){
        return $this->objService->getUsers($id);
    }

}
