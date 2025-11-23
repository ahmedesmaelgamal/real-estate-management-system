<?php

namespace App\Services\Admin;

use App\Models\Setting as ObjModel;
use App\Models\Setting as settingObj;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class SettingService extends BaseService
{
    protected string $folder = 'admin/setting';
    protected string $route = 'settings';
    protected SettingObj $settingObj;

    public function __construct(ObjModel $objModel, SettingObj $settingObj)
    {
        $this->settingObj = $settingObj;
        parent::__construct($objModel);
    }

    public function index($request)
    {

        $settings = $this->settingObj->get();
        if ($request->ajax()) {
            $obj = $this->getDataTable();
            return DataTables::of($obj)
                ->editColumn('key', function ($obj) {
                    return $obj->key;
                })
                ->editColumn('value', function ($obj) {
                    return $obj->value;
                })
                ->addColumn('action', function ($obj) {
                    $buttons = ' ';
                    if (auth("admin")->check() && Auth::user()->can("edit_setting")) {

                        $buttons .= '
                        <button type="button" data-id="' . $obj->id . '" class="btn btn-pill btn-info-light editBtn">
                            <i class="fa fa-edit"></i>
                        </button>
                    ';
                    }
                    if (auth("admin")->check() && Auth::user()->can("delete_setting")) {

                        $buttons .= '<button class="btn btn-pill btn-danger-light" data-bs-toggle="modal"
                            data-bs-target="#delete_modal" data-id="' . $obj->id . '" data-title="' . $obj->name . '">
                            <i class="fas fa-trash"></i>
                        </button>';
                    }
                    return $buttons;
                })
                ->addIndexColumn()
                ->escapeColumns([])
                ->make(true);
        } else {
            return view($this->folder . '/index', [
                'updateRoute' => route("{$this->route}.update"),
                'bladeName' => trns($this->route),
                'route' => $this->route,
                'settings' => $settings
            ]);
        }
    }
    public function termsIndex($request)
    {

        $settings = $this->settingObj->get();
        if ($request->ajax()) {
            $obj = $this->getDataTable();
            return DataTables::of($obj)
                ->editColumn('key', function ($obj) {
                    return $obj->key;
                })
                ->editColumn('value', function ($obj) {
                    return $obj->value;
                })
                ->addColumn('action', function ($obj) {
                    $buttons = ' ';
                    if (auth("admin")->check() && Auth::user()->can("edit_setting")) {

                        $buttons .= '
                        <button type="button" data-id="' . $obj->id . '" class="btn btn-pill btn-info-light editBtn">
                            <i class="fa fa-edit"></i>
                        </button>
                    ';
                    }
                    if (auth("admin")->check() && Auth::user()->can("delete_setting")) {

                        $buttons .= '<button class="btn btn-pill btn-danger-light" data-bs-toggle="modal"
                            data-bs-target="#delete_modal" data-id="' . $obj->id . '" data-title="' . $obj->name . '">
                            <i class="fas fa-trash"></i>
                        </button>';
                    }
                    return $buttons;
                })
                ->addIndexColumn()
                ->escapeColumns([])
                ->make(true);
        } else {
            return view($this->folder . '/termsindex', [
                'updateRoute' => route("{$this->route}.update"),
                'bladeName' => trns($this->route),
                'route' => $this->route,
                'settings' => $settings
            ]);
        }
    }

    public function create()
    {

        return view("{$this->folder}/parts/create", [
            'storeRoute' => route("{$this->route}.store"),

        ]);
    }

    public function store($data): \Illuminate\Http\JsonResponse
    {
        if (isset($data['image'])) {
            $data['image'] = $this->handleFile($data['image'], 'Setting');
        }

        try {
            $this->createData($data);
            return response()->json(['status' => 200, 'message' => trns('Data created successfully.')]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => trns('Something went wrong.'), trns('error') => $e->getMessage()]);
        }
    }

    public function edit($obj)
    {
        $settings = $this->settingObj->get();
        return view("{$this->folder}/parts/edit", [
            'obj' => $obj,
            'updateRoute' => route("{$this->route}.update"),
            'settings' => $settings
        ]);
    }

    public function update($data)
    {
        $loader = $this->settingObj->where('key', 'loader')->first();
        $logo = $this->settingObj->where('key', 'logo')->first();
        $favIcon = $this->settingObj->where('key', 'fav_icon')->first();

        if (isset($data['logo'])) {
            $data['logo'] = $this->handleFile($data['logo'], 'Setting');

            if ($logo != 'null') {
                $this->deleteFile($logo);
            }
        }
        if (isset($data['fav_icon'])) {
            $data['fav_icon'] = $this->handleFile($data['fav_icon'], 'Setting');

            if ($favIcon != 'null') {
                $this->deleteFile($logo);
            }
        }
        if (isset($data['loader'])) {
            $data['loader'] = $this->handleFile($data['loader'], 'Setting');

            if ($loader != 'null') {
                $this->deleteFile($loader);
            }
        }
      

        if (isset($data['system_language'])) {
            $language = $data['system_language'];

            // Validate that the language is either 'ar' or 'en'
            if (in_array($language, ['ar', 'en'])) {
                // Set the application locale
                app()->setLocale($language);

                // Store the selected language in the session
                session(['system_language' => $language]);

                // Set the direction (RTL for Arabic, LTR for English)
                $direction = ($language === 'ar') ? 'rtl' : 'ltr';
                session(['direction' => $direction]);
            }
        }

        try {
            if (isset($data['logo'])) {
                $this->settingObj->where('key', 'logo')->update(['value' => $data['logo']]);
            }
            if (isset($data['fav_icon'])) {
                $this->settingObj->where('key', 'fav_icon')->update(['value' => $data['fav_icon']]);
            }
            if (isset($data['loader'])) {
                $this->settingObj->where('key', 'loader')->update(['value' => $data['loader']]);
            }
            if (isset($data['app_mentainance'])) {
                $this->settingObj->where('key', 'app_mentainance')->update(['value' => $data['app_mentainance']]);
            }
            if (isset($data['app_version'])) {
                $this->settingObj->where('key', 'app_version')->update(['value' => $data['app_version']]);
            }
            if (isset($data['letterhead'])) {
                $this->settingObj->where('key', 'letterhead')->update(['value' => $data['letterhead']]);
            }
            if (isset($data['terms']) && is_array($data['terms'])) {
                $aboutJson = json_encode([
                    'ar' => $data['terms']['ar'] ?? '',
                    'en' => $data['terms']['en'] ?? ''
                ], JSON_UNESCAPED_UNICODE);

                $this->settingObj->where('key', 'terms')->update(['value' => $aboutJson]);
            }
            $route = route('settings.index');


            if (isset($data['key']) && $data['key'] == 'setting') {
                $route = route('settings.index');
            } else {
                $route = route('terms.index');
            }

            return response()->json(['status' => 200, 'message' => trns('Data updated successfully.'), 'redirect' => $route]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => trns('Something went wrong.'), trns('error') => $e->getMessage(), 'redirect' => $route]);
        }
    }

    public function changeLanguage($lang)
    {

        $language = $lang;
        // Validate that the language is either 'ar' or 'en'
        if (in_array($language, ['ar', 'en'])) {
            // Set the application locale
            app()->setLocale($language);

            // Store the selected language in the session
            session(['system_language' => $language]);

            // Set the direction (RTL for Arabic, LTR for English)
            $direction = ($language === 'ar') ? 'rtl' : 'ltr';
            session(['direction' => $direction]);
        }

        return redirect()->back();
    }


    public function terms()
    {
        $value = $this->settingObj->where('key', 'terms')->first()->value;

        $terms = json_decode($value, true);
        return view("admin.setting.terms", [
            'terms' => $terms[app()->getLocale()] ?? ''
        ]);
    }
}
