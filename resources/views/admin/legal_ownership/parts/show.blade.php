@extends('admin.layouts.master')

@section('title')
    {{ config()->get('app.name') }} | {{ trns($bladeName) }}
@endsection
@section('page_name')
    {{ trns($bladeName) }}
@endsection

@section('content')
    <!-- Create Or Edit Modal -->
    <div class="modal fade" id="editOrCreate" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="example-Modal3">{{ trns('object_details') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body">
                    <input id="delete_id" name="id" type="hidden">
                    <p>{{ trns('are_you_sure_you_want_to_delete_this_obj') }} <span id="title"
                            class="text-danger"></span>?</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Create Or Edit Modal -->

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

    <div class="row">

        <div class="col-md-12 col-lg-12">
            <div class="p-5">
                <div class="d-flex justify-content-between">

                    <h2 data-v-268c4d9a="" color="primary"><span data-v-268c4d9a="" class="user-prfile"><i
                                data-v-268c4d9a="" class="bx bx-building-house"></i></span> {{ @$obj->first()->name }}
                    </h2>
                    <div class="d-flex align-items-center justify-content-end">


                        <button class="btn btn-icon text-white addBtn" style="background-color: #00F3CA; color: #00193a;"
                            data-bs-toggle="modal" data-bs-target="#editOrCreate">
                            <span><i class="fe fe-plus"></i></span> {{ trns('add_new_unit') }}
                        </button>

                        <!-- Options Dropdown -->
                        <div class="dropdown mr-3">
                            <button class="btn dropdown-toggle d-flex align-items-center"
                                style="background-color: #00193a; color: white;" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ trns('options') }}

                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                {{--                        <a class="dropdown-item d-flex align-items-center" --}}
                                {{--                           href="{{ route('real_states.index') }}?edit_user={{ @$obj->id }}&show_modal=true"> --}}
                                {{--                            <i class="fas fa-edit mr-2"></i> --}}
                                {{--                            {{ trns("update") }} --}}
                                {{--                        </a> --}}
                                <a class="dropdown-item editRealStateBtn" href="javascript:void(0);"
                                    data-id="{{ $obj->id }}">
                                    <img src="'.asset('edit.png').'" alt="no-icon" class="img-fluid ms-1"
                                        style="width: 24px; height: 24px;"> {{ trns('Edit') }}
                                </a>
                                <a class="dropdown-item d-flex align-items-center toggleStatusBtn" href="#"
                                    data-id="{{ @$obj->id }}" data-status="{{ @$obj->status }}">
                                    <i class="fas fa-power-off mr-2"></i>
                                    {{ @$obj->status == 1 ? trns('Deactivate_real_state') : trns('activate') }}
                                </a>
                            </div>
                        </div>

                        <!-- Back Button -->
                        <a href="{{ route('real_states.index') }}"
                            style="background-color: white; border: 1px solid #00193a; color: #00193a; padding: 5px; transform: rotate(180deg); margin-right:10px;"
                            class="btn" style="min-width: 150px;">
                            <i class="fas fa-long-arrow-alt-right mr-2"></i>

                        </a>
                    </div>
                </div>
            </div>
            <div style="padding: 25px; padding-bottom: 60px">
                <!-- Navbar with tabs -->
                <ul class="nav nav-tabs" id="realEstateTabs">
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
                        <a class="nav-link" data-tab="tab4" href="#">{{ trns('documents') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-tab="tab5" href="#">{{ trns('image_gallery') }}</a>
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

                            <div class="container m-5">

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
                            <div class="row">
                                <div class="col-12 row text-center">


                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('association name') }} </h4>
                                        <p>{{ @$obj->association->name }} {!! copyable_text(@$obj->association->name) !!}</p>
                                    </div>

                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('real_state_name') }} </h4>
                                        <p>{{ @$obj->name }} {!! copyable_text(@$obj->name) !!}</p>
                                    </div>


                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('street') }} </h4>
                                        <p>{{ @$obj->realStateDetails?->street }}</p>
                                    </div>
                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('space') }} </h4>
                                        <p>{{ @$obj->realStateDetails?->space }}</p>
                                    </div>


                                    {{--                                    <div class="col-3 mb-4"> --}}
                                    {{--                                        <h4> {{ trns('area') }} </h4> --}}
                                    {{--                                        <p>{{ $obj->realStateDetails?->area }}</p> --}}
                                    {{--                                    </div> --}}
                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('flat space') }} </h4>
                                        <p>{{ @$obj->realStateDetails?->flat_space }}</p>
                                    </div>
                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('part number') }} </h4>
                                        <p>{{ @$obj->realStateDetails?->part_number }}</p>
                                    </div>
                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('bank account number') }} </h4>
                                        <p>{{ @$obj->realStateDetails?->bank_account_number }} {!! copyable_text(@$obj->realStateDetails?->bank_account_number) !!}</p>
                                    </div>
                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('mint number') }} </h4>
                                        <p>{{ @$obj->realStateDetails?->mint_number }} {!! copyable_text(@$obj->realStateDetails?->mint_number) !!}</p>
                                    </div>

                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('mint source') }} </h4>
                                        <p>{{ @$obj->realStateDetails?->mint_source }}</p>
                                    </div>
                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('floor count') }} </h4>
                                        <p>{{ @$obj->realStateDetails?->floor_count }}</p>
                                    </div>
                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('elevator count') }} </h4>
                                        <p>{{ @$obj->realStateDetails?->elevator_count }}</p>
                                    </div>
                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('building_type') }} </h4>
                                        <p>{{ @$obj->realStateDetails?->building_type }}</p>
                                    </div>
                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('building year') }} </h4>
                                        <p>{{ @$obj->realStateDetails?->building_year }}</p>
                                    </div>
                                    {{--                                    <div class="col-3 mb-4"> --}}
                                    {{--                                        <h4> {{ trns('building count') }} </h4> --}}
                                    {{--                                        <p>{{ $obj->realStateDetails?->building_count }}</p> --}}
                                    {{--                                    </div> --}}


                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('electric account number') }} </h4>
                                        <p>{{ @$obj->realStateDetails?->electric_account_number }} {!! copyable_text(@$obj->realStateDetails?->electric_account_number) !!}
                                        </p>
                                    </div>
                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('electric_subscription_number') }} </h4>
                                        <p>{{ @$obj->realStateDetails?->electric_subscription_number }}
                                            {!! copyable_text(@$obj->realStateDetails?->electric_account_number) !!}</p>
                                    </div>
                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('electric meter number') }} </h4>
                                        <p>{{ @$obj->realStateDetails?->electric_meter_number }} {!! copyable_text(@$obj->realStateDetails?->electric_meter_number) !!}
                                        </p>
                                    </div>
                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('water account number') }} </h4>
                                        <p>{{ @$obj->realStateDetails?->water_account_number }} {!! copyable_text(@$obj->realStateDetails?->water_account_number) !!}</p>
                                    </div>
                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('water meter number') }} </h4>
                                        <p>{{ @$obj->realStateDetails?->water_meter_number }} {!! copyable_text(@$obj->realStateDetails?->water_meter_number) !!}</p>
                                    </div>
                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('northern border') }} </h4>
                                        <p>{{ @$obj->realStateDetails?->northern_border }}</p>
                                    </div>
                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('southern border') }} </h4>
                                        <p>{{ @$obj->realStateDetails?->southern_border }}</p>
                                    </div>
                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('eastern border') }} </h4>
                                        <p>{{ @$obj->realStateDetails?->eastern_border }}</p>
                                    </div>
                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('western border') }} </h4>
                                        <p>{{ @$obj->realStateDetails?->western_border }}</p>

                                    </div>


                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('status') }} </h4>
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

                                    @if (@$obj->status == 0)
                                        <div class="col-3 mb-4">
                                            <h4> {{ trns('stop reason') }} </h4>
                                            <p>{{ @$obj->stop_reason }}</p>
                                        </div>
                                    @endif
                                    <div class="col-3 mb-4">
                                        <h4> {{ trns('location') }} </h4>
                                        <p><a href="https://www.google.com/maps?q={{ @$obj->lat }},{{ @$obj->long }}"
                                                target="_blank"
                                                class="btn btn-sm btn-primary">{{ trns('go location') }}</a></p>
                                    </div>


                                </div>
                            </div>


                        </div>

                        <div
                            style="border-radius: 6px;
                            background-color: #fbf9f9;
                            border: 1px solid #ddd;
                            padding: 15px; margin-top: 20px;">

                            <div class="container m-5">

                                <div class="px-0 mb-5">
                                    <div class="mb-4">
                                        <!-- Left side - Title -->
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0 text-primary" style="font-weight: bold; color: #00193a;">
                                                ملاك الوحدة</h4>
                                        </div>


                                    </div>
                                </div>


                            </div>
                            <hr style="background-color: black;">

                            <div class="card-body">

                                <table class="table table-bordered table-hover text-nowrap w-100 usersTable"
                                    style="border: 1px solid #e3e3e3; border-radius: 10px;" id="">
                                    <thead>
                                        <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">
                                            <th class="min-w-100px">{{ trns('national_id') }}</th>
                                            <th class="min-w-150px">{{ trns('name') }}</th>
                                            <th class="min-w-150px">{{ trns('email') }}</th>
                                            <th class="min-w-100px">{{ trns('phone') }}</th>
                                            {{--                                        <th class="min-w-100px">{{ trns(key: 'unit_ownership_percentage') }}</th> --}}
                                            <th class="min-w-100px">{{ trns('status') }}</th>
                                            <th class="min-w-150px">{{ trns('actions') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="realStateUnits">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table table-bordered text-nowrap w-100 unitsTable" id="UnitdataTable"
                                style="border: 1px solid #e3e3e3; border-radius: 10px;">
                                <thead>
                                    <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">
                                        <th class="min-w-25px rounded-end">
                                            <input type="checkbox" id="select-all">
                                        </th>
                                        <th class="min-w-25px">{{ trns('unit_code') }}</th>
                                        {{--                                    <th class="min-w-25px">{{ trns('owners_name') }}</th> --}}
                                        {{--                                    <th class="min-w-25px">{{ trns('RealStates_number') }}</th> --}}
                                        <th class="min-w-25px">{{ trns('unit_number') }}</th>
                                        <th class="min-w-25px">{{ trns('description') }}</th>
                                        <th class="min-w-25px">{{ trns('floor_count') }}</th>
                                        {{--                                    <th class="min-w-25px">{{ trns('association_name') }}</th> --}}
                                        <th class="min-w-50px rounded-start">{{ trns('actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="tab3">

                        <div class="p-5">
                            <!-- Right side - Actions -->
                            <div class="container m-5">
                                <div class="row">

                                </div>
                            </div>
                        </div>

                        <div id="tab3">

                            <div class="p-5">


                                <div class="row">
                                    <div class="row text-center">
                                        <!-- Basic Information -->
                                        <div class="col-12 mt-4"
                                            style="border-radius: 6px;
    background-color: #fbf9f9;
    border: 1px solid #ddd;
    padding: 15px;">

                                            <div class="m-5 w-100">
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
                                                    <h4>{{ trns('Association Name') }}</h4>
                                                    <p>{{ @$obj->association->name ?? trns('N/A') }}</p>
                                                </div>
                                                <div class="col-2 mb-4">
                                                    <h4>{{ trns('Association Number') }}</h4>
                                                    <p>{!! copyable_text(@$obj->association->number) !!}{{ @$obj->association->number ?? trns('N/A') }}
                                                    </p>
                                                </div>
                                                <div class="col-2 mb-4">
                                                    <h4>{{ trns('Real State Count') }}</h4>
                                                    <p>{{ @$obj->association->RealStates->count() ?? trns('N/A') }}</p>
                                                    {{--                                            <p>{{ $unitCount ?? trns('N/A') }}</p> --}}
                                                </div>


                                                <div class="col-2 mb-4">
                                                    <h4>{{ trns('Unit Count') }}</h4>
                                                    {{--                                            <p>{{ @$obj->association->RealStates->Units ?? trns('N/A') }}</p> --}}
                                                    <p>{{ $obj->association->RealStates->sum('units_count') ?? trns('N/A') }}
                                                    </p>

                                                </div>

                                                <div class="col-2 mb-4">
                                                    <h4>{{ trns('real_state_establish_date') }}</h4>
                                                    <p>{{ @$obj->association->establish_date ? @$obj->association->establish_date : trns('N/A') }}
                                                    </p>
                                                </div>
                                                <div class="col-3 mb-4">
                                                    <h4> {{ trns('status') }} </h4>
                                                    <p>
                                                        @if (@$obj->status == 1)
                                                            <span style="border-radius: 10%"
                                                                class="bg-success text-white rounded px-3 py-2">{{ trns('active') }}</span>
                                                        @else
                                                            <span style="border-radius: 10%"
                                                                class="bg-danger text-white rounded px-3 py-2">{{ trns('inactive') }}</span>
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
                                                <div class="col-3 mb-4">
                                                    <h4>{{ trns('national_id') }}</h4>
                                                    <p>{{ @$obj->association->user->national_id ?? trns('N/A') }}</p>
                                                </div>

                                                <!-- Numbers -->
                                                <div class="col-3 mb-4">
                                                    <h4>{{ trns('name') }}</h4>
                                                    <p>{{ @$obj->association->user->name ?? trns('N/A') }}</p>
                                                </div>
                                                <div class="col-3 mb-4">
                                                    <h4>{{ trns('email') }}</h4>
                                                    <p>{{ @$obj->association->user->email ?? trns('N/A') }}</p>
                                                </div>
                                                <div class="col-3 mb-4">
                                                    <h4> {{ trns('status') }} </h4>
                                                    <p>
                                                        @if (@$obj->status == 1)
                                                            <span style="border-radius: 10%"
                                                                class="bg-success text-white rounded px-3 py-2">{{ trns('active') }}</span>
                                                        @else
                                                            <span style="border-radius: 10%"
                                                                class="bg-danger text-white rounded px-3 py-2">{{ trns('inactive') }}</span>
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="col-3 mb-4">
                                                    <h4>{{ trns('phone') }}</h4>
                                                    <p>{{ @$obj->association->user->phone ?? trns('N/A') }}</p>
                                                </div>

                                            </div>


                                        </div>
                                        <div class="col-12 mt-4"
                                            style="border-radius: 6px;
                        background-color: #fbf9f9;
                        border: 1px solid #ddd;
                        padding: 15px;">
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
                                                                        <!-- <input class="form-check-input" type="radio"
                                                                                            name="facility_management_template" id="template1" value="template1"> -->
                                                                        <label class="form-check-label"
                                                                            for="template1"></label>
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

                                        {{--                                <div class="col-12 mt-5"> --}}
                                        {{--                                    <div id="map" style="height: 400px;"></div> --}}
                                        {{--                                </div> --}}






                                        {{--                                @endif --}}

                                        {{--                                @else --}}
                                        {{--                                    <h1>{{trns("there is no data here")}}</h1> --}}


                                    </div>
                                    <div class="col-12"
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
                                            <label for="lat"
                                                class="form-control-label">{{ trns('Select from the map and the width and length will be determined automatically') }}</label>
                                        </div>


                                        {{-- الخريطة --}}
                                        <div id="map" style="height: 400px;"></div>
                                    </div>
                                    <!-- Continue for all remaining fields -->
                                </div>
                            </div>
                        </div>


                    </div>
                    <div id="tab4">
                        <h3>{{ trns('images') }}</h3>


                        {{--                        @if ($obj ?? $obj->getMedia('images')->isNotEmpty()) --}}
                        <table class="table table-bordered text-center"
                            style="border: 1px solid #e3e3e3; border-radius: 10px;">
                            <thead>
                                <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">
                                    <th>{{ trns('rated_number') }}</th>
                                    <th>{{ trns('image_name') }}</th>
                                    <th>{{ trns('Size (KB)') }}</th>
                                    <th>{{ trns('creator') }}</th>
                                    <th>{{ trns('created_at') }}</th>
                                    <th>{{ trns('show') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{--                                @foreach (@$obj->getMedia('images') as $media) --}}
                                <tr>
                                    <td>{{ @$loop->iteration }}</td>
                                    <td style="cursor: pointer;"
                                        onclick="openModal('{{ asset('storage/' . @$media->id . '/' . @$media->file_name) }}')">
                                        {{ @$media->file_name }}
                                    </td>
                                    <td>{{ number_format(@$media->size / 1024, 2) }}</td>
                                    <td>{{ @$obj->admin_id ?? '-' }}</td>
                                    {{--                                        <td>{{ @$media??@$media->created_at->format('Y-m-d H:i') }}</td> --}}
                                    <td>{{ @$media ?? @$media->created_at }}</td>
                                    <td style="cursor: pointer;"
                                        onclick="openModal('{{ asset('storage/' . @$media->id . '/' . @$media->file_name) }}')">
                                        <i class="fas fa-file"></i>
                                        <?php @$media->file_name; ?>
                                    </td>


                                </tr>
                                {{--                                @endforeach --}}
                            </tbody>
                        </table>
                        {{--                        @endif --}}
                    </div>
                    <div id="imageModal" class="modal">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <img class="modal-content" id="modalImage">
                    </div>

                    <div id="tab5">


                        {{--                        @if ($obj ?? $obj->getMedia('files')->isNotEmpty()) --}}

                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>{{ trns('rated_number') }}</th>
                                    <th>{{ trns('file_name') }}</th>
                                    <th>{{ trns('Size (KB)') }}</th>
                                    <th>{{ trns('creator') }}</th>
                                    <th>{{ trns('created_at') }}</th>
                                    <th>{{ trns('show') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{--                                @foreach ($obj->getMedia('files') as $media) --}}
                                <tr>
                                    <td>{{ @$loop->iteration }}</td>
                                    <td style="cursor: pointer;"
                                        onclick="openFileModal('{{ asset('storage/' . @$media->id . '/' . @$media->file_name) }}')">
                                        {{ @$media->file_name }}
                                    </td>
                                    <td>{{ number_format(@$media->size / 1024, 2) }}</td>
                                    <td>{{ @$obj->admin?->name }}</td>
                                    {{--                                        <td>{{ @$media??@$media->created_at->format('Y-m-d H:i') }}</td> --}}
                                    <td>{{ @$media ?? @$media->created_at }}</td>
                                    <td style="cursor: pointer;"
                                        onclick="openModalFile('{{ asset('storage/' . @$media->id . '/' . @$media->file_name) }}')">
                                        <i class="fas fa-file"></i>
                                    </td>

                                </tr>
                                {{--                                @endforeach --}}
                            </tbody>
                        </table>
                        <div id="imageModal"
                            style="display:none; position:fixed; z-index:9999;
                                left:0; top:0; width:100vw;  background:rgba(0,0,0,0.8);">
                            <span class="close" onclick="closeModal()">&times;</span>
                            <img style="width:80%; height:80%; margin:5% auto; display:block; border:0"
                                class="modal-content" id="modalImage">
                        </div>

                        <!-- image Modal -->
                        <div id="fileModal">
                            <div id="fileModalContent">
                                <button onclick="closeFileModal()">&times;</button>
                                <iframe id="modalFile" src=""></iframe>
                            </div>
                        </div>


                        {{-- fiel midel  --}}
                        <div id="fileModal" class="modal">
                            <span class="close" onclick="closeFileModal()">&times;</span>
                            <div id="fileModalContent">
                                <iframe id="fileIframe"></iframe>
                                <div id="fileNotSupported"
                                    style="display: none; color: white; text-align: center; padding: 20px;">
                                    {{ trns('File not supported for preview. You can download it instead.') }}
                                </div>
                            </div>
                        </div>


                        <script>
                            function openFileModal(url) {
                                document.getElementById('modalFile').src = url;
                                document.getElementById('fileModal').style.display = 'block';
                            }

                            function openModal(imagePath) {
                                var modal = document.getElementById("imageModal");
                                var modalImg = document.getElementById("modalImage");

                                modal.style.display = "block";
                                modalImg.src = imagePath;
                            }

                            function closeFileModal() {
                                document.getElementById('fileModal').style.display = 'none';
                                document.getElementById('modalFile').src = '';
                            }
                        </script>
                        {{--                        @endif --}}
                        <div id="fileModal"
                            style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background: rgba(0,0,0,0.8);">
                            <div
                                style="position:relative; width:80%; height:80%; margin: 5% auto; background:#fff; padding: 10px;">
                                <button onclick="closeFileModal()"
                                    style="position:absolute; top:10px; right:10px; font-size:20px;">&times;
                                </button>
                                <iframe id="modalFile" src="" width="100%" height="100%"
                                    frameborder="0"></iframe>
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


        <div class="modal fade" id="editOrCreate" data-backdrop="static" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">{{ trns('user details') }}</h5> <!-- Added id here -->
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-body"></div>
                    <div class="modal-footer" id="modal-footer">

                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('ajaxCalls')
        @include('admin/layouts/NewmyAjaxHelper')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>



        <!-- Leaflet CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

        <!-- Leaflet JS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <!-- Your map container -->
        <div id="map" style="height: 400px;"></div>

        <!-- Input fields to update -->
        <input type="hidden" id="lat" value="24.7136">
        <input type="hidden" id="long" value="46.6753">

        <script>
            showAddModal('{{ route('units.showCreate', ['id' => $obj->id]) }}')
            $(document).on('submit', 'Form#addForm', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var url = $('#addForm').attr('action');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#addButton').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                            ' ></span> <span style="margin-left: 4px;">{{ trns('loading...') }}</span>'
                        ).attr('disabled', true);
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.status == 200) {
                            toastr.success('{{ trns('added_successfully') }}');
                            if (data.redirect_to) {
                                setTimeout(function() {
                                    window.location.href = data.redirect_to;
                                }, 2000);
                            } else {
                                $('#editOrCreate').modal('hide');
                                $('#dataTable').DataTable().ajax.reload();
                            }
                        } else if (data.status == 405) {
                            toastr.error(data.mymessage);
                        } else
                            toastr.error('{{ trns('something_went_wrong') }}');
                        $('#addButton').html(`{{ trns('add') }}`).attr('disabled', false);
                        $('#editOrCreate').modal('hide')
                    },
                    error: function(data) {
                        if (data.status === 500) {
                            toastr.error('');
                        } else if (data.status === 422) {
                            var errors = $.parseJSON(data.responseText);
                            $.each(errors, function(key, value) {
                                if ($.isPlainObject(value)) {
                                    $.each(value, function(key, value) {
                                        toastr.error(value, '{{ trns('error') }}');
                                    });
                                }
                            });
                        } else
                            toastr.error('{{ trns('something_went_wrong') }}');
                        $('#addButton').html(`اضافة`).attr('disabled', false);
                    }, //end error method

                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
            {{-- $('#search_modal').on('shown.bs.modal', function() {
                    $('select[name="search_select"]').select2({
                        width: '100%',
                        dropdownParent: $('#search_modal')
                    });
                }); --}}


            {{-- the edit section --}}


            $(document).on('click', '.editBtn', function() {
                var userId = $(this).data('id');

                // Load content into modal (example with AJAX)
                $.get('/admin/users/' + userId + '/edit', function(data) {
                    $('#modal-body').html(data);
                    $('#editOrCreate').modal('show');
                }).fail(function() {
                    alert('Error loading user data');
                });
            });

            // Clear modal when closed
            $('#editOrCreate').on('hidden.bs.modal', function() {
                $(this).find('.modal-body').html('');
            });


            {{-- edit store code --}}


            document.addEventListener('DOMContentLoaded', function() {
                const editModal = new bootstrap.Modal(document.getElementById('editOrCreate'));

                document.querySelectorAll('.editRealStateBtn').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        const editUrl = '{{ route('real_states.edit', ':id') }}'.replace(':id', id);

                        document.getElementById('modalTitle').textContent =
                            '{{ trns('edit_real_state_details') }}';

                        fetch(editUrl)
                            .then(response => response.text())
                            .then(html => {
                                document.getElementById('modal-body').innerHTML = html;
                                editModal.show();
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
                                toastr.success('Success', "{{ trns('active') }}");
                                $('#updateConfirmModal').modal('hide');
                                $('#bulk-delete').prop('disabled', false);
                                $('#bulk-update').prop('disabled', false);
                                $('#select-all').prop('checked', false);
                                $('#dataTable').DataTable().ajax.reload(null, false);
                            } else {
                                $('#select-all').prop('checked', false);
                                toastr.warning('Success', "{{ trns('inactive') }}");
                            }
                        } else {
                            $('#select-all').prop('checked', false);
                            toastr.error('Error', "{{ trns('something_went_wrong') }}");
                        }
                    },
                    error: function() {
                        toastr.error('Error', "{{ trns('something_went_wrong') }}");
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                const initialLat = parseFloat(document.getElementById('lat').value) || parseFloat(
                    "{{ $obj->lat }}");
                const initialLng = parseFloat(document.getElementById('long').value) || parseFloat(
                    "{{ $obj->long }}");


                const map = L.map('map').setView([initialLat, initialLng], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
                }).addTo(map);

                const marker = L.marker([initialLat, initialLng], {
                        draggable: true
                    }).addTo(map)
                    .bindPopup('Drag me to set location')
                    .openPopup();



                document.getElementById('lat').addEventListener('input', updateMarkerFromInputs);
                document.getElementById('long').addEventListener('input', updateMarkerFromInputs);
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
                                        <span class="copy-text">${data}</span>
                                        <button class="copy-btn" title="Copy" data-copy="${data}">
                                            📋
                                        </button>
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
            });




            $(document).ready(function() {
                var usersTable = $('.usersTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('realState.owners', ['request' => request(), 'id' => @$obj->id]) }}',
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

                },

                {
                    data: 'unit_number',
                    name: 'unit_number'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'floor_count',
                    name: 'floor_count'
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

                let id = $(this).data('id');
                let currentStatus = parseInt($(this).data('status'));
                $.ajax({
                    type: 'PUT',
                    url: '{{ route('real_states.update', $obj->id) }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'update': "status",
                        'status': currentStatus === 1 ? 0 : 1
                    },
                    success: function(data) {
                        if (data.status === 200) {
                            toastr.success("{{ trns('status_changed_successfully') }}");
                            location.reload();
                        } else {
                            toastr.error("{{ trns('something_went_wrong') }}");
                        }
                    },
                    error: function() {
                        toastr.error("{{ trns('something_went_wrong') }}");
                    }
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
    @endsection
