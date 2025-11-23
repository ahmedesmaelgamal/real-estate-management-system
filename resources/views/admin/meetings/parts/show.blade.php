@extends('admin/layouts/master')
@section('title')
    {{ config()->get('app.name') }} | {{ $obj->name }}
@endsection
@section('page_name')
    {{ trns('meeting_management') }}
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
        <div class="modal fade" id="delete_modal_meeting_of_show" tabindex="-1" role="dialog"
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
        </div>
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
                        <button type="button" class="btn btn-danger" id="deleteAgendaBtn">{{ trns('delete_agenda') }}</button>
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
                            <h2>{{ trns('meetings_attendance') }}</h2>
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
                                        <a class="dropdown-item editMeetBtn" href="javascript:void(0);"
                                            data-id="{{ $obj->id }}">
                                            <img src="{{ asset('edit.png') }}" alt="no-icon" class="img-fluid ms-1"
                                                style="width: 24px; height: 24px;">
                                            {{ trns('Edit') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('meetings.download', $obj->id) }}"
                                            data-id="{{ $obj->id }}">
                                            {{ trns('download') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item delayBtn" href="javascript:void(0);"
                                            data-id="{{ $obj->id }}">
                                            {{ trns('delay_meet') }}
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

                                <a href="{{ route('meetings.index') }}" class="btn"
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
                                        {{ trns('basic_information_of_meeting') }}</h4>
                                    <!-- <h4>{{ $obj->name ?? trns('N/A') }}</h4> -->
                                    <hr style="background-color: black;">
                                    <div class="row m-4">
                                        <div class="col-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('meeting_number') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->id ?? trns('N/A') }}</p>
                                        </div>
                                        
                                        <div class="col-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('association name') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->association->name ?? trns('N/A') }}</p>
                                        </div>
                                        
                                        <div class="col-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('topic') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->topic ?? trns('N/A') }}</p>
                                        </div>

                                        <div class="col-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('created_by') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->creator ? $obj->creator->name : trns('N/A') }}</p>
                                        </div>


                                        <div class="col-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('association_owner') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->association->admin->name ?? trns('N/A') }}</p>
                                        </div>

                                        <div class="col-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('date') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->date ?? trns('N/A') }}</p>
                                        </div>

                                        {{-- <div class="col-lg-2 col-md-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('topic') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                <button type="button" class="btn btn-primary" onclick="loadTopics()">
                                                    {{ trns('show_topics') }}
                                                </button>

                                            </p>
                                        </div> --}}

                                        {{-- <div class="col-1 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('agenda') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->agenda->getTranslation('name', app()->getLocale()) ?? trns('N/A') }}
                                            </p>
                                        </div> --}}

                                        @if ($obj->other_topic)
                                            <div class="col-2 mb-4">
                                                <h4 class="text-muted" style="font-size: 12px;">
                                                    {{ trns('other_topic') }}
                                                </h4>
                                                <p class="font-weight-bold" style="font-size: 12px;">
                                                    {{ $obj->other_topic ?? trns('N/A') }}
                                                </p>
                                            </div>
                                        @endif

                                        <div class="col-lg-1 col-md-2 mb-4">
                                            <h4 class="text-muted" style="font-size: 12px;">
                                                {{ trns('address') }}
                                            </h4>
                                            <p class="font-weight-bold" style="font-size: 12px;">
                                                {{ $obj->address ?? trns('N/A') }}</p>
                                        </div>

                                    </div>
                                </div>







                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h1 class="card-title"> {{ trns('agendas_of_meetings') }}</h1>
                                        <div>
                                            <button type="button" class="btn btn-icon text-white addAgendaButton"
                                                style="border: none;">
                                                <span><i class="fe fe-plus"></i></span> {{ trns('add_new_agenda') }}
                                            </button>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <!--begin::Table-->
                                            <table class="table text-nowrap w-100" id="agendaDataTable"
                                                style=" border-radius: 10px 10px 0 0; margin-bottom: 0 !important;">
                                                <thead>
                                                    <tr style="background-color: #e3e3e3; color: #00193a;">
                                                        <th class="rounded-end">#</th>
                                                        <th class="min-w-50px">{{ trns('name') }}</th>
                                                        <th class="min-w-50px">{{ trns('description') }}</th>
                                                        <th class="min-w-50px">{{ trns('date') }}</th>
                                                        <th class="min-w-50px">{{ trns('actions') }}</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>




{{-- 
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h1 class="card-title"> {{ trns('topics_of_meetings') }}</h1>
                                        <div>
                                            <button type="button" class="btn btn-icon text-white addNewTopic"
                                                style="border: none;">
                                                <span><i class="fe fe-plus"></i></span> {{ trns('add_new_topic') }}
                                            </button>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <!--begin::Table-->
                                            <table class="table text-nowrap w-100" id="topicDataTable"
                                                style=" border-radius: 10px 10px 0 0; margin-bottom: 0 !important;">
                                                <thead>
                                                    <tr style="background-color: #e3e3e3; color: #00193a;">
                                                        <th class="rounded-end">#</th>
                                                        <th class="min-w-50px">{{ trns('title') }}</th>
                                                        <th class="min-w-50px">{{ trns('actions') }}</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div> --}}






                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h1 class="card-title"> {{ trns('summary_of_meetings') }}</h1>
                                        <div>
                                            <button type="button" class="btn btn-icon text-white addNewsummary"
                                                style="border: none;">
                                                <span><i class="fe fe-plus"></i></span> {{ trns('add_new_summary') }}
                                            </button>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <!--begin::Table-->
                                            <table class="table text-nowrap w-100" id="dataTable"
                                                style=" border-radius: 10px 10px 0 0; margin-bottom: 0 !important;">
                                                <thead>
                                                    <tr style="background-color: #e3e3e3; color: #00193a;">
                                                        <th class="rounded-end">#</th>
                                                        <th class="min-w-50px">{{ trns('title') }}</th>
                                                        <th class="min-w-50px">{{ trns('description') }}</th>
                                                        <th class="min-w-50px">{{ trns('owner') }}</th>
                                                        <th class="min-w-50px">{{ trns('end_date') }}</th>

                                                        <th class="min-w-50px">{{ trns('actions') }}</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>




            <div class="modal fade" id="show_topics" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ trns('owners') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ trns('topic_name') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_topics_body">
                                        @foreach ($obj->topics as $topic)
                                            <tr>
                                                <td>{{ $topic->getTranslation('title', app()->getLocale()) }}</td>
                                            </tr>
                                        @endforeach
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


    </div>
    @include('admin.layouts.NewmyAjaxHelper')
@endsection
@section('ajaxCalls')
    <script>
        function loadTopics() {
            // Get the modal element
            var myModal = new bootstrap.Modal(document.getElementById('show_topics'), {
                keyboard: false
            });

            myModal.show();
        }
    </script>
    <script>
        // ===============================
        // 📌 handle delete meeting
        // ===============================

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
                var routeOfDelete = "{{ route('meetings.destroy', ':id') }}".replace(':id', id);

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
                                window.location.href = "{{ route('meetings.index') }}";
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
                    window.location.reload();
                    $('#delayMeetModel').modal('hide');
                    toastr.success('Meeting delayed successfully!');
                    $('#dataTable').DataTable().ajax.reload();
                },
                error: function(err) {
                    toastr.error('Failed to update meeting.');
                }
            });
        });







        // ===============================
        // 📌 handle show summary datatable 
        // ===============================
        document.addEventListener("DOMContentLoaded", function() {
            let meeting_id = {{ $obj->id ?? 'null' }};

            // Summary table
            let summaryColumns = [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'owner_id',
                    name: 'owner_id'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];
            showSummaryData(null, '{{ route('meetSummary.index') }}', summaryColumns, 0, 3, meeting_id);



            // ===============================
            // 📌 handle topic datatable 
            // ===============================
            // Topic table
            let topicColumns = [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];
            showTopicData(null, '{{ route('topics.index') }}', topicColumns, 0, 3, meeting_id);




            // ===============================
            // 📌 handle agenda datatable 
            // ===============================
            let agendaColumns = [{
                    data: 'id',
                    name: 'id'
                }, {

                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];
            showAgendaData(null, '{{ route('agenda.index') }}', agendaColumns, 0, 3, meeting_id);
        });




        // ===============================
        // 📌 doube functions for summary and topic datatable
        // ===============================
        async function showSummaryData(showRoute, routeOfShow, columns, orderByColumn = 0, showCol = 3, meeting_id = null) {
            let table = $('#dataTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: routeOfShow,
                    data: function(d) {
                        if (meeting_id) d.meeting_id = meeting_id;
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



        async function showTopicData(showRoute, routeOfShow, columns, orderByColumn = 0, showCol = 3, meeting_id = null) {
            let table = $('#topicDataTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: routeOfShow,
                    data: function(d) {
                        if (meeting_id) d.meeting_id = meeting_id;
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
                $('#topicDataTable tbody').on('click', `tr td:nth-child(${showCol})`, function(e) {
                    if ($(e.target).is('input, button, a, .delete-checkbox, .editBtn, .statusBtn')) return;
                    let id = $(this).closest('tr').data('id');
                    if (id) window.location.href = showRoute.replace(':id', id);
                });
            }
        }



        async function showAgendaData(showRoute, routeOfShow, columns, orderByColumn = 0, showCol = 3, meeting_id = null) {
            let table = $('#agendaDataTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: routeOfShow,
                    data: function(d) {
                        if (meeting_id) d.meeting_id = meeting_id;
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
                $('#topicDataTable tbody').on('click', `tr td:nth-child(${showCol})`, function(e) {
                    if ($(e.target).is('input, button, a, .delete-checkbox, .editBtn, .statusBtn')) return;
                    let id = $(this).closest('tr').data('id');
                    if (id) window.location.href = showRoute.replace(':id', id);
                });
            }
        }
    </script>



    <script>
        // ===============================
        // 📌 update meet
        // ===============================

        $(document).on('click', '.editMeetBtn', function() {
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
                $('#modal-body').load(url);
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
                    setTimeout(function() {
                        window.location.reload(); // ✅ fixed typo here
                    }, 1000);

                    $('#meetingsUpdatebtn').html('{{ trns('update') }}').attr('disabled', false);
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
                    $('#meetingsUpdatebtn').html('{{ trns('update') }}').attr('disabled', false);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });

        {{-- end or updatea and edit --}}




        // ===============================
        // 📌 update the topic
        // ===============================
        $(document).on('click', '.editTopicBtn', function() {
            var id = $(this).data('id');
            var url = '{{ route('topics.edit', ':id') }}'.replace(':id', id);

            $('#modal-body').html(loader);
            $('#editOrCreate').modal('show');
            $('#editOrCreate .modal-title').text('{{ trns('edit_topic') }}');

            // Footer buttons
            $('#modal-footer').html(`
                <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('close') }}</button>
                    <button type="button" class="btn btn-one me-2" id="updateTopicButton" data-id="${id}">{{ trns('update') }}</button>
                </div>
            `);

            setTimeout(function() {
                $('#modal-body').load(url);
            }, 500);
        });

        $(document).on('click', '#updateTopicButton', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            var form = $('#updateForm');
            var formData = new FormData(form[0]);
            var url = '{{ route('topics.update', ':id') }}'.replace(':id', id);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#updateTopicButton').html(
                            '<span class="spinner-border spinner-border-sm mr-2"></span> {{ trns('loading...') }}'
                        )
                        .attr('disabled', true);
                },
                success: function(data) {
                    if (data.status == 200) {
                        Swal.fire({
                            title: '{{ trns('updated_successfully') }}',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false
                        });
                        $('#topicDataTable').DataTable().ajax.reload();
                        $('#editOrCreate').modal('hide');
                    } else if (data.status == 405) {
                        toastr.error(data.mymessage);
                    } else {
                        toastr.error('{{ trns('something_went_wrong') }}');
                    }
                    $('#updateTopicButton').html('{{ trns('update') }}').attr('disabled', false);
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
                    $('#updateTopicButton').html('{{ trns('update') }}').attr('disabled', false);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });



        // ===============================
        // 📌 Edit Meet Summary Modal
        // ===============================
        $(document).on('click', '.editSummaryButton', function() {
            var id = $(this).data('id');
            var url = '{{ route('meetSummary.edit', ':id') }}'.replace(':id', id);

            $('#modal-body').html(loader);
            $('#editOrCreate').modal('show');
            $('#editOrCreate .modal-title').text('{{ trns('edit_meet_summary') }}');

            $('#modal-footer').html(`
                <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('close') }}</button>
                    <button type="button" class="btn btn-one me-2" id="updateSummaryButton" data-id="${id}">
                        {{ trns('update') }}
                    </button>
                </div>
            `);

            // Load form
            $('#modal-body').load(url, function() {
                console.log("Form loaded!");
            });
        });


        // ===============================
        // 📌 Update Meet Summary
        // ===============================
        $(document).on('click', '#updateSummaryButton', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            var form = $('.meetSummaryUpdateForm');
            var formData = new FormData(form[0]);
            formData.append('_method', 'PUT');
            var url = '{{ route('meetSummary.update', ':id') }}'.replace(':id', id);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#updateSummaryButton').html(
                            '<span class="spinner-border spinner-border-sm mr-2"></span> {{ trns('loading...') }}'
                        )
                        .attr('disabled', true);
                },
                success: function(data) {
                    if (data.status == 200) {
                        toastr.success('{{ trns('updated_successfully') }}');
                        $('#dataTable').DataTable().ajax.reload();
                        $('#editOrCreate').modal('hide');
                    } else if (data.status == 405) {
                        toastr.error(data.mymessage);
                    } else {
                        toastr.error('{{ trns('something_went_wrong') }}');
                    }
                    $('#updateSummaryButton').html('{{ trns('update') }}').attr('disabled', false);
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
                    $('#updateSummaryButton').html('{{ trns('update') }}').attr('disabled', false);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });

        // ===============================
        // 📌 add summary code  
        // ===============================
        $(document).on('click', '.addNewsummary', function() {
            let routeOfShow = @json(route('meetSummary.create'));

            $('#modal-footer').html(`
                <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('close') }}</button>
                    <button type="submit" class="btn btn-one me-2" id="addSummaryBtn">{{ trns('create') }}</button>
                </div>
            `);

            $('#modal-body').html(loader);
            $('#editOrCreate').modal('show');

            setTimeout(function() {
                $('#modal-body').load(routeOfShow);
            }, 250);
        });
        // ===============================
        // 📌 submit summary code 
        // ===============================
        // submit form via ajax
        $(document).on('click', '#addSummaryBtn', function(e) {
            e.preventDefault();

            // clear old errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            let form = $('#addForm')[0];
            let formData = new FormData(form);
            formData.append("meet_id", "{{ $obj->id }}");



            let url = $('#addForm').attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#addSummaryBtn')
                        .html(
                            '<span class="spinner-border spinner-border-sm mr-2"></span> {{ trns('loading...') }}'
                        )
                        .attr('disabled', true);
                },
                success: function(data) {
                    $('#addSummaryBtn').html('{{ trns('create') }}').attr('disabled', false);

                    $('#dataTable').DataTable().ajax.reload();
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
                            $('#editOrCreate').modal('hide');
                            $('#dataTable').DataTable().ajax.reload();
                        }
                    } else {
                        toastr.error(data.mymessage ?? '{{ trns('something_went_wrong') }}');
                    }
                },
                error: function(xhr) {
                    $('#addSummaryBtn').html('{{ trns('create') }}').attr('disabled', false);

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


        // ===============================
        // 📌 add topic code 
        // ===============================
        $(document).on('click', '.addNewTopic', function() {
            let routeOfShow = @json(route('topics.create'));

            $('#modal-footer').html(`
                <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('close') }}</button>
                    <button type="submit" class="btn btn-one me-2" id="addNewTopicBtn">{{ trns('create') }}</button>
                </div>
            `);

            $('#modal-body').html(loader);
            $('#editOrCreate').modal('show');

            setTimeout(function() {
                $('#modal-body').load(routeOfShow);
            }, 250);
        });
        // ===============================
        // 📌 submit meet topic
        // ===============================
        // submit form via ajax
        $(document).on('click', '#addNewTopicBtn', function(e) {
            e.preventDefault();

            // clear old errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            let form = $('.topicAddForm')[0];
            let formData = new FormData(form);
            formData.append("meet_id", "{{ $obj->id }}");



            let url = $('.topicAddForm').attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#addNewTopicBtn')
                        .html(
                            '<span class="spinner-border spinner-border-sm mr-2"></span> {{ trns('loading...') }}'
                        )
                        .attr('disabled', true);
                },
                success: function(data) {
                    $('#addNewTopicBtn').html('{{ trns('create') }}').attr('disabled', false);

                    $('topicDataTable').DataTable().ajax.reload();
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
                            $('#editOrCreate').modal('hide');
                            $('#topicDataTable').DataTable().ajax.reload();
                        }
                    } else {
                        toastr.error(data.mymessage ?? '{{ trns('something_went_wrong') }}');
                    }
                },
                error: function(xhr) {
                    $('#addNewTopicBtn').html('{{ trns('create') }}').attr('disabled', false);

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






        // delete for summary
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
                let routeOfDelete = "{{ route('meetSummary.destroy', ':id') }}".replace(':id', id);

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

                            $('#dataTable').DataTable().ajax.reload();


                            // إعادة تحميل الصفحة بعد ثانية
                            // setTimeout(function () {
                            //     window.location.reload();
                            // }, 900);
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
















        // Delete for Agenda
        $(document).ready(function() {
            // لما المودال يتفتح، نحط البيانات
            $('#delete_modal_of_agenda').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let id = button.data('id');
                let title = button.data('title');

                $('#delete_agenda_id').val(id);
                $('#agenda_title').text(title);
            });

            // لما يضغط على زر الحذف
            $('#deleteAgendaBtn').on('click', function() {
                let id = $('#delete_agenda_id').val();
                let routeOfDelete = "{{ route('agenda.destroy', ':id') }}".replace(':id', id);

                $.ajax({
                    type: 'DELETE',
                    url: routeOfDelete,
                    data: {
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        if (data.status === 200) {
                            // اقفل المودال
                            let modal = bootstrap.Modal.getInstance(document.getElementById(
                                'delete_modal_of_agenda'));
                            modal.hide();

                            // إشعار نجاح
                            Swal.fire({
                                title: '{{ trns('deleted_successfully') }}',
                                icon: 'success',
                                timer: 800,
                                showConfirmButton: false
                            });

                            // إعادة تحميل الجدول
                            $('#agendaDataTable').DataTable().ajax.reload();
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









        // ===============================
        // 📌 add agenda code 
        // ===============================
        $(document).on('click', '.addAgendaButton', function() {
            let routeOfShow = @json(route('agenda.create'));

            $('#modal-footer').html(`
                <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('close') }}</button>
                    <button type="submit" class="btn btn-one me-2" id="addNewAgendaButton">{{ trns('create') }}</button>
                </div>
            `);

            $('#modal-body').html(loader);
            $('#editOrCreate').modal('show');

            setTimeout(function() {
                $('#modal-body').load(routeOfShow);
            }, 250);
        });
        // ===============================
        // 📌 submit meet topic
        // ===============================
        // submit form via ajax
        $(document).on('click', '#addNewAgendaButton', function(e) {
            e.preventDefault();

            // clear old errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            let form = $('.agendaAddForm')[0];
            let formData = new FormData(form);
            formData.append("meet_id", "{{ $obj->id }}");



            let url = $('.agendaAddForm').attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#addNewAgendaButton')
                        .html(
                            '<span class="spinner-border spinner-border-sm mr-2"></span> {{ trns('loading...') }}'
                        )
                        .attr('disabled', true);
                },
                success: function(data) {
                    $('#addNewAgendaButton').html('{{ trns('create') }}').attr('disabled', false);

                    $('agendaDataTable').DataTable().ajax.reload();
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
                            $('#editOrCreate').modal('hide');
                            $('#agendaDataTable').DataTable().ajax.reload();
                        }
                    } else {
                        toastr.error(data.mymessage ?? '{{ trns('something_went_wrong') }}');
                    }
                },
                error: function(xhr) {
                    $('#addNewAgendaButton').html('{{ trns('create') }}').attr('disabled', false);

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





        // ===============================
        // 📌 update the agenda
        // ===============================
        $(document).on('click', '.editAgendaButton', function() {
            var id = $(this).data('id');
            var url = '{{ route('agenda.edit', ':id') }}'.replace(':id', id);

            $('#modal-body').html(loader);
            $('#editOrCreate').modal('show');
            $('#editOrCreate .modal-title').text('{{ trns('edit_topic') }}');

            // Footer buttons
            $('#modal-footer').html(`
                <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('close') }}</button>
                    <button type="button" class="btn btn-one me-2" id="updateAgendaButton" data-id="${id}">{{ trns('update') }}</button>
                </div>
            `);

            setTimeout(function() {
                $('#modal-body').load(url);
            }, 500);
        });

        $(document).on('click', '#updateAgendaButton', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            var form = $('#updateForm');
            var formData = new FormData(form[0]);
            var url = '{{ route('agenda.update', ':id') }}'.replace(':id', id);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#updateAgendaButton').html(
                            '<span class="spinner-border spinner-border-sm mr-2"></span> {{ trns('loading...') }}'
                        )
                        .attr('disabled', true);
                },
                success: function(data) {
                    if (data.status == 200) {
                        Swal.fire({
                            title: '{{ trns('updated_successfully') }}',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false
                        });
                        $('#agendaDataTable').DataTable().ajax.reload();
                        $('#editOrCreate').modal('hide');
                    } else if (data.status == 405) {
                        toastr.error(data.mymessage);
                    } else {
                        toastr.error('{{ trns('something_went_wrong') }}');
                    }
                    $('#updateAgendaButton').html('{{ trns('update') }}').attr('disabled', false);
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
                    $('#updateAgendaButton').html('{{ trns('update') }}').attr('disabled', false);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    </script>
@endsection
