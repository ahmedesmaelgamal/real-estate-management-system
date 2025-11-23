<?php

namespace App\Services\Admin;

use App\Services\BaseService;
use Illuminate\Http\Request;
use App\Models\Association;
use App\Models\RealState;
use App\Models\Unit;
use Spatie\MediaLibrary\MediaCollections\Models\Media as ObjModel;

class MediaService extends BaseService
{
    protected string $folder = 'admin/media';

    public function __construct(protected ObjModel $objModel)
    {
        parent::__construct($objModel);
    }

    public function create($request)
    {
        return view($this->folder . '.create', [
            'model_id' => $request->id,
            'model' => $request->model,
            'type' => $request->type
        ]);
    }


    public function store($request): \Illuminate\Http\JsonResponse
    {
        try {
            $type = $request->type;
            $model_name = $request->model;
            $model_id = $request->model_id;

            // أضف التحقق من وجود الـ model class
            $modelClass = "App\\Models\\{$model_name}";

            if (!class_exists($modelClass)) {
                return response()->json([
                    'status' => 404,
                    'message' => "Model {$model_name} not found"
                ]);
            }

            $model = $modelClass::find($model_id);

            if (!$model) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Record not found'
                ]);
            }

            // معالجة الصور
            if ($request->has('images') && $request->images) {
                $this->storeMediaLibrary($request->file('images'), $model, 'images', 'images',false);
            }

            // معالجة الملفات
            if ($request->has('files') && $request->files) {
                $this->storeMediaLibrary($request->file('files'), $model, 'files', 'files',false);
            }

            // التحقق من وجود ملفات
            if (!$request->has('images') && !$request->has('files')) {
                return response()->json([
                    'status' => 400,
                    'message' => 'No files provided'
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => trns('create success')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => trns('Something went wrong.'),
                'error' => $e->getMessage()
            ]);
        }
    }

}
