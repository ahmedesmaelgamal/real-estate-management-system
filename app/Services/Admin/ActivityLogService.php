<?php

namespace App\Services\Admin;

use App\Services\BaseService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity as ObjModel;
use Yajra\DataTables\DataTables;
use App\Models\Admin as AdminObj;

class ActivityLogService extends BaseService
{
    protected string $folder = 'admin/activity_log';
    protected string $route = 'activity_logs';
    protected AdminObj $adminObj;

    public function __construct(protected ObjModel $objModel, AdminObj $adminObj)
    {
        $this->adminObj = $adminObj;
        parent::__construct($objModel);
    }


    public function index($request)
    {
        if ($request->ajax()) {
            $obj = $this->getDataTable();
            return DataTables::of($obj)
                ->editColumn('description', function ($obj) {
                    return trns($obj->description);
                })
                ->editColumn('subject_type', function ($obj) {
                    return trns(class_basename($obj->subject_type));
                })
                ->editColumn('subject_id', function ($obj) {
                    return $obj->subject_id;
                })

                ->editColumn('causer_id', function ($obj) {
                    return $this->adminObj->where('id', $obj->causer_id)->first()->name ?? "";
                })
                ->addColumn('action', function ($obj) {
                    $buttons = '';
//                    if(auth("admin")->check() && auth("admin")->user()->can("delete_activity_log")) {
//                        $buttons = '
//                            <button class="btn btn-pill btn-danger-light" data-bs-toggle="modal"
//                                data-bs-target="#delete_modal" data-id="' . $obj->id . '" data-title="' . $obj->name . '">
//                                <i class="fas fa-trash"></i>
//                            </button>
//                        ';
//                    };

                    return $buttons;
                })
                ->addColumn('created_at', function ($obj) {
                    return $obj->created_at->format('Y-m-d H:i:s A');
                })

                ->addIndexColumn()
                ->escapeColumns([])
                ->make(true);
        } else {
            return view($this->folder . '/index', [
                // 'createRoute' => route($this->route . '.create'),
                'bladeName' => trns($this->route),
                'route' => $this->route,
            ]);
        }
    }

    public function deleteAll()
    {
        $this->objModel->truncate();
        return redirect()->route($this->route . '.index')->with('success', trns('logs deleted successfully'));
    }
}
