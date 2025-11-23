<?php

namespace App\Services\Admin;

use App\Models\Meeting;
use App\Models\Topic;
use App\Models\Topic as ObjModel;
use App\Models\topic_has_meet;
use App\Models\User;
use App\Services\BaseService;
use Yajra\DataTables\DataTables;

class TopicService extends BaseService
{
    protected string $folder = 'admin/Meeting_topics';
    protected string $route = 'topics';

    public function __construct(protected ObjModel $objModel , protected topic_has_meet $TopicHasMeet , protected User $users  , protected Meeting $meeting, protected  Topic $contractterms)
    {
        parent::__construct($objModel);
    }

    public function index( $request)
    {


        if ($request->ajax()) {


            $meeting = 0;
            if ($request->has('meeting_id')) {
                $meeting = $this->meeting->with('topics')->find($request->meeting_id);


                $obj = $meeting ? $meeting->topics : collect(); 
            } else {
                $obj = $this->getDataTable(); 
            }

            return DataTables::of($obj)
    ->addColumn('title', function ($obj) {
        return $obj->getTranslation('title', app()->getLocale());
    })
    ->addColumn('action', function ($obj) use ($meeting) { // ✅ أضفنا use هنا
        $deleteCheck = $obj->meetings()->exists(); // returns true if it has meetings

        $buttons = '
        <div class="dropdown">
            <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $obj->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                <i class="fa-solid fa-ellipsis"></i>
            </button>
            <ul class="dropdown-menu" style="z-index: 99999; background-color: #EAEAEA;" aria-labelledby="dropdownMenuButton' . $obj->id . '">
                <li>
                    <a class="dropdown-item editBtn editTopicBtn" href="javascript:void(0);" data-id="' . $obj->id . '">
                        <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1" style="width: 24px; height: 24px;"> ' . trns("Edit") . '
                    </a>
                </li>
        ';

        // ✅ شرط الزرار Delete
        if (!$meeting) {
            if (!$deleteCheck) {
                $buttons .= '
                    <li>
                             <button class="dropdown-item text-danger topicDeleteBtn" data-bs-toggle="modal"
                                                data-bs-target="#delete_modal" data-id="' . $obj->id . '" data-title="' . $obj->getTranslation('title', app()->getLocale()) . '">
                                                <i class="fas fa-trash"></i> ' . trns("delete") . '
                                            </button>
                        </li>';
                    
            } else {
                $buttons .= '
                    <li>
                        <button class="dropdown-item text-danger cantDeleteButton" data-bs-toggle="modal"
                            data-bs-target="#cantDeleteModal" data-title="' . $obj->getTranslation('title', app()->getLocale()) . '">
                            <i class="fas fa-trash"></i> ' . trns("delete") . '
                        </button>
                    </li>';
            }
        }

        $buttons .= '</ul></div>';

        return $buttons;
    })
    ->addIndexColumn()
    ->escapeColumns([])
    ->make(true);

        }

        return view($this->folder . '/index', [
            'createRoute' => route($this->route . '.create'),
            'bladeName' => trns($this->route),
            'route' => $this->route,
        ]);
    }


    public function create()
    {
        return view("{$this->folder}/parts/create", [
            'storeRoute' => route("{$this->route}.store"),
            "users" => $this->users->get(),
        ]);
    }

    public function store($data): \Illuminate\Http\JsonResponse
    {
        try {
            $meet_id = $data['meet_id'] ?? null;

            if ($meet_id) {
                unset($data['meet_id']);
            }

          
            $topic = $this->createData($data);

            if ($meet_id) {
                $this->TopicHasMeet->create([
                    "topic_id" => $topic->id,
                    "meet_id"  => $meet_id
                ]);
            }

            return response()->json([
                'status'  => 200,
                'message' => trns('Data created successfully.')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' => trns('Something went wrong.'),
                'error'   => $e->getMessage()
            ]);
        }
    }



    public function edit($obj)
    {
        return view("{$this->folder}/parts/edit", [
            'obj' => $obj,
            'updateRoute' => route("{$this->route}.update", $obj->id),
            "users" => $this->users->get(),
        ]);
    }

    public function getData() {
        $terms = $this->contractterms->get()->map(function($term) {
            return [
                'id' => $term->id,
                'title' => $term->getTranslation('title', app()->getLocale()),
                'description' => $term->description,
            ];
        });
        return response()->json(['status' => 200, 'terms' => $terms]);
    }



    public function update($data, $id)
    {

        $oldObj = $this->getById($id);

        try {
        $oldObj->update($data);
            return response()->json(['status' => 200, 'message' => trns('Data updated successfully.')]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => trns('Something went wrong.'), trns('error') => $e->getMessage()]);
        }
    }
}
