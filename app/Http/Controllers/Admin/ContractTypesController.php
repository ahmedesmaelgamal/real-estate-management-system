<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractTypesRequest;
use App\Http\Requests\ContractTypesRequest as ObjRequest;
use App\Models\ContractType;
use App\Models\ContractParty;

use App\Services\Admin\ContractTypesService;
use Illuminate\Http\Request;

class ContractTypesController extends Controller
{
    public function __construct(protected ContractTypesService $objService , protected  ContractType $ContractType) {}

    public function index(Request $request)
    {
        return $this->objService->index($request);
    }

    public function create()
    {
        return $this->objService->create();
    }

    public function store(ObjRequest $data)
    {
        $data = $data->validated();
        return $this->objService->store($data);
    }

    public function edit($id)
    {
        $ContractType = $this->ContractType->findOrFail($id);
        return $this->objService->edit($ContractType);
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
        return $this->objService->updateColumnSelected($request,'status');
    }

    public function deleteSelected(Request $request){
        return $this->objService->deleteSelected($request);
    }
}
