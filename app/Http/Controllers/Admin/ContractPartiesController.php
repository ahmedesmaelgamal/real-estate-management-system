<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractPartiesRequest;
use App\Http\Requests\ContractPartiesRequest as ObjRequest;
use App\Models\ContractParty;
use App\Services\Admin\ContractPartiesService;
use App\Services\Admin\ContractPartiesService as ObjService;
use Illuminate\Http\Request;

class ContractPartiesController extends Controller
{
    public function __construct(protected ContractPartiesService $objService , protected  ContractParty $contractParty) {}

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
        $ContractParty = $this->contractParty->findOrFail($id);
        return $this->objService->edit($ContractParty);
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
