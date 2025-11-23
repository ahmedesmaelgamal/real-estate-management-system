<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest as ObjRequest;
use App\Services\Admin\UserService as ObjService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected ObjService $objService) {}

    public function index(Request $request)
    {
        return $this->objService->index($request);
    }


    public function show($id)
    {
        $model = $this->objService->model->find($id);
        return $this->objService->show($model);
    }

    public function create()
    {
        return $this->objService->create();
    }

    public function getAssociationUsers($id){
        return $this->objService->getAssociationUsers($id);
    }

    public function getUserById($id){
        return $this->objService->getUserById($id);
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
        $model = $this->objService->model->find($id);
        return $this->objService->edit($model);
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
    public function showGenerateForm(Request $request, $id)
    {
        $id = decrypt($id);
        return $this->objService->showGenerateForm($request, $id);
    }
    public function PasswordStore(Request $request)
    {
        $user = $this->objService->model->find($request->id);
        return $this->objService->PasswordStore($request, $user);
    }


    public function addExcel()
    {
        return $this->objService->addExcel();
    }

    public function storeExcel(Request $request)
    {
        return $this->objService->storeExcel($request);
    }


    public function exportExcel() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return $this->objService->exportExcel();
    }

    public function getUnits($id){
        return $this->objService->getUnits($id);
    }
}
