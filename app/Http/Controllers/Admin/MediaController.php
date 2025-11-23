<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\MediaLibrary\MediaCollections\Models\Media as ObjModel;
use App\Services\Admin\MediaService as ObjService;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function __construct(protected ObjService $objService) {}


    public function create(Request $request)
    {
        return $this->objService->create($request);
    }

    public function store(Request $request)
    {
        return $this->objService->store($request);
    }

}
