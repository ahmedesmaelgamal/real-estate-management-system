<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Http\Requests\MeetingRerquest as ObjRequest;
use App\Services\Admin\MeetingService as ObjService;

class MeetingController extends Controller
{
    public function __construct(protected ObjService $objService , protected  Meeting $ObjModel) {}

    public function index(Request $request)
    {
        return $this->objService->index($request);
    }

    public function create()
    {
        return $this->objService->create();
    }

    public function show($id){
        return $this->objService->show($id);
    }

    public function showDate($id)
    {
        $meet = $this->ObjModel->find($id);
        return $this->objService->showDate($meet);
    }

    public function sendNotification(Request $request , $id)
    {
        $data = $request->all();
        return $this->objService->sendNotification($data , $id);
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

    public function getOwners($id){
        return $this->objService->getOwners($id);
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

    public function download($id)
    {
        return $this->objService->download($id);
    }
    public function singlePageCreate()
    {
        return $this->objService->singlePageCreate();
    }


    public function getUserMeetByAssociation($id){
        return $this->objService->getAssociationOwners($id);
    }

}
