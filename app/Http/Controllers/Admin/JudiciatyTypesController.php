<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JudiciatyTypesRequest as ObjRequest;
use App\Models\JudiciatyType;
use App\Services\Admin\JudiciatyTypesService;
use Illuminate\Http\Request;

class JudiciatyTypesController extends Controller
{
    public function __construct(protected JudiciatyTypesService $objService, protected  JudiciatyType $ObjModel) {}

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
        $ObjModel = $this->ObjModel->findOrFail($id);
        return $this->objService->edit($ObjModel);
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
}
