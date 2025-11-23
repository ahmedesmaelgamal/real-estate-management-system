<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest as ObjRequest;
use App\Models\Admin;
use App\Services\Admin\AdminService as ObjService;
use Illuminate\Http\Request;


class AdminController extends Controller
{

    public function __construct(protected ObjService $objService) {}

    public function index(Request $request)
    {
        return $this->objService->index($request);
    }

    public function destroy($id)
    {
        return $this->objService->delete($id);
    }

    public function myProfile()
    {
        return $this->objService->myProfile();
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

    public function singlePageCreate()
    {
        return $this->objService->singlePageCreate();
    }

    public function store(ObjRequest $request)
    {
        $data = $request->validated();
        return $this->objService->store($data);
    }

    public function getAssociationAdmin($id){
        return $this->objService->getAssociationAdmin($id);
    }

    public function edit(Admin $admin)
    {
        return $this->objService->edit($admin);
    }

    public function update(ObjRequest $request, $id)
    {
        $data = $request->validated();
        return $this->objService->update($data, $id);
    }
    public function updateProfile(Request $request)
    {

        return $this->objService->updateProfile($request->all());
    }




    public function deleteSelected(Request $request)
    {
        return $this->objService->deleteSelected($request);
    }



    public function updateColumnSelected(Request $request)
    {
        return $this->objService->updateColumnSelected($request, 'status');
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
}//end class
