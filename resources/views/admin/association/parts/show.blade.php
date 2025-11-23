@extends('admin/layouts/master')
@section('title')
    {{ config()->get('app.name') }} | {{ $obj->name }}
@endsection
@section('page_name')
    {{ trns('associations_management') }} / {{ $obj->name }}
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


        .table td,
        .table th {
            vertical-align: middle;
            word-break: break-word;
            max-width: 200px;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        #fileModal {
            display: none;
            position: fixed;

            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
        }

        #fileModalContent {
            position: relative;
            width: 80%;
            height: 80%;
            margin: 5% auto;
            background: #fff;
            padding: 10px;
        }

        #fileModal iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        #fileModal button {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            background: none;
            border: none;
            color: #000;
            cursor: pointer;
        }

        .tab-content>div {
            display: none;
        }

        .tab-content>.active {
            display: block;
        }

        .dropdown-menu {
            z-index: 99999 !important;
        }
    </style>

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



    {{-- file midel --}}

    <style>
        #fileModalContent {
            position: relative;
            width: 80%;
            height: 80%;
            margin: 5% auto;
            background: #fff;
            padding: 10px;
        }

        #fileIframe {
            width: 100%;
            height: 100%;
            border: none;
            display: none;
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
            max-width: 75vw;
            max-height: 75vh;
        }
    </style>









    <div class="row">
        <!-- Create Or Edit Modal -->
        <div class="modal fade" id="editOrCreate" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ trns('create') }}</h5>

                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-body">
                        <!-- Dynamic content will be loaded here -->
                    </div>
                    <div class="modal-footer" id="modal-footer">

                    </div>
                </div>
            </div>
        </div>
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
                        <button type="button" class="btn btn-one" id="delete_btn_of_show">{{ trns('delete') }}!
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL CLOSED -->

        <!-- Can't Delete Modal -->
        <div class="modal fade" id="cantDeleteModal" tabindex="-1" aria-labelledby="cantDeleteModalLabel"
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


        <div class="col-md-12 col-lg-12">
            <div class="">


                <div class="" style="padding: 15px ; padding-bottom: 60px">


                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <img style="height: 70px; width: 70px; border-radius: 50%; margin-left: 10px;" alt="Avatar"
                                src="{{ getFile('storage/association/' . $obj->getMedia('logo')->first()?->model_id . '/logo/' . $obj->getMedia('logo')->first()?->file_name) }}">
                            {{ $obj->name }}
                            </h2>
                        </div>


                        <div class="dropdown">
                            <button class="btn dropdown-toggle m-2" type="button"
                                id="dropdownMenuButton{{ $obj->id }}" data-bs-toggle="dropdown" aria-expanded="false"
                                style="background-color: #00193a; color: #00F3CA;">
                                {{ trns('options') }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $obj->id }}"
                                style="background-color: #EAEAEA;">
                                <li>
                                    <a class="dropdown-item association_show_edit" href="javascript:void(0);"
                                        data-id="{{ $obj->id }}">
                                        <img src="{{ asset('edit.png') }}" alt="no-icon" class="img-fluid ms-1"
                                            style="width: 24px; height: 24px;"> {{ trns('Edit') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item toggleAssociationStatusBtn" href="#"
                                        data-id="{{ $obj->id }}" data-status="{{ $obj->status }}">
                                        {{ $obj->status == 1 ? trns('Deactivate_association') : trns('Activate_association') }}
                                    </a>
                                </li>
                                @if (!checkIfModelHasRecords(\App\Models\RealState::class, 'association_id', $obj->id))
                                    <li>
                                        <a class="dropdown-item" style="color: red; cursor: pointer; margin-right: 5px;"
                                            data-bs-toggle="modal" data-bs-target="#delete_modal_of_show"
                                            data-id="{{ $obj->id }}" data-title="{{ $obj->name }}">
                                            <i class="fas fa-trash" style="margin-left: 5px;"></i>
                                            {{ trns(key: 'delete') }}
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a class="dropdown-item show-cant-delete-modal"
                                            style="color: red; cursor: pointer; margin-right: 5px;" data-bs-toggle="modal"
                                            data-bs-target="#cantDeleteModal"
                                            data-title="{{ trns('You_cant_delete_this_association_please_delete_all_real_states_first') }}">
                                            <i class="fas fa-trash" style="margin-left: 5px;"></i>
                                            {{ trns(key: 'delete') }}
                                        </a>
                                    </li>
                                @endif

                            </ul>
                            <a href="{{ route('associations.index') }}" class="btn"
                                style="transform: rotate(180deg); border: 1px solid gray; padding: 6px 11px;">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>

                    </div>

                    <ul class="nav nav-tabs" style="margin: 0 3px;" id="realEstateTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-tab="tab1" href="#">{{ trns('main information') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-tab="association_real_states"
                                href="#association_real_states">{{ trns('real_states') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-tab="association_units"
                                href="#association_units">{{ trns('units') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-tab="tab4" href="#">{{ trns('images') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-tab="tab5" href="#">{{ trns('documents') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-tab="association_meetings"
                                href="#association_meetings">{{ trns('meetings') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-tab="association_votes"
                                href="#association_votes">{{ trns('votes') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-tab="association_contracts"
                                href="#association_contracts">{{ trns('contracts') }}</a>
                        </li>
                    </ul>


                    <!-- test the update -->


                    <div class="tab-content mt-4 mb-0">
                        <div id="tab1" class="active">
                            <div class="tab-pane fade show active" id="basic-info" role="tabpanel">
                                <div class="show-content mt-3"
                                    style="border-radius: 6px;
                                    background-color: #fbf9f9;
                                    border: 1px solid #ddd;
                                    padding: 15px;">
                                    <h4 style="font-weight: bold; color: #00193a;">
                                        {{ trns('basic_information_of_association') }}</h4>
                                    <!-- <h4>{{ $obj->name ?? trns('N/A') }}</h4> -->
                                    <hr style="background-color: black;">
                                    <div class="row m-4">
                                        <div class="col-lg-2 col-md-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('association name') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ trns('association : ') . $obj->name }}</p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('association number') }}</h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {!! $obj->number ? copyable_text($obj->number) . ' ' . $obj->number : trns('N/A') !!}</p>

                                        </div>

                                        <div class="col-lg-2 col-md-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('real state count') }}</h4>

                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->RealStates->count() ?? trns('N/A') }}</p>


                                        </div>
                                        <div class="col-lg-2 col-md-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('unit count') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->RealStates->map(fn($realState) => $realState->units->count())->sum() ?? trns('N/A') }}
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('establish_date') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->establish_date ?? trns('N/A') }}</p>
                                        </div>


                                        <div class="col-lg-2 col-md-3 mb-2">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('status') }} </h4>
                                            {!! $obj->status == 1
                                                ? "<p class='badge px-3 py-2' style='background-color: #6AFFB2; color: #1F2A37; border-radius: 30px'>" .
                                                    trns('active') .
                                                    '</p>'
                                                : "<p class='badge px-3 py-2' style='background-color: #FFBABA; color: #1F2A37; border-radius: 30px'>" .
                                                    trns('inactive') .
                                                    '</p>' !!}

                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-4"
                                    style="border-radius: 6px;
                                    background-color: #fbf9f9;
                                    border: 1px solid #ddd;
                                    padding: 15px;">
                                    <h4 style="font-weight: bold; color: #00193a;">{{ trns('association_management') }}
                                    </h4>
                                    <hr style="background-color: black;">
                                    <div class="row m-4">
                                        <div class="col-lg-2 col-md-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('national id') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->AssociationManager->national_id ?? trns('N/A') }}</p>
                                        </div>
                                        <div class="col-lg-3 col-md-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('name') }}</h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->AssociationManager->name ?? trns('N/A') }}</p>
                                        </div>
                                        <div class="col-lg-3 col-md-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('email') }}</h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->AssociationManager->email ?? trns('N/A') }}</p>
                                        </div>
                                        <div class="col-lg-2 col-md-3 mb-2">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('status') }} </h4>
                                            {!! $obj->AssociationManager->status == 1
                                                ? "<p class='badge px-3 py-2' style='background-color: #6AFFB2; color: #1F2A37; border-radius: 30px'>" .
                                                    trns('active') .
                                                    '</p>'
                                                : "<p class='badge px-3 py-2' style='background-color: #FFBABA; color: #1F2A37; border-radius: 30px'>" .
                                                    trns('inactive') .
                                                    '</p>' !!}
                                        </div>
                                        <div class="col-lg-2 col-md-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;"> {{ trns('phone number') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->AssociationManager->phone ?? trns('N/A') }}</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="mt-2 row">

                                        <div class="col-12 mt-3"
                                            style="border-radius: 6px;
                                    background-color: #fbf9f9;
                                    border: 1px solid #ddd;
                                    padding: 15px;">

                                            <h4 style="font-weight: bold; color: #00193a;">
                                                {{ trns('إدارة مرافق الجمعيه') }}
                                            </h4>
                                            <hr style="background-color: black;">
                                            <div class="card custom-card text-right w-50"
                                                style="box-shadow: none;background-color: #F4F4F4; border: 3px solid #00F3CA57; border-radius: 6px;">
                                                <div class="card-body">

                                                    <h5 class="association-card-header"
                                                        style="color: #00193a; font-weight: bold;">
                                                        {{ $obj->AssociationModel?->title }}
                                                    </h5>
                                                    <p class="association-card-para" style="color: #b5b5c3;">
                                                        {{ $obj->AssociationModel?->description }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">

                                        </div>
                                    </div>
                                </div>
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

                                </div>


                                {{-- الخريطة --}}
                                <div id="map" style="height: 400px;"></div>
                            </div>


                        </div>
                        <div id="association_real_states">
                            <div class="tab-pane fade show active" id="basic-info" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-3">

                                    <h4 class="text-blacek"> {{ trns('association_real_states_table') }}</h4>
                                    @can('create_real_state')
                                        <button class="btn btn-icon text-white  addBtnInShow" id="addRealState">
                                            <span>
                                            </span> {{ trns('add_real_state') }}
                                        </button>
                                    @endcan
                                </div>

                                <table class="table table-bordered text-nowrap w-100"
                                    style="border: 1px solid #e3e3e3; border-radius: 10px; margin-bottom: 0 !important;"
                                    id="realStatesTable">
                                    <thead>
                                        <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">
                                            <th>#</th>
                                            <th class="min-w-0px">{{ trns('real_state_name') }}</th>
                                            <th>{{ trns('real_state_location') }}</th>
                                            <th class="min-w-5px">{{ trns('real_state_count') }}</th>
                                            <th class="min-w-20px">{{ trns('real_state_created_at') }}</th>
                                            <th class="min-w-10px">{{ trns('real_state_status') }}</th>
                                            <th class="min-w-10px">{{ trns('actions') }}</th>
                                        </tr>

                                    </thead>
                                </table>


                            </div>


                        </div>
                        <div id="association_units">
                            <div class="tab-pane fade show active" id="basic-info" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="text-blacek"> {{ trns('association_units_table') }}</h4>
                                    @can('create_unit')
                                        <button class="btn btn-icon text-white  addBtnInShow" id="addUnit">
                                            <span>
                                            </span> {{ trns('add_unit') }}
                                        </button>
                                    @endcan
                                </div>
                                <table class="table table-bordered text-nowrap w-100"
                                    style="border: 1px solid #e3e3e3; border-radius: 10px; margin-bottom: 0 !important;"
                                    id="unitsTable">
                                    <thead>
                                        <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">
                                            <th>#</th>
                                            <th>{{ trns('unit_code') }}</th>
                                            <th>{{ trns('unit_number') }}</th>
                                            <th>{{ trns('real_state_owners_name') }}</th>
                                            <th>{{ trns('real_state_number') }}</th>
                                            <th>{{ trns('created_at') }}</th>
                                            <th>{{ trns('status') }}</th>
                                            <th>{{ trns('actions') }}</th>
                                        </tr>
                                    </thead>
                                </table>


                            </div>
                        </div>

                        {{-- delete meeting modal --}}
                        <div class="modal fade" id="delete_modal_vote_of_show" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog " role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ trns('delete') }}</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input id="delete_id" name="id" type="hidden">
                                        <p>{{ trns('are_you_sure_you_want_to_delete_this_obj') }}</p>
                                    </div>
                                    <div class="modal-footer d-flex flex-nowrap">
                                        <button type="button" class="btn btn-two" data-bs-dismiss="modal"
                                            id="dismiss_delete_modal">
                                            {{ trns('close') }}
                                        </button>
                                        <button type="button" class="btn btn-one" id="delete_button_vote_of_show">
                                            {{ trns('delete') }}!
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="association_votes">
                            <div class="tab-pane fade show active" id="basic-info" role="tabpanel">

                                <div class="card w-100">
                                    <div class="card-header">
                                        <h4 class="" style="color: #00193a; margin-bottom: 0px;">
                                            {{ trns('votes') }}</h4>
                                        <div class=" d-flex">

                                            @can('create_user')
                                                <button class="btn btn-icon text-white addVoteBtn" data-type="create"
                                                    style="border: none;">
                                                    <span>
                                                        <i class="fe fe-plus"></i>
                                                    </span> {{ trns('add_vote') }}
                                                </button>
                                            @endcan
                                        </div>
                                    </div>
                                    <div class="mt-5" style="padding: 1rem 1.5rem;">
                                        <div class="table-responsive" style="overflow-x: inherit;">
                                            <!--begin::Table-->
                                            <table class="table text-nowrap w-100"
                                                style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;"
                                                id="voteDataTable">
                                                <thead>
                                                    <tr class="fw-bolder"
                                                        style="background-color: #E9E9E9; color: #00193a;">

                                                        <th>#</th>
                                                        <th class="min-w-50px">{{ trns('association_name') }}</th>
                                                        {{-- <th class="min-w-50px">{{ trns('title') }}</th>
                                                        <th class="min-w-50px">{{ trns('description') }}</th> --}}
                                                        <th class="min-w-50px">{{ trns('stuplish_at') }}</th>
                                                        <th class="min-w-50px">{{ trns('vote_start_date') }}</th>
                                                        <th class="min-w-50px">{{ trns('vote_end_date') }}</th>
                                                        <th class="min-w-50px">{{ trns('owners_number') }}</th>
                                                        <th class="min-w-50px">{{ trns('audience_number') }}</th>
                                                        <th class="min-w-50px">{{ trns('unVoted_number') }}</th>
                                                        <th class="min-w-50px">{{ trns('status') }}</th>
                                                        <th class="min-w-50px rounded-start">{{ trns('actions') }}</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- the delay modal  --}}
                        <div class="modal fade" id="delayMeetModel" data-backdrop="static" tabindex="-1"
                            role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ trns('delay_meet') }}</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="delayModalbody">
                                        <form id="updateDelayMeetForm" method="POST">
                                            @csrf
                                            <input type="hidden" id="delayMeet_id" name="id">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="date">{{ trns('delay_Date') }} <span
                                                                class="text-danger">*</span></label>
                                                        <input onclick="this.showPicker()" type="datetime-local"
                                                            name="date" class="form-control" />
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit"
                                                class="btn btn-primary mt-3">{{ trns('save') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- delete meeting modal --}}
                        <div class="modal fade" id="delete_modal_meeting_of_show" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog " role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ trns('delete') }}</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input id="delete_id" name="id" type="hidden">
                                        <p>{{ trns('are_you_sure_you_want_to_delete_this_obj') }}</p>
                                    </div>
                                    <div class="modal-footer d-flex flex-nowrap">
                                        <button type="button" class="btn btn-two" data-bs-dismiss="modal"
                                            id="dismiss_delete_modal">
                                            {{ trns('close') }}
                                        </button>
                                        <button type="button" class="btn btn-one" id="delete_button_meeting_of_show">
                                            {{ trns('delete') }}!
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="association_meetings">
                            <div class="tab-pane fade show active" id="basic-info" role="tabpanel">
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h1 class="card-title"> {{ trns('mettings') }}</h1>
                                        <div class="">
                                            <button class="btn btn-icon text-white addMeetingBtn" style="border: none;">
                                                <span>
                                                    <i class="fe fe-plus"></i>
                                                </span> {{ trns('add_mettings') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <!--begin::Table-->
                                            <table class="table text-nowrap w-100" id="MeetingDataTable"
                                                style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;">
                                                <thead>
                                                    <tr style="background-color: #e3e3e3; color: #00193a;">
                                                        <th class="rounded-end">#</th>
                                                        <th class="min-w-50px">{{ trns('association_name') }}</th>
                                                        <th class="min-w-50px">{{ trns('date') }}</th>
                                                        <th class="min-w-50px">{{ trns('created_by') }}</th>
                                                        <th class="min-w-50px">{{ trns('created_at') }}</th>
                                                        {{-- <th class="min-w-50px">{{ trns('agenda') }}</th> --}}
                                                        <th class="min-w-50px">{{ trns('address_space') }}</th>
                                                        <th class="min-w-50px">{{ trns('actions') }}</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="association_contracts">
                            <div class="tab-pane fade show active" id="basic-info" role="tabpanel">
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h1 class="card-title"> {{ trns('contracts') }}</h1>
                                        <div class="">
                                            <button class="btn btn-icon text-white addcontractBtn" style="border: none;">
                                                <span>
                                                    <i class="fe fe-plus"></i>
                                                </span> {{ trns('add_contract') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <!--begin::Table-->
                                            <table class="table text-nowrap w-100" id="contractDataTable"
                                                style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;">
                                                <thead>
                                                    <tr style="background-color: #e3e3e3; color: #00193a;">
                                                        <th>{{ trns('contract_number') }}</th>
                                                        <th>{{ trns('contract_type') }}</th>
                                                        <th>{{ trns('contract_name') }}</th>
                                                        <th>{{ trns('contract_date') }}</th>
                                                        <th>{{ trns('contract_location_') }}</th>
                                                        <th>{{ trns('first_party') }}</th>
                                                        <th>{{ trns('second_party') }}</th>
                                                        <th>{{ trns('actions') }}</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div id="tab4">
                            <div class="show-image">

                                <div class="card mt-3 p-1 pl-5 pr-5 w-100">

                                    <div class="d-flex justify-content-between align-items-center">
                                        @can('create_association')
                                            <button class="btn btn-icon text-white  addMediaBtn"
                                                data-id="{{ $obj->id }}" data-model="Association" data-type="image">
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
                                                    style="border: 1px solid #e3e3e3; border-radius: 10px; margin-bottom: 0 !important;"
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
                                                                style="z-index: 99999; background-color: #EAEAEA; text-align: right;"
                                                                aria-labelledby="dropdownMenuButton1">

                                                                <li class="m-2">
                                                                    <span class="download-img" style="cursor: pointer;"
                                                                        data-fileName=" {{ $media->file_name }} "
                                                                        data-url="{{ asset('storage/association/' . $media->model_id . '/images/' . $media->file_name) }}">
                                                                        <i class="fas fa-download"></i>
                                                                        {{ trns('download') }}
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

                                                        <img onclick="openModal('{{ asset('storage/association/' . $obj->id . '/images/' . $media->file_name) }}')"
                                                            style="width:100%; height:100%; border-radius: 10px"
                                                            src="{{ asset('storage/association/' . $obj->id . '/images/' . $media->file_name) }}">

                                                    </div>
                                                @endforeach

                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div id="tab5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="card w-100">
                                    <div class="card-header"
                                        style="border-bottom: 1px solid rgba(234, 238, 251, 0.8) !important;">
                                        <h4>{{ trns('files') }}</h4>
                                        @can('create_association')
                                            <button class="btn btn-icon text-white addMediaBtn"
                                                data-id="{{ $obj->id }}" data-model="Association" data-type="file">
                                                <span>
                                                </span> {{ trns('add_file') }}
                                            </button>
                                        @endcan
                                    </div>

                                    <div class="table-responsive mt-5 mb-5"
                                        style="overflow: inherit; padding: 1rem 1.5rem;">
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
                                                        <td style="cursor: pointer;">
                                                            <a
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
                                                        <td colspan="7" class="text-center text-muted">لا يوجد
                                                            ملفات</td>
                                                    </tr>
                                                @endforelse

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="imageModal"
                    style="display:none; position:fixed; z-index:9999;
                                left:0; top:0; width:100vw;  background:rgba(0,0,0,0.8);">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <img style="width:80%; height:80%; margin:5% auto; display:block; border:0" class="modal-content"
                        id="modalImage">
                </div>


                <div class="modal fade" id="show_owners" index="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <div id="fileModal"
                    style="display:none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.6);">
                    <div
                        style="position: relative; width: 90%; max-width: 900px; height: 90vh; margin: 5vh auto; background: white; padding: 20px;">
                        <span onclick="closeFileModal()"
                            style="position:absolute; top:10px; right:15px; cursor:pointer;">✖</span>

                        <iframe id="fileFrame" width="100%" height="90%"
                            style="display:none; border:none;"></iframe>

                        <div id="fileFallback" style="display:none; text-align:center;">
                            <p>لا يمكن عرض هذا الملف.</p>
                            <a id="downloadButton" href="#" download class="btn btn-primary" target="_blank">تحميل
                                الملف</a>
                        </div>
                    </div>
                </div>


            </div>
        </div>


        <!--Delete MODAL -->
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
                                class="text-danger"></span>?</p>
                    </div>
                    <div class="modal-footer d-flex flex-nowrap">
                        <button type="button" class="btn btn-two" data-bs-dismiss="modal" id="dismiss_delete_modal">
                            {{ trns('close') }}
                        </button>
                        <button type="button" class="btn btn-one" id="delete_btn">{{ trns('delete') }} !</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL CLOSED -->


        <style>
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
        </style>


        <!-- Leaflet CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

        <!-- Leaflet JS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <!-- Your map container -->
        <div id="map" style="height: 400px;"></div>

        <!-- Input fields to update -->
        <input type="hidden" id="lat" value="{{ $obj->lat }}">
        <input type="hidden" id="long" value="{{ $obj->long }}">
    </div>
    @include('admin.layouts.NewmyAjaxHelper')
@endsection
@section('ajaxCalls')
    <script>
        // ===============================
        // 📌 show datatable for meetings
        // ===============================
        document.addEventListener("DOMContentLoaded", function() {
            let association_id = {{ $obj->id ?? 'null' }};

            // Summary table
            let summaryColumns = [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'association_id',
                    name: 'association_id'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'created_by',
                    name: 'created_by'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                // {
                //     data: 'agenda_id',
                //     name: 'agenda_id'
                // },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];
            showMeetingData(null, '{{ route('meetings.index') }}', summaryColumns, 0, 3, association_id);




            // ===============================
            // 📌 doube functions for summary and topic datatable
            // ===============================
            async function showMeetingData(showRoute, routeOfShow, columns, orderByColumn = 0, showCol = 3,
                association_id = null) {
                let table = $('#MeetingDataTable').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: {
                        url: routeOfShow,
                        data: function(d) {
                            if (association_id) d.association_id = association_id;
                        }
                    },
                    columns: columns,
                    order: [
                        [orderByColumn ? orderByColumn : 0, "DESC"]
                    ],
                    createdRow: function(row, data) {
                        $(row).attr('data-id', data.id).addClass('clickable-row');
                    },
                    language: {
                        sProcessing: "{{ trns('processing...') }}",
                        sLengthMenu: "{{ trns('show') }} _MENU_ {{ trns('records') }}",
                        sZeroRecords: "{{ trns('no_records_found') }}",
                        sInfo: "{{ trns('showing') }} _START_ {{ trns('to') }} _END_ {{ trns('of') }} _TOTAL_ {{ trns('records') }}",
                        sInfoEmpty: "{{ trns('showing') }} 0 {{ trns('to') }} 0 {{ trns('of') }} 0 {{ trns('records') }}",
                        sInfoFiltered: "({{ trns('filtered_from') }} _MAX_ {{ trns('total_records') }})",
                        sSearch: "{{ trns('search') }} :    ",
                        oPaginate: {
                            sPrevious: "{{ trns('previous') }}",
                            sNext: "{{ trns('next') }}",
                        },
                        buttons: {
                            copyTitle: '{{ trns('copied') }} <i class="fa fa-check-circle text-success"></i>',
                            copySuccess: {
                                1: "{{ trns('copied') }} 1 {{ trns('row') }}",
                                _: "{{ trns('copied') }} %d {{ trns('rows') }}"
                            },
                        }
                    },
                });

                if (showRoute) {
                    $('#dataTable tbody').on('click', `tr td:nth-child(${showCol})`, function(e) {
                        if ($(e.target).is('input, button, a, .delete-checkbox, .editBtn, .statusBtn'))
                            return;
                        let id = $(this).closest('tr').data('id');
                        if (id) window.location.href = showRoute.replace(':id', id);
                    });
                }
            }
        });






        // ===============================
        // 📌 handle delay the meeting
        // ===============================
        //  delay the meeting js 
        $(document).on('click', '.delayBtn', function() {
            let id = $(this).data('id');

            let fetchRoute = '{{ route('meetings.showDate', ':id') }}'.replace(':id', id);
            let updateRoute = '{{ route('meetings.update', ':id') }}'.replace(':id', id);

            // Show modal
            $('#delayMeetModel').modal('show');

            // Reset previous values
            $('#delayMeet_id').val(id);
            $('#date').val('');
            $('#updateDelayMeetForm').attr('action', updateRoute);

            // Loader (optional)
            $('#date').prop('disabled', true);

            // Fetch meeting data
            $.ajax({
                url: fetchRoute,
                method: 'GET',
                success: function(res) {
                    $('#date').val(res.date);
                    $('#date').prop('disabled', false);
                },
                error: function() {
                    $('#date').prop('disabled', false);
                    toastr.error('Failed to fetch meeting data.');

                }
            });
        });

        // Submit form via AJAX
        $(document).on('submit', '#updateDelayMeetForm', function(e) {
            e.preventDefault();
            let form = $(this);
            let url = form.attr('action');
            let data = form.serialize();

            $.ajax({
                url: url,
                method: 'PUT',
                data: data,
                success: function() {
                    // window.location.reload();
                    $('#delayMeetModel').modal('hide');
                    Swal.fire({
                        title: '{{ trns('Meeting delayed successfully') }}',
                        icon: 'success',
                        timer: 1000,
                        showConfirmButton: false
                    });
                    $('#MeetingDataTable').DataTable().ajax.reload();
                },
                error: function(err) {
                    toastr.error('Failed to update meeting.');
                }
            });
        });



        // ===============================
        // 📌 update meet
        // ===============================

        $(document).on('click', '.editMeetingBtn', function() {
            var id = $(this).data('id');
            var url = '{{ route('meetings.edit', ':id') }}'.replace(':id', id);

            $('#modal-body').html(loader);
            $('#editOrCreate').modal('show');
            $('#editOrCreate .modal-title').text('{{ trns('edit_meeting') }}');

            // Footer buttons
            $('#modal-footer').html(`
                <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('close') }}</button>
                    <button type="button" class="btn btn-one me-2" id="meetingsUpdatebtn" data-id="${id}">{{ trns('update') }}</button>
                </div>
            `);

            setTimeout(function() {
                // $('#modal-body').load(url);
                $('#modal-body').load(url, function() {
                    $(".meetingsUpdateForm #association_id").prop("disabled", true);
                });

            }, 500);
        });


        $(document).on('click', '#meetingsUpdatebtn', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            var form = $('.meetingsUpdateForm');
            var formData = new FormData(form[0]);
            formData.append("_method", "PUT");
            var url = '{{ route('meetings.update', ':id') }}'.replace(':id', id);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#meetingsUpdatebtn').html(
                            '<span class="spinner-border spinner-border-sm mr-2"></span> {{ trns('loading...') }}'
                        )
                        .attr('disabled', true);
                },
                success: function(data) {
                    Swal.fire({
                        title: '{{ trns('updated_successfully') }}',
                        icon: 'success',
                        timer: 1000,
                        showConfirmButton: false
                    });
                    $('#editOrCreate').modal('hide');
                    // setTimeout(function() {
                    //     window.location.reload(); // ✅ fixed typo here
                    // }, 1000);
                    $('#MeetingDataTable').DataTable().ajax.reload();

                    $('#meetingsUpdatebtn').html('{{ trns('update') }}').attr('disabled', false);
                },

                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, messages) {
                            messages.forEach(msg => toastr.error(msg));
                        });
                    } else {
                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('error') }}</span>',
                            imageUrl: '{{ asset('true.png') }}',
                            imageWidth: 80,
                            imageHeight: 80,
                            imageAlt: 'error',
                            showConfirmButton: false,
                            timer: 700,
                            customClass: {
                                image: 'swal2-image-mt30'
                            }
                        });
                    }
                    $('#meetingsUpdatebtn').html('{{ trns('update') }}').attr('disabled', false);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });



        // ===============================
        // 📌 handle delete meeting
        // ===============================

        initCantDeleteModalHandler();
        $(document).ready(function() {

            // 1️⃣ When user clicks on the delete button → open modal & set data
            $(document).on('click', '#meetingDeleteBtn', function() {
                var id = $(this).data('id'); // get meeting id from button
                $('#delete_id').val(id); // set id inside hidden input in modal
                $('#delete_modal_meeting_of_show').modal('show'); // open modal
            });

            // 2️⃣ When confirm delete button in modal is clicked
            $(document).on('click', '#delete_button_meeting_of_show', function() {
                var id = $("#delete_id").val();
                var routeOfDelete = "{{ route('meetings.destroy', ':id') }}".replace(':id', id);

                $.ajax({
                    type: 'DELETE',
                    url: routeOfDelete,
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'id': id
                    },
                    success: function(data) {
                        if (data.status === 200) {
                            $('#delete_modal_meeting_of_show').modal('hide');

                            Swal.fire({
                                title: '<span style="margin-bottom: 50px; display: block;">{{ trns('success') }}</span>',
                                imageUrl: '{{ asset('true.png') }}',
                                imageWidth: 80,
                                imageHeight: 80,
                                imageAlt: 'Success',
                                showConfirmButton: false,
                                timer: 700,
                                customClass: {
                                    image: 'swal2-image-mt30'
                                }
                            });
                            $('#MeetingDataTable').DataTable().ajax.reload();

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

        });






        // add contract dataTable
        // ===============================
        // show the contracts of this user in datatable
        document.addEventListener("DOMContentLoaded", function() {
            let association_id = {{ $obj->id ?? 'null' }};

            // contracts table
            let contractColumns = [{
                    data: 'id',
                    name: 'id',
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'location',
                    name: 'location'
                },
                {
                    data: 'firstParty',
                    name: 'firstParty'
                },
                {
                    data: 'secondParty',
                    name: 'secondParty'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];
            showContractDataTable(null, '{{ route('contracts.index') }}', contractColumns, 0, 3, association_id);
        });




        // ===============================
        // 📌  functions for contracts datatable
        // ===============================
        async function showContractDataTable(showRoute, routeOfShow, columns, orderByColumn = 0, showCol = 3,
            association_id =
            null) {
            let table = $('#contractDataTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: routeOfShow,
                    data: function(d) {
                        if (association_id) d.association_id = association_id;
                    }
                },
                columns: columns,
                order: [
                    [orderByColumn ? orderByColumn : 0, "DESC"]
                ],
                createdRow: function(row, data) {
                    $(row).attr('data-id', data.id).addClass('clickable-row');
                },
                language: {
                    sProcessing: "{{ trns('processing...') }}",
                    sLengthMenu: "{{ trns('show') }} _MENU_ {{ trns('records') }}",
                    sZeroRecords: "{{ trns('no_records_found') }}",
                    sInfo: "{{ trns('showing') }} _START_ {{ trns('to') }} _END_ {{ trns('of') }} _TOTAL_ {{ trns('records') }}",
                    sInfoEmpty: "{{ trns('showing') }} 0 {{ trns('to') }} 0 {{ trns('of') }} 0 {{ trns('records') }}",
                    sInfoFiltered: "({{ trns('filtered_from') }} _MAX_ {{ trns('total_records') }})",
                    sSearch: "{{ trns('search') }} :    ",
                    oPaginate: {
                        sPrevious: "{{ trns('previous') }}",
                        sNext: "{{ trns('next') }}",
                    },
                    buttons: {
                        copyTitle: '{{ trns('copied') }} <i class="fa fa-check-circle text-success"></i>',
                        copySuccess: {
                            1: "{{ trns('copied') }} 1 {{ trns('row') }}",
                            _: "{{ trns('copied') }} %d {{ trns('rows') }}"
                        },
                    }
                },
                // ... language and buttons as you already have ...
            });

            if (showRoute) {
                $('#dataTable tbody').on('click', `tr td:nth-child(${showCol})`, function(e) {
                    if ($(e.target).is('input, button, a, .delete-checkbox, .editBtn, .statusBtn')) return;
                    let id = $(this).closest('tr').data('id');
                    if (id) window.location.href = showRoute.replace(':id', id);
                });
            }
        }
        /* =========================
        /* =========================
        /* contract function create , update and delete 
        /* ========================= */



        // create contract 

        //     /* =========================
        //     🟢 ADD contract SECTION
        //     ========================== */
        $(document).on('click', '.addcontractBtn', function() {
            $('#modal-body').html(loader);
            $('#editOrCreate').modal('show');

            $('#modal-footer').html(`
                        <div class="w-100 d-flex">
                            <button type="button" class="btn btn-two" data-bs-dismiss="modal">
                                {{ trns('close') }}
                            </button>
                            <button type="submit" class="btn btn-one me-2" id="contractStoreBtn">
                                {{ trns('create') }}
                            </button>
                        </div>
                    `);



            setTimeout(function() {
                $('#modal-body').load("{{ route('association_contracts.createByAssociation') }}",
                    function() {

                        // بعد تحميل الفورم بالكامل
                        const $associationSelect = $(".addContractForm #association_id");
                        const $associationSelectUser = $(".addContractForm #user_association_id");
                        const $associationSelectPartner = $(
                            ".addContractForm #user_partner_association_id");
                        const $audienceNumber = $(".addContractForm #audience_number");

                        const associationId = {{ $obj->id }};

                        // 🔹 تثبيت association id في الفورم
                        $associationSelect.val(associationId).prop('disabled', true);
                        $associationSelectUser.val(associationId).prop('disabled', true);
                        $associationSelectPartner.val(associationId).prop('disabled', true);
                        if ($('.addContractForm input[name="association_id_hidden"]').length === 0) {
                            $('<input>').attr({
                                type: 'hidden',
                                name: 'association_id',
                                value: associationId
                            }).appendTo('.addContractForm');
                        }

                        // ------------------------------
                        // ✅ Reset and show correct fields
                        // ------------------------------
                        $('#asssociation').show();
                        $('#first_association_user').hide();
                        $("#association_details").show();
                        $("#association_admin").show();
                        $("#association_admin_id").show();
                        $("#contract_party_id").hide();
                        $("#user_partner_association").hide();
                        $("#user_asssociation").hide();
                        $('#association_name').show();
                        $('#association_number').show();
                        $('#association_establish_date').show();
                        $("#association_details").show();
                        $("#party_name_second, #party_nation_id_second, #party_phone_second, #party_email_second, #party_name_first, #party_nation_id_first, #party_phone_first, #party_email_first")
                            .val("")
                            .prop("readonly", false);

                        $("#contract_first_party").hide();

                        $("#first_association_admin_id").empty().append(
                            '<option value="" selected>{{ trns('select_user') }}</option>'
                        );
                        $("#second_association_admin_id").empty().append(
                            '<option value="" selected>{{ trns('select_user') }}</option>'
                        );

                        $("#first_association_admin_id, #second_association_admin_id").val(null)
                            .trigger('change');

                        // ------------------------------
                        // ✅ جلب تفاصيل الجمعية (association details)
                        // ------------------------------
                        if (associationId) {
                            $.ajax({
                                url: "{{ route('association.byId', ['id' => '__ID__']) }}"
                                    .replace('__ID__', associationId),
                                method: 'GET',
                                success: function(data) {
                                    if (data.status === 200) {
                                        var association = data.data;
                                        var locale = '{{ app()->getLocale() }}';
                                        var name = '';

                                        // معالجة الاسم حسب الـ locale أو structure
                                        if (association.name && typeof association.name ===
                                            'string') {
                                            name = association.name;
                                        } else if (association.name && typeof association
                                            .name === 'object') {
                                            name = association.name[locale] ?? association
                                                .name[Object.keys(association.name)[0]] ??
                                                '';
                                        } else if (association.translations && association
                                            .translations[locale]) {
                                            name = association.translations[locale].name ??
                                                '';
                                        }

                                        $('#association_number').show();
                                        $('#association_name').show();
                                        $('#association_establish_date').show();
                                        $("#association_details").show();
                                        $('#association_name').val(name).prop('readonly',
                                            true);
                                        $('#association_number').val(association.number ??
                                            '').prop('readonly', true);
                                        $('#association_establish_date').val(association
                                            .establish_date ?? '').prop('readonly',
                                            true);
                                    } else {
                                        $('#association_name, #association_number, #association_establish_date')
                                            .val('');
                                    }
                                },
                                error: function() {
                                    $('#association_name, #association_number, #association_establish_date')
                                        .val('');
                                }
                            });

                            // ------------------------------
                            // ✅ جلب أدمن الجمعية (association admin)
                            // ------------------------------
                            $.ajax({
                                url: "{{ route('association.getAdmin', ['id' => '__ID__']) }}"
                                    .replace('__ID__', associationId),
                                method: 'GET',
                                success: function(data) {
                                    if (data.status === 200) {
                                        var admin = data.admin;

                                        $("#contract_first_party").hide();
                                        $("#association_admin").show();
                                        $("#association_admin_id")
                                            .html(
                                                `<option value="${admin.id}" selected>${admin.name}</option>`
                                            )
                                            .trigger('change')
                                            .prop('readonly', true);

                                        // تعيين بيانات الأدمن كطرف أول
                                        $("#party_name_first").val(admin.name).prop(
                                            'readonly', true);
                                        $("#party_nation_id_first").val(admin.national_id)
                                            .prop('readonly', true);
                                        $("#party_phone_first").val(admin.phone).prop(
                                            'readonly', true);
                                        $("#party_email_first").val(admin.email).prop(
                                            'readonly', true);
                                    } else {
                                        $('#association_admin_id').empty().append(
                                            `<option value="">{{ trns('no_admin_found') }}</option>`
                                        );
                                    }
                                },
                                error: function() {
                                    $('#association_admin_id').empty().append(
                                        `<option value="">{{ trns('error_loading_admin') }}</option>`
                                    );
                                }
                            });
                        } else {
                            $("#association_admin_id").empty().append(
                                '<option value="">{{ trns('select_admin') }}</option>'
                            );
                        }

                        // ------------------------------
                        // ✅ Load audience number (optional)
                        // ------------------------------
                        $.ajax({
                            url: "{{ route('getUserByAssociation', ':id') }}".replace(':id',
                                associationId),
                            type: "GET",
                            dataType: "json",
                            success: function(response) {
                                if (response.count) {
                                    $audienceNumber.val(response.count);
                                }
                            },
                            error: function(xhr) {
                                console.error("Error loading audience number:", xhr
                                    .responseText);
                            }
                        });
                    });
            }, 250);
        });





        // Handle add contract form submit
        $(document).on('click', '#contractStoreBtn', function(e) {
            e.preventDefault();

            // Clear previous validation errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            // Get the form using class instead of ID
            let form = $('.addContractForm')[0];
            let formData = new FormData(form);
            let url = $(form).attr('action'); // get form action URL dynamically

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#contractStoreBtn').html(
                        '<span class="spinner-border spinner-border-sm mr-2"></span> <span style="margin-left: 4px;">{{ trns('loading...') }}</span>'
                    ).attr('disabled', true);
                },
                success: function(data) {
                    $('#contractStoreBtn').html('{{ trns('create') }}').attr('disabled', false);

                    if (data.status === 200) {
                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('success') }}</span>',
                            imageUrl: '{{ asset('true.png') }}',
                            imageWidth: 80,
                            imageHeight: 80,
                            showConfirmButton: false,
                            timer: 2000
                        });

                        $('#editOrCreate').modal('hide');

                        $('#contractDataTable').DataTable().ajax.reload();

                        $('#meetingsUpdatebtn').html('{{ trns('update') }}').attr('disabled', false);

                    } else if (data.status === 405) {
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
                },
                error: function(xhr) {
                    $('#contractStoreBtn').html('{{ trns('create') }}').attr('disabled', false);

                    if (xhr.status === 500) {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('server_error') }}',
                            text: '{{ trns('internal_server_error') }}'
                        });
                    } else if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        // Clear previous validation messages and styles
                        $('.validation-error').text('');
                        $('.is-invalid').removeClass('is-invalid');

                        $.each(errors, function(field, messages) {
                            let message = messages[0];
                            let input = $('[name="' + field + '"]');

                            // Handle nested array names (dot notation → brackets)
                            if (!input.length && field.includes('.')) {
                                let nameWithBrackets = field.replace(/\.(\w+)/g, '[$1]');
                                input = $('[name="' + nameWithBrackets + '"]');
                            }

                            // Convert dot to underscore for error <p> id
                            let errorId = 'error_' + field.replace(/\./g, '_');

                            if (input.length) {
                                input.addClass('is-invalid');
                            }

                            // Fill the <p> tag with error text (if exists)
                            $('#' + errorId).text(message);
                        });

                        // Focus first field with error
                        let firstErrorField = Object.keys(errors)[0];
                        let firstInput = $('[name="' + firstErrorField + '"]');
                        if (!firstInput.length && firstErrorField.includes('.')) {
                            let nameWithBrackets = firstErrorField.replace(/\.(\w+)/g, '[$1]');
                            firstInput = $('[name="' + nameWithBrackets + '"]');
                        }
                        if (firstInput.length) {
                            firstInput.focus();
                        }

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('error') }}',
                            text: '{{ trns('something_went_wrong') }}'
                        });
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });



        // 

        // ===============================
        // 📌 update contract
        // ===============================

        $(document).on('click', '.editcontractBtn', function() {
            var id = $(this).data('id');
            var url = '{{ route('contracts.edit', ':id') }}'.replace(':id', id);

            $('#modal-body').html(loader);
            $('#editOrCreate').modal('show');
            $('#editOrCreate .modal-title').text('{{ trns('edit_meeting') }}');

            $(".modal-dialog").addClass("modal-xl");
            // Footer buttons
            $('#modal-footer').html(`
                <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('close') }}</button>
                    <button type="button" class="btn btn-one me-2" id="contractUpdateBTN" data-id="${id}">{{ trns('update') }}</button>
                </div>
            `);

            setTimeout(function() {
                $('#modal-body').load(url);
            }, 500);
        });


        $(document).on('click', '#contractUpdateBTN', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            var form = $('.contract_form');
            var formData = new FormData(form[0]);
            formData.append("_method", "PUT");
            var url = '{{ route('contracts.update', ':id') }}'.replace(':id', id);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#contractUpdateBTN').html(
                            '<span class="spinner-border spinner-border-sm mr-2"></span> {{ trns('loading...') }}'
                        )
                        .attr('disabled', true);
                },
                success: function(data) {
                    Swal.fire({
                        title: '{{ trns('updated_successfully') }}',
                        icon: 'success',
                        timer: 1000,
                        showConfirmButton: false
                    });
                    $('#editOrCreate').modal('hide');
                    $('#contractDataTable').DataTable().ajax.reload();
                    // setTimeout(function() {
                    //     window.location.reload(); // ✅ fixed typo here
                    // }, 1000);
                    $(".modal-dialog").addClass("modal-lg");

                    $('#contractUpdateBTN').html('{{ trns('update') }}').attr('disabled', false);
                },

                error: function(xhr) {
                    $(".modal-dialog").addClass("modal-lg");
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, messages) {
                            messages.forEach(msg => toastr.error(msg));
                        });
                    } else {
                        toastr.error('{{ trns('something_went_wrong') }}');
                    }
                    $('#contractUpdateBTN').html('{{ trns('update') }}').attr('disabled', false);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });




        // delete contract
        $(document).ready(function() {
            $('#delete_modal').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let id = button.data('id');
                let title = button.data('title');

                $('#delete_id').val(id);
                $('#title').text(title);
            });

            $('#delete_btn').on('click', function() {
                let id = $('#delete_id').val();
                let routeOfDelete = "{{ route('contracts.destroy', ':id') }}".replace(':id', id);

                $.ajax({
                    type: 'DELETE',
                    url: routeOfDelete,
                    data: {
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        if (data.status === 200) {
                            // إغلاق المودال
                            let modal = bootstrap.Modal.getInstance(document.getElementById(
                                'delete_modal'));
                            modal.hide();

                            // إشعار بالنجاح
                            Swal.fire({
                                title: '{{ trns('deleted_successfully') }}',
                                icon: 'success',
                                timer: 800,
                                showConfirmButton: false
                            });

                            $('#contractDataTable').DataTable().ajax.reload();

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ trns('Deletion failed') }}',
                                text: data.message ||
                                    '{{ trns('Something went wrong') }}'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('Error') }}',
                            text: xhr.responseJSON?.message ||
                                '{{ trns('Something went wrong') }}'
                        });
                    }
                });
            });
        });


        /* =========================
        /* =========================
        /* =========================
        /* =========================
        /* =========================
        /* =========================
        /* =========================
        /* =========================



        /* =========================
        /* =========================
        🟢 ADD MEETING SECTION
        ========================== */
        $(document).on('click', '.addMeetingBtn', function() {
            $('#modal-body').html(loader);
            $('#editOrCreate').modal('show');

            $('#modal-footer').html(`
                <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two" data-bs-dismiss="modal">
                        {{ trns('close') }}
                    </button>
                    <button type="submit" class="btn btn-one me-2" id="addMeetingBtn">
                        {{ trns('create') }}
                    </button>
                </div>
            `);

            // Load the meeting creation form
            setTimeout(function() {
                $('#modal-body').load("{{ route('meetings.create') }}", function() {
                    const $associationSelect = $(".addMeetingForm #association_id");
                    const $usersSelect = $(".addMeetingForm #users_id");
                    const $adminName = $(".addMeetingForm #admin_name");
                    const $ownerId = $(".addMeetingForm #owner_id");

                    /**
                     * 🔹 Function: Load users by association
                     */
                    function loadUsersByAssociation(associationId) {
                        if (!associationId) return;

                        $.ajax({
                            url: '{{ route('getUserMeetByAssociation', ':id') }}'.replace(
                                ':id', associationId),
                            type: 'GET',
                            beforeSend: function() {
                                $usersSelect.html(
                                    '<option disabled selected>{{ trns('loading_users') }}...</option>'
                                );
                            },
                            success: function(response) {
                                $usersSelect.empty();

                                if (response.users && response.users.length > 0) {
                                    $.each(response.users, function(index, user) {
                                        $usersSelect.append(new Option(user
                                            .name, user.id));
                                    });
                                } else {
                                    $usersSelect.append(
                                        '<option disabled>{{ trns('no_users_found') }}</option>'
                                    );
                                }

                                $usersSelect.trigger('change');
                            },
                            error: function() {
                                $usersSelect.html(
                                    '<option disabled>{{ trns('error_loading_users') }}</option>'
                                );
                            }
                        });
                    }

                    /**
                     * 🔹 Function: Load owner/admin by association
                     */
                    function loadOwnerByAssociation(associationId) {
                        if (!associationId) {
                            $adminName.val('');
                            $ownerId.val('');
                            return;
                        }

                        $.ajax({
                            url: "{{ route('meetings.getOwners', ':id') }}".replace(':id',
                                associationId),
                            type: 'GET',
                            success: function(response) {
                                if (response.status === 200 && response.user) {
                                    $adminName.val(response.user.name);
                                    $ownerId.val(response.user.id);
                                } else {
                                    $adminName.val('');
                                    $ownerId.val('');
                                    alert("{{ trns('no_admin_found') }}");
                                }
                            },
                            error: function() {
                                $adminName.val('');
                                $ownerId.val('');
                                alert("{{ trns('failed_to_load_user') }}");
                            }
                        });
                    }

                    /**
                     * 🔹 Manual association change
                     */
                    $associationSelect.on('change', function() {
                        const associationId = {{ $obj->id }};
                        loadUsersByAssociation(associationId);
                        loadOwnerByAssociation(associationId);
                    });

                    /**
                     * 🔹 Auto set association from index and trigger both requests
                     */
                    @if (isset($obj) && isset($obj->id))
                        const associationId = {{ $obj->id }};
                        $associationSelect.val(associationId).trigger('change');

                        // 🟢 Disable visually + add hidden field for request
                        $associationSelect.prop('disabled', true);
                        if ($('.addMeetingForm input[name="association_id_hidden"]').length === 0) {
                            $('<input>').attr({
                                type: 'hidden',
                                name: 'association_id',
                                value: associationId
                            }).appendTo('.addMeetingForm');
                        }

                        // Load related data
                        loadUsersByAssociation(associationId);
                        loadOwnerByAssociation(associationId);
                    @endif
                });
            }, 250);
        });



        // Handle add meeting form submit
        $(document).on('click', '#addMeetingBtn', function(e) {
            e.preventDefault();

            // Clear previous validation errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            // Get the form using class instead of ID
            let form = $('.addMeetingForm')[0];
            let formData = new FormData(form);
            let url = $(form).attr('action'); // get form action URL dynamically

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#addMeetingBtn').html(
                        '<span class="spinner-border spinner-border-sm mr-2"></span> <span style="margin-left: 4px;">{{ trns('loading...') }}</span>'
                    ).attr('disabled', true);
                },
                success: function(data) {
                    $('#addMeetingBtn').html('{{ trns('create') }}').attr('disabled', false);

                    if (data.status === 200) {
                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('success') }}</span>',
                            imageUrl: '{{ asset('true.png') }}',
                            imageWidth: 80,
                            imageHeight: 80,
                            showConfirmButton: false,
                            timer: 2000
                        });

                        $('#editOrCreate').modal('hide');

                        $('#MeetingDataTable').DataTable().ajax.reload();

                        $('#meetingsUpdatebtn').html('{{ trns('update') }}').attr('disabled', false);

                    } else if (data.status === 405) {
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
                },
                error: function(xhr) {
                    $('#addMeetingBtn').html('{{ trns('create') }}').attr('disabled', false);

                    if (xhr.status === 500) {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('server_error') }}',
                            text: '{{ trns('internal_server_error') }}'
                        });
                    } else if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            let input = $('[name="' + field + '"]');
                            input.addClass('is-invalid');
                            input.after('<div class="invalid-feedback">' + messages[0] +
                                '</div>');
                        });
                        let firstErrorField = Object.keys(errors)[0];
                        $('[name="' + firstErrorField + '"]').focus();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('error') }}',
                            text: '{{ trns('something_went_wrong') }}'
                        });
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    </script>











    <script>
        // ===============================
        // 📌 show datatable for votes
        // ===============================
        document.addEventListener("DOMContentLoaded", function() {
            let association_id = {{ $obj->id ?? 'null' }};

            // Summary table
            let summaryColumns = [{
                    data: "id",
                    name: "id"
                },
                {
                    data: 'association_id',
                    name: 'association_id',

                }
                // ,
                // {
                //     data: 'title',
                //     name: 'title',

                // },
                // {
                //     data: 'description',
                //     name: 'description',

                // }
                , {
                    data: "created_at",
                    name: "created_at"
                },
                {
                    data: "start_date",
                    name: "start_date"
                }, {
                    data: "end_date",
                    name: "end_date"
                }, {
                    data: "owners_number",
                    name: "owners_number"
                }, {
                    data: "audience_number",
                    name: "audience_number"
                }, {
                    data: "unVoted",
                    name: "unVoted"
                },
                {
                    data: "status",
                    name: "status"
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];
            showVoteDataTable(null, '{{ route('votes.index') }}', summaryColumns, 0, 3, association_id);


            // ===============================
            // 📌 doube functions for votes
            // ===============================
            async function showVoteDataTable(showRoute, routeOfShow, columns, orderByColumn = 0, showCol = 3,
                association_id = null) {
                let table = $('#voteDataTable').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: {
                        url: routeOfShow,
                        data: function(d) {
                            if (association_id) d.association_id = association_id;
                        }
                    },
                    columns: columns,
                    order: [
                        [orderByColumn ? orderByColumn : 0, "DESC"]
                    ],
                    createdRow: function(row, data) {
                        $(row).attr('data-id', data.id).addClass('clickable-row');
                    },
                    language: {
                        sProcessing: "{{ trns('processing...') }}",
                        sLengthMenu: "{{ trns('show') }} _MENU_ {{ trns('records') }}",
                        sZeroRecords: "{{ trns('no_records_found') }}",
                        sInfo: "{{ trns('showing') }} _START_ {{ trns('to') }} _END_ {{ trns('of') }} _TOTAL_ {{ trns('records') }}",
                        sInfoEmpty: "{{ trns('showing') }} 0 {{ trns('to') }} 0 {{ trns('of') }} 0 {{ trns('records') }}",
                        sInfoFiltered: "({{ trns('filtered_from') }} _MAX_ {{ trns('total_records') }})",
                        sSearch: "{{ trns('search') }} :    ",
                        oPaginate: {
                            sPrevious: "{{ trns('previous') }}",
                            sNext: "{{ trns('next') }}",
                        },
                        buttons: {
                            copyTitle: '{{ trns('copied') }} <i class="fa fa-check-circle text-success"></i>',
                            copySuccess: {
                                1: "{{ trns('copied') }} 1 {{ trns('row') }}",
                                _: "{{ trns('copied') }} %d {{ trns('rows') }}"
                            },
                        }
                    },
                });

                if (showRoute) {
                    $('#voteDataTable tbody').on('click', `tr td:nth-child(${showCol})`, function(e) {
                        if ($(e.target).is('input, button, a, .delete-checkbox, .editBtn, .statusBtn'))
                            return;
                        let id = $(this).closest('tr').data('id');
                        if (id) window.location.href = showRoute.replace(':id', id);
                    });
                }
            }
        });



        //     // ===============================
        //         // 📌 update vote
        //     // ===============================

        $(document).on('click', '.editVoteBtn', function() {
            var id = $(this).data('id');
            var url = '{{ route('votes.edit', ':id') }}'.replace(':id', id);

            $('#modal-body').html(loader);
            $('#editOrCreate').modal('show');
            $('#editOrCreate .modal-title').text('{{ trns('edit_vote') }}');

            // Footer buttons
            $('#modal-footer').html(`
                    <div class="w-100 d-flex">
                        <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('close') }}</button>
                        <button type="button" class="btn btn-one me-2" id="voteupdatebtn" data-id="${id}">{{ trns('update') }}</button>
                    </div>
                `);

            setTimeout(function() {
                $('#modal-body').load(url, function() {

                    const $form = $('.addVoteForm');
                    const $associationSelect = $form.find('#association_id');
                    const $audienceNumber = $form.find('#audience_number');

                    // 🟢 اجلب القيمة الحالية من السيرفر أو من الفورم
                    const associationId = ${{ $obj->id }};

                    /**
                     * 🔹 تأمين الـ select بحيث ما يتغيرش، بس القيمة تتبعت
                     */
                    if (associationId) {
                        // نغلقه شكلياً
                        $associationSelect.css({
                            'pointer-events': 'none',
                            'background-color': '#e9ecef',
                            'opacity': '0.8'
                        });

                        // نضيف hidden input بنفس الاسم عشان القيمة تتبعت
                        if ($form.find('input[name="association_id"]').length === 0) {
                            $('<input>').attr({
                                type: 'hidden',
                                name: 'association_id',
                                value: associationId
                            }).appendTo($form);
                        }

                        /**
                         * 🔹 جلب عدد الحضور (audience_number)
                         */
                        $.ajax({
                            url: "{{ route('getUserByAssociation', ':id') }}".replace(
                                ':id', associationId),
                            type: "GET",
                            dataType: "json",
                            success: function(response) {
                                if (response.count) {
                                    $audienceNumber.val(response.count);
                                } else {
                                    $audienceNumber.val('');
                                }
                            },
                            error: function() {
                                $audienceNumber.val('');
                            }
                        });
                    }

                });
            }, 500);
        });



        $(document).on('click', '#voteupdatebtn', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            var form = $('.votes_update_form');
            var formData = new FormData(form[0]);
            formData.append("_method", "PUT");
            var url = '{{ route('votes.update', ':id') }}'.replace(':id', id);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#voteupdatebtn').html(
                            '<span class="spinner-border spinner-border-sm mr-2"></span> {{ trns('loading...') }}'
                        )
                        .attr('disabled', true);
                },
                success: function(data) {
                    Swal.fire({
                        title: '{{ trns('updated_successfully') }}',
                        icon: 'success',
                        timer: 1000,
                        showConfirmButton: false
                    });
                    $('#editOrCreate').modal('hide');
                    // setTimeout(function() {
                    //     window.location.reload(); // ✅ fixed typo here
                    // }, 1000);
                    $('#voteDataTable').DataTable().ajax.reload();

                    $('#voteupdatebtn').html('{{ trns('update') }}').attr('disabled', false);
                },

                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, messages) {
                            messages.forEach(msg => toastr.error(msg));
                        });
                    } else {
                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('error') }}</span>',
                            imageUrl: '{{ asset('true.png') }}',
                            imageWidth: 80,
                            imageHeight: 80,
                            imageAlt: 'error',
                            showConfirmButton: false,
                            timer: 700,
                            customClass: {
                                image: 'swal2-image-mt30'
                            }
                        });
                    }
                    $('#voteupdatebtn').html('{{ trns('update') }}').attr('disabled', false);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });



        //     // ===============================
        //         // 📌 handle delete meeting
        //     // ===============================

        initCantDeleteModalHandler();
        $(document).ready(function() {

            //
            $(document).on('click', '#voteDeleteBtn', function() {
                var id = $(this).data('id');
                $('#delete_id').val(id);
                $('#delete_modal_vote_of_show').modal('show');
            });


            $(document).on('click', '#delete_button_vote_of_show', function() {
                var id = $("#delete_id").val();
                var routeOfDelete = "{{ route('votes.destroy', ':id') }}".replace(':id', id);

                $.ajax({
                    type: 'DELETE',
                    url: routeOfDelete,
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'id': id
                    },
                    success: function(data) {
                        if (data.status === 200) {
                            $('#delete_modal_vote_of_show').modal('hide');

                            Swal.fire({
                                title: '<span style="margin-bottom: 50px; display: block;">{{ trns('success') }}</span>',
                                imageUrl: '{{ asset('true.png') }}',
                                imageWidth: 80,
                                imageHeight: 80,
                                imageAlt: 'Success',
                                showConfirmButton: false,
                                timer: 700,
                                customClass: {
                                    image: 'swal2-image-mt30'
                                }
                            });
                            $('#voteDataTable').DataTable().ajax.reload();

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

        });




        //     /* =========================
        //     🟢 ADD vote SECTION
        //     ========================== */
        $(document).on('click', '.addVoteBtn', function() {
            $('#modal-body').html(loader);
            $('#editOrCreate').modal('show');

            $('#modal-footer').html(`
                        <div class="w-100 d-flex">
                            <button type="button" class="btn btn-two" data-bs-dismiss="modal">
                                {{ trns('close') }}
                            </button>
                            <button type="submit" class="btn btn-one me-2" id="addVoteBtn">
                                {{ trns('create') }}
                            </button>
                        </div>
                    `);

            setTimeout(function() {
                $('#modal-body').load("{{ route('votes.create') }}", function() {
                    // بعد تحميل الفورم بالكامل
                    const $associationSelect = $(".addVoteForm #association_id");
                    const $audienceNumber = $(".addVoteForm #audience_number");

                    // نحط id من الobject
                    const associationId = {{ $obj->id }};

                    // نخلي select disabled
                    $associationSelect.val(associationId).prop('disabled', true);

                    // نضيف hidden input عشان القيمة تتبعت مع الفورم
                    if ($('.addVoteForm input[name="association_id_hidden"]').length === 0) {
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'association_id',
                            value: associationId
                        }).appendTo('.addVoteForm');
                    }

                    // نجيب audience number
                    $.ajax({
                        url: "{{ route('getUserByAssociation', ':id') }}".replace(':id',
                            associationId),
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            if (response.count) {
                                $audienceNumber.val(response.count);
                            }
                        },
                        error: function(xhr) {
                            console.error("Error loading audience number:", xhr
                                .responseText);
                        }
                    });
                });
            }, 250);
        });


        $(document).on('click', '#addVoteBtn', function(e) {
            e.preventDefault();

            // Clear previous validation errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            // Get the form using class instead of ID
            let form = $('.addVoteForm')[0];
            let formData = new FormData(form);
            let url = $(form).attr('action'); // get form action URL dynamically

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#addVoteBtn').html(
                        '<span class="spinner-border spinner-border-sm mr-2"></span> <span style="margin-left: 4px;">{{ trns('loading...') }}</span>'
                    ).attr('disabled', true);
                },
                success: function(data) {
                    $('#addVoteBtn').html('{{ trns('create') }}').attr('disabled', false);

                    if (data.status === 200) {
                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('success') }}</span>',
                            imageUrl: '{{ asset('true.png') }}',
                            imageWidth: 80,
                            imageHeight: 80,
                            showConfirmButton: false,
                            timer: 2000
                        });

                        $('#editOrCreate').modal('hide');

                        $('#voteDataTable').DataTable().ajax.reload();

                        $('#addVoteBtn').html('{{ trns('update') }}').attr('disabled', false);

                    } else if (data.status === 405) {
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
                },
                error: function(xhr) {
                    $('#addVoteBtn').html('{{ trns('create') }}').attr('disabled', false);

                    if (xhr.status === 500) {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('server_error') }}',
                            text: '{{ trns('internal_server_error') }}'
                        });
                    } else if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            let input = $('[name="' + field + '"]');
                            input.addClass('is-invalid');
                            input.after('<div class="invalid-feedback">' + messages[0] +
                                '</div>');
                        });
                        let firstErrorField = Object.keys(errors)[0];
                        $('[name="' + firstErrorField + '"]').focus();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('error') }}',
                            text: '{{ trns('something_went_wrong') }}'
                        });
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });







        // status and revote for votes 
        $(document).on('click', '.toggleVoteStatusBtn', function(e) {
            e.preventDefault();

            let id = $(this).data('id');
            let currentStatus = parseInt($(this).data('status'));
            let newStatus = currentStatus === 1 ? 0 : 1;

            $.ajax({
                type: 'POST',
                url: '{{ route('votes.updateColumnSelected') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'ids': [id],
                    'status': newStatus
                },
                success: function(data) {
                    if (data.status === 200) {
                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('status_updated_successfully') }}</span>',
                            imageUrl: '{{ asset('true.png') }}',
                            imageWidth: 80,
                            imageHeight: 80,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#voteDataTable').DataTable().ajax.reload();
                    } else {
                        toastr.error("{{ trns('something_went_wrong') }}");
                    }
                },
                error: function() {
                    toastr.error("{{ trns('something_went_wrong') }}");
                }
            });
        });





        //  revoting js 
        {{--        show revote modal --}}
        var routeRevoteShow = "{{ route('votes.revoteShow', ':id') }}";

        $(document).on('click', '.revote_btn', function() {
            var id = $(this).data('id');
            var url = routeRevoteShow.replace(':id', id);

            $('#modal-body').html(loader); // loader
            $('#editOrCreate').modal('show');

            if (typeof titleModal !== 'undefined' && titleModal != null) {
                $('#modalTitle').text(titleModal);
            }

            $('#modal-footer').html(`
                    <div class="w-100 d-flex">
                        <button type="button" class="btn btn-two" data-bs-dismiss="modal"><?php echo e(trns('close')); ?></button>
                        <button type="submit" class="btn btn-one me-2" id="revoteButton"><?php echo e(trns('revote')); ?></button>
                    </div>
                `);

            $('#modal-body').load(url);
        });




        // //     revote store script
        $(document).on('click', '#revoteButton', function(e) {
            e.preventDefault();
            const form = $('#revote_form')[0];
            const url = @json(route('votes.revote.revoting'));
            const formData = new FormData(form);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#updateButton')
                        .html('<span class="spinner-border spinner-border-sm me-2"></span>' +
                            '<span style="margin-left:4px;"><?php echo e(trns('loading...')); ?></span>')
                        .attr('disabled', true);
                },
                success: function(data) {
                    $('#revoteButton').html(`<?php echo e(trns('update')); ?>`).attr('disabled', false);

                    if (data.status === 200) {
                        $('#editOrCreate').modal('hide').on('hidden.bs.modal', function() {
                            $('#modal-body').html('');
                        });


                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('status_updated_successfully') }}</span>',
                            imageUrl: '{{ asset('true.png') }}',
                            imageWidth: 80,
                            imageHeight: 80,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#voteDataTable').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '<?php echo e(trns('something_went_wrong')); ?>'
                        });
                    }

                },
                error: function(data) {
                    $('#revoteButton').html(`<?php echo e(trns('update')); ?>`).attr('disabled', false);

                    if (data.status === 500) {
                        Swal.fire({
                            icon: 'error',
                            title: '<?php echo e(trns('something_went_wrong')); ?>'
                        });
                    } else if (data.status === 422) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors.errors, function(key, value) {
                            $('#' + key).next('.invalid-feedback').remove();
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).after('<div class="invalid-feedback">' + value[0] +
                                '</div>');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '<?php echo e(trns('something_went_wrong')); ?>'
                        });
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    </script>















































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
        deleteScriptInShow("{{ route('associations.destroy', ':id') }}");
    </script>

    <script>
        $(function() {

            'use strict';
            $('.tabs-list li').on('click', function() {

                $(this).addClass('show').siblings().removeClass('show');

                $('.content-list > div').hide();

                $($(this).data('content')).fadeIn();
            });

        });
    </script>



    <script>
        $(document).on('click', '.association_show_edit', function() {
            var id = $(this).data('id')
            var url = '{{ route($editRoute . '.edit', ':id') }}';
            url = url.replace(':id', id)
            $('#modal-body').html(loader)
            $('#editOrCreate').modal('show');
            $('#editOrCreate .modal-title').text('تعديل الجمعية');

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
                $('#modal-body').load(url)
            }, 500)
        })
        editScript();


        {{-- update associations --}}

        $(document).on('submit', '.association_update_form', function(e) {

            e.preventDefault();
            var formData = new FormData(this);
            var id = $(this).data('id');
            var url = '{{ route('associations.update', ':id') }}'.replace(':id', id);
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
                    if (data.status == 200) {
                        toastr.success('{{ trns('added_successfully') }}');
                        if (data.redirect_to) {
                            setTimeout(function() {
                                window.location.href = data.redirect_to;
                            }, 2000);
                        } else {
                            $('#editOrCreate').modal('hide');
                            window.location.reload();
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

        {{-- end or updatea and edit --}}



        $(document).on('click', '.editUnitsBtn', function() {
            var id = $(this).data('id')
            var url = '{{ route('units.edit', ':id') }}';
            url = url.replace(':id', id)
            $('#modal-body').html(loader)
            $('#editOrCreate').modal('show');
            $('#editOrCreate .modal-title').text('تعديل الوحدة');
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
                $('#modal-body').load(url)
            }, 500)
        })


        $(document).on('submit', '.units_update_form', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            var id = $(this).data('id');
            var url = '{{ route('units.update', ':id') }}'.replace(':id', id);
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

        {{-- edit realstate --}}
        $(document).on('click', '.editRealStateBtn', function() {
            var id = $(this).data('id')
            var url = '{{ route('real_states.edit', ':id') }}';
            url = url.replace(':id', id)
            $('#modal-body').html(loader)
            $('#editOrCreate').modal('show');
            $('#editOrCreate .modal-title').text('تعديل العقار');
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
                $('#modal-body').load(url)
            }, 500)
        })


        $(document).on('submit', '.real_state_update_form', function(e) {

            e.preventDefault();
            var formData = new FormData(this);
            var id = $(this).data('id');
            var url = '{{ route('real_states.update', ':id') }}'.replace(':id', id);
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

        {{-- edn the update --}}

        {{-- the status for realState --}}
        $(document).on('click', '.toggleRealStateStatusBtn', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let currentStatus = $(this).data('status');
            let newStatus = currentStatus === 1 ? 0 : 1;

            $.ajax({
                type: 'POST',
                url: '{{ route('real_states.updateColumnSelected') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'ids': [id],
                    'status': newStatus
                },
                success: function(data) {
                    if (data.status === 200) {
                        toastr.success("{{ trns('status_changed_successfully') }}");
                        $('#realStatesTable').DataTable().ajax.reload(null, false);
                    } else {
                        toastr.error("{{ trns('something_went_wrong') }}");
                    }
                },
                error: function() {
                    toastr.error("{{ trns('something_went_wrong') }}");
                }
            });
        });
        {{-- user toggle status  --}}
        $(document).on('click', '.toggleUserStatusBtn', function(e) {
            e.preventDefault();

            let id = $(this).data('id');
            let currentStatus = parseInt($(this).data('status'));
            let newStatus = currentStatus === 1 ? 0 : 1;

            $.ajax({
                type: 'POST',
                url: "{{ route('users.updateColumnSelected') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'ids': [id],
                    'status': newStatus
                },
                success: function(data) {
                    if (data.status === 200) {
                        toastr.success("{{ trns('status_changed_successfully') }}");
                        $('#bulk-delete').prop('disabled', "false");
                        $('#bulk-update').prop('disabled', "false");
                        $('#select-all').prop('checked', "false");


                        $('#dataTable').DataTable().ajax.reload(null, false);
                    } else {
                        toastr.error("{{ trns('something_went_wrong') }}");
                    }
                },
                error: function() {
                    toastr.error("{{ trns('something_went_wrong') }}");
                }
            });
        });


        {{-- the status for units --}}
        $(document).on('click', '.toggleUnitsStatusBtn', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let currentStatus = $(this).data('status');
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
                        toastr.success("{{ trns('status_changed_successfully') }}");
                        $('#unitsTable').DataTable().ajax.reload(null, false);
                    } else {
                        toastr.error("{{ trns('something_went_wrong') }}");
                    }
                },
                error: function() {
                    toastr.error("{{ trns('something_went_wrong') }}");
                }
            });
        });


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

            // Update input fields when marker is dragged
            {{-- marker.on('dragend', function(e) {
                const {
                    lat,
                    lng
                } = marker.getLatLng();
                document.getElementById('lat').value = lat.toFixed(6);
                document.getElementById('long').value = lng.toFixed(6);
            }); --}}

            // Update marker when map is clicked
            {{-- map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                document.getElementById('lat').value = e.latlng.lat.toFixed(6);
                document.getElementById('long').value = e.latlng.lng.toFixed(6);
            }); --}}

            // Update marker when inputs are changed
            {{-- function updateMarkerFromInputs() {
                const lat = parseFloat(document.getElementById('lat').value);
                const lng = parseFloat(document.getElementById('long').value);

                if (!isNaN(lat) && !isNaN(lng)) {
                    const latlng = [lat, lng];
                    marker.setLatLng(latlng);
                    map.panTo(latlng);
                }
            } --}}

            {{-- document.getElementById('lat').addEventListener('input', updateMarkerFromInputs);
            document.getElementById('long').addEventListener('input', updateMarkerFromInputs); --}}
        });
    </script>


    {{-- file js  --}}




    <script>
        function openFileModal(fileUrl) {
            const modal = document.getElementById('fileModal');
            const iframe = document.getElementById('fileFrame');
            const fallback = document.getElementById('fileFallback');
            const downloadButton = document.getElementById('downloadButton');

            const ext = fileUrl.split('.').pop().toLowerCase();

            iframe.src = '';

            if (ext === 'pdf') {
                iframe.src = fileUrl;
                iframe.style.display = 'block';
                fallback.style.display = 'none';
            } else if (['doc', 'docx', 'xls', 'xlsx'].includes(ext)) {
                const isOnline = fileUrl.startsWith('http') && !fileUrl.includes('127.0.0.1') && !fileUrl.includes(
                    'localhost');

                if (isOnline) {
                    iframe.src = `https://view.officeapps.live.com/op/embed.aspx?src=${encodeURIComponent(fileUrl)}`;
                    iframe.style.display = 'block';
                    fallback.style.display = 'none';
                } else {
                    iframe.style.display = 'none';
                    fallback.style.display = 'block';
                    fallback.innerHTML = `
                        <p>لا يمكن عرض هذا الملف في المعاينة.</p>
                        <a href="${fileUrl}" download class="btn btn-primary mt-2">تحميل الملف</a>
                    `;
                }
            } else {
                iframe.style.display = 'none';
                fallback.style.display = 'block';
                fallback.innerHTML = `
                    <p>لا يمكن عرض هذا النوع من الملفات.</p>
                    <a href="${fileUrl}" download class="btn btn-primary mt-2">تحميل الملف</a>
                `;
            }

            downloadButton.href = fileUrl;
            modal.style.display = 'block';
        }


        function closeFileModal() {
            const modal = document.getElementById('fileModal');
            const iframe = document.getElementById('fileFrame');

            modal.style.display = 'none';
            iframe.src = '';
        }
    </script>




    {{-- images js  --}}

    <script>
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
    </script>

    <script>
        $(document).on('click', '.toggleAssociationStatusBtn', function(e) {
            e.preventDefault();

            let id = $(this).data('id');
            let currentStatus = parseInt($(this).data('status'));
            let newStatus = currentStatus === 1 ? 0 : 1;

            $.ajax({
                type: 'POST',
                url: '{{ route('associations.updateColumnSelected') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'ids': [id],
                    'status': newStatus
                },
                success: function(data) {
                    if (data.status === 200) {
                        toastr.success("{{ trns('status_changed_successfully') }}");
                        window.location.reload();


                        $('#dataTable').DataTable().ajax.reload(null, false);
                    } else {
                        toastr.error("{{ trns('something_went_wrong') }}");
                    }
                },
                error: function() {
                    toastr.error("{{ trns('something_went_wrong') }}");
                }
            });
        });
    </script>



    @if ($obj->RealStates)
        <script>
            $(document).ready(function() {
                const associationId = '{{ $obj->id }}';

                $('#realStatesTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: `{{ route('association.real_states.show', ['id' => '__id__']) }}`.replace('__id__',
                        associationId),
                    columns: [{
                            data: 'id',
                            name: 'id',
                        }, {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'location',
                            name: 'location'
                        },
                        {
                            data: 'units_count',
                            name: 'units_count'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    searching: false,
                    language: {
                        url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json",
                    },
                    createdRow: function(row, data, dataIndex) {
                        $(row).attr('data-id', data.id);
                    }
                });
                $('#realStatesTable tbody').on('mouseenter', 'tr', function() {
                    $(this).css('cursor', 'pointer');
                });

                $('#realStatesTable tbody').on('click', 'td:eq(1)', function(e) {
                    let colIndex = $(this).index();
                    if (colIndex >= 1 && colIndex <= 4) {
                        if ($(e.target).is('input, button, a, .delete-checkbox, .editBtn, .statusBtn')) {
                            return;
                        }
                        let row = $(this).closest('tr');
                        let id = row.data('id');

                        let baseUrl = window.location.origin;
                        let finalUrl = `{{ route('real_states.show', ['real_state' => '__id__']) }}`.replace(
                            '__id__', id);
                        window.location.href = finalUrl;

                    }
                });

            });
        </script>

        <script>
            $(document).ready(function() {
                const associationId = '{{ $obj->id }}';

                $('#realStatesTableOwnerShip').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: `{{ route('association.real_statesOwwnerShip.show', ['id' => '__id__']) }}`.replace(
                        '__id__', associationId),
                    columns: [{
                            data: 'national_id',
                            render: function(data, type, row) {
                                return `
                                <button
                                    style="cursor:pointer;border:none;background-color:transparent;"
                                    class="copy-btn" title="Copy" data-copy="${data}">
                                        <i class="fa-regular fa-copy"></i>
                                    </button>
                                    <span class="copy-text">${data}</span>
                                `;
                            }
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            render: function(data, type, row) {
                                return `
                                <button
                                    style="cursor:pointer;border:none;background-color:transparent;"
                                    class="copy-btn" title="Copy" data-copy="${data}">
                                        <i class="fa-regular fa-copy"></i>
                                    </button>
                                    <span class="copy-text">${data}</span>
                                `;
                            }
                        },
                        {
                            data: 'actions',
                            name: 'actions'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        }
                    ],
                    searching: false,
                    lengthChange: false,
                    language: {
                        url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json",
                    },
                });
            });
        </script>
    @endif


    @if ($obj->RealStates)
        <script>
            $(document).ready(function() {
                const associationId = '{{ $obj->id }}';

                const table = $('#unitsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: `{{ route('association.units', ['association_id' => '__id__']) }}`.replace('__id__',
                        associationId),
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'unit_code',
                            name: 'unit_code'
                        },
                        {
                            data: 'unit_number',
                            name: 'unit_number'
                        },
                        {
                            data: 'real_state_owners_name',
                            name: 'real_state_owners_name'
                        },
                        {
                            data: 'real_state_number',
                            name: 'real_state_number'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    searching: false,
                    lengthChange: false,
                    language: {
                        url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json",
                    },
                    createdRow: function(row, data, dataIndex) {
                        $(row).attr('data-id', data.id);
                    }
                });

                // ✅ ضع الأحداث خارج الـ DataTable
                $('#unitsTable tbody').on('mouseenter', 'tr', function() {
                    $(this).css('cursor', 'pointer');
                });

                $('#unitsTable tbody').on('click', 'td', function(e) {
                    let colIndex = $(this).index();
                    if (colIndex >= 1 && colIndex <= 4) {
                        if ($(e.target).is('input, button, a, .delete-checkbox, .editBtn, .statusBtn')) {
                            return;
                        }
                        let row = $(this).closest('tr');
                        let id = row.data('id');

                        let finalUrl = `{{ route('units.show', ['unit' => '__id__']) }}`.replace(
                            '__id__', id);
                        window.location.href = finalUrl;
                    }
                });

                $(document).on('click', '.show-owners-btn', function() {
                    const ownersJson = $(this).attr('data-owners');
                    try {
                        const ownersData = JSON.parse(ownersJson);
                        const modalBody = $('#show_owners_body');
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
                            '<tr><td colspan="2" class="text-center text-danger">Error loading data</td></tr>'
                        );
                    }
                });
            });
        </script>


        <script>
            $(document).ready(function() {
                const associationId = '{{ $obj->id }}';

                $('#unitsTableOwnerShip').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: `{{ route('association.unitsTableOwnerShip.show', ['id' => '__id__']) }}`.replace(
                        '__id__', associationId),
                    columns: [{
                            data: 'national_id',
                            render: function(data, type, row) {
                                return `
                                <button
                                    style="cursor:pointer;border:none;background-color:transparent;"
                                    class="copy-btn" title="Copy" data-copy="${data}">
                                        <i class="fa-regular fa-copy"></i>
                                    </button>
                                    <span class="copy-text">${data}</span>
                                `;
                            }
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            render: function(data, type, row) {
                                return `
                                <button
                                    style="cursor:pointer;border:none;background-color:transparent;"
                                    class="copy-btn" title="Copy" data-copy="${data}">
                                        <i class="fa-regular fa-copy"></i>
                                    </button>
                                    <span class="copy-text">${data}</span>
                                `;
                            }
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'actions',
                            name: 'actions'
                        },
                    ],
                    searching: false,
                    lengthChange: false,
                    language: {
                        url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json",
                    },
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


            {{-- let id = $(this).data('id'); --}}

            {{-- $.ajax({ --}}
            {{--    type: 'POST', --}}
            {{--    url: '{{ route('associationImages.delete') }}', --}}
            {{--    data: { --}}
            {{--        "_token": "{{ csrf_token() }}", --}}
            {{--        'id': id --}}
            {{--    }, --}}
            {{--    success: function (data) { --}}
            {{--        if (data.status === 200) { --}}
            {{--            toastr.success("{{ trns('image_deleted_successfully') }}"); --}}
            {{--            window.location.reload(); --}}
            {{--        } else { --}}
            {{--            toastr.error("{{ trns('something_went_wrong') }}"); --}}
            {{--        } --}}
            {{--    }, --}}
            {{--    error: function () { --}}
            {{--        toastr.error("{{ trns('something_went_wrong') }}"); --}}
            {{--    } --}}
            {{-- }); --}}


            $(document).on('click', '.delete_file', function(e) {
                e.preventDefault();

                let id = $(this).data('id');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('associationfiles.delete') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': id
                    },
                    success: function(data) {
                        if (data.status === 200) {
                            toastr.success("{{ trns('image_deleted_successfully') }}");
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


            {{-- js for delete fiels --}}
            $(document).on('click', '.delete_img', function(e) {
                e.preventDefault();

                let id = $(this).data('id');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('associationfiles.delete') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': id
                    },
                    success: function(data) {
                        if (data.status === 200) {
                            toastr.success("{{ trns('image_deleted_successfully') }}");
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
        </script>
    @endif




    {{-- script to images datatable  --}}
    <script>
        $(document).ready(function() {
            const associationId = '{{ $obj->id }}';

            $('#imagesDatatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{ route('association.images.show', ['id' => '__id__']) }}`.replace(
                    '__id__', associationId),
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
    </script>
    <script>
        $(document).ready(function() {
            const associationId = '{{ $obj->id }}';

            $('#filesDatatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{ route('association.files.show', ['id' => '__id__']) }}`.replace(
                    '__id__', associationId),
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
    </script>
    <script>
        $(document).on('click', '.delete_img', function(e) {
            e.preventDefault();

            let id = $(this).data('id');

            $.ajax({
                type: 'POST',
                url: '{{ route('AssociationDeletefile.delete') }}',
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
        $(document).on('click', '.body-span-msg', function() {
            let body = $(this).data('body');
            Swal.fire({
                title: body,
                confirmButtonText: '{{ trns('close') }}',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const realStateBtn = document.getElementById('addRealState');
            const unitBtn = document.getElementById('addUnit');

            if (realStateBtn) {
                realStateBtn.addEventListener('click', function() {
                    showAddModalInShow('{{ route('real_states.createInShow') }}', {
                        association_id: {{ $obj->id }}
                    });
                });
            }

            if (unitBtn) {
                unitBtn.addEventListener('click', function() {
                    showAddModalInShow('{{ route('units.createInShow') }}', {
                        association_id: {{ $obj->id }}
                    });
                });
            }
        });
    </script>




    <script>
        // AJAX form submission
    </script>
@endsection
