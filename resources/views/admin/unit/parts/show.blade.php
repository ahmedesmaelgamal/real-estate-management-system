@extends('admin/layouts/master')


@section('title')
    {{ config()->get('app.name') }} | {{ trns('unit') }}
@endsection
@section('page_name')
    <a href="{{ route('units.index') }}">
        {{ trns('Units_management') }}
    </a>
@endsection
@section('content')
    <style>
        .gallery-image {
            cursor: pointer;
            transition: 0.3s;
            margin: 5px;
        }

        .gallery-image:hover {
            opacity: 0.7;
        }


        .tab-content>div {
            display: none;
        }

        .tab-content>.active {
            display: block;
        }

        .min-w-150px {
            min-width: 150px;
        }

        .d-flex {
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
        }

        .text-muted {
            color: #6c757d;
        }

        .text-dark {
            color: #343a40;
        }

        .p-4 {
            background-color: #f8f9fa;
            border-radius: 8px;
        }


        #imageModal {
            display: none;
            position: fixed;

            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
        }

        #modalImage {

            width: 75%;
            height: 75%;
        }
    </style>
    <div class="row">

        <div class="col-md-12 col-lg-12">
            <div class="p-15" style="padding: 25px ; padding-bottom: 60px">
                <div class="d-flex justify-content-between">
                    <h2 class="mb-0"><span class="user-prfile"><i class="bx bx-building-house"></i></span>
                        {{ $obj->first()->unit_number }} </h2>
                    <div
                        style="display: flex;
                                                justify-content: center;
                                                padding: 10px;">
                        <button class="btn btn-icon text-white addExcelOfElectricOrWaterFileOfUnit importBtn">
                            <span>
                                <img style="height: 24px;" src="{{ asset('assets/import.png') }}" alt="">
                            </span> {{ trns('import_electricity_or_water') }}
                        </button>
                        <!-- Options Dropdown -->
                        <div class="dropdown {{ lang() == 'ar' ? 'me-2' : 'ms-2' }}">
                            <button class="btn dropdown-toggle d-flex align-items-center"
                                style="background-color: #00193a; color: #00F3CA;" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown">
                                {{ trns('options') }}
                            </button>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                                style="background-color: #EAEAEA;">
                                <!-- Changed dropdown-menu-right to dropdown-menu-end for Bootstrap 5 -->
                                <a class="dropdown-item editUnitBtn" href="javascript:void(0);"
                                    data-id="{{ $obj->id }}">
                                    <img src="{{ asset('edit.png') }}" alt="no-icon" class="img-fluid ms-1"
                                        style="width: 24px; height: 24px;"> {{ trns('Edit') }}
                                </a>
                                <a class="dropdown-item d-flex align-items-center toggleStatusBtn" href="#"
                                    data-id="{{ $obj->id }}" data-status="{{ $obj->status }}">
                                    <i class="fas fa-power-off ms-2"></i>
                                    <!-- Changed mr-2 to me-2 (Bootstrap 5 RTL-friendly margin) -->
                                    {{ $obj->status == 1 ? trns('Deactivate unit') : trns('Activate unit') }}
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="" style="padding-bottom: 60px">
                    <!-- Right side - Actions -->

                    <div>
                        <ul class="nav nav-tabs" style="margin: 0 3px;" id="realEstateTabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-tab="tab1"
                                    href="#">{{ trns('unit_information') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-tab="tab2"
                                    href="#unitRealstate">{{ trns('real_state_information') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-tab="tab3"
                                    href="#">{{ trns('association_information') }}</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-tab="tab5" href="#">{{ trns('gallery') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-tab="tab4" href="#">{{ trns('documents') }}</a>
                            </li>

                        </ul>
                        <div class="row">
                            <div class="container-fluid px-0">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                </div>
                            </div>

                            <div class="tab-content">
                                <!--tab1 content -->
                                <div id="tab1" class="active">
                                    <div class="tab-pane fade show active" id="basic-info" role="tabpanel">
                                        <div class="show-content">
                                            <div
                                                style="border-radius: 6px;background-color: #fbf9f9;border: 1px solid #ddd;padding: 15px;">
                                                <h4 class="mb-4" style="font-weight: bold; color: #00193a;">
                                                    {{ trns('unit_main_information') }}</h4>

                                                <!-- First divider - made more visible -->
                                                <hr style="background-color: black;">

                                                <div class="row m-2">
                                                    <!-- First Column Group -->
                                                    <div class="col-lg-2 col-md-4 mb-4">
                                                        <h6 class="text-muted">{{ trns('unit_code') }}</h6>
                                                        <p class="font-weight-bold">{{ $obj->unit_code }}</p>
                                                    </div>

                                                    <div class="col-lg-2 col-md-4 mb-4">
                                                        <h6 class="text-muted">{{ trns('unit_owner_name') }}</h6>
                                                        <p class="font-weight-bold">
                                                            {{ optional($obj->unitOwners->sortByDesc('percentage')->first()?->user)->name ?? '-' }}
                                                        </p>
                                                    </div>

                                                    <div class="col-lg-2 col-md-4 mb-4">
                                                        <h6 class="text-muted">{{ trns('unit_number') }}</h6>
                                                        <p class="font-weight-bold">{{ $obj->unit_number }}</p>
                                                    </div>

                                                    <div class="col-lg-2 col-md-4 mb-4">
                                                        <h6 class="text-muted">{{ trns('real_state_number') }}</h6>
                                                        <p class="font-weight-bold">
                                                            {{ $obj->RealState?->real_state_number ?? trns('N/A') }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Second divider -->
                                                <hr class="divider my-4" style="border-top: 2px solid #e9ecef;">

                                                <div class="row m-2">
                                                    <!-- Second Column Group -->
                                                    <div class="col-lg-2 col-md-4 mb-4">
                                                        <h6 class="text-muted">{{ trns('association_name') }}</h6>
                                                        <p class="font-weight-bold">{{ $obj->association->name }}</p>
                                                    </div>

                                                    <div class="col-lg-2 col-md-4 mb-4">
                                                        <h6 class="text-muted">{{ trns('real_state_name') }}</h6>
                                                        <p class="font-weight-bold">{{ $obj->RealState->name }}</p>
                                                    </div>

                                                    <div class="col-lg-2 col-md-4 mb-4">
                                                        <h6 class="text-muted">{{ trns('floor_number') }}</h6>
                                                        <p class="font-weight-bold">{{ $obj->floor_count }}</p>
                                                    </div>
                                                </div>
                                                <div class="row m-2">
                                                    <div class="col-lg-12 col-md-12 mb-12">
                                                        <h6 class="text-muted">{{ trns('unit_description') }}</h6>
                                                        <p class="font-weight-bold">{{ $obj->description }}</p>
                                                    </div>
                                                </div>
                                                <hr class="divider my-4" style="border-top: 2px solid #e9ecef;">

                                                <div class="row m-2">
                                                    <div class="col-lg-2 col-md-4 mb-4">
                                                        <h6 class="text-muted">{{ trns('space') }}</h6>
                                                        <p class="font-weight-bold">{{ $obj->space }}</p>
                                                    </div>
                                                    <div class="col-lg-2 col-md-4 mb-4">
                                                        <h6 class="text-muted">{{ trns('unified_code') }}</h6>
                                                        <p class="font-weight-bold">{{ $obj->unified_code }}</p>
                                                    </div>


                                                    <div class="col-lg-2 col-md-4 mb-4">
                                                        <h6 class="text-muted">{{ trns('floor_count') }}</h6>
                                                        <p class="font-weight-bold">{{ $obj->floor_count }}</p>
                                                    </div>

                                                    <div class="col-lg-2 col-md-4 mb-4">
                                                        <h6 class="text-muted">{{ trns('bathrooms_count') }}</h6>
                                                        <p class="font-weight-bold">{{ $obj->bathrooms_count }}</p>
                                                    </div>
                                                </div>

                                                <div class="row m-2">
                                                    <!-- Third Column Group -->
                                                    <div class="col-lg-2 col-md-4 mb-4">
                                                        <h6 class="text-muted">{{ trns('bedrooms_count') }}</h6>
                                                        <p class="font-weight-bold">{{ $obj->bedrooms_count }}</p>
                                                    </div>

                                                    <div class="col-lg-2 col-md-4 mb-4">
                                                        <h6 class="text-muted">{{ trns('northern_border') }}</h6>
                                                        <p class="font-weight-bold">{{ $obj->northern_border }}</p>
                                                    </div>

                                                    <div class="col-lg-2 col-md-4 mb-4">
                                                        <h6 class="text-muted">{{ trns('eastern_border') }}</h6>
                                                        <p class="font-weight-bold">{{ $obj->eastern_border }}</p>
                                                    </div>


                                                    <div class="col-lg-2 col-md-4 mb-4">
                                                        <h6 class="text-muted">{{ trns('western_border') }}</h6>
                                                        <p class="font-weight-bold">{{ $obj->western_border }}</p>
                                                    </div>
                                                    <div class="col-lg-2 col-md-4 mb-4">
                                                        <h6 class="text-muted">{{ trns('southern_border') }}</h6>
                                                        <p class="font-weight-bold">{{ $obj->southern_border }}</p>
                                                    </div>

                                                    <div class="col-lg-2 col-md-4 mb-4">
                                                        <h6 class="text-muted">{{ trns('status') }}</h6>
                                                        {!! $obj->status == 1
                                                            ? "<span class='badge p-2' style='background-color: #6AFFB2; color: #1F2A37; border-radius: 30px'>" .
                                                                trns('active') .
                                                                '</span>'
                                                            : "<span class='badge p-2' style='background-color: #FFBABA; color: #1F2A37; border-radius: 30px'>" .
                                                                trns('inactive') .
                                                                '</span>' !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                style="border-radius: 6px;
                            background-color: #fbf9f9;
                            border: 1px solid #ddd;
                            padding: 15px; margin-top: 20px;">

                                                <div class="">

                                                    <div
                                                        class="px-0 mb-3 d-flex justify-content-between align-items-center">
                                                        <div class="mb-4">
                                                            <!-- Left side - Title -->
                                                            <div class="flex-grow-1">
                                                                <h4 class="mb-0 text-primary"
                                                                    style="font-weight: bold; color: #00193a;">
                                                                    {{ trns('real_state_electrics') }}</h4>
                                                            </div>

                                                        </div>
                                                        <div>
                                                            <button class="btn btn-icon text-white addElectricOrWaterBtn"
                                                                data-type="electric"
                                                                data-route="{{ route('unit.create_electrics.create', $obj->id) }}"
                                                                style="border: none;">
                                                                {{ trns('add_new_electric') }}
                                                            </button>

                                                            <button class="btn btn-icon text-white"
                                                                id="bulk-delete-electric" data-type="electrics" disabled>
                                                                <span><i class="fe fe-trash text-white"></i></span>
                                                                {{ trns('delete selected') }}
                                                            </button>
                                                        </div>
                                                    </div>


                                                </div>
                                                <hr style="background-color: black;">

                                                <div class="card-body">

                                                    <table
                                                        class="table table-bordered table-hover text-nowrap w-100 electricsTable"
                                                        style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom:0 !important;"
                                                        id="electricsTable">
                                                        <thead>
                                                            <tr class="fw-bolder"
                                                                style="background-color: #e3e3e3; color: #00193a;">
                                                                <th class="min-w-25px rounded-end">
                                                                    <input type="checkbox" id="select-all-electric">
                                                                </th>
                                                                <th class="min-w-100px">{{ trns('meter_name') }}</th>
                                                                <th class="min-w-100px">
                                                                    {{ trns('electric_account_number') }}</th>
                                                                <th class="min-w-150px">
                                                                    {{ trns('electric_meter_number') }}</th>
                                                                <th class="min-w-150px">
                                                                    {{ trns('electric_subscription_number') }}</th>
                                                                <th class="min-w-150px">{{ trns('created at') }}</th>
                                                                <th class="min-w-50px rounded-start">
                                                                    {{ trns('actions') }}
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>


                                            <div
                                                style="border-radius: 6px;
                            background-color: #fbf9f9;
                            border: 1px solid #ddd;
                            padding: 15px; margin-top: 20px;">

                                                <div class="">

                                                    <div
                                                        class="px-0 mb-3 d-flex justify-content-between align-items-center">
                                                        <div class="mb-4">
                                                            <!-- Left side - Title -->
                                                            <div class="flex-grow-1">
                                                                <h4 class="mb-0 text-primary"
                                                                    style="font-weight: bold; color: #00193a;">
                                                                    {{ trns('real_state_water') }}</h4>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <button class="btn btn-icon text-white addElectricOrWaterBtn"
                                                                data-type="water"
                                                                data-route="{{ route('unit.create_waters.create', $obj->id) }}"
                                                                style="border: none;">
                                                                {{ trns('add_new_water') }}
                                                            </button>

                                                            <button class="btn btn-icon text-white" id="bulk-delete-water"
                                                                data-type="waters" disabled>
                                                                <span><i class="fe fe-trash text-white"></i></span>
                                                                {{ trns('delete selected') }}
                                                            </button>
                                                        </div>
                                                    </div>


                                                </div>
                                                <hr style="background-color: black;">

                                                <div class="card-body">

                                                    <table
                                                        class="table table-bordered table-hover text-nowrap w-100 waterTable"
                                                        style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom:0 !important;;"
                                                        id="waterTable">
                                                        <thead>
                                                            <tr class="fw-bolder"
                                                                style="background-color: #e3e3e3; color: #00193a;">
                                                                <th class="min-w-25px rounded-end">
                                                                    <input type="checkbox" id="select-all-water">
                                                                </th>
                                                                <th class="min-w-100px">{{ trns('meter_name') }}</th>
                                                                <th class="min-w-100px">{{ trns('water_account_number') }}
                                                                </th>
                                                                <th class="min-w-150px">{{ trns('water_meter_number') }}
                                                                </th>
                                                                <th class="min-w-150px">{{ trns('created at') }}</th>
                                                                <th class="min-w-50px rounded-start">
                                                                    {{ trns('actions') }}
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>



                                            <div
                                                style="border-radius: 6px;background-color: #fbf9f9;border: 1px solid #ddd;padding: 15px;margin-top: 20px; ">
                                                <div>
                                                    <h3 class="card-title" style="font-weight: bold; color: #00193a;">
                                                        {{ trns('property_management') }}</h3>
                                                </div>
                                                <hr style="background-color: black;">


                                                <div class="table-responsive" style="overflow-x: inherit;">
                                                    <!--begin::Table-->
                                                    <table class="table text-nowrap w-100 usersTable" id=""
                                                        style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;">
                                                        <thead>
                                                            <tr class="fw-bolder"
                                                                style="background-color: #e3e3e3; color: #00193a;">


                                                                <th class="min-w-100px">{{ trns('national_id') }}</th>
                                                                <th class="min-w-150px">{{ trns('name') }}</th>
                                                                <th class="min-w-150px">{{ trns('email') }}</th>
                                                                <th class="min-w-100px">{{ trns('phone') }}</th>
                                                                <th class="min-w-100px">
                                                                    {{ trns('unit_ownership_percentage') }}</th>
                                                                <th class="min-w-100px">{{ trns('status') }}</th>
                                                                <th class="min-w-150px">{{ trns('actions') }}</th>
                                                            </tr>
                                                        </thead>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--tab1 content -->

                                <!--tab2 content -->
                                <div id="tab2">
                                    <div class="tab-pane fade show" id="property-info" role="tabpanel">
                                        <div class="show-content"
                                            style="border-radius: 6px;background-color: #fbf9f9; border: 1px solid #ddd;padding: 15px;">
                                            <h4 class="mb-4" style="font-weight: bold; color: #00193a;">
                                                {{ trns('property details') }}</h4>


                                            <!-- First divider -->
                                            <hr style="background-color: black;">

                                            <div class="row m-2">

                                                <div class="col-lg-2 col-md-4 mb-4">
                                                    <h6 class="text-muted">{{ trns('association_name') }}</h6>
                                                    <p class="font-weight-bold">
                                                        {!! $obj->association?->name
                                                            ? copyable_text($obj->association?->name) . ' ' . $obj->association?->name
                                                            : trns('N/A') !!}</p>
                                                </div>
                                                <div class="col-lg-2 col-md-4 mb-4">
                                                    <h6 class="text-muted">{{ trns('real_state_name') }}</h6>
                                                    <p class="font-weight-bold">{{ $obj->RealState?->name }}</p>
                                                </div>

                                                <div class="col-lg-2 col-md-4 mb-4">
                                                    <h6 class="text-muted">{{ trns('street') }}</h6>
                                                    <p class="font-weight-bold">
                                                        {{ $obj->RealState?->realStateDetails?->street ?? trns('N/A') }}
                                                    </p>
                                                </div>

                                                <div class="col-lg-2 col-md-4 mb-4">
                                                    <h6 class="text-muted">{{ trns('space') }}</h6>
                                                    <p class="font-weight-bold">
                                                        {{ $obj->RealState?->realStateDetails?->space ?? trns('N/A') }}</p>
                                                </div>
                                                <div class="col-lg-2 col-md-4 mb-4">
                                                    <h6 class="text-muted">{{ trns('flat_space') }}</h6>
                                                    <p class="font-weight-bold">
                                                        {{ $obj->RealState?->realStateDetails?->flat_space ?? trns('N/A') }}
                                                    </p>
                                                </div>
                                                <div class="col-lg-2 col-md-4 mb-4">
                                                    <h6 class="text-muted">{{ trns('part number') }}</h6>
                                                    <p class="font-weight-bold">
                                                        {{ $obj->RealState?->realStateDetails?->part_number ?? trns('N/A') }}
                                                    </p>
                                                </div>
                                                <div class="col-lg-2 col-md-4 mb-4">
                                                    <h6 class="text-muted">{{ trns('bank account number') }}</h6>
                                                    <p class="font-weight-bold">
                                                        {!! $obj->RealState?->realStateDetails?->bank_account_number
                                                            ? copyable_text($obj->RealState?->realStateDetails?->bank_account_number) .
                                                                ' ' .
                                                                $obj->RealState?->realStateDetails?->bank_account_number
                                                            : trns('N/A') !!}
                                                    </p>
                                                </div>

                                                <div class="col-lg-2 col-md-4 mb-4">
                                                    <h6 class="text-muted">{{ trns('mint number') }}</h6>
                                                    <p class="font-weight-bold">
                                                        {!! $obj->RealState->realStateDetails?->mint_number
                                                            ? copyable_text($obj->RealState->realStateDetails?->mint_number) .
                                                                ' ' .
                                                                $obj->RealState->realStateDetails?->mint_number
                                                            : trns('N/A') !!}
                                                    </p>
                                                </div>
                                                <!-- Third Column Group -->
                                                <div class="col-lg-2 col-md-4 mb-4">
                                                    <h6 class="text-muted">{{ trns('mint source') }}</h6>
                                                    <p class="font-weight-bold">
                                                        {{ $obj->RealState?->realStateDetails?->mint_source ?? trns('N/A') }}
                                                    </p>
                                                </div>

                                                <div class="col-lg-2 col-md-4 mb-4">
                                                    <h6 class="text-muted">{{ trns('floor count') }}</h6>
                                                    <p class="font-weight-bold">
                                                        {{ $obj->RealState?->realStateDetails?->floor_count ?? trns('N/A') }}
                                                    </p>
                                                </div>

                                                <div class="col-lg-2 col-md-4 mb-4">
                                                    <h6 class="text-muted">{{ trns('elevator count') }}</h6>
                                                    <p class="font-weight-bold">
                                                        {{ $obj->RealState?->realStateDetails?->elevator_count ?? trns('N/A') }}
                                                    </p>
                                                </div>
                                                <div class="col-lg-2 col-md-4 mb-4">
                                                    <h6 class="text-muted">{{ trns('building type') }}</h6>
                                                    <p class="font-weight-bold">
                                                        {{ $obj->RealState?->realStateDetails?->building_type ?? trns('N/A') }}
                                                    </p>
                                                </div>
                                                <div class="col-lg-2 col-md-4 mb-4">
                                                    <h6 class="text-muted">{{ trns('building year') }}</h6>
                                                    <p class="font-weight-bold">
                                                        {{ $obj->RealState?->realStateDetails?->building_year ?? trns('N/A') }}
                                                    </p>
                                                </div>

                                                <div class="col-lg-2 col-md-4 mb-4">
                                                    <h6 class="text-muted">{{ trns('electric account number') }}</h6>
                                                    <p class="font-weight-bold">
                                                        {{ $obj->RealState?->realStateDetails?->electric_account_number ?? trns('N/A') }}
                                                    </p>
                                                </div>

                                                <div class="col-lg-2 col-md-4 mb-4">
                                                    <h6 class="text-muted">
                                                        {{ trns('real_state_electric_subscription_number') }}
                                                    </h6>
                                                    <p class="font-weight-bold">
                                                        {{ $obj->RealState?->realStateDetails?->electric_subscription_number ?? trns('N/A') }}
                                                    </p>
                                                </div>

                                                <!-- Fourth Column Group -->
                                                <div class="col-lg-2 col-md-4 mb-4">
                                                    <h6 class="text-muted">{{ trns('electric meter number') }}</h6>
                                                    <p class="font-weight-bold">
                                                        {{-- {{ $obj->RealState?->realStateDetails?->electric_meter_number ?? trns('N/A') }}
                                                        {!! copyable_text($obj->RealState?->realStateDetails?->electric_meter_number) !!} --}}
                                                        {!! $obj->RealState?->realStateDetails?->electric_meter_number
                                                            ? copyable_text($obj->RealState?->realStateDetails?->electric_meter_number) .
                                                                ' ' .
                                                                $obj->RealState?->realStateDetails?->electric_meter_number
                                                            : trns('N/A') !!}
                                                    </p>
                                                </div>
                                                <div class="col-lg-2 col-md-4 mb-4">
                                                    <h6 class="text-muted">{{ trns('water account number') }}</h6>
                                                    <p class="font-weight-bold">
                                                        {{ $obj->RealState?->realStateDetails?->water_account_number ?? trns('N/A') }}
                                                    </p>
                                                </div>

                                                <div class="col-lg-2 col-md-4 mb-4">
                                                    <h6 class="text-muted">{{ trns('water meter number') }}</h6>
                                                    <p class="font-weight-bold">
                                                        {{ $obj->RealState?->realStateDetails?->water_meter_number ?? trns('N/A') }}
                                                    </p>
                                                </div>

                                            </div>


                                        </div>
                                    </div>
                                    <div
                                        style="border-radius: 6px;background-color: #fbf9f9;border: 1px solid #ddd; padding: 15px; margin-top: 20px;">
                                        <div>
                                            <h4 style="font-weight: bold; color: #00193a;">
                                                {{ trns('property_management') }}
                                            </h4>
                                        </div>
                                        <hr style="background-color: black;">
                                        <div class="card-body">

                                            <div class="table-responsive" style="overflow-x: inherit;">
                                                <!--begin::Table-->
                                                <table class="table text-nowrap w-100 usersTable" id=""
                                                    style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;">
                                                    <thead>
                                                        <tr class="fw-bolder"
                                                            style="background-color: #e3e3e3; color: #00193a;">
                                                            <th class="min-w-100px">{{ trns('national_id') }}</th>
                                                            <th class="min-w-150px">{{ trns('name') }}</th>
                                                            <th class="min-w-150px">{{ trns('email') }}</th>
                                                            <th class="min-w-100px">{{ trns('phone') }}</th>
                                                            <th class="min-w-100px">
                                                                {{ trns('unit_ownership_percentage') }}</th>
                                                            <th class="min-w-100px">{{ trns('status') }}</th>
                                                            <th class="min-w-150px">{{ trns('actions') }}</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--tab2 content -->

                                <!--tab3 content -->
                                <div id="tab3">
                                    @if ($obj->association)
                                        <div class="tab-pane fade show" id="property-info" role="tabpanel">
                                            <div class="show-content mt-3">
                                                <div
                                                    style="border-radius: 6px;background-color: #fbf9f9;border: 1px solid #ddd; padding: 15px;">
                                                    <h4 class="mb-4" style="font-weight: bold; color: #00193a;">
                                                        {{ trns('association_main_information') }}</h4>

                                                    <hr style="background-color: black;">

                                                    <div class="row m-2">

                                                        <div class="col-lg-2 col-md-4 mb-4">
                                                            <h6 class="text-muted">{{ trns('association_name') }}
                                                            </h6>
                                                            <p class="font-weight-bold">
                                                                {!! $obj->association?->name
                                                                    ? copyable_text($obj->association?->name) . ' ' . $obj->association?->name
                                                                    : trns('N/A') !!}
                                                            </p>
                                                        </div>
                                                        <div class="col-lg-2 col-md-4 mb-4">
                                                            <h6 class="text-muted">{{ trns('number') }}</h6>
                                                            <p class="font-weight-bold">

                                                                {!! $obj->association?->number
                                                                    ? copyable_text($obj->association?->number) . ' ' . $obj->association?->number
                                                                    : trns('N/A') !!}
                                                            </p>
                                                        </div>

                                                        <div class="col-lg-2 col-md-4 mb-4">
                                                            <h6 class="text-muted">{{ trns('real_state_count') }}
                                                            </h6>
                                                            <p class="font-weight-bold">
                                                                {{ $obj?->RealState?->association?->RealStates->count() ?? trns('N/A') }}
                                                            </p>
                                                        </div>

                                                        <div class="col-lg-2 col-md-4 mb-4">
                                                            <h6 class="text-muted">{{ trns('unit_count') }}</h6>
                                                            <p class="font-weight-bold">
                                                                {{ $obj->association?->RealStates->sum('units_count') ?? trns('N/A') }}
                                                            </p>
                                                        </div>
                                                        <div class="col-lg-2 col-md-4 mb-4">
                                                            <h6 class="text-muted">{{ trns('establish_date') }}</h6>
                                                            <p class="font-weight-bold">
                                                                {{ $obj->RealState?->association?->establish_date ? \Carbon\Carbon::parse($obj?->RealState?->association?->establish_date)->format('d / m / Y') : 'N/A' }}
                                                            </p>
                                                        </div>
                                                        <div class="col-lg-2 col-md-4 mb-4">
                                                            <h6 class="text-muted">{{ trns('status') }}</h6>
                                                            <p class="font-weight-bold">
                                                                @if ($obj->status == 1)
                                                                    <span class="badge"
                                                                        style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px">{{ trns('active') }}</span>
                                                                @else
                                                                    <span class="badge"
                                                                        style="background-color: #FFBABA; color: #1F2A37; border-radius: 30px">{{ trns('inactive') }}</span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Second divider -->
                                                <div
                                                    style="border-radius: 6px;background-color: #fbf9f9;border: 1px solid #ddd;padding: 15px; margin-top: 20px;">
                                                    <h4 class="mb-4" style="font-weight: bold; color: #00193a;">
                                                        {{ trns('association_management') }}</h4>
                                                    <hr style="background-color: black;">

                                                    <div class="row m-2">
                                                        <!-- Second Column Group -->
                                                        <div class="col-lg-2 col-md-4 mb-4">
                                                            <h6 class="text-muted">{{ trns('national_id') }}</h6>
                                                            <p class="font-weight-bold">
                                                                {{ $obj->association?->AssociationManager?->national_id ?? trns('N/A') }}
                                                            </p>
                                                        </div>
                                                        <div class="col-lg-2 col-md-4 mb-4">
                                                            <h6 class="text-muted">{{ trns('name') }}</h6>
                                                            <p class="font-weight-bold">
                                                                {{ $obj->association?->AssociationManager?->name ?? trns('N/A') }}
                                                            </p>
                                                        </div>

                                                        <div class="col-lg-2 col-md-4 mb-4">
                                                            <h6 class="text-muted">{{ trns('email') }}</h6>
                                                            <p class="font-weight-bold">
                                                                {{ $obj->association?->AssociationManager?->email ?? trns('N/A') }}
                                                            </p>
                                                        </div>

                                                        <div class="col-lg-2 col-md-4 mb-4">
                                                            <h6 class="text-muted">{{ trns('status') }}</h6>
                                                            <p class="font-weight-bold">
                                                                @if ($obj->association?->AssociationManager?->status == 1)
                                                                    <span class="badge"
                                                                        style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px">{{ trns('active') }}</span>
                                                                @else
                                                                    <span class="badge"
                                                                        style="background-color: #FFBABA; color: #1F2A37; border-radius: 30px">{{ trns('inactive') }}</span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                        <div class="col-lg-2 col-md-4 mb-4">
                                                            <h6 class="text-muted">{{ trns('phone') }}</h6>
                                                            <p class="font-weight-bold">
                                                                {{ $obj->association?->AssociationManager?->phone ?? trns('N/A') }}
                                                            </p>
                                                        </div>

                                                    </div>
                                                </div>


                                                <div class="col-12 mt-4"
                                                    style="border-radius: 6px;background-color: #fbf9f9;border: 1px solid #ddd;padding: 15px;">
                                                    <div class="form-group">
                                                        <h4 for="lat" class="form-control-label"
                                                            style="font-weight: bold; color: #00193a; text-align: right;">
                                                            {{ trns('Association Facilities Management') }}
                                                        </h4>
                                                        <hr style="background-color: black;">
                                                        <div class="mt-2 row">
                                                            <div class="col-md-6 mb-3">
                                                                <div class="card custom-card text-right"
                                                                    style="box-shadow: none;background-color: #f8f9fa; border: 1px solid #b5b5c3; border-radius: 6px;">
                                                                    <div class="card-body">
                                                                        <div
                                                                            class="form-check form-check-inline float-end">
                                                                            <!-- <input class="form-check-input" type="radio"
                                                                                                                                                                                                                                name="facility_management_template" id="template1" value="template1"> -->
                                                                            <label class="form-check-label"
                                                                                for="template1"></label>
                                                                        </div>
                                                                        <h5 class="association-card-header"
                                                                            style="color: #00193a; font-weight: bold;">
                                                                            {{ trns('Integrated Facilities Management') }}
                                                                        </h5>
                                                                        <p class="association-card-para">
                                                                            {{ trns('Here the service provider is able to provide most of the services') }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- <div class="col-md-6 mb-3">
                                                                                                                                                                                                    <div class="card custom-card text-right">
                                                                                                                                                                                                        <div class="card-body">
                                                                                                                                                                                                            <div class="form-check form-check-inline float-end">
                                                                                                                                                                                                                <input class="form-check-input" type="radio"
                                                                                                                                                                                                                    name="facility_management_template" id="template2" value="template2">
                                                                                                                                                                                                                <label class="form-check-label" for="template2"></label>
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                            <h5 class="association-card-header">
                                                                                                                                                                                                                {{ trns('Basic Model (Contract per Service)') }}</h5>
                                                                                                                                                                                                            <p class="association-card-para">
                                                                                                                                                                                                                {{ trns('Here the association can contract directly with each of the service providers') }}
                                                                                                                                            </p>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div> -->
                                                            <!-- <div class="col-md-6 mb-3">
                                                                                                                                                                                                    <div class="card custom-card text-right">
                                                                                                                                                                                                        <div class="card-body">
                                                                                                                                                                                                            <div class="form-check form-check-inline float-end">
                                                                                                                                                                                                                <input class="form-check-input" type="radio"
                                                                                                                                                                                                                    name="facility_management_template" id="template3" value="template3">
                                                                                                                                                                                                                <label class="form-check-label" for="template3"></label>
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                            <h5 class="association-card-header">
                                                                                                                                                                                                                {{ trns('Total Facilities Management') }}</h5>
                                                                                                                                                                                                            <p class="association-card-para">
                                                                                                                                                                                                                {{ trns('A single contract is concluded between the association and the service provider, and here the service provider is responsible for managing all services') }}
                                                                                                                                            </p>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div> -->
                                                            <!-- <div class="col-md-6 mb-3">
                                                                                                                                                                                                    <div class="card custom-card text-right">
                                                                                                                                                                                                        <div class="card-body">
                                                                                                                                                                                                            <div class="form-check form-check-inline float-end">
                                                                                                                                                                                                                <input class="form-check-input" type="radio"
                                                                                                                                                                                                                    name="facility_management_template" id="template4" value="template4">
                                                                                                                                                                                                                <label class="form-check-label" for="template4"></label>
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                            <h5 class="association-card-header">
                                                                                                                                                                                                                {{ trns('Self-operation (agent model)') }}</h5>
                                                                                                                                                                                                            <p class="association-card-para">
                                                                                                                                                                                                                {{ trns("The property's board of directors manages contract matters and contracts are entered into directly") }}

                                                                                                                                            </p>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div> -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div
                                                    style="border-radius: 6px;background-color: #fbf9f9;border: 1px solid #ddd;padding: 15px; margin-top: 20px;">
                                                    <h4 style="font-weight: bold; color: #00193a;">
                                                        {{ trns('موقع الجمعيه على الخريطه') }}</h4>
                                                    <hr style="background-color: black;">

                                                    <div class="row m-4">
                                                        <div class="col-12">
                                                            <div id="map" style="height: 400px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <h1>{{ trns('there is no data here') }}</h1>
                                    @endif
                                </div>
                                <!--tab3 content -->

                                <!--tab5 content -->
                                <div id="tab5">
                                    <div class="show-image">
                                        <div class="d-flex justify-content-between align-items-center">
                                            @can('create_unit')
                                                <button class="btn btn-icon text-white  addMediaBtn"
                                                    data-id="{{ $obj->id }}" data-model="Unit" data-type="image">
                                                    <span>
                                                    </span> {{ trns('add_image') }}
                                                </button>
                                            @endcan
                                            <ul class="tabs-list">
                                                <li class="show list-show" data-content=".content-one">
                                                    <i class="fa-solid fa-bars"></i>
                                                </li>
                                                <li class="list-show" data-content=".content-two">
                                                    <i class="fa-solid fa-table-cells"></i>
                                                </li>

                                            </ul>
                                        </div>
                                        <div class="content-list">
                                            <div class="content-one">
                                                <div class="table-responsive" style="overflow: inherit;">
                                                    <table class="table  table-bordered text-nowrap w-100"
                                                        style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;"
                                                        id="imagesDatatable">
                                                        <thead>
                                                            <tr class="fw-bolder"
                                                                style="background-color: #e3e3e3; color: #00193a;">

                                                                <th>{{ trns('name') }}</th>
                                                                <th>{{ trns('Size (KB)') }}</th>
                                                                <th>{{ trns('admin_id') }}</th>
                                                                <th>{{ trns('created_at') }}</th>
                                                                <th>{{ trns('image') }}</th>

                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="content-two">

                                                <div class="d-flex flex-wrap">

                                                    @foreach ($obj->getMedia('images') as $media)
                                                        <div class="image-hover"
                                                            style="width:300px; height:200px; position: relative; margin: 10px;">
                                                            <div class="dropdown drop-delete-image"
                                                                style="position: absolute; top: 20px; left: 10px;">
                                                                <button class="dropdown-toggle" type="button"
                                                                    id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                                    aria-expanded="false"
                                                                    style=" background-color: white; border-radius: 5px; border: none;">
                                                                    <i class="fa-solid fa-ellipsis"></i>
                                                                </button>
                                                                <ul class="dropdown-menu"
                                                                    style="background-color: #EAEAEA; text-align: right;"
                                                                    aria-labelledby="dropdownMenuButton1">

                                                                    <li class="m-2">
                                                                        <span class="download-img"
                                                                            style="cursor: pointer;"
                                                                            data-fileName=" {{ $media->file_name }} "
                                                                            data-url="{{ asset('storage/unit/' . $media->model_id . '/images/' . $media->file_name) }}">
                                                                            <i class="fas fa-download"></i>
                                                                            {{ trns('download') }}
                                                                        </span>

                                                                    </li>

                                                                    <li class="m-2">
                                                                        <span class="delete_img" style="cursor: pointer;"
                                                                            data-id=" {{ $media->id }}">
                                                                            <i class="fas fa-trash"></i>
                                                                            {{ trns('Delete') }}
                                                                        </span>
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                            <img onclick="openModal('{{ asset('storage/unit/' . $obj->id . '/images/' . $media->file_name) }}')"
                                                                style="width:100%; height:100%; border-radius: 10px"
                                                                src="{{ asset('storage/unit/' . $obj->id . '/images/' . $media->file_name) }}">

                                                        </div>
                                                    @endforeach

                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--tab5 content -->

                                <!--tab4 content -->
                                <div id="tab4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h3>{{ trns('attachment') }}</h3>
                                        @can('create_unit')
                                            <button class="btn btn-icon text-white  addMediaBtn"
                                                data-id="{{ $obj->id }}" data-model="Unit" data-type="file">
                                                <span>
                                                </span> {{ trns('add_file') }}
                                            </button>
                                        @endcan
                                    </div>
                                    <div class="table-responsive" style="overflow: inherit;">
                                        <table class="table  table-bordered text-nowrap w-100 filesTable"
                                            style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom:0 !important;">
                                            <thead>
                                                <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">
                                                    <th>{{ trns('rated_number') }}</th>
                                                    <th>{{ trns('file_icon') }}</th>
                                                    <th>{{ trns('file_name') }}</th>
                                                    <th>{{ trns('creator') }}</th>
                                                    <th>{{ trns('created_at') }}</th>
                                                    <th>{{ trns('Size (KB)') }}</th>
                                                    <th>{{ trns('actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($obj->media()->where('collection_name', 'files')->get() as $media)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            @php
                                                                $extension = strtolower(
                                                                    pathinfo($media->file_name, PATHINFO_EXTENSION),
                                                                );
                                                                $iconClass = 'fas fa-file'; // default icon
                                                                $iconColor = '#6c757d'; // default color

                                                                // Define icons and colors based on extension
                                                                $iconSize = '45px'; // Set bigger size for all icons

                                                                switch ($extension) {
                                                                    case 'pdf':
                                                                        $iconImage = asset('svgs/pdf.svg');
                                                                        break;
                                                                    case 'doc':
                                                                    case 'docx':
                                                                        $iconImage = asset('svgs/word.svg');
                                                                        break;
                                                                    case 'xls':
                                                                    case 'xlsx':
                                                                        $iconImage = asset('svgs/excel.svg');
                                                                        break;
                                                                    default:
                                                                        $iconImage = asset('svgs/file.svg');
                                                                        break;
                                                                }

                                                            @endphp

                                                            <img src="{{ $iconImage }}" style="width: 40px" />

                                                        </td>
                                                        <td style="cursor: pointer;" <a
                                                            href="{{ asset('storage/' . @$media->id . '/' . @$media->file_name) }}">
                                                            {{ Str::before($media->file_name, '_') }}

                                                            </a>
                                                        </td>
                                                        <td>{{ App\Models\Admin::find($media->custom_properties['admin_id'])->name ?? '-' }}
                                                        </td>
                                                        <td>{{ @$media->created_at }}</td>
                                                        <td>{{ number_format(@$media->size / 1024, 2) }} KB</td>
                                                        <td style="cursor: pointer;">
                                                            <div class="dropdown">
                                                                <button class="dropdown-toggle" type="button"
                                                                    id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                                    aria-expanded="false"
                                                                    style="background-color: transparent; border: none;">
                                                                    <i class="fa-solid fa-ellipsis"></i>
                                                                </button>
                                                                <ul class="dropdown-menu"
                                                                    style="z-index: 9999; background-color: rgb(234, 234, 234); text-align: right;"
                                                                    aria-labelledby="dropdownMenuButton1">
                                                                    <li>
                                                                        <a class="dropdown-item" target="_blank"
                                                                            href="{{ asset('storage/' . @$media->id . '/' . @$media->file_name) }}">
                                                                            <i class="fa-solid fa-eye me-1"></i>
                                                                            {{ trns('view') }}
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item download-btn"
                                                                            href="{{ asset('storage/' . @$media->id . '/' . @$media->file_name) }}"
                                                                            download>
                                                                            <i class="fas fa-download me-1"></i>
                                                                            {{ trns('download_file') }}
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item delete_img"
                                                                            href="javascript:void(0);"
                                                                            data-id="{{ $media->id }}"
                                                                            data-title="{{ $media->file_name }}">
                                                                            <i
                                                                                class="fas fa-trash ms-1"></i>{{ trns('Delete') }}
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center text-muted">لا يوجد ملفات
                                                        </td>
                                                    </tr>
                                                @endforelse

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--tab4 content -->

                                <div id="imageModal" class="modal">
                                    <span class="close" onclick="closeModal()">&times;</span>
                                    <img style="width:80%; height:80%; margin:5% auto; display:block; border:0"
                                        class="modal-content" id="modalImage">
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- the images modal --}}
                    <div id="imageModal"
                        style="display:none; position:fixed; z-index:9999;
                            left:0; top:0; width:100vw;  background:rgba(0,0,0,0.8);">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <img style="width:80%; height:80%; margin:5% auto; display:block; border:0" class="modal-content"
                            id="modalImage">
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Create Or Edit Modal -->
    <div class="modal fade" id="editOrCreate" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">{{ trns('add new user') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body">
                    <!-- Content will be loaded here via AJAX -->
                </div>
                <div class="modal-footer" id="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <!-- Create Or Edit Modal -->


    <!-- addOrEditElectricOrWaterModal Modal -->
    <div class="modal fade" id="addOrEditElectricOrWaterModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title_add_electric_or_water"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_body_of_add_electric_or_water">

                </div>
                <div class="modal-footer" id="modal_footer_add_electric_or_water">

                </div>
            </div>
        </div>
    </div>
    <!-- addOrEditElectricOrWaterModal Modal -->
    </div>
    <div class="modal fade" id="delete_electric_or_water_modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trns('delete') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input id="delete_id" name="id" type="hidden">
                    <p>{{ trns('are_you_sure_you_want_to_delete_this_obj') }} </p>

                </div>
                <div class="modal-footer d-flex flex-nowrap">
                    <button type="button" class="btn btn-two" data-bs-dismiss="modal" id="dismiss_delete_modal">
                        {{ trns('close') }}
                    </button>
                    <button type="button" class="btn btn-one"
                        id="delete_btn_of_electric_or_water">{{ trns('delete') }} !</button>
                </div>
            </div>
        </div>
    </div>

    <!-- delete selected  Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">{{ trns('confirm_deletion') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ trns('are_you_sure_you_want_to_delete_selected_items') }}</p>
                </div>
                <div class="modal-footer d-flex flex-nowrap">
                    <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('cancel') }}</button>
                    <button type="button" class="btn btn-one" id="confirm-delete-btn">{{ trns('delete') }}</button>
                </div>
            </div>
        </div>



    </div>

    <!-- addExcelOfElectricOrWaterFileOfUnit Modal -->

    <div class="modal fade" id="addExcelOfElectricOrWaterFileOfUnit" tabindex="-1"
        aria-labelledby="addExcelOfElectricOrWaterFileOfUnit" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExcelOfElectricOrWaterFileOfUnit">استيراد ملف Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-excel-body-electric-or-water-of-unit">
                </div>
            </div>
        </div>
    </div>

    <!-- delete selected  Modal -->
    @include('admin.layouts.NewmyAjaxHelper')

@endsection
@section('ajaxCalls')
    <script>
        $(document).on('click', '.addMediaBtn', function() {
            var id = $(this).data('id');
            var model = $(this).data('model');
            var type = $(this).data('type');
            var url = '{{ route('media.create') }}?id=' + id + '&model=' + model + '&type=' + type;
            $('#modal-body').html(loader)
            $('#editOrCreate').modal('show');
            if (type == 'file') {
                $('#editOrCreate .modal-title').text('اضافة ملفات');
            } else {
                $('#editOrCreate .modal-title').text('اضافة صور');
            }

            // footer buttons
            $('#modal-footer').html(`
                <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two"
                            data-bs-dismiss="modal">{{ trns('close') }}</button>
                    <button type="submit" class="btn btn-one me-2"
                            id="addMediaButton">{{ trns('add') }}</button>
                </div>
            `);

            setTimeout(function() {
                $('#modal-body').load(url)
            }, 500)

            $(document).on('click', '#addMediaButton', function() {
                var form = $('#mediaCreate')[0];
                var formData = new FormData(form);
                var url = $(form).attr('action');
                console.log(url);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#addMediaButton').html(
                                '<span class="spinner-border spinner-border-sm mr-2"></span> <span style="margin-left: 4px;">{{ trns('loading...') }}</span>'
                            )
                            .attr('disabled', true);
                    },
                    success: function(data) {
                        $('#addMediaButton').html('{{ trns('add') }}').attr('disabled',
                            false);
                        if (data.status == 200) {
                            Swal.fire({
                                title: '<span style="margin-bottom: 50px; display: block;">{{ trns('added_successfully') }}</span>',
                                imageUrl: '{{ asset('true.png') }}',
                                imageWidth: 80,
                                imageHeight: 80,
                                imageAlt: 'Success',
                                showConfirmButton: false,
                                timer: 2000,
                                customClass: {
                                    image: 'swal2-image-mt30'
                                }
                            });
                            setTimeout(e => {
                                window.location.reload();
                            }, 1000);

                            // إعادة تعيين النموذج
                            $('.addForm')[0].reset();
                            $('.file-previews').html('');

                            if (data.redirect_to) {
                                setTimeout(function() {
                                    window.location.href = data.redirect_to;
                                }, 2000);
                            } else {
                                $('#editOrCreate').modal('hide');
                                if (typeof window.location.reload === 'function') {
                                    window.location.reload();
                                }
                            }
                        } else if (data.status == 405) {
                            Swal.fire({
                                title: '<span style="margin-bottom: 50px; display: block;">{{ trns('something_went_wrong') }}</span>',
                                imageUrl: '{{ asset('true.png') }}',
                                imageWidth: 80,
                                imageHeight: 80,
                                imageAlt: 'Success',
                                showConfirmButton: false,
                                timer: 2000,
                                customClass: {
                                    image: 'swal2-image-mt30'
                                }
                            });
                        } else {
                            Swal.fire({
                                title: '<span style="margin-bottom: 50px; display: block;">{{ trns('something_went_wrong') }}</span>',
                                imageUrl: '{{ asset('true.png') }}',
                                imageWidth: 80,
                                imageHeight: 80,
                                imageAlt: 'Success',
                                showConfirmButton: false,
                                timer: 2000,
                                customClass: {
                                    image: 'swal2-image-mt30'
                                }
                            });
                        }

                        $('#addMediaButton').html('{{ trns('add') }}').attr('disabled',
                            false);
                    },
                    error: function(xhr, status, error) {
                        $('#addMediaButton').html('{{ trns('add') }}').attr('disabled',
                            false);
                        if (xhr.status === 500) {
                            toastr.error('{{ trns('server_error') }}');
                        } else if (xhr.status === 422) {
                            var errors = xhr.responseJSON;
                            if (errors && errors.errors) {
                                $.each(errors.errors, function(key, value) {
                                    if (Array.isArray(value)) {
                                        $.each(value, function(index, message) {
                                            toastr.error(message,
                                                '{{ trns('error') }}');
                                        });
                                    } else {
                                        toastr.error(value, '{{ trns('error') }}');
                                    }
                                });
                            } else {
                                toastr.error('{{ trns('validation_error') }}');
                            }
                        } else if (xhr.status === 413) {
                            toastr.error('{{ trns('file_too_large') }}');
                        } else {
                            toastr.error('{{ trns('something_went_wrong') }}');
                        }

                        $('#addMediaButton').html('{{ trns('add') }}').attr('disabled',
                            false);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
        })
    </script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-sA+oYy5rjphsyV6qLdX5lFh3ugMQAxTVvD+FA2z6+3Y=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-oRkS4hJ2kMRSR2J7DHOY7FTh5E3uX9U4I9znKzJxM7E=" crossorigin=""></script>

    <script>
        // Global variables
        let map, marker;

        $(document).ready(function() {
            const realstate_id = '{{ $obj->id }}';

            $('#imagesDatatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{ route('unitImages.images.show', ['id' => '__id__']) }}`.replace('__id__',
                    realstate_id),
                columns: [{
                        data: 'name',
                        name: 'name',
                        render: function(data, type, row) {
                            if (!data) return '';
                            return data.split('_')[0];
                        }
                    },
                    {
                        data: 'size',
                        name: 'size'
                    },
                    {
                        data: 'admin_id',
                        name: 'admin_id'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            if (!data) return '';
                            var date = new Date(data);
                            var yyyy = date.getFullYear();
                            var mm = ('0' + (date.getMonth() + 1)).slice(-2);
                            var dd = ('0' + date.getDate()).slice(-2);
                            var hh = ('0' + date.getHours()).slice(-2);
                            var min = ('0' + date.getMinutes()).slice(-2);
                            var ss = ('0' + date.getSeconds()).slice(-2);
                            return `${yyyy}-${mm}-${dd} ${hh}:${min}:${ss}`;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                searching: false,
                lengthChange: false,
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json", // Fixed CORS issue
                },
            });

            // Initialize Dropify
            $('.dropify').dropify();

            // Initialize Select2
            initializeSelect2WithSearchCustom('#user_ids');
            initializeSelect2('#association_id');
            initializeSelect2('#real_state_id');

            // Initialize Map
            initializeMap();

            // Initialize commissioned fields
            toggleCommissionedFields();
            $('input[name="is_commission"]').on("change", toggleCommissionedFields);

            // Date validation
            initializeDateValidation();

            // Initialize tabs
            initializeTabs();
        });

        // Map initialization function
        function initializeMap() {
            const initialLat = parseFloat("{{ $obj->lat ?? 24.7136 }}");
            const initialLng = parseFloat("{{ $obj->long ?? 46.6753 }}");

            map = L.map('map').setView([initialLat, initialLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            marker = L.marker([initialLat, initialLng], {
                    draggable: true
                }).addTo(map)
                .bindPopup('Drag me to set location')
                .openPopup();

            // Map event listeners
            marker.on('dragend', function(e) {
                const {
                    lat,
                    lng
                } = e.target.getLatLng();
                $('#lat').val(lat.toFixed(6));
                $('#long').val(lng.toFixed(6));
            });

            map.on('click', function(e) {
                const {
                    lat,
                    lng
                } = e.latlng;
                marker.setLatLng([lat, lng]);
                $('#lat').val(lat.toFixed(6));
                $('#long').val(lng.toFixed(6));
            });

            // Add existing locations if available
            @if (isset($locations))
                @foreach ($locations as $location)
                    L.marker([{{ $location->lat }}, {{ $location->lng }}])
                        .addTo(map)
                        .bindPopup('<b>{{ $location->name }}</b><br>{{ $location->description }}');
                @endforeach
            @endif

            // Fix map display issues
            setTimeout(function() {
                map.invalidateSize();
            }, 100);
        }

        // Update marker position function
        function updateMarkerPosition() {
            let lat = parseFloat($("#lat").val());
            let long = parseFloat($("#long").val());

            if (!isNaN(lat) && !isNaN(long) && marker) {
                marker.setLatLng([lat, long]);
                map.panTo([lat, long]);
            }
        }

        // Bind input events for lat/long
        $(document).on("input", "#lat, #long", updateMarkerPosition);

        // Modal functions
        function openModal(imagePath) {
            var modal = document.getElementById("imageModal");
            var modalImg = document.getElementById("modalImage");

            if (modal && modalImg) {
                modal.style.display = "block";
                modalImg.src = imagePath;
                console.log('imagePath', imagePath);
            }
        }

        function closeModal() {
            var modal = document.getElementById("imageModal");
            if (modal) {
                modal.style.display = "none";
            }
        }

        // Tabs initialization
        function initializeTabs() {
            $('.tabs-list li').on('click', function() {
                $(this).addClass('show').siblings().removeClass('show');
                $('.content-list > div').hide();
                $($(this).data('content')).fadeIn();
            });
        }

        // Commissioned fields toggle
        function toggleCommissionedFields() {
            $('.commissioned').toggle($('input[name="is_commission"]:checked').val() === '1');
        }

        // Date validation initialization
        function initializeDateValidation() {
            $('#appointment_start_date').on('change', function() {
                const startDate = $(this).val();
                $('#appointment_end_date').attr('min', startDate);

                if ($('#appointment_end_date').val() && $('#appointment_end_date').val() < startDate) {
                    $('#appointment_end_date').val('');
                }
            });

            $('#appointment_end_date').on('change', function() {
                const endDate = $(this).val();
                $('#appointment_start_date').attr('max', endDate);

                if ($('#appointment_start_date').val() && $('#appointment_start_date').val() > endDate) {
                    $('#appointment_start_date').val('');
                }
            });
        }

        // Download images handler
        $(document).on("click", ".download-img", function() {
            const url = $(this).data('url');
            const fileName = $(this).data('filename');

            const link = document.createElement('a');
            link.href = url;
            link.download = fileName || 'downloaded-image';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        // Delete images handler
        $(document).on('click', '.delete_img', function(e) {
            e.preventDefault();

            let id = $(this).data('id');

            $.ajax({
                type: 'POST',
                url: '{{ route('unitImages.delete') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id': id
                },
                success: function(data) {
                    if (data.status === 200) {
                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('image_deleted_successfully') }}</span>',
                            imageUrl: '{{ asset('true.png') }}',
                            imageWidth: 80,
                            imageHeight: 80,
                            imageAlt: 'Success',
                            showConfirmButton: false,
                            timer: 2000,
                            customClass: {
                                image: 'swal2-image-mt30'
                            }
                        });
                        window.location.reload();
                    }
                },
                error: function() {
                    toastr.error("{{ trns('something_went_wrong') }}");
                }
            });
        });

        // Edit modal handler
        function showEditModal1(routeOfEdit, titleModal = null) {
            $(document).on('click', '.editUnitBtn', function() {

                var id = $(this).data('id');
                var url = routeOfEdit.replace(':id', id);

                $('#modal-body').html(loader);
                $('#editOrCreate').modal('show');
                if (titleModal != null) {
                    $('#modalTitle').text(titleModal);
                }

                // footer buttons
                $('#modal-footer').html(`
                <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two"
                            data-bs-dismiss="modal">{{ trns('close') }}</button>
                    <button type="submit" class="btn btn-one me-2"
                            id="updateButton">{{ trns('update') }}</button>
                </div>
            `);

                setTimeout(function() {
                    $('#modal-body').load(url);
                }, 500);
            });
        }

        showEditModal1("{{ route('units.edit', ':id') }}", '{{ trns('edit_unit') }}');

        // Users DataTable
        $(document).ready(function() {
            var usersColumns = [{
                    data: 'national_id',
                    name: 'national_id'
                },
                {
                    data: 'name',
                    name: 'name',
                    render: function(data, type, row) {
                        var showUrl = '{{ route('users.show', 0) }}'.replace('/0', '/' + row.id);
                        return `<a href="${showUrl}">${data}</a>`;
                    }
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'unit_ownership',
                    name: 'unit_ownership'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ];

            $('.usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('units.unitOwnersByUnit', ['request' => request(), 'id' => $obj->id]) }}',
                    type: 'GET'
                },
                columns: usersColumns,
                order: [
                    [1, 'asc']
                ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
                },
                createdRow: function(row, data, dataIndex) {
                    $(row).attr('data-id', data.id);
                },
                error: function(xhr, error, thrown) {
                    console.error('DataTables error:', error, thrown);
                }
            });

            // Add Using Ajax
            showEditModal("{{ route('users.edit', ':id') }}", '{{ trns('edit_user') }}');
            editScript();

            // Files DataTable
            $('.filesTable').DataTable({
                processing: true,
                serverSide: false,
                order: [
                    [0, 'desc']
                ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
                },
            });
        });

        // Status toggle handler
        $(document).on('click', '.toggleStatusBtn', function(e) {
            e.preventDefault();

            let id = $(this).data('id');
            let currentStatus = parseInt($(this).data('status'));
            let newStatus = currentStatus === 1 ? 0 : 1;

            $.ajax({
                type: 'POST',
                url: '{{ route('units.updateColumnSelected') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'ids': [id],
                    'status': newStatus
                },
                success: function(data) {
                    if (data.status === 200) {
                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('status_changed_successfully') }}</span>',
                            imageUrl: '{{ asset('true.png') }}',
                            imageWidth: 80,
                            imageHeight: 80,
                            imageAlt: 'Success',
                            showConfirmButton: false,
                            timer: 1500,
                            customClass: {
                                image: 'swal2-image-mt30'
                            }
                        });

                        window.location.reload();
                    } else {
                        toastr.error("{{ trns('something_went_wrong') }}");
                    }
                },
                error: function() {
                    toastr.error("{{ trns('something_went_wrong') }}");
                }
            });
        });

        // Hash navigation
        $(document).ready(function() {
            if (window.location.hash === '#unitRealstate') {
                $('.nav-tabs a[href="#unitRealstate"]').tab('show');
            }
        });
    </script>



    <script>
        $(document).ready(function() {
            var waterColumns = [{
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `<input type="checkbox" class="delete-checkbox-water" value="${row.id}">`;
                    }
                }, {
                    data: 'water_name',
                    name: 'water_name'
                },
                {
                    data: 'water_account_number',
                    name: 'water_account_number'
                },
                {
                    data: 'water_meter_number',
                    name: 'water_meter_number'
                },

                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }

            ];
            var waterTable = $('.waterTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('units.get_waters', ['request' => request(), 'id' => @$obj->id]) }}',
                    type: 'GET'
                },
                columns: waterColumns,
                order: [
                    [2, 'asc']
                ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
                },
                createdRow: function(row, data, dataIndex) {
                    $(row).attr('data-id', data.id);
                },
                error: function(xhr, error, thrown) {
                    console.error('DataTables error:', error, thrown);
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            var ElectiricColumns = [{
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `<input type="checkbox" class="delete-checkbox-electric" value="${row.id}">`;
                    }
                }, {
                    data: 'electric_name',
                    name: 'electric_name'
                }, {
                    data: 'electric_account_number',
                    name: 'electric_account_number'
                },
                {
                    data: 'electric_meter_number',
                    name: 'electric_meter_number'
                },

                {
                    data: 'electric_subscription_number',
                    name: 'electric_subscription_number',
                },

                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }

            ];
            var electricsTable = $('.electricsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('units.get_electrics', ['request' => request(), 'id' => @$obj->id]) }}',
                    type: 'GET'
                },
                columns: ElectiricColumns,
                order: [
                    [3, 'asc']
                ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
                },
                createdRow: function(row, data, dataIndex) {
                    $(row).attr('data-id', data.id);
                },
                error: function(xhr, error, thrown) {
                    console.error('DataTables error:', error, thrown);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#bulk-delete-electric, #bulk-delete-water').prop('disabled', true);


            $('#select-all-electric').on('click', function() {
                const isChecked = $(this).is(':checked');
                $('.delete-checkbox-electric').prop('checked', isChecked);
                toggleBulkDeleteButton('electric');
            });

            $(document).on('change', '.delete-checkbox-electric', function() {
                toggleBulkDeleteButton('electric');
            });

            $('#select-all-water').on('click', function() {
                const isChecked = $(this).is(':checked');
                $('.delete-checkbox-water').prop('checked', isChecked);
                toggleBulkDeleteButton('water');
            });

            $(document).on('change', '.delete-checkbox-water', function() {
                toggleBulkDeleteButton('water');
            });

            $('#bulk-delete-electric, #bulk-delete-water').on('click', function() {
                const type = $(this).data('type');
                const checkboxes = type === 'electrics' ? '.delete-checkbox-electric' :
                    '.delete-checkbox-water';
                const tableId = type === 'electrics' ? '#electricsTable' : '#waterTable';

                const selected = $(checkboxes + ':checked').map(function() {
                    return $(this).val();
                }).get();

                if (selected.length > 0) {
                    $('#deleteConfirmModal').modal('show');

                    $('#confirm-delete-btn').off('click').on('click', function() {
                        $.ajax({
                            url: '{{ $delete_selected_route_electric_or_waters }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ids: selected,
                                type: type
                            },
                            success: function(response) {
                                if (response.status === 200) {
                                    Swal.fire({
                                        title: '<span style="margin-bottom: 50px; display: block;">{{ trns('changed_successfully') }}</span>',
                                        imageUrl: '{{ asset('true.png') }}',
                                        imageWidth: 80,
                                        imageHeight: 80,
                                        imageAlt: 'Success',
                                        showConfirmButton: false,
                                        timer: 500,
                                        customClass: {
                                            image: 'swal2-image-mt30'
                                        }
                                    });

                                    $(checkboxes).prop('checked', false);
                                    $(tableId).DataTable().ajax.reload();
                                    $('#deleteConfirmModal').modal('hide');
                                    toggleBulkDeleteButton(type);
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{ trns('something_went_wrong') }}'
                                    });
                                }
                            },
                            error: function() {
                                toastr.error('{{ trns('something_went_wrong') }}');
                                $('#deleteConfirmModal').modal('hide');
                                toggleBulkDeleteButton(type);
                            }
                        });
                    });
                }
            });

            function toggleBulkDeleteButton(type) {
                if (type === 'electric') {
                    const anyChecked = $('.delete-checkbox-electric:checked').length > 0;
                    $('#bulk-delete-electric').prop('disabled', !anyChecked);
                } else if (type === 'water') {
                    const anyChecked = $('.delete-checkbox-water:checked').length > 0;
                    $('#bulk-delete-water').prop('disabled', !anyChecked);
                }
            }
        });
    </script>





    <script>
        var loader = `
			<div id="skeletonLoader" class="skeleton-loader">
    <div class="loader-header">
        <div class="skeleton skeleton-text"></div>
    </div>
    <div class="loader-body">
        <div class="skeleton skeleton-textarea"></div>
    </div>

        </div>
        `;

        $(document).on('click', '.addElectricOrWaterBtn', function() {
            const type = $(this).data('type');
            const route = $(this).data('route');
            console.log(type, route);

            let title = '';
            if (type === 'electric') {
                title = "{{ trns('add_new_electric') }}";
            } else if (type === 'water') {
                title = "{{ trns('add_new_water') }}";
            } else {
                title = "{{ trns('add') }}";
            }

            $('#modal_title_add_electric_or_water').text(title);

            $('#modal_footer_add_electric_or_water').html(`
        <div class="w-100 d-flex">
            <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('close') }}</button>
            <button type="submit" class="btn btn-one me-2" id="addElectricOrWaterButton">{{ trns('create') }}</button>
        </div>
    `);

            $('#modal_body_of_add_electric_or_water').html(loader);
            $('#addOrEditElectricOrWaterModal').modal('show');

            setTimeout(function() {
                $('#modal_body_of_add_electric_or_water').load(route);
            }, 250);
        });




        $(document).on('click', '.editElectricOrWaterBtn', function() {

            var id = $(this).data('id');
            var type = $(this).data('type');
            var route = $(this).data('route');
            $('#modal_body_of_add_electric_or_water').html(loader);
            $('#addOrEditElectricOrWaterModal').modal('show');
            let title = '';
            if (type === 'electric') {
                title = "{{ trns('edit_new_electric') }}";
            } else if (type === 'water') {
                title = "{{ trns('edit_new_water') }}";
            } else {
                title = "{{ trns('edit') }}";
            }

            $('#modal_title_add_electric_or_water').text(title);

            // footer buttons
            $('#modal_footer_add_electric_or_water').html(`
        <div class="w-100 d-flex">
            <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('close') }}</button>
            <button type="submit" class="btn btn-one me-2" id="updateElectricOrWaterButton">{{ trns('update') }}</button>
        </div>
    `);

            setTimeout(function() {
                $('#modal_body_of_add_electric_or_water').load(route);
            }, 500);
        });












        $(document).on('click', '#addElectricOrWaterButton', function(e) {
            e.preventDefault();

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            var formData = new FormData($('#addElectricOrWaterForm')[0]);
            var url = $('#addElectricOrWaterForm').attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#addElectricOrWaterButton').html(
                            '<span class="spinner-border spinner-border-sm mr-2"></span> <span style="margin-left: 4px;">{{ trns('loading...') }}</span>'
                        )
                        .attr('disabled', true);
                },
                success: function(data) {
                    $('#addElectricOrWaterButton').html('{{ trns('add') }}').attr('disabled',
                        false);
                    console.log(data);
                    if (data.status == 200) {
                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('success') }}</span>',
                            imageUrl: '{{ asset('true.png') }}',
                            imageWidth: 80,
                            imageHeight: 80,
                            imageAlt: 'Success',
                            showConfirmButton: false,
                            timer: 500,
                            customClass: {
                                image: 'swal2-image-mt30'
                            }
                        });

                        if (data.redirect_to) {
                            setTimeout(function() {
                                window.location.href = data.redirect_to;
                            }, 2000);
                        } else {
                            $('#addOrEditElectricOrWaterModal').modal('hide');
                            $('#electricsTable').DataTable().ajax.reload();
                            $('#waterTable').DataTable().ajax.reload();

                        }
                    } else if (data.status == 405) {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('error') }}',
                            text: data.mymessage
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('error') }}',
                            text: '{{ trns('something_went_wrong') }}'
                        });
                    }
                    $('#addElectricOrWaterButton').html('{{ trns('add') }}').attr('disabled',
                        false);
                },
                error: function(xhr) {
                    $('#addElectricOrWaterButton').html('{{ trns('add') }}').attr('disabled',
                        false);

                    if (xhr.status === 500) {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('server_error') }}',
                            text: '{{ trns('internal_server_error') }}'
                        });
                    } else if (xhr.status === 422) {
                        // Handle validation errors
                        var errors = xhr.responseJSON.errors;

                        // Display validation errors under each field
                        $.each(errors, function(field, messages) {
                            var input = $('[name="' + field + '"]');

                            // Add invalid class to input
                            input.addClass('is-invalid');

                            // Create error message element
                            var errorHtml = '<div class="invalid-feedback">' + messages[0] +
                                '</div>';


                            input.after(errorHtml);
                        });

                        // Show SweetAlert for validation errors
                        var firstErrorField = Object.keys(errors)[0];
                        var firstErrorMessage = errors[firstErrorField][0];

                        // Focus on first error field
                        $('[name="' + firstErrorField + '"]').focus();

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('error') }}',
                            text: '{{ trns('something_went_wrong') }}'
                        });
                    }

                    $('#addElectricOrWaterButton').html('{{ trns('add') }}').attr('disabled',
                        false);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });


        $(document).on('click', '#updateElectricOrWaterButton', function(e) {
            e.preventDefault();

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            var formData = new FormData($('#updateElectricOrWaterForm')[0]);
            var url = $('#updateElectricOrWaterForm').attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#updateElectricOrWaterButton').html(
                            '<span class="spinner-border spinner-border-sm mr-2"></span> <span style="margin-left: 4px;">{{ trns('loading...') }}</span>'
                        )
                        .attr('disabled', true);
                },
                success: function(data) {
                    $('#updateElectricOrWaterButton').html('{{ trns('edit') }}').attr('disabled',
                        false);
                    console.log(data);
                    if (data.status == 200) {
                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('success') }}</span>',
                            imageUrl: '{{ asset('true.png') }}',
                            imageWidth: 80,
                            imageHeight: 80,
                            imageAlt: 'Success',
                            showConfirmButton: false,
                            timer: 500,
                            customClass: {
                                image: 'swal2-image-mt30'
                            }
                        });

                        if (data.redirect_to) {
                            setTimeout(function() {
                                window.location.href = data.redirect_to;
                            }, 2000);
                        } else {
                            $('#addOrEditElectricOrWaterModal').modal('hide');
                            $('#electricsTable').DataTable().ajax.reload();
                            $('#waterTable').DataTable().ajax.reload();

                        }
                    } else if (data.status == 405) {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('error') }}',
                            text: data.mymessage
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('error') }}',
                            text: '{{ trns('something_went_wrong') }}'
                        });
                    }
                    $('#updateElectricOrWaterButton').html('{{ trns('edit') }}').attr('disabled',
                        false);
                },
                error: function(xhr) {
                    $('#updateElectricOrWaterButton').html('{{ trns('edit') }}').attr('disabled',
                        false);

                    if (xhr.status === 500) {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('server_error') }}',
                            text: '{{ trns('internal_server_error') }}'
                        });
                    } else if (xhr.status === 422) {
                        // Handle validation errors
                        var errors = xhr.responseJSON.errors;

                        // Display validation errors under each field
                        $.each(errors, function(field, messages) {
                            var input = $('[name="' + field + '"]');

                            // Add invalid class to input
                            input.addClass('is-invalid');

                            // Create error message element
                            var errorHtml = '<div class="invalid-feedback">' + messages[0] +
                                '</div>';


                            input.after(errorHtml);
                        });

                        // Show SweetAlert for validation errors
                        var firstErrorField = Object.keys(errors)[0];
                        var firstErrorMessage = errors[firstErrorField][0];

                        // Focus on first error field
                        $('[name="' + firstErrorField + '"]').focus();

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('error') }}',
                            text: '{{ trns('something_went_wrong') }}'
                        });
                    }

                    $('#updateElectricOrWaterButton').html('{{ trns('edit') }}').attr('disabled',
                        false);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });

        $('#delete_electric_or_water_modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var title = button.data('title');
            var route = button.data('route');

            var modal = $(this);

            modal.find('#delete_btn_of_electric_or_water').data('route', route);

            modal.find('.modal-body #delete_id').val(id);
            modal.find('.modal-body #title').text(title);
        });


        $(document).on('click', '#delete_btn_of_electric_or_water', function() {
            var id = $("#delete_id").val();
            var route = $('#delete_btn_of_electric_or_water').data('route');

            route = route.replace(':id', id);


            $.ajax({
                type: 'DELETE',
                url: route,
                data: {
                    '_token': "{{ csrf_token() }}",
                },
                success: function(data) {
                    if (data.status === 200) {
                        $('#delete_electric_or_water_modal').modal('hide');
                        $('#electricsTable').DataTable().ajax.reload();
                        $('#waterTable').DataTable().ajax.reload();

                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('success') }}</span>',
                            imageUrl: '{{ asset('true.png') }}',
                            imageWidth: 80,
                            imageHeight: 80,
                            imageAlt: 'Success',
                            showConfirmButton: false,
                            timer: 500,
                            customClass: {
                                image: 'swal2-image-mt30'
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('Deletion failed') }}',
                            text: data.message ||
                                '{{ trns('Something went wrong') }}',
                            confirmButtonText: '{{ trns('OK') }}'
                        });
                    }
                },

                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ trns('Error') }}',
                        text: xhr.responseJSON?.message ||
                            '{{ trns('Something went wrong') }}',
                        confirmButtonText: '{{ trns('OK') }}'
                    });
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.addExcelOfElectricOrWaterFileOfUnit', function() {
            console.log('clicked');
            let routeOfShow = '{{ route('unit.add.electric_or_water.excel') }}';
            $('#modal-excel-body-electric-or-water-of-unit').html(loader);
            $('#addExcelOfElectricOrWaterFileOfUnit').modal('show');

            setTimeout(function() {
                $('#modal-excel-body-electric-or-water-of-unit').load(routeOfShow, function() {
                    initExcelForm();

                });
            }, 250);
        });




        function initExcelForm() {
            $('#excel-import-form-electric-or-water-of-unit').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let submitBtn = form.find('button[type="submit"]');
                let originalBtnText = submitBtn.html();

                submitBtn.prop('disabled', true).html(
                    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ${submitBtn.text()}...`
                );

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#addExcelOfElectricOrWaterFileOfUnit').modal('hide');
                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('success') }}</span>',
                            imageUrl: '{{ asset('true.png') }}',
                            imageWidth: 80,
                            imageHeight: 80,
                            imageAlt: 'Success',
                            showConfirmButton: false,
                            timer: 500,
                            customClass: {
                                image: 'swal2-image-mt30'
                            }
                        });
                        $('#electricsTable').DataTable().ajax.reload(null, false);
                        $('#waterTable').DataTable().ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        let errorMessage = xhr.responseJSON?.message ||
                            '{{ trans('server_connection_error') }}';
                        if (xhr.responseJSON?.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors)[0][0];
                        }
                        toastr.error(errorMessage);
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).html(originalBtnText);
                    }
                });
            });
        }
    </script>
@endsection
