@extends('admin.layouts.master')

@section('title')
    {{ config()->get('app.name') }} | {{ trns($bladeName) }}
@endsection
@section('page_name')
    {{ trns($bladeName) }}
@endsection

<style>
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

<style>
    .tab-content>div {
        display: none;
    }

    .tab-content>.active {
        display: block;
    }

    .btn-outline-success:not(:disabled):not(.disabled):active,
    .btn-outline-success:not(:disabled):not(.disabled).active {
        background-color: transparent !important;
        color: #00183b !important;
        border-bottom: 1px solid #00f3ca !important;
    }
</style>
@section('content')
    <!-- Create Or Edit Modal -->
    <div class="modal fade" id="editOrCreate" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="example-Modal3">{{ trns('add_unit') }} </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body">

                </div>
                <div class="modal-footer" id="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <!-- Create Or Edit Modal -->
    <!--Delete MODAL -->
    <div class="modal fade" id="delete_modal_of_show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                    <button type="button" class="btn btn-one" id="delete_btn_of_show">{{ trns('delete') }} !</button>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL CLOSED -->

    <!-- Can't Delete Modal -->
    <div class="modal fade" id="cantDeleteModal" tabindex="-1" aria-labelledby="cantDeleteModalLabel" aria-hidden="true">
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
                    <div class="alert alert-warning mt-3" role="alert">
                        <p id="cantDeleteMessage" class="text-danger fw-bold fs-7">
                    </div>
                </div>
                <div class="modal-footer d-flex flex-nowrap">
                    <button type="button" class="btn w-100 btn-two" data-bs-dismiss="modal">
                        {{ trns('close') }}
                    </button>
                </div>
            </div>
        </div>

    </div>




    <div class="row">

        <div class="col-md-12 col-lg-12">
            <div class="">
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <img style="height: 70px; width: 70px; border-radius: 50%; margin-left: 10px;" alt="Avatar"
                            src="{{ getFile('storage/association/' . $obj->getMedia('logo')->first()?->model_id . '/logo/' . $obj->getMedia('logo')->first()?->file_name) }}">
                        {{ $obj->name }}
                        </h2>
                    </div>


                    <div class="d-flex align-items-center justify-content-end">

                        <a href="https://www.google.com/maps?q={{ @$obj->lat }},{{ @$obj->long }}" target="_blank"
                            class="btn" style="border: 1px solid #E1E1E1; background-color: #FCFCFC; color:  #00193A; ">
                            <img style="height: 20px" src="{{ asset('assets/map_line.png') }}">
                            {{ trns('go location') }}</a>

                        <!-- Options Dropdown -->
                        <div class="dropdown mr-2 ml-2">
                            <button class="btn dropdown-toggle d-flex align-items-center"
                                style="background-color: #00193a; color: #00F3CA;" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown">
                                {{ trns('options') }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                                style="background-color: #EAEAEA;">
                                <!-- Changed dropdown-menu-right to dropdown-menu-end for Bootstrap 5 -->
                                <a class="dropdown-item editRealStateBtn" href="javascript:void(0);"
                                    data-id="{{ $obj->id }}">
                                    <img src="{{ asset('edit.png') }}" alt="no-icon" class="img-fluid ms-1"
                                        style="width: 24px; height: 24px;"> {{ trns('Edit') }}
                                </a>
                                <a class="dropdown-item d-flex align-items-center toggleStatusBtn" href="#"
                                    data-id="{{ $obj->id }}" data-status="{{ $obj->status }}">
                                    <i class="fas fa-power-off ms-2"></i>
                                    <!-- Changed mr-2 to me-2 (Bootstrap 5 RTL-friendly margin) -->
                                    {{ $obj->status == 1 ? trns('Deactivate_real_state') : trns('activate') }}
                                </a>
                                @if (!checkIfModelHasRecords(\App\Models\Unit::class, 'real_state_id', $obj->id))
                                    <a class="dropdown-item" style="color: red; cursor: pointer; margin-right: 5px;"
                                        data-bs-toggle="modal" data-bs-target="#delete_modal_of_show"
                                        data-id="{{ $obj->id }}" data-title="{{ $obj->name }}">
                                        <i class="fas fa-trash" style="margin-left: 5px;"></i>
                                        {{ trns(key: 'delete') }}
                                    </a>
                                @else
                                    <a class="dropdown-item show-cant-delete-modal"
                                        style="color: red; cursor: pointer; margin-right: 5px;" data-bs-toggle="modal"
                                        data-bs-target="#cantDeleteModal"
                                        data-title="{{ trns('You_cant_delete_this_association_please_delete_all_real_states_first') }}">
                                        <i class="fas fa-trash" style="margin-left: 5px;"></i>
                                        {{ trns(key: 'delete') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        <button
                            class="btn {{ lang() == 'ar' ? 'ms-2' : 'me-2' }} btn-icon text-white addExcelOfElectricOrWaterFile importBtn">
                            <span>
                                <img style="height: 24px;" src="{{ asset('assets/import.png') }}" alt="">
                            </span> {{ trns('import_electricity_or_water') }}
                        </button>

                        <button class="btn btn-icon text-white addBtnInShow" id="addUnit"
                            style="background-color: #00F3CA !important; color: #00193a !important;"
                            data-bs-toggle="modal" data-bs-target="#editOrCreate">
                            <span><i class="fe fe-plus"></i></span> {{ trns('add_internal_unit') }}
                        </button>


                        <!-- Back Button -->
                        <a href="{{ route('real_states.index') }}"
                            style="background-color: white; border: 1px solid #00193a; color: #00193a; padding: 11px; transform: rotate(180deg);"
                            class="btn {{ lang() == 'ar' ? 'me-2' : 'ms-2' }}" style="min-width: 150px;">
                            <i class="fas fa-long-arrow-alt-right"></i>

                        </a>
                    </div>
                </div>
            </div>
            <div style=" padding-bottom: 60px">
                <!-- Navbar with tabs -->
                <ul class="nav nav-tabs" style="margin: 0 3px;" id="realEstateTabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-tab="tab1" href="#">{{ trns('main information') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-tab="realStateUnits" href="#realStateUnits">{{ trns('property') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-tab="tab3" href="#">{{ trns('association_information') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-tab="tab5" href="#">{{ trns('image_gallery') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-tab="tab4" href="#">{{ trns('documents') }}</a>
                    </li>


                </ul>


                <!-- Tab content -->
                <div class="tab-content mt-4">
                    <div id="tab1" class="active">
                        <!-- Right side - Actions -->

                        <div
                            style="border-radius: 6px;
                            background-color: #fbf9f9;
                            border: 1px solid #ddd;
                            padding: 15px;">

                            <div class="">

                                <div class="px-0 mb-5">
                                    <div class="mb-4">
                                        <!-- Left side - Title -->
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0 text-primary" style="font-weight: bold; color: #00193a;">
                                                {{ trns('real_state_main_information') }}</h4>
                                        </div>


                                    </div>
                                </div>


                            </div>
                            <hr style="background-color: black;">
                            <div class="">
                                <div class="row">
                                    <div class="col-12 row">


                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('association name') }} </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {!! $obj->association->name
                                                    ? copyable_text($obj->association->name) . ' ' . $obj->association->name
                                                    : trns('N/A') !!}</p>
                                        </div>

                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('real_state_name') }} </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {!! $obj->name ? copyable_text($obj->name) . ' ' . $obj->name : trns('N/A') !!}</p>
                                        </div>

                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('real_state_number') }} </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {!! $obj->real_state_number
                                                    ? copyable_text($obj->real_state_number) . ' ' . $obj->real_state_number
                                                    : trns('N/A') !!}</p>

                                        </div>

                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('legal_ownership') }} </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->legal_ownership_other == null ? ($obj->legalOwnership ? $obj->legalOwnership->title : 'N/A') : $obj->legal_ownership_other }}
                                            </p>
                                        </div>


                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('street') }} </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ @$obj->realStateDetails?->street }}</p>
                                        </div>
                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('space') }} </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ @$obj->realStateDetails?->space }}</p>
                                        </div>

                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('flat space') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ @$obj->realStateDetails?->flat_space }}</p>
                                        </div>
                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('part number') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ @$obj->realStateDetails?->part_number }}</p>
                                        </div>
                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('bank account number') }} </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {!! $obj->realStateDetails?->bank_account_number
                                                    ? copyable_text($obj->realStateDetails?->bank_account_number) . ' ' . $obj->realStateDetails?->bank_account_number
                                                    : trns('N/A') !!}</p>
                                        </div>
                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('mint number') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {!! $obj->realStateDetails?->mint_number
                                                    ? copyable_text($obj->realStateDetails?->mint_number) . ' ' . $obj->realStateDetails?->mint_number
                                                    : trns('N/A') !!}</p>
                                        </div>

                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('mint source') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ @$obj->realStateDetails?->mint_source }}</p>
                                        </div>
                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('floor count') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ @$obj->realStateDetails?->floor_count }}</p>
                                        </div>
                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('elevator count') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ @$obj->realStateDetails?->elevator_count }}</p>
                                        </div>
                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('building_type') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ @$obj->realStateDetails?->building_type }}</p>
                                        </div>
                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('building year') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ @$obj->realStateDetails?->building_year }}</p>
                                        </div>




                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('northern border') }} </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ @$obj->realStateDetails?->northern_border }}</p>
                                        </div>



                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('southern border') }} </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ @$obj->realStateDetails?->southern_border }}</p>
                                        </div>
                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('eastern border') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ @$obj->realStateDetails?->eastern_border }}</p>
                                        </div>
                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('western border') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ @$obj->realStateDetails?->western_border }}</p>

                                        </div>


                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('status') }} </h4>
                                            <p>
                                                @if (@$obj->status == 1)
                                                    <span
                                                        style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px"
                                                        class="">{{ trns('active') }}</span>
                                                @else
                                                    <span style="border-radius: 10%"
                                                        class="">{{ trns('inactive') }}</span>
                                                @endif
                                            </p>
                                        </div>

                                        @if (@$obj->status == 0)
                                            <div class="col-3 mb-4">
                                                <h4 class="text-muted" style="font-size: 12px;">
                                                    {{ trns('stop reason') }} </h4>
                                                <p class="font-weight-bold" style="font-size: 12px;">
                                                    {{ @$obj->stop_reason }}</p>
                                            </div>
                                        @endif



                                    </div>
                                </div>
                            </div>


                        </div>




                        <div
                            style="border-radius: 6px;
                            background-color: #fbf9f9;
                            border: 1px solid #ddd;
                            padding: 15px; margin-top: 20px;">

                            <div class="">

                                <div class="px-0 mb-3 d-flex justify-content-between align-items-center">
                                    <div class="mb-4">
                                        <!-- Left side - Title -->
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0 text-primary" style="font-weight: bold; color: #00193a;">
                                                {{ trns('real_state_electrics') }}</h4>
                                        </div>
                                    </div>

                                    <div>
                                        <button class="btn btn-icon text-white addElectricOrWaterBtn" data-type="electric"
                                            data-route="{{ route('real_state.create_electrics.create', $obj->id) }}"
                                            style="border: none;">
                                            {{ trns('add_new_electric') }}
                                        </button>

                                        <button class="btn btn-icon text-white" id="bulk-delete-electric"
                                            data-type="electrics" disabled>
                                            <span><i class="fe fe-trash text-white"></i></span>
                                            {{ trns('delete selected') }}
                                        </button>

                                    </div>


                                </div>


                            </div>
                            <hr style="background-color: black;">

                            <div class="card-body">

                                <table class="table table-bordered table-hover text-nowrap w-100 electricsTable"
                                    style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;"
                                    id="electricsTable">
                                    <thead>
                                        <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">
                                            <th class="min-w-25px rounded-end">
                                                <input type="checkbox" id="select-all-electric">
                                            </th>
                                            <th class="min-w-100px">{{ trns('meter_name') }}</th>
                                            <th class="min-w-100px">{{ trns('electric_account_number') }}</th>
                                            <th class="min-w-150px">{{ trns('electric_meter_number') }}</th>
                                            <th class="min-w-150px">{{ trns('electric_subscription_number') }}</th>
                                            <th class="min-w-150px">{{ trns('created at') }}</th>
                                            <th class="min-w-50px rounded-start">{{ trns('actions') }}</th>
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

                                <div class="px-0 mb-3 d-flex justify-content-between align-items-center">
                                    <div class="mb-4">
                                        <!-- Left side - Title -->
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0 text-primary" style="font-weight: bold; color: #00193a;">
                                                {{ trns('real_state_water') }}</h4>
                                        </div>

                                    </div>
                                    <div>
                                        <button class="btn btn-icon text-white addElectricOrWaterBtn" data-type="water"
                                            data-route="{{ route('real_state.create_waters.create', $obj->id) }}"
                                            style="border: none;">
                                            {{ trns('add_new_water') }}
                                        </button>

                                        <button class="btn btn-icon text-white" id="bulk-delete-water" data-type="waters"
                                            disabled>
                                            <span><i class="fe fe-trash text-white"></i></span>
                                            {{ trns('delete selected') }}
                                        </button>
                                    </div>
                                </div>


                            </div>
                            <hr style="background-color: black;">

                            <div class="card-body">

                                <table class="table table-bordered table-hover text-nowrap w-100 waterTable"
                                    style="border: 1px solid #e3e3e3; border-radius: 10px;" id="waterTable">
                                    <thead>
                                        <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">
                                            <th class="min-w-25px rounded-end">
                                                <input type="checkbox" id="select-all-water">
                                            </th>
                                            <th class="min-w-100px">{{ trns('meter_name') }}</th>
                                            <th class="min-w-100px">{{ trns('water_account_number') }}</th>
                                            <th class="min-w-150px">{{ trns('water_meter_number') }}</th>
                                            <th class="min-w-150px">{{ trns('created at') }}</th>
                                            <th class="min-w-150px">{{ trns('actions') }}</th>
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

                                <div class="px-0 mb-5">
                                    <div class="mb-4">
                                        <!-- Left side - Title -->
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0 text-primary" style="font-weight: bold; color: #00193a;">
                                                {{ trns('units_owners') }}</h4>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <hr style="background-color: black;">

                            <div class="card-body">

                                <table class="table table-bordered table-hover text-nowrap w-100 usersTable"
                                    style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;"
                                    id="">
                                    <thead>
                                        <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">
                                            <th class="min-w-100px">{{ trns('national_id') }}</th>
                                            <th class="min-w-150px">{{ trns('name') }}</th>
                                            <th class="min-w-150px">{{ trns('email') }}</th>
                                            <th class="min-w-100px">{{ trns('phone') }}</th>
                                            <th class="min-w-100px">{{ trns('status') }}</th>
                                            <th class="min-w-150px">{{ trns('actions') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="realStateUnits">
                        <div class="table-responsive" style="overflow: inherit;">
                            <!--begin::Table-->
                            <table class="table table-bordered text-nowrap w-100 unitsTable" id="UnitdataTable"
                                style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;">
                                <thead>
                                    <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">
                                        <th class="min-w-25px rounded-end">
                                            <input type="checkbox" id="select-all">
                                        </th>
                                        <th class="min-w-25px">{{ trns('unit_code') }}</th>
                                        <th class="min-w-25px">{{ trns('user_name') }}</th>
                                        <th class="min-w-25px">{{ trns('real_state_number') }}</th>
                                        <th class="min-w-25px">{{ trns('unit_number') }}</th>
                                        <th class="min-w-25px">{{ trns('floor_number') }}</th>
                                        <th class="min-w-25px">{{ trns('association_name') }}</th>
                                        <th class="min-w-25px">{{ trns('space') }}</th>
                                        <th class="min-w-50px rounded-start">{{ trns('actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="tab3" style="padding-right: 12px;">
                        <!-- <div class="p-5"> -->
                        <div class="row">
                            <div class="row">
                                <!-- Basic Information -->
                                <div class="col-12"
                                    style="border-radius: 6px;background-color: #fbf9f9;border: 1px solid #ddd;padding: 15px;">
                                    <div class="w-100">
                                        <div class="container-fluid px-0 mb-5">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <div class="flex-grow-1">
                                                    <h4 class="mb-0 text-primary text-end"
                                                        style="font-weight: bold; color: #00193a;">
                                                        {{ trns('basic information') }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr style="background-color: black;">
                                    <div class="row">
                                        <div class="col-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('Association Name') }}</h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ @$obj->association->name ?? trns('N/A') }}</p>
                                        </div>
                                        <div class="col-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('Association Number') }}</h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {!! $obj->association->number
                                                    ? copyable_text($obj->association->number) . ' ' . $obj->association->number
                                                    : trns('N/A') !!}
                                            </p>
                                        </div>
                                        <div class="col-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('Real State Count') }}</h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ @$obj->association->RealStates->count() ?? trns('N/A') }}</p>
                                        </div>


                                        <div class="col-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">{{ trns('Unit Count') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->association->RealStates->sum('units_count') ?? trns('N/A') }}
                                            </p>

                                        </div>

                                        <div class="col-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('real_state_establish_date') }}</h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ @$obj->association->establish_date ? @$obj->association->establish_date : trns('N/A') }}
                                            </p>
                                        </div>
                                        <div class="col-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('status') }}
                                            </h4>
                                            <p>
                                                @if (@$obj->status == 1)
                                                    <span
                                                        style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px"
                                                        class="badge px-3 py-2">{{ trns('active') }}</span>
                                                @else
                                                    <span style="border-radius: 10%"
                                                        class="badge px-3 py-2">{{ trns('inactive') }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-4"
                                    style="border-radius: 6px;
    background-color: #fbf9f9;
    border: 1px solid #ddd;
    padding: 15px;">
                                    <h4 style="font-weight: bold; color: #00193a; text-align: right;">
                                        {{ trns('real_state_association_management') }}</h4>
                                    <hr style="background-color: black;">


                                    <div class="row">
                                        <div class="col-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('national_id') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ @$obj->association->AssociationManager->national_id ?? trns('N/A') }}
                                            </p>
                                        </div>

                                        <!-- Numbers -->
                                        <div class="col-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">{{ trns('name') }}</h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ @$obj->association->AssociationManager->name ?? trns('N/A') }}</p>
                                        </div>
                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">{{ trns('email') }}</h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ @$obj->association->AssociationManager->email ?? trns('N/A') }}</p>
                                        </div>
                                        <div class="col-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('status') }}
                                            </h4>
                                            <p>
                                                @if (@$obj->status == 1)
                                                    <span
                                                        style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px"
                                                        class="badge px-3 py-2">{{ trns('active') }}</span>
                                                @else
                                                    <span style="border-radius: 10%"
                                                        class="badge px-3 py-2">{{ trns('inactive') }}</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">{{ trns('phone') }}</h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ @$obj->association->AssociationManager->phone ?? trns('N/A') }}</p>
                                        </div>

                                    </div>


                                </div>
                                <div
                                    class="col-12 mt-4"style="border-radius: 6px;background-color: #fbf9f9;border: 1px solid #ddd;padding: 15px;">
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
                                                    @if ($obj->association->AssociationModel && $obj->association->AssociationModel->title)
                                                        <div class="card-body">
                                                            <div class="form-check form-check-inline float-end">
                                                                <label class="form-check-label" for="template1"></label>
                                                            </div>
                                                            <h5 class="association-card-header"
                                                                style="color: #00193a; font-weight: bold;">
                                                                {{ @$obj->association->AssociationModel->title }}
                                                            </h5>
                                                            <p class="association-card-para">
                                                                {{ @$obj->association->AssociationModel->description }}
                                                            </p>

                                                        </div>
                                                    @else
                                                        <h5 class="association-card-header"
                                                            style="color: #00193a; font-weight: bold;">
                                                            {{ trns('there_is_no_specific_type_of_amenities_for_this_association') }}
                                                        </h5>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12  mt-4"
                                style="border-radius: 6px;
                                    background-color: #fbf9f9;
                                    border: 1px solid #ddd;
                                    padding: 15px;">
                                <div class="form-group">
                                    <h4 style="font-weight: bold; color: #00193a;" for="lat"
                                        class="form-control-label" style="display:block">
                                        {{ trns('association_location_on_the_map') }}
                                    </h4>
                                    <hr style="background-color: black;">
                                    {{-- <label for="lat"
                                                class="form-control-label">{{ trns('Select from the map and the width and length will be determined automatically') }}</label> --}}
                                </div>

                                {{-- الخريطة --}}
                                <div id="map" style="height: 400px;"></div>
                            </div>
                            <!-- Continue for all remaining fields -->
                        </div>
                        <!-- </div> -->


                    </div>
                    <div id="tab4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3>الملفات</h3>
                            @can('create_real_state')
                                <button class="btn btn-icon text-white addMediaBtn" data-id="{{ $obj->id }}"
                                    data-model="RealState" data-type="file">
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
                                    @foreach ($obj->media()->where('collection_name', 'files')->get() as $media)
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
                                                                <i class="fa-solid fa-eye me-1"></i> {{ trns('view') }}
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
                                                            <a class="dropdown-item delete_img" download
                                                                href="javascript:void(0);" data-id="{{ $media->id }}"
                                                                data-title="{{ $media->file_name }}">
                                                                <i class="fas fa-trash ms-1"></i>{{ trns('Delete') }}
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="imageModal" class="modal">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <img style="width:80%; height:80%; margin:5% auto; display:block; border:0" class="modal-content"
                            id="modalImage">
                    </div>

                    <div id="tab5">
                        <div class="show-image">
                            <div class="d-flex justify-content-between align-items-center">
                                @can('create_real_state')
                                    <button class="btn btn-icon text-white  addMediaBtn" data-id="{{ $obj->id }}"
                                        data-model="RealState" data-type="image">
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
                                            style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom:0 !important;"
                                            id="imagesDatatable">
                                            <thead>
                                                <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">
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
                                                        style="z-index: 99999; background-color: #EAEAEA; text-align: right;"
                                                        aria-labelledby="dropdownMenuButton1">

                                                        <li class="m-2">
                                                            <span class="download-img" style="cursor: pointer;"
                                                                data-fileName=" {{ $media->file_name }} "
                                                                data-url="{{ asset('storage/realstate/' . $media->model_id . '/images/' . $media->file_name) }}">
                                                                <i class="fas fa-download"></i> {{ trns('download') }}
                                                            </span>

                                                        </li>

                                                        <li class="m-2">
                                                            <span class="delete_img" style="cursor: pointer;"
                                                                data-id=" {{ $media->id }}">
                                                                <i class="fas fa-trash"></i> {{ trns('Delete') }}
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <img onclick="openModal('{{ asset('storage/realstate/' . $obj->id . '/images/' . $media->file_name) }}')"
                                                    style="width:100%; height:100%; border-radius: 10px"
                                                    src="{{ asset('storage/realstate/' . $obj->id . '/images/' . $media->file_name) }}">

                                            </div>
                                        @endforeach

                                    </div>





                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <!--Delete unit owner MODAL -->
        <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
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
                        <p>{{ trns('are_you_sure_you_want_to_delete_this_obj') }} <span id="title"
                                class="text-danger"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal"
                            id="dismiss_delete_modal">
                            {{ trns('close') }}
                        </button>
                        <button type="button" class="btn btn-danger" id="delete_btn">{{ trns('delete') }} !</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete unit owner MODAL -->


        {{-- the images modal --}}

        <div id="imageModal"
            style="display:none; position:fixed; z-index:9999;
                                left:0; top:0; width:100vw;  background:rgba(0,0,0,0.8);">
            <span class="close" onclick="closeModal()">&times;</span>
            <img style="width:80%; height:80%; margin:5% auto; display:block; border:0" class="modal-content"
                id="modalImage">
        </div>


        <!--show owners MODAL -->
        <div class="modal fade" id="show_owners" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ trns('owners') }}</h5>

                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ trns('unit_owner_name') }}</th>
                                        <th>{{ trns('unit_ownership_percentage') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="show_owners_body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer d-flex flex-nowrap">
                        <button type="button" class="btn btn-default"
                            style="background-color: #00193a; color: white; border: none;padding: 5px 50px; margin-left: 10px;"
                            data-bs-dismiss="modal">
                            {{ trns('close') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

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

    <!-- delete selected  Modal -->

    <!-- addExcelOfElectricOrWaterFile Modal -->
    <div class="modal fade" id="addExcelOfElectricOrWaterFile" tabindex="-1"
        aria-labelledby="addExcelOfElectricOrWaterFile" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExcelOfElectricOrWaterFileLabel">استيراد ملف Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-excel-body-electric-or-water">
                </div>
            </div>
        </div>
    </div>
    <!-- addExcelOfElectricOrWaterFile Modal -->

    </div>


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
    <script>
        initCantDeleteModalHandler();
        deleteScriptInShow("{{ route('real_states.destroy', ':id') }}");
    </script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-sA+oYy5rjphsyV6qLdX5lFh3ugMQAxTVvD+FA2z6+3Y=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-oRkS4hJ2kMRSR2J7DHOY7FTh5E3uX9U4I9znKzJxM7E=" crossorigin=""></script>

    <script>
        showAddModal('{{ route('units.create', $obj->id) }}');
        addscript();
    </script>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Input fields to update -->
    <input type="hidden" id="lat" value="24.7136">
    <input type="hidden" id="long" value="46.6753">



    {{-- the images js code  --}}
    <script>
        $(document).ready(function() {
            const realstate_id = '{{ $obj->id }}';

            $('#imagesDatatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{ route('realState.images.show', ['id' => '__id__']) }}`.replace(
                    '__id__', realstate_id),
                columns: [

                    {
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
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json",
                },
            });
        });



        function openModal(imagePath) {
            var modal = document.getElementById("imageModal");
            var modalImg = document.getElementById("modalImage");

            modal.style.display = "block";
            modalImg.src = imagePath;
            console.log('imagePath', imagePath)
        }

        function closeModal() {
            var modal = document.getElementById("imageModal");
            modal.style.display = "none";
        }



        $(function() {

            'use strict';
            $('.tabs-list li').on('click', function() {

                $(this).addClass('show').siblings().removeClass('show');

                $('.content-list > div').hide();

                $($(this).data('content')).fadeIn();
            });

        });


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


        $(document).on('click', '.delete_img', function(e) {
            e.preventDefault();

            let id = $(this).data('id');

            $.ajax({
                type: 'POST',
                url: '{{ route('realStateImage.delete') }}',
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
                    } else {
                        // toastr.error("{{ trns('something_went_wrong') }}");
                    }
                },
                error: function() {
                    // toastr.error("{{ trns('something_went_wrong') }}");
                }
            });
        });

        $(document).on('click', '.delete_img', function(e) {
            e.preventDefault();

            let id = $(this).data('id');

            $.ajax({
                type: 'POST',
                url: '{{ route('realStateImage.delete') }}',
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
                    } else {
                        // toastr.error("{{ trns('something_went_wrong') }}");
                    }
                },
                error: function() {
                    // toastr.error("{{ trns('something_went_wrong') }}");
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '.editBtn', function() {
            var userId = $(this).data('id');

            // Load content into modal (example with AJAX)
            $.get('/admin/units/' + userId + '/edit', function(data) {
                $('#modal-body').html(data);
                $('#editOrCreate').modal('show');
                // footer buttons
                $('#modal-footer').html(`
                <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two"
                            data-bs-dismiss="modal">{{ trns('close') }}</button>
                    <button type="submit" class="btn btn-one me-2"
                            id="updateButton">{{ trns('update') }}</button>
                </div>
            `);
            }).fail(function() {
                alert('Error loading user data');
            });
        });
        editScript();

        $(document).on('click', '.toggleRealStateUserStatusBtn', function(e) {
            e.preventDefault();

            let id = $(this).data('id');
            let currentStatus = parseInt($(this).data('status'));
            let newStatus = currentStatus === 1 ? 0 : 1;

            $.ajax({
                type: 'POST',
                url: "{{ route('users.updateColumnSelected') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    ids: [id],
                    status: newStatus
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
                            timer: 2000,
                            customClass: {
                                image: 'swal2-image-mt30'
                            }
                        });
                        $('.usersTable').DataTable().ajax.reload(null, false);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('something_went_wrong') }}'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ trns('something_went_wrong') }}'
                    });
                }
            });

        });


        // Clear modal when closed
        $('#editOrCreate').on('hidden.bs.modal', function() {
            $(this).find('.modal-body').html('');
        });

        document.addEventListener('DOMContentLoaded', function() {
            const editModal = new bootstrap.Modal(document.getElementById('editOrCreate'));

            document.querySelectorAll('.editRealStateBtn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const editUrl = '{{ route('real_states.edit', ':id') }}'.replace(':id', id);

                    document.getElementById('example-Modal3').textContent =
                        '{{ trns('edit_real_state_details') }}';

                    fetch(editUrl)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('modal-body').innerHTML = html;
                            editModal.show();
                            // footer buttons
                            $('#modal-footer').html(`
                <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two"
                            data-bs-dismiss="modal">{{ trns('close') }}</button>
                    <button type="submit" class="btn btn-one me-2"
                            id="updateButton">{{ trns('update') }}</button>
                </div>
            `);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error loading form');
                        });
                });
            });

            window.showCreateModal = function(url) {
                document.getElementById('modalTitle').textContent = '{{ trns('Add New Users') }}';
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('modal-body').innerHTML = html;
                        editModal.show();
                    });
            };
        });

        $('#editOrCreate').on('hidden.bs.modal', function() {
            $(this).find('.modal-body').html(''); // Clear modal content
        });

        // for status
        $(document).on('click', '.statusBtn', function() {
            let ids = [];
            $('.statusBtn').each(function() {
                ids.push($(this).data('id'));
            });


            var val = $(this).is(':checked') ? 1 : 0;


            $.ajax({
                type: 'POST',
                url: '{{ route($route . '.updateColumnSelected') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'ids': ids,
                },
                success: function(data) {
                    if (data.status === 200) {
                        if (val !== 0) {
                            Swal.fire({
                                title: '<span style="margin-bottom: 50px; display: block;">{{ trns('active') }}</span>',
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
                            $('#updateConfirmModal').modal('hide');
                            $('#bulk-delete').prop('disabled', false);
                            $('#bulk-update').prop('disabled', false);
                            $('#select-all').prop('checked', false);
                            $('#dataTable').DataTable().ajax.reload(null, false);
                        } else {
                            $('#select-all').prop('checked', false);
                            Swal.fire({
                                title: '<span style="margin-bottom: 50px; display: block;">{{ trns('inactive') }}</span>',
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
                    } else {
                        $('#select-all').prop('checked', false);
                        // toastr.error('Error', "{{ trns('something_went_wrong') }}");
                    }
                },
                error: function() {
                    // toastr.error('Error', "{{ trns('something_went_wrong') }}");
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            var mapDiv = document.getElementById('map');
            if (!mapDiv) return;

            const initialLat = parseFloat("{{ $obj->lat ?? 24.7136 }}");
            const initialLng = parseFloat("{{ $obj->long ?? 46.6753 }}");

            const map = L.map('map', {
                center: [initialLat, initialLng],
                zoom: 13
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/">Eldapour</a> contributors'
            }).addTo(map);

            // إعادة تحديد الحجم عند تحميل الصفحة
            map.whenReady(function() {
                setTimeout(function() {
                    map.invalidateSize();
                }, 100);
            });

            // مراقبة تغيير حجم النافذة
            window.addEventListener('resize', function() {
                map.invalidateSize();
            });

            // إعادة تحديد الحجم كل 5 ثوان (حسب طلبك السابق)
            setInterval(function() {
                map.invalidateSize();
            }, 5000);

            // Create a marker and keep reference
            var marker = L.marker([initialLat, initialLng], {
                    riseOnHover: true
                }).addTo(map)
                .bindPopup('{{ trns('real_state_location') }}')
                .openPopup();



            var crosshairMarker = L.marker(map.getCenter(), {
                icon: crosshairIcon,
                interactive: false,
                keyboard: false
            }).addTo(map);

            // Keep crosshair in center on move
            map.on('move', function() {
                crosshairMarker.setLatLng(map.getCenter());
            });
        });




        $(document).ready(function() {
            var usersColumns = [{
                    data: 'national_id',
                    name: 'national_id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    render: function(data, type, row) {
                        return `
                                        <button
                            class="copy-btn"
                            title="Copy"
                            data-copy="${data}"
                            style="cursor:pointer;border:none;background-color:transparent;">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                        <span>${data}</span>
                                    `;
                    },
                    data: 'email',
                    name: 'email',

                },
                {
                    data: 'phone',
                    name: 'phone',
                    orderable: false
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
            var usersTable = $('.usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('units.unitOwners', ['request' => request(), 'id' => @$obj->id]) }}',
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
        });

        $(document).ready(function() {
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


        var unitColumns = [{
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `<input type="checkbox" class="delete-checkbox" value="${row.id}">`;
                }
            },
            {
                data: 'unit_code',
                name: 'unit_code',
                orderable: false,
                render: function(data, type, row) {
                    var showUrl = '{{ route('units.show', 0) }}'.replace('/0', '/' + row.id);
                    return `<a href="${showUrl}">${data}</a>`;
                }

            },
            {
                data: 'owner_name',
                name: 'owner_name',
                orderable: false,

            },
            {
                data: 'real_state_number',
                name: 'real_state_number'
            },
            {
                data: 'unit_number',
                name: 'unit_number'
            },

            {
                data: 'floor_count',
                name: 'floor_count'
            },
            {
                data: 'association_name',
                name: 'association_name',
                orderable: false,

            },
            {
                data: 'space',
                name: 'space'
            },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ];

        $('.unitsTable').DataTable({

            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('real-estate.property', $obj->id) }}',
                type: 'GET'
            },
            columns: unitColumns,
            order: [
                [1, 'asc']
            ],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
            },
            createdRow: function(row, data, dataIndex) {
                $(row).attr('data-id', data.id);
                console.log('success')
            },
            error: function(xhr, error, thrown) {
                console.error('DataTables error:', error, thrown);
                console.log('error')
            }

        });

        $(document).on('click', '.show-owners-btn', function() {
            // Get the JSON string and parse it
            const ownersJson = $(this).attr('data-owners');

            try {
                const ownersData = JSON.parse(ownersJson);
                const modalBody = $('#show_owners_body');

                console.log(ownersJson);

                // Clear previous content
                modalBody.empty();

                if (ownersData && ownersData.length > 0) {
                    ownersData.forEach(owner => {
                        modalBody.append(`
                    <tr>
                        <td>${owner.name}</td>
                        <td>${owner.percentage}%</td>
                    </tr>
                `);
                    });
                } else {
                    modalBody.html(
                        '<tr><td colspan="2" class="text-center text-muted">لم يتم العثور علي أي مالك</td></tr>'
                    );
                }
            } catch (e) {
                console.error('Error parsing owners data:', e);
                $('#show_owners_body').html(
                    '<tr><td colspan="2" class="text-center text-danger">Error loading data</td></tr>');
            }
        });


        $('#select-all').on('click', function() {
            var isChecked = $(this).prop('checked');
            $('.unitsTable .delete-checkbox').prop('checked', isChecked);
        });

        // Handle individual checkbox clicks
        $(document).on('click', '.delete-checkbox', function() {
            var allChecked = $('.unitsTable .delete-checkbox:checked').length === $('.unitsTable .delete-checkbox')
                .length;
            $('#select-all').prop('checked', allChecked);
        });

        document.addEventListener("DOMContentLoaded", function() {
            const tabs = document.querySelectorAll('[data-tab]');
            const contents = document.querySelectorAll('.tab-content > div');

            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    const target = this.getAttribute('data-tab');
                    contents.forEach(c => c.classList.remove('active'));
                    document.getElementById(target).classList.add('active');
                });
            });
        });



        $(document).on('click', '.toggleStatusBtn', function(e) {
            e.preventDefault();
            console.log('Toggle Status Button Clicked');

            let id = $(this).data('id');
            let currentStatus = parseInt($(this).data('status'));
            $.ajax({
                type: 'POST',
                url: '{{ route('real_states.toggle_status', $obj->id) }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'status': currentStatus === 1 ? 0 : 1
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
                            timer: 2000,
                            customClass: {
                                image: 'swal2-image-mt30'
                            }
                        });
                        location.reload();
                    } else {}
                },
                error: function() {}
            });

        });

        deleteScript("{{ route('units' . '.destroy', ':id') }}");

        $(document).ready(function() {
            // Handle tab switching from URL hash
            var hash = window.location.hash;
            if (hash) {
                setTimeout(function() {
                    // More specific selector for Bootstrap tabs
                    var tabLink = $('a[href="' + hash + '"]');

                    if (tabLink.length) {

                        var tabContent = $(hash);
                        console.log('Tab Content:', tabContent);

                        if (tabContent.length) {
                            tabLink.tab('show');
                            setTimeout(function() {
                                tabLink.tab('show');
                            }, 50);

                            $('.tab-content').children('div').removeClass('active');
                            tabContent.addClass('active');

                            console.log('Tab should be active now');
                        } else {
                            console.error('Tab content not found for:', hash);
                        }
                    } else {
                        console.log('Tab link not found for hash:', hash);
                    }
                }, 200);
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
                }, {
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
                    url: '{{ route('real_states.get_waters', ['request' => request(), 'id' => @$obj->id]) }}',
                    type: 'GET'
                },
                columns: waterColumns,
                order: [
                    [3, 'desc']
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
                    url: '{{ route('real_states.get_electrics', ['request' => request(), 'id' => @$obj->id]) }}',
                    type: 'GET'
                },
                columns: ElectiricColumns,
                order: [
                    [4, 'desc']
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
        document.addEventListener('DOMContentLoaded', function() {
            const unitBtn = document.getElementById('addUnit');



            if (unitBtn) {
                unitBtn.addEventListener('click', function() {
                    showAddModalInShow('{{ route('units.createInShow') }}', {
                        association_id: {{ $obj->association_id }},
                        real_state_id: {{ $obj->id }}

                    });
                });
            }
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
        $(document).on('click', '.addExcelOfElectricOrWaterFile', function() {
            let routeOfShow = '{{ route('real_state.add.electric_or_water.excel') }}';
            $('#modal-excel-body-electric-or-water').html(loader);
            $('#addExcelOfElectricOrWaterFile').modal('show');

            setTimeout(function() {
                $('#modal-excel-body-electric-or-water').load(routeOfShow, function() {
                    initExcelForm();
                });
            }, 250);
        });




        function initExcelForm() {
            $('#excel-import-form-electric-or-water').on('submit', function(e) {
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
                        $('#addExcelOfElectricOrWaterFile').modal('hide');
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
