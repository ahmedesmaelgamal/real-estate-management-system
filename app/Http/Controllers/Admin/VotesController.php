<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Vote;
use App\Services\Admin\ContractService;
use App\Services\Admin\VotesService;
use Illuminate\Http\Request;
use App\Http\Requests\VotesRequest as ObjRequest;
use Svg\Tag\Rect;

class VotesController extends Controller
{
    public function __construct(protected VotesService $objService, protected  Vote $ObjModel) {}

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

    public function singlePageCreate()
    {
        return $this->objService->singlePageCreate();
    }

    public function show($id)
    {
        $ObjModel = $this->ObjModel->findOrFail($id);
        return $this->objService->show($ObjModel);
    }

    public function getVoteImage(Request $request)
    {
        return $this->objService->getVoteImage($request);
    }

    
    public function getVoteData(Request $request)
    {
        return $this->objService->getVoteData($request);
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

    public function revoteShow($id)
    {
        $ObjModel = $this->ObjModel->findOrFail($id);
        return $this->objService->revoteShow($ObjModel);
    }
    public function revote(Request $request)
    {
        $request->validate([
            "start_date" => "required|date",
            "end_date" => "required|date",
            "vote_percentage" => "required",
        ]);
        return $this->objService->revote($request->all());
    }

    public function makeVote(Request $request)
    {
        return $this->objService->makeVote($request);
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

    public function checkVotes()
    {
        return $this->objService->checkVotes();
    }

    public function getAssociationOwners($id)
    {
        return $this->objService->getAssociationOwners($id);
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
