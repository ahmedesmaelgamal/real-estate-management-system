@extends('admin/layouts/master')
@section('title')
    {{ config()->get('app.name') }} | {{ $obj->topic ?? "-" }}
@endsection
@section('page_name')
    {{ trns('court_case_management') . '/' . $obj->topic }}
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

        <div class="modal fade" id="editOrCreateCaseUpdate" data-backdrop="static" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">{{ trns('create_case_update') }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" id="caseUpdateTypeModalBody">
                        <!-- The form content will be loaded here -->
                    </div>

                    <div class="modal-footer" id="caseUpdateTypeModalFooter">
                        <!-- dynamic footer buttons -->
                    </div>

                </div>
            </div>
        </div>




        <!--Delete MODAL -->
        {{-- <div class="modal fade" id="delete_modal_meeting_of_show" tabindex="-1" role="dialog"
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
                        <button type="button" class="btn btn-one" id="delete_btn_of_show">{{ trns('delete') }}!
                        </button>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- MODAL CLOSED -->


        {{-- delete agenda modal --}}
        <div class="modal fade" id="delete_modal_of_agenda" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ trns('delete_agenda') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input id="delete_agenda_id" type="hidden">
                        <p>{{ trns('are_you_sure_you_want_to_delete_this_agenda') }}</p>
                        {{-- <p><strong id="agenda_title"></strong></p> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ trns('close') }}</button>
                        <button type="button" class="btn btn-danger"
                            id="deleteAgendaBtn">{{ trns('delete_agenda') }}</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Delete MODAL -->
        <div class="modal fade" id="delete_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ trns('delete') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <input id="delete_id" type="hidden">
                        <p>{{ trns('are_you_sure_you_want_to_delete_this_obj') }}
                            <span id="title" class="text-danger fw-bold"></span>؟
                        </p>
                    </div>

                    <div class="modal-footer d-flex flex-nowrap">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ trns('close') }}
                        </button>
                        <button type="button" class="btn btn-danger" id="delete_btn">
                            {{ trns('delete') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete MODAL END -->




        <div class="modal fade" id="delete_modal_of_summary" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ trns('delete') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input id="delete_summary_id" type="hidden">
                        <p>{{ trns('are_you_sure_you_want_to_delete_this_obj') }}</p>
                        <p><strong id="title"></strong></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ trns('close') }}</button>
                        <button type="button" class="btn btn-danger"
                            id="deleteSummaryBtn">{{ trns('delete') }}</button>
                    </div>
                </div>
            </div>
        </div>





        <div class="modal fade" id="delayMeetModel" data-backdrop="static" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ trns('delay_meet') }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                                        <input onclick="this.showPicker()" type="datetime-local" name="date"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">{{ trns('save') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>





        <div class="col-md-12 col-lg-12">
            <div class="">


                <div class="" style="padding: 15px ; padding-bottom: 60px">


                    <div class="d-flex justify-content-between row">
                        <div class="col-6">
                            <h2>{{ trns('show_court_case') }}</h2>
                        </div>

                        <div class="col-6 d-flex justify-content-end">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle m-2" type="button"
                                    id="dropdownMenuButton{{ $obj->id }}" data-bs-toggle="dropdown"
                                    aria-expanded="false" style="background-color: #00193a; color: #00F3CA;">
                                    {{ trns('options') }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $obj->id }}"
                                    style="background-color: #EAEAEA;">
                                    <li>
                                        <a class="dropdown-item editCourtCaseBtn" href="javascript:void(0);"
                                            data-id="{{ $obj->id }}">
                                            <img src="{{ asset('edit.png') }}" alt="no-icon" class="img-fluid ms-1"
                                                style="width: 24px; height: 24px;">
                                            {{ trns('Edit') }}
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a class="dropdown-item" href="{{ route('meetings.download', $obj->id) }}"
                                            data-id="{{ $obj->id }}">
                                            {{ trns('download') }} 1
                                        </a>
                                    </li> --}}
                                    <li>
                                        <a class="dropdown-item openStatusModel toggleRealStatesStatusBtn"
                                            href="javascript:void(0);" data-id="{{ $obj->id }}"
                                            data-status="{{ $obj->status }}">
                                            {{ $obj->status == 1 ? trns('Deactivate_court_case') : trns('Activate_court_case') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger" style="cursor: pointer;"
                                            data-bs-toggle="modal" data-bs-target="#delete_modal_of_show"
                                            data-id="{{ $obj->id }}" data-title="{{ $obj->name }}">
                                            <i class="fas fa-trash me-1"></i> {{ trns('delete') }}
                                        </a>
                                    </li>
                                </ul>

                                <a href="{{ route('court_case.index') }}" class="btn"
                                    style="transform: rotate(180deg); border: 1px solid gray; padding: 6px 11px;">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>



                    <div class="tab-content mt-4 mb-0">
                        <div id="tab1" class="active">
                            <div class="tab-pane fade show active" id="basic-info" role="tabpanel">
                                <div class="show-content mt-3"
                                    style="border-radius: 6px;
                                    background-color: #fbf9f9;
                                    border: 1px solid #ddd;
                                    padding: 15px;">
                                    <h4 style="font-weight: bold; color: #00193a;">
                                        {{ trns('basic_information_of_court_case') }}</h4>
                                    <!-- <h4>{{ $obj->case_number ?? trns('N/A') }}</h4> -->
                                    <hr style="background-color: black;">
                                    <div class="row m-4">


                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('judiciaty_type') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->judiciatyType ? $obj->judiciatyType->getTranslation('title', app()->getLocale()) : trns('N/A') }}
                                            </p>
                                        </div>

                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('case_type') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->caseType->getTranslation('title', app()->getLocale()) ?? trns('N/A') }}
                                            </p>
                                        </div>

                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('case_number') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->case_number ?? trns('N/A') }}</p>
                                        </div>

                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('Created At') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ ($obj->created_at ? $obj->created_at->format('Y-m-d') : trns('N/A')) }}</p>
                                        </div>

                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('case_date') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->case_date ?? trns('N/A') }}</p>
                                        </div>

                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('association') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->association->LocalizedName ?? trns('N/A') }}</p>
                                        </div>

                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('owner') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->owner->name ?? trns('N/A') }}</p>
                                        </div>

                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('unit') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->unit->unit_number ?? trns('N/A') }}</p>
                                        </div>

                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('case_price') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->case_price ?? trns('N/A') }}</p>
                                        </div>

                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('judiciaty date') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->judiciaty_date ?? trns('N/A') }}</p>
                                        </div>

                                        <div class="col-3 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('case_topic') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->topic ?? trns('N/A') }}</p>
                                        </div>

                                        <div class="col-12">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('case_description') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->description ?? trns('N/A') }}</p>
                                        </div>


                                    </div>

                                </div>

                            </div>


                            <div class="tab-content mt-4 mb-0">
                                <div id="tab1" class="active">
                                    <div class="tab-pane fade show active" id="basic-info" role="tabpanel">
                                        <div class="show-content mt-3"
                                            style="border-radius: 6px;
                                                background-color: #fbf9f9;
                                                border: 1px solid #ddd;
                                                padding: 15px;">

                                            <div class="row align-items-center">
                                                <h4 class="col-6" style="font-weight: bold; color: #00193a;">
                                                    {{ trns('court_case_updates') }}
                                                </h4>

                                                
                                                <div class="col-6 d-flex justify-content-end">
                                                    
                                                    <button id="createCaseUpdate" class="btn btn-primary">
                                                        <i class="fe fe-plus" style="font-size: 16px; margin-right: 4px;color:#ffffff !important;"></i>
                                                        {{ trns('create_case_update') }}
                                                    </button>
                                                </div>
                                            </div>

                                            <hr style="background-color: black;">

                                            <div class="row m-4">

                                                @foreach ($obj->caseUpdates as $caseUpdate)
                                                    <div class="col-12 mb-4">

                                                        <div class="p-4 rounded"
                                                            style="background: #f7f7f7; border: 1px solid #e3e3e3;">

                                                            {{-- Header: user + badge + date --}}
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-3">

                                                                <div class="d-flex align-items-center">
                                                                    <img src="{{ asset('assets/avatar.png') }}"
                                                                        class="rounded-circle me-2" width="45"
                                                                        height="45" alt="user">
                                                                    <div style="margin-right: 25px">
                                                                        <h6 class="m-0 fw-bold">
                                                                            {{ $caseUpdate->creator->name ?? '-' }}</h6>
                                                                        <small
                                                                            class="text-muted">{{ $caseUpdate->created_at->format('d/m/Y') }}</small>
                                                                    </div>
                                                                </div>

                                                                <span class="badge bg-success" style="font-size: 14px;">
                                                                    {{ $caseUpdate->caseUpdateType->getTranslation('title', app()->getLocale()) }}
                                                                </span>

                                                            </div>

                                                            {{-- Title --}}
                                                            <h5 class="fw-bold mb-3">
                                                                {{ $caseUpdate->getTranslation('title', app()->getLocale()) }}
                                                            </h5>

                                                            {{-- Content --}}
                                                            <p class="text-muted mb-4" style="line-height: 1.7;">
                                                                {{ $caseUpdate->description }}
                                                            </p>

                                                            {{-- Attachments --}}
                                                            @if ($caseUpdate->getMedia('files')->count() > 0)
                                                                <div class="col-12 mb-4">
                                                                    <label class="form-control-label text-primary-custom">
                                                                        {{ trns('current_files') }}
                                                                    </label>

                                                                    <div class="d-flex flex-wrap"
                                                                        id="existing-files-container">

                                                                        @foreach ($caseUpdate->getMedia('files') as $media)
                                                                            @php
                                                                                $extension = strtolower(
                                                                                    pathinfo(
                                                                                        $media->file_name,
                                                                                        PATHINFO_EXTENSION,
                                                                                    ),
                                                                                );

                                                                                // Real image types
                                                                                $imageExtensions = [
                                                                                    'jpg',
                                                                                    'jpeg',
                                                                                    'png',
                                                                                    'gif',
                                                                                    'webp',
                                                                                ];

                                                                                // File icons for non-images
                                                                                $iconClass = match ($extension) {
                                                                                    'pdf'
                                                                                        => 'fas fa-file-pdf text-danger',
                                                                                    'doc',
                                                                                    'docx'
                                                                                        => 'fas fa-file-word text-primary',
                                                                                    'xls',
                                                                                    'xlsx'
                                                                                        => 'fas fa-file-excel text-success',
                                                                                    'txt'
                                                                                        => 'fas fa-file-alt text-secondary',
                                                                                    'ppt',
                                                                                    'pptx'
                                                                                        => 'fas fa-file-powerpoint text-warning',
                                                                                    'zip',
                                                                                    'rar'
                                                                                        => 'fas fa-file-archive text-info',
                                                                                    default
                                                                                        => 'fas fa-file text-secondary',
                                                                                };
                                                                            @endphp

                                                                            <div class="file-preview-item position-relative me-2 mb-2"
                                                                                data-id="{{ $media->id }}"
                                                                                style="width: 180px; border: 1px solid #ddd; border-radius: 8px; background: #fff; padding: 10px;">

                                                                                <div class="text-center mb-2">

                                                                                    {{-- If IMAGE → show image thumbnail --}}
                                                                                    @if (in_array($extension, $imageExtensions))
                                                                                        <img src="{{ $media->getUrl() }}"
                                                                                            alt="image"
                                                                                            style="width: 70px; height: 70px; object-fit: cover; border-radius: 6px; border:1px solid #ccc;">
                                                                                    @else
                                                                                        <i class="{{ $iconClass }}"
                                                                                            style="font-size: 40px;"></i>
                                                                                    @endif

                                                                                    <div class="file-name mt-1"
                                                                                        style="font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                                                        {{ $media->file_name }}
                                                                                    </div>

                                                                                    <small class="text-muted">
                                                                                        {{ number_format($media->size / 1024, 1) }}
                                                                                        KB
                                                                                    </small>
                                                                                </div>

                                                                                {{-- @dd($media->getUrl()) --}}
                                                                                {{-- Open file --}}
                                                                                <a href="{{ $media->getUrl() }}"
                                                                                    target="_blank"
                                                                                    class="btn btn-sm btn-light w-100 mb-1">
                                                                                    {{ trns('open') }}
                                                                                </a>

                                                                                {{-- Remove file --}}
                                                                                {{-- <button type="button"
                                                                                    class="btn btn-danger btn-sm remove-existing-file"
                                                                                    style="position: absolute; top: 5px; right: 5px; width: 25px; height: 25px; padding: 0; border-radius: 50%; z-index: 10;">
                                                                                    ×
                                                                                </button> --}}

                                                                                {{-- Hidden input to send existing file IDs --}}
                                                                                <input type="hidden"
                                                                                    name="existing_files[]"
                                                                                    value="{{ $media->id }}">
                                                                            </div>
                                                                        @endforeach

                                                                    </div>
                                                                </div>
                                                            @else
                                                                <p class="text-muted">{{ trns('no_files_found') }}</p>
                                                            @endif


                                                        </div>

                                                    </div>
                                                @endforeach

                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- status modal --}}
                    <div class="modal fade" id="stopReason_modal" tabindex="-1" role="dialog"
                        aria-labelledby="stopReasonModalLabel" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ trns('delete') }}</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input id="element_id" name="id" type="hidden">
                                    <p>{{ trns('are_you_sure_you_want_to_change_status_?') }} <span id="title"
                                            class="text-danger"></span></p>
                                </div>
                                <div class="modal-footer d-flex flex-nowrap">
                                    <button type="button" class="btn btn-two" data-bs-dismiss="modal"
                                        id="dismiss_delete_modal">
                                        {{ trns('close') }}
                                    </button>
                                    <button type="button" class="btn btn-one statusStopReasonBtn"
                                        id="change_status">{{ trns('change_Status') }} !</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!--Delete MODAL -->
                    <div class="modal fade" id="delete_modal_of_show" tabindex="-1" role="dialog"
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
                                    <input id="delete_id_case" name="id" type="hidden">
                                    <p>{{ trns('are_you_sure_you_want_to_delete_this_obj') }} </p>

                                </div>
                                <div class="modal-footer d-flex flex-nowrap">
                                    <button type="button" class="btn btn-two" data-bs-dismiss="modal"
                                        id="dismiss_delete_modal">
                                        {{ trns('close') }}
                                    </button>
                                    <button type="button" class="btn btn-one"
                                        id="deleteCourtCase">{{ trns('delete') }}!
                                    </button>
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


                </div>
                @include('admin.layouts.NewmyAjaxHelper')
            @endsection
            @section('ajaxCalls')
                <script>
                    // ===============================
                    // 📌 handle delete court case
                    // ===============================

                    initCantDeleteModalHandler();
                    $(document).ready(function() {

                        // When modal is opening
                        $('#delete_modal_of_show').on('show.bs.modal', function(event) {
                            var button = $(event.relatedTarget);
                            var id = button.data('id');

                            $(this).find('#delete_id_case').val(id);
                        });

                        // Delete action
                        $(document).on('click', '#deleteCourtCase', function() {

                            var id = $("#delete_id_case").val();

                            var routeOfDelete = "{{ route('court_case.destroy', ':id') }}".replace(':id', id);

                            $.ajax({
                                type: 'DELETE',
                                url: routeOfDelete,
                                data: {
                                    '_token': "{{ csrf_token() }}",
                                    'id': id
                                },
                                success: function(data) {

                                    if (data.status === 200) {

                                        $('#delete_modal_of_show').modal('hide');

                                        Swal.fire({
                                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('success') }}</span>',
                                            imageUrl: '{{ asset('true.png') }}',
                                            imageWidth: 80,
                                            imageHeight: 80,
                                            showConfirmButton: false,
                                            timer: 800,
                                        });

                                        setTimeout(function() {
                                            window.location.href =
                                                "{{ route('court_case.index') }}";
                                        }, 900);

                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: '{{ trns('Deletion failed') }}',
                                            text: data.message ||
                                                '{{ trns('Something went wrong') }}',
                                        });
                                    }
                                },

                                error: function(xhr) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{ trns('Error') }}',
                                        text: xhr.responseJSON?.message ||
                                            '{{ trns('Something went wrong') }}',
                                    });
                                }

                            });
                        });
                    });




                    // ===============================
                    // 📌 update court_case
                    // ===============================

                    $(document).on('click', '.editCourtCaseBtn', function() {
                        var id = $(this).data('id');
                        var url = '{{ route('court_case.edit', ':id') }}'.replace(':id', id);

                        $('#modal-body').html(loader);
                        $('#editOrCreate').modal('show');
                        $('#editOrCreate .modal-title').text('{{ trns('edit_court_case') }}');

                        // Footer buttons
                        $('#modal-footer').html(`
                            <div class="w-100 d-flex">
                                <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('close') }}</button>
                                <button type="button" class="btn btn-one me-2" id="CourtCaseUpdatebtn" data-id="${id}">{{ trns('update') }}</button>
                            </div>
                        `);

                        setTimeout(function() {
                            $('#modal-body').load(url);
                        }, 500);
                    });


                    $(document).on('click', '#CourtCaseUpdatebtn', function(e) {
                        e.preventDefault();

                        var id = $(this).data('id');
                        var form = $('.CourtCaseUpdateForm');
                        var formData = new FormData(form[0]);
                        formData.append("_method", "PUT");
                        var url = '{{ route('court_case.update', ':id') }}'.replace(':id', id);

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: formData,
                            beforeSend: function() {
                                $('#CourtCaseUpdatebtn').html(
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
                                setTimeout(function() {
                                    window.location.reload(); // ✅ fixed typo here
                                }, 1000);

                                $('#CourtCaseUpdatebtn').html('{{ trns('update') }}').attr('disabled', false);
                            },

                            error: function(xhr) {
                                if (xhr.status === 422) {
                                    var errors = xhr.responseJSON.errors;
                                    $.each(errors, function(key, messages) {
                                        messages.forEach(msg => toastr.error(msg));
                                    });
                                } else {
                                    toastr.error('{{ trns('something_went_wrong') }}');
                                }
                                $('#CourtCaseUpdatebtn').html('{{ trns('update') }}').attr('disabled', false);
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    });

                    {{-- end or updatea and edit --}}




                    // ======================================================
                    // 📌 Open Create Modal for updateCase
                    // ======================================================
                    $(document).on('click', '#createCaseUpdate', function() {

                        let routeOfShow = @json(route('case_update.create'));

                        $('#caseUpdateTypeModalFooter').html(`
                            <div class="w-100 d-flex">
                                <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('close') }}</button>
                                <button type="submit" class="btn btn-one me-2" id="addCaseUpdateTypeBtn">{{ trns('create') }}</button>
                            </div>
                        `);

                        $('#caseUpdateTypeModalBody').html(loader);
                        $('#editOrCreateCaseUpdate').modal('show');

                        let caseId = @json($obj->id);
                        setTimeout(function() {
                            $('#caseUpdateTypeModalBody').load(routeOfShow, function() {
                                $('#case_id').val(caseId);
                            });
                        }, 250);
                    });

                    // ======================================================
                    // 📌 Submit CaseUpdateType Form via AJAX
                    // ======================================================
                    $(document).on('click', '#addCaseUpdateTypeBtn', function(e) {
                        e.preventDefault();

                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').remove();

                        let form = $('.addCaseUpdateTypeForm')[0];
                        let formData = new FormData(form);
                        let url = $('.addCaseUpdateTypeForm').attr('action');

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: formData,

                            beforeSend: function() {
                                $('#addCaseUpdateTypeBtn')
                                    .html(
                                        '<span class="spinner-border spinner-border-sm mr-2"></span> {{ trns('loading...') }}'
                                    )
                                    .attr('disabled', true);
                            },

                            success: function(data) {
                                $('#addCaseUpdateTypeBtn').html('{{ trns('create') }}').attr('disabled', false);

                                if (data.status == 200) {

                                    Swal.fire({
                                        title: '{{ trns('added_successfully') }}',
                                        icon: 'success',
                                        timer: 1000,
                                        showConfirmButton: false
                                    });

                                    if (data.redirect_to) {
                                        setTimeout(() => window.location.href = data.redirect_to, 1000);
                                    } else {
                                        $('#editOrCreateCaseUpdate').modal('hide');
                                        $('#dataTable').DataTable().ajax.reload();
                                    }
                                    window.location.reload();
                                } else {
                                    toastr.error(data.message ?? '{{ trns('something_went_wrong') }}');
                                }
                            },

                            error: function(xhr) {
                                $('#addCaseUpdateTypeBtn').html('{{ trns('create') }}').attr('disabled', false);

                                if (xhr.status === 422) {
                                    let errors = xhr.responseJSON.errors;

                                    $.each(errors, function(field, messages) {
                                        let input = $('[name="' + field + '"]');

                                        input.addClass('is-invalid');
                                        input.after('<div class="invalid-feedback">' + messages[0] +
                                            '</div>');
                                    });
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
                    $(document).on('click', '.openStatusModel', function() {

                        const id = $(this).data('id');
                        const status = Number($(this).data('status'));

                        $('#element_id').val(id);

                        if (status === 1) {
                            $('#stop_reason_div').removeClass('d-none');
                            $('#change_status').text("{{ trns('deactivate') }}");
                        } else {
                            $('#stop_reason_div').addClass('d-none');
                            $('#change_status').text("{{ trns('activate') }}");
                        }


                        const modalEl = document.getElementById('stopReason_modal');
                        bootstrap.Modal.getOrCreateInstance(modalEl).show();
                    });

                    $(document).on('click', '.statusStopReasonBtn', function(e) {
                        e.preventDefault();

                        let id = $("#element_id").val();
                        let stop_reason = $("#stop_reason").val();

                        $.ajax({
                            type: 'POST',
                            url: "{{ route($route . '.updateColumnSelected') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",

                                // required by function
                                'ids': [id], // MUST be array
                                'column': 'status', // the column name
                                'values': [1, 0], // toggle between 1 and 0

                                // extra fields if you need them server-side
                                'stop_reason': stop_reason
                            },
                            success: function(data) {
                                if (data.status === 200) {
                                    toastr.success("{{ trns('status_changed_successfully') }}");

                                    $('#bulk-delete').prop('disabled', false);
                                    $('#bulk-update').prop('disabled', false);
                                    $('#select-all').prop('checked', false);

                                    const modalEl = document.getElementById('stopReason_modal');
                                    bootstrap.Modal.getOrCreateInstance(modalEl).hide();

                                    $("#stop_reason").val('');

                                    $('#dataTable').DataTable().ajax.reload(null, false);
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
            @endsection
