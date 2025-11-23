<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourtCaseRequest as ObjRequest;
use App\Models\CourtCase;
use App\Services\Admin\CourtCasesService;
use Illuminate\Http\Request;

class CourtCasesController extends Controller
{
    public function __construct(protected CourtCasesService $objService, protected  CourtCase $ObjModel) {}

    public function index(Request $request)
    {
        return $this->objService->index($request);
    }

    public function show($id)
    {
        return $this->objService->show($id);
    }
    
    public function create()
    {
        return $this->objService->create();
    }

    public function singlePageCreate()
    {
        return $this->objService->singlePageCreate();
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
}
