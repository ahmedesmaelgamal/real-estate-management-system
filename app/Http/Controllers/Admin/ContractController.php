<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Services\Admin\ContractService;
use Illuminate\Http\Request;
use App\Http\Requests\ContractRequest as ObjRequest;

class ContractController extends Controller
{
    public function __construct(protected ContractService $objService , protected  Contract $ObjModel) {}

    public function index(Request $request)
    {
        return $this->objService->index($request);
    }

    public function create()
    {
        return $this->objService->create();
    }
    public function createByAssociation()
    {
        return $this->objService->createByAssociation();
    }

    public function store(ObjRequest $data)
    {
        $data = $data->validated();
        return $this->objService->store($data);
    }

    public function singlePageCreate()
    {
        return $this->objService->singlePageCreate();
    }

    public function show($id)
    {
        $ObjModel = $this->ObjModel->findOrFail($id);
        return $this->objService->show($ObjModel);
    }

    public function edit($id)
    {
        $ObjModel = $this->ObjModel->findOrFail($id);
        return $this->objService->edit($ObjModel);
    }

    public function update(ObjRequest $request, $id)
    {
        $data = $request->validated();
        return $this->objService->update($data, $id);
    }


    public function getContractNames($typeId)
    {
        return $this->objService->getContractNames($typeId);
    }


    public function destroy($id)
    {
        return $this->objService->delete($id);
    }
    public function updateColumnSelected(Request $request)
    {
        return $this->objService->updateColumnSelected($request,'status');
    }

    public function deleteSelected(Request $request){
        return $this->objService->deleteSelected($request);
    }

    public function exportExcel(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return $this->objService->exportExcel();
    }

    public function addExcel()
    {
        return $this->objService->addExcel();

    }

    public function storeExcel(Request $request)
    {
        return $this->objService->storeExcel($request);
    }

    public function download($id){
        return $this->objService->download($id);
    }
}
