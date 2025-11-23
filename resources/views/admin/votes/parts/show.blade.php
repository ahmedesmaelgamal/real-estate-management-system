@extends('admin.layouts.master')

@section('title', trns('vote_details'))

@section('page_name')
    <a href="{{ route('votes.index') }}">
        {{ trns('votes_management') . '/' }}
    </a>
    <a href="">
        {{ trns('ths_vote') }}
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



        <!-- Modal to Show Vote Image -->
        {{-- <div class="modal fade" id="voteImageModal" tabindex="-1" aria-labelledby="voteImageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="voteImageModalLabel">{{ trns('show_image') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="voteImagePreview" src="" alt="Vote Image" class="img-fluid rounded shadow">
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="modal fade" id="voteImageModal" tabindex="-1" aria-labelledby="voteImageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="voteImageModalLabel">{{ trns('show_file') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">

                        <!-- صورة -->
                        <img id="voteImagePreview" src="" alt="" class="img-fluid rounded shadow d-none">

                        <!-- PDF -->
                        <iframe id="votePdfPreview" src="" style="width:100%; height:500px;"
                            class="d-none"></iframe>

                    </div>
                </div>
            </div>
        </div>







        <!-- Create Or Edit Modal -->
        <div class="modal fade" id="editOrCreate" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ trns('delete') }}</h5>

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


        <div class="modal fade" id="makeVoteModal" tabindex="-1" aria-labelledby="makeVoteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">


                <div class="modal-content">
                    <form id="makeVoteForm" method="POST" enctype="multipart/form-data"
                        action="{{ route('votes.makeVote') }}">
                        @csrf
                        <input type="hidden" name="user_id" id="vote_user_id">
                        <input type="hidden" name="vote_id" id="vote_id">
                        <input type="hidden" name="vote_detail_id" id="vote_detail_id">

                        <div class="modal-header">
                            <h5 class="modal-title" id="makeVoteModalLabel">{{ trns('make_vote') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body text-center">

                            <div class="form-group">
                                <h3>{{ $obj->title_trans ?? trns('no data') }}</h3>
                                <h5>{{ $obj->description_trans ?? trns('no data') }}</h5>

                                <label class="d-block mt-3">{{ trns('vote_action') }}</label>

                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="radio" name="vote_action" id="vote_yes"
                                        value="yes" required>
                                    <label class="form-check-label me-2" for="vote_yes">{{ trns('yes') }}</label>
                                </div>

                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="radio" name="vote_action" id="vote_no"
                                        value="no" required>
                                    <label class="form-check-label me-2" for="vote_no">{{ trns('no') }}</label>
                                </div>
                            </div>

                            <!-- ✅ Dropify Style File Upload -->
                            <div class="col-12 mt-4">
                                <div class="form-group">
                                    <label for="vote_file" class="form-control-label"
                                        style="display: block; color: #00F3CA !important;">
                                        {{ trns('upload_vote_document') }}
                                    </label>

                                    <label for="vote_file" class="form-control-label"
                                        style="display: block; color: gray !important; font-weight: normal !important;">
                                        {{ trns('you_can_upload_vote_documents_here') }}
                                    </label>

                                    <div class="file-upload-wrapper">
                                        <input type="file" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" name="file"
                                            id="vote_dropify" class="file-upload-input files-dropify">
                                        <label for="vote_dropify" class="file-upload-label">
                                            {{-- <span
                                                class="file-upload-text d-flex flex-column justify-content-center align-items-center">
                                                <i class="fa-solid fa-cloud-arrow-up mb-3"></i>
                                                {{ trns('drag_and_drop_or_click_to_upload') }}
                                            </span> --}}
                                        </label>
                                        <div class="file-previews" style="position: absolute; top: 0; right: 10px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ✅ End Dropify Style -->

                        </div>

                        <div class="modal-footer" style="flex-wrap: nowrap;">
                            <button type="button" class="btn btn-two" data-bs-dismiss="modal">
                                {{ trns('close') }}
                            </button>
                            <button type="submit" class="btn btn-one me-2">
                                {{ trns('submit_vote') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>





        <div class="col-md-12 col-lg-12">
            <div class="">
                <div class="d-flex align-items-center"></div>

                <div class="" style="padding: 15px; padding-bottom: 60px">
                    <div class="row">
                        <div class="col-6">
                            <h2 style="font-weight: bold; color: #00193a;">{{ trns('vote_see') }}</h2>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle m-2" type="button"
                                    id="dropdownMenuButton{{ $obj->id }}" data-bs-toggle="dropdown"
                                    aria-expanded="false" style="background-color: #00193a; color: #00F3CA;">
                                    {{ trns('options') }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $obj->id }}"
                                    style="background-color: #EAEAEA;">
                                    <li>
                                        <a class="dropdown-item editBtn" href="javascript:void(0);"
                                            data-id="{{ $obj->id }}">
                                            <img src="{{ asset('edit.png') }}" alt="no-icon" class="img-fluid ms-1"
                                                style="width: 24px; height: 24px;"> {{ trns('Edit') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item toggleStatusBtn" href="#"
                                            data-id="{{ $obj->id }}" data-status="{{ $obj->status }}">
                                            {{ $obj->status == 1 ? trns('Deactivate_vote') : trns('Activate_vote') }}
                                        </a>
                                    </li>
                                    @if ($canRevote)
                                        <li>
                                            <a class="dropdown-item revote_btn" href="javascript:void(0);"
                                                data-id="{{ $obj->id }}">
                                                {{ trns('revote') }}
                                            </a>
                                        </li>
                                    @endif

                                    <a class="dropdown-item" style="color: red; cursor: pointer; margin-right: 5px;"
                                        data-bs-toggle="modal" data-bs-target="#delete_modal_of_show"
                                        data-id="{{ $obj->id }}" data-title="{{ $obj->name }}">
                                        <i class="fas fa-trash" style="margin-left: 5px;"></i>
                                        {{ trns('delete') }}
                                    </a>


                                </ul>
                                <a href="{{ route('votes.index') }}" class="btn"
                                    style="transform: rotate(180deg); border: 1px solid gray; padding: 6px 11px;">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>


                        <!--Delete MODAL -->
                        <div class="modal fade" id="delete_modal_of_show" tabindex="-1" role="dialog"
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
                                        <p>{{ trns('are_you_sure_you_want_to_delete_this_obj') }} </p>

                                    </div>
                                    <div class="modal-footer d-flex flex-nowrap">
                                        <button type="button" class="btn btn-two" data-bs-dismiss="modal"
                                            id="dismiss_delete_modal">
                                            {{ trns('close') }}
                                        </button>
                                        <button type="button" class="btn btn-one"
                                            id="delete_btn_of_show">{{ trns('delete') }}!
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- MODAL CLOSED -->
                    </div>

                    <ul class="nav nav-tabs" style="margin: 0 3px;" id="realEstateTabs">
                        <li class="nav-item">
                            <a class="nav-link active {{ $obj->stage_number < 1 ? 'disabled' : '' }}" data-tab="tab1"
                                href="#tab1">{{ trns('first_stage') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link  {{ $obj->stage_number < 2 ? 'disabled' : '' }}" data-tab="tab2"
                                href="#tab2">{{ trns('second_stage') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link  {{ $obj->stage_number < 3 ? 'disabled' : '' }}" data-tab="tab3"
                                href="#tab3">{{ trns('third_stage') }}</a>
                        </li>
                    </ul>


                    <style>
                        .nav-link.disabled {
                            pointer-events: none;
                            opacity: 0.5;
                        }
                    </style>



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
                                        {{ trns('basic_information_of_votes') }}</h4>
                                    <!-- <h4>{{ $obj->name ?? trns('N/A') }}</h4> -->
                                    <hr style="background-color: black;">
                                    <div class="row m-4">
                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('association_name') }}</h6>
                                            <p class="fw-bold">
                                                {{ $obj->association?->getTranslation('name', app()->getLocale()) ?? trns('no data') }}
                                            </p>
                                        </div>
                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('title') }}</h6>
                                            <p class="fw-bold">
                                                {{ $obj->title_trans ?? trns('no data') }}
                                            </p>
                                        </div>


                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('created_at') }}</h6>
                                            <p class="fw-bold">
                                                {{ $obj->created_at?->format('Y-m-d') ?? trns('N/A') }}
                                            </p>
                                        </div>

                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('vote_start_date') }}</h6>
                                            <p class="fw-bold">
                                                <!-- {{ ($obj->stage_number == 1
                                                    ? $firstDetail->start_date->format('Y-m-d')
                                                    : ($obj->stage_number == 2
                                                        ? $secondDetail->start_date->format('Y-m-d')
                                                        : $thirdDetail->start_date->format('Y-m-d'))) ?? trns('N/A') }} -->


                                                @if ($firstDetail)
                                                    {{ $firstDetail->start_date->format('Y-m-d') }}
                                                @endif

                                            </p>
                                        </div>

                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('vote_end_date') }}</h6>
                                            <p class="fw-bold">
                                                <!-- {{ ($obj->stage_number == 1
                                                    ? $firstDetail->end_date->format('Y-m-d')
                                                    : ($obj->stage_number == 2
                                                        ? $secondDetail->end_date->format('Y-m-d')
                                                        : $thirdDetail->end_date->format('Y-m-d'))) ?? trns('N/A') }} -->

                                                @if ($firstDetail)
                                                    {{ $firstDetail->end_date->format('Y-m-d') }}
                                                @endif

                                            </p>
                                        </div>
                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('stop_percentage') }}</h6>
                                            <p class="fw-bold">
                                                {{ $firstDetail->vote_percentage ?? trns('N/A') }}
                                            </p>
                                        </div>

                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('status') }}</h6>
                                            <p>
                                                @if ($obj->status == 1 && $obj->stage_number == 1)
                                                    <span class="badge px-3 py-2"
                                                        style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px">
                                                        {{ trns('active') }}
                                                    </span>
                                                @else
                                                    <span class="badge px-3 py-2"
                                                        style="background-color: #FFBABA; color: #1F2A37; border-radius: 30px">
                                                        {{ trns('inactive') }}
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('description') }}</h6>
                                            <p class="fw-bold">
                                                {{ $obj->description_trans ?? trns('no data') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-4"
                                    style="border-radius: 6px;
                                    background-color: #fbf9f9;
                                    border: 1px solid #ddd;
                                    padding: 15px;">
                                    <h4 style="font-weight: bold; color: #00193a;">{{ trns('votes_management') }}
                                    </h4>
                                    <hr style="background-color: black;">
                                    <div class="row m-4">
                                        <div class="col-2">
                                            <h6 class="text-uppercase text-muted">{{ trns('owners_number') }}</h6>
                                            <p class="fw-bold">
                                                {{ $owners_count ?? trns('no data') }}
                                            </p>
                                        </div>

                                        <div class="col-2">
                                            <h6 class="text-uppercase text-muted">{{ trns('voters_percentage') }}</h6>
                                            <p class="fw-bold">
                                                @php
                                                    if ($owners_count > 0) {
                                                        $percentage =
                                                            (($firstDetail->yes_audience + $firstDetail->no_audience) /
                                                                $owners_count) *
                                                            100;
                                                    } else {
                                                        $percentage = null;
                                                    }
                                                @endphp

                                                {{ $percentage !== null ? number_format($percentage, 2) . '%' : trns('N/A') }}
                                            </p>
                                        </div>


                                        <div class="col-2">
                                            <h6 class="text-uppercase text-muted">{{ trns('yse_voters') }}</h6>
                                            <p class="fw-bold">
                                                {{ $firstDetail->yes_audience ?? trns('N/A') }}
                                            </p>
                                        </div>

                                        <div class="col-2">
                                            <h6 class="text-uppercase text-muted">{{ trns('no_voters') }}</h6>
                                            <p class="fw-bold">
                                                {{ $firstDetail->no_audience ?? trns('N/A') }}
                                            </p>
                                        </div>
                                        <div class="col-2">
                                            <h6 class="text-uppercase text-muted">{{ trns('under_voteing') }}</h6>
                                            <p class="fw-bold">
                                                @php
                                                    $firstvotersCount = $obj->voteDetailHasUsers
                                                        ->where('stage_number', 1)
                                                        ->count();
                                                @endphp

                                                @if ($obj->stage_number == 1)
                                                    {{ $owners_count - (($firstDetail->yes_audience ?? 0) + ($firstDetail->no_audience ?? 0)) }}
                                                @else
                                                    {{ 0 }}
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-2" style="margin-bottom: 30px">
                                            <h6 class="text-uppercase text-muted">{{ trns('unVoters') }}</h6>
                                            <p class="fw-bold">

                                                @php
                                                    $firstvotersCount = $obj->voteDetailHasUsers
                                                        ->where('stage_number', 1)
                                                        ->count();
                                                @endphp
                                                @if ($firstDetail->end_date->isPast() || $obj->stage_number != 1)
                                                    {{ $owners_count - ($firstDetail->yes_audience + $firstDetail->no_audience) ?? trns('N/A') }}
                                                @else
                                                    0
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
                                    <div class="table-responsive" style="overflow-x: inherit; margin-top: 30px">
                                        <!--begin::Table-->
                                        <table class="table text-nowrap w-100"
                                            style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;"
                                            id="userStage1DataTable">
                                            <thead>
                                                <tr class="fw-bolder" style="background-color: #E9E9E9; color: #00193a;">
                                                    <th>#</th>
                                                    <th class="min-w-50px">{{ trns('national_id') }}</th>
                                                    <th class="min-w-50px">{{ trns('name') }}</th>
                                                    <th class="min-w-50px">{{ trns('arabic_email') }}</th>
                                                    <th class="min-w-50px">{{ trns('phone_number') }}</th>
                                                    <th class="min-w-50px">{{ trns('voted_by') }}</th>
                                                    <th class="min-w-50px">{{ trns('status') }}</th>
                                                    <th class="min-w-50px rounded-start">{{ trns('actions') }}</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                            </div>






                        </div>




                        <div id="tab2">
                            <div class="tab-pane fade show active" id="basic-info" role="tabpanel">
                                <div class="show-content mt-3"
                                    style="border-radius: 6px;
                                    background-color: #fbf9f9;
                                    border: 1px solid #ddd;
                                    padding: 15px;">
                                    <h4 style="font-weight: bold; color: #00193a;">
                                        {{ trns('basic_information_of_votes') }}</h4>
                                    <!-- <h4>{{ $obj->name ?? trns('N/A') }}</h4> -->
                                    <hr style="background-color: black;">
                                    <div class="row m-4">
                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('association_name') }}</h6>
                                            <p class="fw-bold">
                                                {{ $obj->association?->getTranslation('name', app()->getLocale()) ?? trns('no data') }}
                                            </p>
                                        </div>
                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('title') }}</h6>
                                            <p class="fw-bold">
                                                {{ $obj->title_trans ?? trns('no data') }}
                                            </p>
                                        </div>

                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('created_at') }}</h6>
                                            <p class="fw-bold">
                                                {{ $obj->created_at?->format('Y-m-d') ?? trns('N/A') }}
                                            </p>
                                        </div>

                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('vote_start_date') }}</h6>
                                            <p class="fw-bold">
                                                <!-- {{ ($obj->stage_number == 1
                                                    ? $firstDetail->start_date->format('Y-m-d')
                                                    : ($obj->stage_number == 2
                                                        ? $secondDetail->start_date->format('Y-m-d')
                                                        : $thirdDetail->start_date->format('Y-m-d'))) ?? trns('N/A') }} -->
                                                @if ($secondDetail)
                                                    {{ $secondDetail->start_date->format('Y-m-d') }}
                                                @endif

                                            </p>
                                        </div>

                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('vote_end_date') }}</h6>
                                            <p class="fw-bold">
                                                <!-- {{ ($obj->stage_number == 1
                                                    ? $firstDetail->end_date->format('Y-m-d')
                                                    : ($obj->stage_number == 2
                                                        ? $secondDetail->end_date->format('Y-m-d')
                                                        : $thirdDetail->end_date->format('Y-m-d'))) ?? trns('N/A') }} -->
                                                @if ($secondDetail)
                                                    {{ $secondDetail->end_date->format('Y-m-d') }}
                                                @endif

                                            </p>
                                        </div>
                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('stop_percentage') }}</h6>
                                            <p class="fw-bold">
                                                {{ $secondDetail->vote_percentage ?? trns('N/A') }}
                                            </p>
                                        </div>

                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('status') }}</h6>
                                            <p>
                                                @if ($obj->status == 1 && $obj->stage_number == 2)
                                                    <span class="badge px-3 py-2"
                                                        style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px">
                                                        {{ trns('active') }}
                                                    </span>
                                                @else
                                                    <span class="badge px-3 py-2"
                                                        style="background-color: #FFBABA; color: #1F2A37; border-radius: 30px">
                                                        {{ trns('inactive') }}
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('description') }}</h6>
                                            <p class="fw-bold">
                                                {{ $obj->description_trans ?? trns('no data') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-4"
                                    style="border-radius: 6px;
                                    background-color: #fbf9f9;
                                    border: 1px solid #ddd;
                                    padding: 15px;">

                                    @if ($secondDetail)
                                        <h4 style="font-weight: bold; color: #00193a;">{{ trns('votes_management') }}
                                        </h4>
                                        <hr style="background-color: black;">
                                        <div class="row m-4">
                                            <div class="col-2">
                                                <h6 class="text-uppercase text-muted">{{ trns('owners_number') }}</h6>
                                                <p class="fw-bold">
                                                    {{ $owners_count ?? trns('no data') }}
                                                </p>
                                            </div>

                                            <div class="col-2">
                                                <h6 class="text-uppercase text-muted">{{ trns('voters_percentage') }}
                                                </h6>
                                                <p class="fw-bold">
                                                    @php
                                                        if ($owners_count > 0) {
                                                            $percentage =
                                                                (($secondDetail?->yes_audience +
                                                                    $secondDetail?->no_audience) /
                                                                    $owners_count) *
                                                                100;
                                                        } else {
                                                            $percentage = null;
                                                        }
                                                    @endphp

                                                    {{ $percentage !== null ? number_format($percentage, 2) . '%' : trns('N/A') }}
                                                </p>
                                            </div>


                                            <div class="col-2">
                                                <h6 class="text-uppercase text-muted">{{ trns('yse_voters') }}</h6>
                                                <p class="fw-bold">
                                                    {{ $secondDetail?->yes_audience ?? trns('N/A') }}
                                                </p>
                                            </div>

                                            <div class="col-2">
                                                <h6 class="text-uppercase text-muted">{{ trns('no_voters') }}</h6>
                                                <p class="fw-bold">
                                                    {{ $secondDetail?->no_audience ?? trns('N/A') }}
                                                </p>
                                            </div>
                                            <div class="col-2">
                                                <h6 class="text-uppercase text-muted">{{ trns('under_voteing') }}</h6>
                                                <p class="fw-bold">
                                                    @php
                                                        $secondVotersCount = $obj->voteDetailHasUsers
                                                            ->where('stage_number', 2)
                                                            ->count();
                                                    @endphp
                                                    @if ($obj->stage_number == 2)
                                                        {{ $owners_count - $firstvotersCount - (($secondDetail->yes_audience ?? 0) + ($secondDetail->no_audience ?? 0)) ?? trns('N/A') }}
                                                    @else
                                                        {{ 0 }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-2" style="margin-bottom:35px">
                                                <h6 class="text-uppercase text-muted">{{ trns('unVoters') }}</h6>
                                                <p class="fw-bold">
                                                    @php
                                                        $secondVotersCount = $obj->voteDetailHasUsers
                                                            ->where('stage_number', 2)
                                                            ->count();
                                                    @endphp
                                                    @if ($firstDetail->end_date->isPast() || $obj->stage_number != 2)
                                                        {{ $owners_count - ($firstDetail->yes_audience + $firstDetail->no_audience + $firstvotersCount) ?? trns('N/A') }}
                                                    @else
                                                        0
                                                    @endif
                                                </p>
                                            </div>


                                        </div>

                                    @endif

                                </div>




                            </div>
                            @if ($secondDetail)
                                <div class="col-12 mt-4"
                                    style="border-radius: 6px;
                                    background-color: #fbf9f9;
                                    border: 1px solid #ddd;
                                    padding: 15px;">
                                    <div class="table-responsive mt-4" style="overflow-x: inherit; margin-top: 65px">
                                        <!--begin::Table-->
                                        <table class="table text-nowrap w-100"
                                            style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;"
                                            id="userStage2DataTable">
                                            <thead>
                                                <tr class="fw-bolder" style="background-color: #E9E9E9; color: #00193a;">
                                                    <th>#</th>
                                                    <th class="min-w-50px">{{ trns('national_id') }}</th>
                                                    <th class="min-w-50px">{{ trns('name') }}</th>
                                                    <th class="min-w-50px">{{ trns('arabic_email') }}</th>
                                                    <th class="min-w-50px">{{ trns('phone_number') }}</th>
                                                    <th class="min-w-50px">{{ trns('voted_by') }}</th>
                                                    <th class="min-w-50px">{{ trns('status') }}</th>
                                                    <th class="min-w-50px r ounded-start">{{ trns('actions') }}</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>


                        <div id="tab2">
                            <div class="tab-pane fade show active" id="basic-info" role="tabpanel">
                                <div class="show-content mt-3"
                                    style="border-radius: 6px;
                                    background-color: #fbf9f9;
                                    border: 1px solid #ddd;
                                    padding: 15px;">
                                    <h4 style="font-weight: bold; color: #00193a;">
                                        {{ trns('basic_information_of_votes') }}</h4>
                                    <!-- <h4>{{ $obj->name ?? trns('N/A') }}</h4> -->
                                    <hr style="background-color: black;">
                                    <div class="row m-4">
                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('association_name') }}</h6>
                                            <p class="fw-bold">
                                                {{ $obj->association?->getTranslation('name', app()->getLocale()) ?? trns('no data') }}
                                            </p>
                                        </div>
                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('title') }}</h6>
                                            <p class="fw-bold">
                                                {{ $obj->title_trans ?? trns('no data') }}
                                            </p>
                                        </div>

                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('created_at') }}</h6>
                                            <p class="fw-bold">
                                                {{ $obj->created_at?->format('Y-m-d') ?? trns('N/A') }}
                                            </p>
                                        </div>

                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('vote_start_date') }}</h6>
                                            <p class="fw-bold">
                                                <!-- {{ ($obj->stage_number == 1
                                                    ? $firstDetail->start_date->format('Y-m-d')
                                                    : ($obj->stage_number == 2
                                                        ? $secondDetail->start_date->format('Y-m-d')
                                                        : $thirdDetail->start_date->format('Y-m-d'))) ?? trns('N/A') }} -->

                                                @if ($secondDetail)
                                                    {{ $secondDetail->start_date->format('Y-m-d') }}
                                                @endif
                                            </p>
                                        </div>

                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('vote_end_date') }}</h6>
                                            <p class="fw-bold">
                                                <!-- {{ ($obj->stage_number == 1
                                                    ? $firstDetail->end_date->format('Y-m-d')
                                                    : ($obj->stage_number == 2
                                                        ? $secondDetail->end_date->format('Y-m-d')
                                                        : $thirdDetail->end_date->format('Y-m-d'))) ?? trns('N/A') }} -->
                                                @if ($secondDetail)
                                                    {{ $secondDetail->end_date->format('Y-m-d') }}
                                                @endif

                                            </p>
                                        </div>
                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('stop_percentage') }}</h6>
                                            <p class="fw-bold">
                                                {{ $secondDetail->vote_percentage ?? trns('N/A') }}
                                            </p>
                                        </div>

                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('status') }}</h6>
                                            <p>
                                                @if ($obj->status == 1 && $obj->stage_number == 2)
                                                    <span class="badge px-3 py-2"
                                                        style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px">
                                                        {{ trns('active') }}
                                                    </span>
                                                @else
                                                    <span class="badge px-3 py-2"
                                                        style="background-color: #FFBABA; color: #1F2A37; border-radius: 30px">
                                                        {{ trns('inactive') }}
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-3">
                                            <h6 class="text-uppercase text-muted">{{ trns('description') }}</h6>
                                            <p class="fw-bold">
                                                {{ $obj->description_trans ?? trns('no data') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-4"
                                    style="border-radius: 6px;
                                    background-color: #fbf9f9;
                                    border: 1px solid #ddd;
                                    padding: 15px;">

                                    @if ($secondDetail)
                                        <h4 style="font-weight: bold; color: #00193a;">{{ trns('votes_management') }}
                                        </h4>
                                        <hr style="background-color: black;">
                                        <div class="row m-4">
                                            <div class="col-2">
                                                <h6 class="text-uppercase text-muted">{{ trns('owners_number') }}</h6>
                                                <p class="fw-bold">
                                                    {{ $owners_count ?? trns('no data') }}
                                                </p>
                                            </div>

                                            <div class="col-2">
                                                <h6 class="text-uppercase text-muted">{{ trns('voters_percentage') }}
                                                </h6>
                                                <p class="fw-bold">
                                                    @php
                                                        if ($owners_count > 0) {
                                                            $percentage =
                                                                (($secondDetail?->yes_audience +
                                                                    $secondDetail?->no_audience) /
                                                                    $owners_count) *
                                                                100;
                                                        } else {
                                                            $percentage = null;
                                                        }
                                                    @endphp

                                                    {{ $percentage !== null ? number_format($percentage, 2) . '%' : trns('N/A') }}
                                                </p>
                                            </div>


                                            <div class="col-2">
                                                <h6 class="text-uppercase text-muted">{{ trns('yse_voters') }}</h6>
                                                <p class="fw-bold">
                                                    {{ $secondDetail?->yes_audience ?? trns('N/A') }}
                                                </p>
                                            </div>

                                            <div class="col-2">
                                                <h6 class="text-uppercase text-muted">{{ trns('no_voters') }}</h6>
                                                <p class="fw-bold">
                                                    {{ $secondDetail?->no_audience ?? trns('N/A') }}
                                                </p>
                                            </div>
                                            <div class="col-2">
                                                <h6 class="text-uppercase text-muted">{{ trns('under_voteing') }}</h6>
                                                <p class="fw-bold">
                                                    @php
                                                        $secondVotersCount = $obj->voteDetailHasUsers
                                                            ->where('stage_number', 2)
                                                            ->count();
                                                    @endphp
                                                    @if ($obj->stage_number == 2)
                                                        {{ $owners_count - (($secondDetail->yes_audience ?? 0) + ($secondDetail->no_audience ?? 0) + $secondVotersCount) ?? trns('N/A') }}
                                                    @else
                                                        {{ 0 }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-2">
                                                <h6 class="text-uppercase text-muted">{{ trns('unVoters') }}</h6>
                                                <p class="fw-bold">
                                                    @php
                                                        $secondVotersCount = $obj->voteDetailHasUsers
                                                            ->where('stage_number', 2)
                                                            ->count();
                                                    @endphp
                                                    @if ($firstDetail->end_date->isPast() || $obj->stage_number != 2)
                                                        {{ $owners_count - ($firstDetail->yes_audience + $firstDetail->no_audience + $firstvotersCount) ?? trns('N/A') }}
                                                    @else
                                                        0
                                                    @endif
                                                </p>
                                            </div>

                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                        <div id="tab3">
                            <div class="show-content mt-3"
                                style="border-radius: 6px;
                                    background-color: #fbf9f9;
                                    border: 1px solid #ddd;
                                    padding: 15px;">
                                <h4 style="font-weight: bold; color: #00193a;">
                                    {{ trns('basic_information_of_votes') }}</h4>
                                <!-- <h4>{{ $obj->name ?? trns('N/A') }}</h4> -->
                                <hr style="background-color: black;">
                                <div class="row m-4">
                                    <div class="col-3">
                                        <h6 class="text-uppercase text-muted">{{ trns('association_name') }}</h6>
                                        <p class="fw-bold">
                                            {{ $obj->association?->getTranslation('name', app()->getLocale()) ?? trns('no data') }}
                                        </p>
                                    </div>

                                    <div class="col-3">
                                        <h6 class="text-uppercase text-muted">{{ trns('title') }}</h6>
                                        <p class="fw-bold">
                                            {{ $obj->title_trans ?? trns('no data') }}
                                        </p>
                                    </div>

                                    <div class="col-3">
                                        <h6 class="text-uppercase text-muted">{{ trns('created_at') }}</h6>
                                        <p class="fw-bold">
                                            {{ $obj->created_at?->format('Y-m-d') ?? trns('N/A') }}
                                        </p>
                                    </div>

                                    <div class="col-3">
                                        <h6 class="text-uppercase text-muted">{{ trns('vote_start_date') }}</h6>
                                        <p class="fw-bold">
                                            <!-- {{ ($obj->stage_number == 1
                                                ? $firstDetail->start_date->format('Y-m-d')
                                                : ($obj->stage_number == 2
                                                    ? $secondDetail->start_date->format('Y-m-d')
                                                    : $thirdDetail->start_date->format('Y-m-d'))) ?? trns('N/A') }} -->
                                            @if ($thirdDetail)
                                                {{ $thirdDetail->start_date->format('Y-m-d') }}
                                            @endif

                                        </p>
                                    </div>

                                    <div class="col-3">
                                        <h6 class="text-uppercase text-muted">{{ trns('vote_end_date') }}</h6>
                                        <p class="fw-bold">
                                            <!-- {{ ($obj->stage_number == 1
                                                ? $firstDetail->end_date->format('Y-m-d')
                                                : ($obj->stage_number == 2
                                                    ? $secondDetail->end_date->format('Y-m-d')
                                                    : $thirdDetail->end_date->format('Y-m-d'))) ?? trns('N/A') }} -->
                                            @if ($thirdDetail)
                                                {{ $thirdDetail->end_date->format('Y-m-d') }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-3">
                                        <h6 class="text-uppercase text-muted">{{ trns('stop_percentage') }}</h6>
                                        <p class="fw-bold">
                                            {{ $thirdDetail->vote_percentage ?? trns('N/A') }}
                                        </p>
                                    </div>

                                    <div class="col-3">
                                        <h6 class="text-uppercase text-muted">{{ trns('status') }}</h6>
                                        <p>
                                            @if ($obj->status == 1 && $obj->stage_number == 3)
                                                <span class="badge px-3 py-2"
                                                    style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px">
                                                    {{ trns('active') }}
                                                </span>
                                            @else
                                                <span class="badge px-3 py-2"
                                                    style="background-color: #FFBABA; color: #1F2A37; border-radius: 30px">
                                                    {{ trns('inactive') }}
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-3">
                                        <h6 class="text-uppercase text-muted">{{ trns('description') }}</h6>
                                        <p class="fw-bold">
                                            {{ $obj->description_trans ?? trns('no data') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4"
                                style="border-radius: 6px;
                                    background-color: #fbf9f9;
                                    border: 1px solid #ddd;
                                    padding: 15px;">
                                @if ($thirdDetail)
                                    <h4 style="font-weight: bold; color: #00193a;">{{ trns('votes_management') }}
                                    </h4>
                                    <hr style="background-color: black;">
                                    <div class="row m-4">
                                        <div class="col-2">
                                            <h6 class="text-uppercase text-muted">{{ trns('owners_number') }}</h6>
                                            <p class="fw-bold">
                                                {{ $owners_count ?? trns('no data') }}
                                            </p>
                                        </div>

                                        <div class="col-2">
                                            <h6 class="text-uppercase text-muted">{{ trns('voters_percentage') }}</h6>
                                            <p class="fw-bold">
                                                @php
                                                    if ($owners_count > 0) {
                                                        $percentage =
                                                            (($thirdDetail?->yes_audience +
                                                                $thirdDetail?->no_audience) /
                                                                $owners_count) *
                                                            100;
                                                    } else {
                                                        $percentage = null;
                                                    }
                                                @endphp

                                                {{ $percentage !== null ? number_format($percentage, 2) . '%' : trns('N/A') }}
                                            </p>
                                        </div>


                                        <div class="col-2">
                                            <h6 class="text-uppercase text-muted">{{ trns('yse_voters') }}</h6>
                                            <p class="fw-bold">
                                                {{ $thirdDetail?->yes_audience ?? trns('N/A') }}
                                            </p>
                                        </div>

                                        <div class="col-2">
                                            <h6 class="text-uppercase text-muted">{{ trns('no_voters') }}</h6>
                                            <p class="fw-bold">
                                                {{ $thirdDetail?->no_audience ?? trns('N/A') }}
                                            </p>
                                        </div>
                                        <div class="col-2">
                                            <h6 class="text-uppercase text-muted">{{ trns('under_voteing') }}</h6>
                                            <p class="fw-bold">
                                                @php
                                                    $thirdVotersCount = $obj->voteDetailHasUsers
                                                        ->where('stage_number', 3)
                                                        ->count();
                                                @endphp
                                                @if ($obj->stage_number == 3)
                                                    {{ $owners_count - ($secondVotersCount + $firstvotersCount) - (($thirdDetail->yes_audience ?? 0) + ($thirdDetail->no_audience ?? 0)) ?? trns('N/A') }}
                                                @else
                                                    {{ 0 }}
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-2">
                                            <h6 class="text-uppercase text-muted">{{ trns('unVoters') }}</h6>
                                            <p class="fw-bold">

                                                @php
                                                    $thirdVotersCount = $obj->voteDetailHasUsers
                                                        ->where('stage_number', 3)
                                                        ->count();
                                                @endphp
                                                @if ($firstDetail->end_date->isPast() || $obj->stage_number != 3)
                                                    {{ $owners_count - ($firstDetail->yes_audience + $firstDetail->no_audience + $secondVotersCount + $firstvotersCount) ?? trns('N/A') }}
                                                @else
                                                    0
                                                @endif

                                            </p>
                                        </div>

                                    </div>

                                @endif
                            </div>

                            @if ($thirdDetail)
                                <div class="col-12 mt-4"
                                    style="border-radius: 6px;
                                    background-color: #fbf9f9;
                                    border: 1px solid #ddd;
                                    padding: 15px;">
                                    <div class="table-responsive mt-4" style="overflow-x: inherit; margin-top: 65px">
                                        <!--begin::Table-->
                                        <table class="table text-nowrap w-100"
                                            style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;"
                                            id="userStage3DataTable">
                                            <thead>
                                                <tr class="fw-bolder" style="background-color: #E9E9E9; color: #00193a;">
                                                    <th>#</th>
                                                    <th class="min-w-50px">{{ trns('national_id') }}</th>
                                                    <th class="min-w-50px">{{ trns('name') }}</th>
                                                    <th class="min-w-50px">{{ trns('arabic_email') }}</th>
                                                    <th class="min-w-50px">{{ trns('phone_number') }}</th>
                                                    <th class="min-w-50px">{{ trns('voted_by') }}</th>
                                                    <th class="min-w-50px">{{ trns('status') }}</th>
                                                    <th class="min-w-50px rounded-start">{{ trns('actions') }}</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            @endif

                        </div>

                    </div>



                    <!-- Edit Or Create Modal -->
                    <div class="modal fade" id="editOrCreate" data-bs-backdrop="static" tabindex="-1" role="dialog"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header d-flex justify-content-between">
                                    <h5 class="modal-title" id="modalTitle">{{ trns('add_new_vote') }}</h5>
                                    <button type="button" class="btn-close m-0" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body" id="modal-body">
                                    <!-- Content will be loaded via AJAX -->
                                </div>
                                <div class="modal-footer" id="modal-footer"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="show_owners" index="-1" role="dialog" aria-labelledby="exampleModalLabel"
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



    </div>
    </div>

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


    @include('admin.layouts.NewmyAjaxHelper')
@endsection

@section('ajaxCalls')










    <link rel="stylesheet" href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}">
    <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.files-dropify').dropify();
        });
    </script>




    <script>
        $('.dropify').dropify();


        document.querySelectorAll('.files-dropify').forEach(input => {
            input.addEventListener('change', function(e) {
                const previewContainer = this.closest('.file-upload-wrapper').querySelector(
                    '.file-previews');
                previewContainer.innerHTML = '';

                for (let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const previewItem = document.createElement('div');
                        previewItem.className = 'preview-item';

                        if (file.type.match('image.*')) {
                            // For images, show the actual image preview
                            previewItem.innerHTML = `
                            <img src="${e.target.result}" alt="${file.name}" style="max-width: 100px; max-height: 100px;">
                            <div class="file-info">
                                <div class="file-name">${file.name}</div>
                                <div class="file-size">${(file.size / 1024).toFixed(2)} KB</div>
                            </div>
                            <button class="remove-btn" data-index="${i}">×</button>
                        `;
                        } else {
                            // For non-images, show SVG icon
                            const extension = getFileExtension(file.name);
                            const iconPath = getIconPath(extension);

                            previewItem.innerHTML = `
                            <div class="file-preview">
                                <img src="${iconPath}" alt="${extension} file" class="file-icon">
                            </div>
                            <button class="remove-btn" data-index="${i}">×</button>
                        `;
                        }

                        previewContainer.appendChild(previewItem);

                        previewItem.querySelector('.remove-btn').addEventListener('click', function() {
                            const index = parseInt(this.getAttribute('data-index'));
                            const dt = new DataTransfer();
                            const files = Array.from(input.files);

                            files.splice(index, 1);
                            files.forEach(file => dt.items.add(file));

                            input.files = dt.files;
                            previewItem.remove();
                        });
                    }

                    reader.readAsDataURL(file);
                }
            });
        });

        // $(document).on('click', '.vote-images-btn', function() {
        //     let userId = $(this).data('user-id');
        //     let voteId = $(this).data('vote-id');
        //     let voteDetailId = $(this).data('vote-detail-id');

        //     $.ajax({
        //         url: '{{ route('votes.getVoteImage') }}',
        //         type: 'GET',
        //         data: {
        //             user_id: userId,
        //             vote_id: voteId,
        //             vote_detail_id: voteDetailId
        //         },
        //         success: function(response) {
        //             if (response.file_url) {

        //                 let fileUrl = response.file_url;
        //                 let fileExtension = fileUrl.split('.').pop().toLowerCase();

        //                 // Reset
        //                 $('#voteImagePreview').addClass('d-none').attr('src', '');
        //                 $('#votePdfPreview').addClass('d-none').attr('src', '');

        //                 if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExtension)) {
        //                     $('#voteImagePreview').attr('src', fileUrl).removeClass('d-none');
        //                 } else if (fileExtension === 'pdf') {
        //                     $('#votePdfPreview').attr('src', fileUrl).removeClass('d-none');
        //                 } else {
        //                     alert('File type not supported');
        //                     return;
        //                 }

        //                 $('#voteImageModal').modal('show');

        //             } else {
        //                 alert('No file found for this vote.');
        //             }
        //         },
        //         error: function() {
        //             alert('Error loading file.');
        //         }
        //     });
        // });
        $(document).on('click', '.vote-images-btn', function() {
            let userId = $(this).data('user-id');
            let voteId = $(this).data('vote-id');
            let voteDetailId = $(this).data('vote-detail-id');

            $.ajax({
                url: '{{ route('votes.getVoteImage') }}',
                type: 'GET',
                data: {
                    user_id: userId,
                    vote_id: voteId,
                    vote_detail_id: voteDetailId
                },
                success: function(response) {
                    if (response.file_url) {
                        let fileUrl = response.file_url;
                        let fileExtension = fileUrl.split('.').pop().toLowerCase();

                        if (['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf'].includes(fileExtension)) {
                            // ✅ Open in new tab
                            window.open(fileUrl, '_blank');
                        } else {
                            alert('File type not supported');
                        }

                    } else {
                        alert('No file found for this vote.');
                    }
                },
                error: function() {
                    alert('Error loading file.');
                }
            });
        });
    </script>


    <script>
        // ===============================
        // 📌 handle show UserStage1 datatable 
        // ===============================
        document.addEventListener("DOMContentLoaded", function() {
            let vote_id = {{ $obj->id ?? 'null' }};
            let vote_detail_id = {{ $firstDetail->id }};
            let stage_id = 1;

            // UserStage1 table
            let UserStage1Columns = [{
                    data: 'id',
                    name: 'id',

                },
                {
                    data: "national_id",
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
                    data: "name",
                    name: "name",
                    render: function(data, type, row) {
                        var showUrl = '{{ route('users.show', 0) }}'.replace('/0', '/' + row.id);
                        return `<a href="${showUrl}">${data}</a>`;
                    }
                },
                {
                    data: "email",
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
                    data: "phone",
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
                    data: "voted_by",
                    name: "voted_by",
                },

                {
                    data: "status",
                    name: "status"
                },
                {
                    data: "action",
                    name: "action"
                }
            ];
            userStage1DataTable(null, '{{ route('users.index') }}', UserStage1Columns, 0, 3, vote_id,
                vote_detail_id, stage_id);

        });




        // ===============================
        // 📌  functions for user stage 1 datatable
        // ===============================
        async function userStage1DataTable(showRoute, routeOfShow, columns, orderByColumn = 0, showCol = 3, vote_id = null,
            vote_detail_id = null, stage_id) {
            let table = $('#userStage1DataTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: routeOfShow,
                    data: function(d) {
                        if (vote_id) d.vote_id = vote_id;
                        if (vote_detail_id) d.vote_detail_id = vote_detail_id;
                        if (stage_id) d.stage_id = stage_id;
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





        // ===============================
        // 📌 handle show UserStage two  datatable 
        // ===============================
        document.addEventListener("DOMContentLoaded", function() {
            let vote_id = {{ $obj->id ?? 'null' }};
            let vote_detail_id = {{ $secondDetail ? $secondDetail->id : $firstDetail->id }};
            let stage_id = 2;

            // UserStage1 table
            let UserStage1Columns = [{
                    data: 'id',
                    name: 'id',

                },
                {
                    data: "national_id",
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
                    data: "name",
                    name: "name",
                    render: function(data, type, row) {
                        var showUrl = '{{ route('users.show', 0) }}'.replace('/0', '/' + row.id);
                        return `<a href="${showUrl}">${data}</a>`;
                    }
                },
                {
                    data: "email",
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
                    data: "phone",
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
                    data: "voted_by",
                    name: "voted_by",
                },


                {
                    data: "status",
                    name: "status"
                },
                {
                    data: "action",
                    name: "action"
                }
            ];
            userStageTwoDataTable(null, '{{ route('users.index') }}', UserStage1Columns, 0, 3, vote_id,
                vote_detail_id, stage_id);

        });




        // ===============================
        // 📌  functions for stage two users datatable
        // ===============================
        async function userStageTwoDataTable(showRoute, routeOfShow, columns, orderByColumn = 0, showCol = 3, vote_id =
            null, vote_detail_id = null, stage_id) {
            let table = $('#userStage2DataTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: routeOfShow,
                    data: function(d) {
                        if (vote_id) d.vote_id = vote_id;
                        if (vote_detail_id) d.vote_detail_id = vote_detail_id;
                        if (stage_id) d.stage_id = stage_id;
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










        // ===============================
        // 📌 handle show UserStage third  datatable 
        // ===============================
        document.addEventListener("DOMContentLoaded", function() {
            let vote_id = {{ $obj->id ?? 'null' }};
            let vote_detail_id = {{ $thirdDetail ? $thirdDetail->id : $firstDetail->id }};
            let stage_id = 3;

            // UserStage1 table
            let UserStage1Columns = [{
                    data: 'id',
                    name: 'id',

                },
                {
                    data: "national_id",
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
                    data: "name",
                    name: "name",
                    render: function(data, type, row) {
                        var showUrl = '{{ route('users.show', 0) }}'.replace('/0', '/' + row.id);
                        return `<a href="${showUrl}">${data}</a>`;
                    }
                },
                {
                    data: "email",
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
                    data: "phone",
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
                    data: "voted_by",
                    name: "voted_by",
                },
                {
                    data: "status",
                    name: "status"
                },
                {
                    data: "action",
                    name: "action"
                }
            ];
            userStageThreeDataTable(null, '{{ route('users.index') }}', UserStage1Columns, 0, 3, vote_id,
                vote_detail_id, stage_id);

        });




        // ===============================
        // 📌  functions for stage third users datatable
        // ===============================
        async function userStageThreeDataTable(showRoute, routeOfShow, columns, orderByColumn = 0, showCol = 3, vote_id =
            null, vote_detail_id = null, stage_id) {
            let table = $('#userStage3DataTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: routeOfShow,
                    data: function(d) {
                        if (vote_id) d.vote_id = vote_id;
                        if (vote_detail_id) d.vote_detail_id = vote_detail_id;
                        if (stage_id) d.stage_id = stage_id;
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






        // Handle make-vote button click
        // $(document).on('click', '.make-vote-btn', function() {
        //     let userId = $(this).data('user-id');
        //     let voteId = $(this).data('vote-id');
        //     let voteDetailId = $(this).data('vote-detail-id');

        //     // Fill modal form values
        //     $('#vote_user_id').val(userId);
        //     $('#vote_id').val(voteId);
        //     $('#vote_detail_id').val(voteDetailId);

        //     // Show modal
        //     $('#makeVoteModal').modal('show');
        // });

        $(document).on('click', '.make-vote-btn', function() {
            let userId = $(this).data('user-id');
            let voteId = $(this).data('vote-id');
            let voteDetailId = $(this).data('vote-detail-id');

            // Fill hidden inputs
            $('#vote_user_id').val(userId);
            $('#vote_id').val(voteId);
            $('#vote_detail_id').val(voteDetailId);

            // Reset form & remove old preview
            $('#makeVoteForm')[0].reset();
            $('#voteFilePreview').remove();

            // Fetch existing vote data
            $.ajax({
                url: '{{ route('votes.getVoteData') }}',
                type: 'GET',
                data: {
                    user_id: userId,
                    vote_id: voteId,
                    vote_detail_id: voteDetailId
                },
                success: function(response) {
                    if (response.exists) {
                        // Fill existing data
                        if (response.vote_action === 'yes') {
                            $('#vote_yes').prop('checked', true);
                        } else if (response.vote_action === 'no') {
                            $('#vote_no').prop('checked', true);
                        }

                        // Show uploaded file if exists
                        if (response.file_url) {
                            let fileUrl = response.file_url;
                            let fileExt = fileUrl.split('.').pop().toLowerCase();
                            let previewHtml = '';

                            if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExt)) {
                                previewHtml = `
                            <div class="mt-3 text-center" id="voteFilePreview">
                                <img src="${fileUrl}" alt="Vote File" class="img-fluid rounded shadow">
                            </div>`;
                            } else {
                                previewHtml = `
                            <div class="mt-3 text-center" id="voteFilePreview">
                                <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    {{ trns('view_uploaded_file') }}
                                </a>
                            </div>`;
                            }

                            $('#vote_file').closest('.form-group').append(previewHtml);
                        }
                    } else {
                        $('#voteFilePreview').remove();
                    }

                    // Show modal after loading data
                    $('#makeVoteModal').modal('show');
                },
                error: function() {
                    alert('Error loading vote data.');
                    $('#makeVoteModal').modal('show');
                }
            });
        });


        // Handle form submit
        $('#makeVoteForm').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this); // ✅ بدل serialize()

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                contentType: false, // ✅ ضروري علشان الملفات تتبعت
                processData: false, // ✅ ضروري علشان FormData يفضل كما هو
                success: function(response) {
                    // Hide modal
                    $('#makeVoteModal').modal('hide');

                    // Reset form
                    $('#makeVoteForm')[0].reset();

                    // Reload datatables
                    window.location.reload();
                    $('#userStage1DataTable').DataTable().ajax.reload(null, false);
                    $('#userStage2DataTable').DataTable().ajax.reload(null, false);
                    $('#userStage3DataTable').DataTable().ajax.reload(null, false);

                    // Success toast
                    toastr.success(response.message || 'Vote recorded successfully');
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong');
                }
            });
        });
    </script>






    <script>
        initCantDeleteModalHandler();
        $(document).ready(function() {
            // Configure modal event listeners
            $('#delete_modal_of_show').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var title = button.data('title');
                var modal = $(this);
                modal.find('.modal-body #delete_id').val(id);
                modal.find('.modal-body #title').text(title);
            });

            $(document).on('click', '#delete_btn_of_show', function() {
                var id = $("#delete_id").val();
                var routeOfDelete = "{{ route('votes.destroy', ':id') }}".replace(':id', id);

                $.ajax({
                    type: 'DELETE',
                    url: routeOfDelete,
                    data: {
                        '_token': "<?php echo e(csrf_token()); ?>",
                        'id': id
                    },
                    success: function(data) {
                        if (data.status === 200) {
                            $('#delete_modal').modal('hide');


                            Swal.fire({
                                title: '<span style="margin-bottom: 50px; display: block;"><?php echo e(trns('success')); ?></span>',
                                imageUrl: '<?php echo e(asset('true.png')); ?>',
                                imageWidth: 80,
                                imageHeight: 80,
                                imageAlt: 'Success',
                                showConfirmButton: false,
                                timer: 500,
                                customClass: {
                                    image: 'swal2-image-mt30'
                                }
                            });
                            // retrun redirect to table

                            setTimeout(function() {
                                window.location.href = "{{ route('votes.index') }}";
                            }, 1000)


                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '<?php echo e(trns('Deletion failed')); ?>',
                                text: data.message ||
                                    '<?php echo e(trns('Something went wrong')); ?>',
                                confirmButtonText: '<?php echo e(trns('OK')); ?>'
                            });
                        }
                    },

                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: '<?php echo e(trns('Error')); ?>',
                            text: xhr.responseJSON?.message ||
                                '<?php echo e(trns('Something went wrong')); ?>',
                            confirmButtonText: '<?php echo e(trns('OK')); ?>'
                        });
                    }
                });
            });
        });
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
        $(document).on('click', '.editBtn', function() {
            var id = $(this).data('id')
            var url = '{{ route($editRoute . '.edit', ':id') }}';
            url = url.replace(':id', id)
            $('#modal-body').html(loader)
            $('#editOrCreate').modal('show');
            $('#editOrCreate .modal-title').text('تعديل التصويت');

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

        $(document).on('submit', '.votes_update_form', function(e) {

            e.preventDefault();
            var formData = new FormData(this);
            var id = $(this).data('id');
            var url = '{{ route('votes.update', ':id') }}'.replace(':id', id);
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






        $(document).on('click', '.toggleStatusBtn', function(e) {
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





        //  revoting js 
        {{--        show revote modal --}}
        var routeRevoteShow = "{{ route('votes.revoteShow', ':id') }}";

        $(document).on('click', '.revote_btn', function() {
            var id = {{ $obj->id }};
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




        //     revote store script
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
                            title: '<span style="margin-bottom: 50px; display: block;"><?php echo e(trns('changed_successfully')); ?></span>',
                            imageUrl: '<?php echo e(asset('true.png')); ?>',
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
                            title: '<?php echo e(trns('something_went_wrong')); ?>'
                        });
                    }

                    if (data.redirect) {
                        setTimeout(function() {
                            window.location.href = data.redirect;
                        }, 1000);
                    } else {

                        $('#dataTable').DataTable().ajax.reload();
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);

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

@endsection
