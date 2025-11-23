@extends('admin/layouts/master')

@section('title')
    {{ config()->get('app.name') . '| ' . $bladeName }}
@endsection
@section('page_name')
    {{ $bladeName }}
@endsection
@section('content')
    <style>
        .fa-regular {
            z-index: 100;
        }

        .fa-regular:hover {
            cursor: pointer;
            background-color: #DFE3E7;
        }
    </style>
    <div class="row">
        <div class="text-center">
            @if (session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif


            @if (session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif


            {{-- In your users.index view --}}
            @if (request()->has('edit_user') && request()->has('show_modal'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        console.log('Attempting to open modal for user:', {{ request('edit_user') }});

                        const editRoute = '{{ route('users.edit', ':id') }}'.replace(':id', {{ request('edit_user') }});
                        console.log('Edit route:', editRoute);

                        console.log('showEditModal function exists');
                        showEditModal(editRoute);

                    });
                </script>
            @endif
        </div>
        <div class="col-md-12 col-lg-12">
            <div class="">
                <div class="d-flex justify-content-between">
                    <h2 class="fw-bold" style="color: #00193a; margin-bottom: 0px;">{{ trns('votes') }}</h2>
                    <div class=" d-flex">

                        @can('create_user')
                            <button class="btn btn-icon text-white addBtn" data-type="create" style="border: none;">
                                <span>
                                    <i class="fe fe-plus"></i>
                                </span> {{ trns('add_vote') }}
                            </button>
                        @endcan
                        <button class="btn {{ lang() == 'ar' ? 'ms-2' : 'me-2' }} mr-3 btn-icon text-white exportExcel  exportBtn">
                            <span>
                                <img style="height: 14px;" src="{{ asset('assets/export.png') }}" alt="">
                            </span> {{ trns('export') }}
                        </button>

                        <button class="btn {{ lang() == 'ar' ? 'ms-2' : 'me-2' }} btn-icon text-white addExcelFile importBtn">
                            <span>
                                <img style="height: 14px;" src="{{ asset('assets/import.png') }}" alt="">
                            </span> {{ trns('import') }}
                        </button>



                        <button class="btn btn-icon text-white ms-2 me-2" data-bs-toggle="modal"
                            data-bs-target="#search_modal">
                            <span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_428_5663)">
                                        <path
                                            d="M14 17C14.2549 17.0003 14.5 17.0979 14.6854 17.2728C14.8707 17.4478 14.9822 17.687 14.9972 17.9414C15.0121 18.1958 14.9293 18.4464 14.7657 18.6418C14.6021 18.8373 14.3701 18.9629 14.117 18.993L14 19H10C9.74512 18.9997 9.49997 18.9021 9.31463 18.7272C9.1293 18.5522 9.01776 18.313 9.00283 18.0586C8.98789 17.8042 9.07067 17.5536 9.23426 17.3582C9.39785 17.1627 9.6299 17.0371 9.883 17.007L10 17H14ZM17 11C17.2652 11 17.5196 11.1054 17.7071 11.2929C17.8946 11.4804 18 11.7348 18 12C18 12.2652 17.8946 12.5196 17.7071 12.7071C17.5196 12.8946 17.2652 13 17 13H7C6.73478 13 6.48043 12.8946 6.29289 12.7071C6.10536 12.5196 6 12.2652 6 12C6 11.7348 6.10536 11.4804 6.29289 11.2929C6.48043 11.1054 6.73478 11 7 11H17ZM20 5C20.2652 5 20.5196 5.10536 20.7071 5.29289C20.8946 5.48043 21 5.73478 21 6C21 6.26522 20.8946 6.51957 20.7071 6.70711C20.5196 6.89464 20.2652 7 20 7H4C3.73478 7 3.48043 6.89464 3.29289 6.70711C3.10536 6.51957 3 6.26522 3 6C3 5.73478 3.10536 5.48043 3.29289 5.29289C3.48043 5.10536 3.73478 5 4 5H20Z"
                                            fill="white" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_428_5663">
                                            <rect width="24" height="24" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </span> {{ trns('search') }}
                        </button>

                            <button class="btn {{ lang() == 'ar' ? 'ms-2' : 'me-2' }} btn-icon text-white"
                                id="bulk-delete-selected" disabled>
                                <span><i class="fe fe-trash"></i></span> {{ trns('delete selected') }}
                            </button>

                            <button class="btn btn-icon text-white" id="bulk-update-selected" disabled>
                                <span><i class="fe fe-trending-up"></i></span> {{ trns('update selected') }}
                            </button>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="main-card">
                            <div>
                                <h2 class="fw-bold">{{ $totalCount }}</h2>
                                <h4 class="fw-bold">{{ trns('total_count') }}</h4>
                            </div>
                            <div>
                                <img src="{{ asset('assets/building_4_line.png') }}" alt="Building Icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="main-card">
                            <div>
                                <h2 class="fw-bold">{{ $inactiveCount }}</h2>
                                <h4 class="fw-bold">{{ trns('closed') }}</h4>
                            </div>
                            <div>
                                <img src="{{ asset('assets/inactive.png') }}" alt="Building Icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">

                        <div class="main-card">
                            <div>
                                <h2 class="fw-bold">{{ $activeCount }}</h2>
                                <h4 class="fw-bold">{{ trns('working') }}</h4>
                            </div>
                            <div>
                                <img src="{{ asset('assets/active.png') }}" alt="Building Icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <div class="table-responsive" style="overflow-x: inherit;">
                        <!--begin::Table-->
                        <table class="table text-nowrap w-100"
                            style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;"
                            id="dataTable">
                            <thead>
                                <tr class="fw-bolder" style="background-color: #E9E9E9; color: #00193a;">
                                    <th class="min-w-25px rounded-end">
                                        <input type="checkbox" id="select-all">
                                    </th>
                                    <th>#</th>
                                    <th class="min-w-50px">{{ trns('association_name') }}</th>
                                    {{-- <th class="min-w-50px">{{ trns('title') }}</th>
                                    <th class="min-w-50px">{{ trns('description') }}</th> --}}
                                    <th class="min-w-50px">{{ trns('stuplish_at') }}</th>
                                    <th class="min-w-50px">{{ trns('vote_start_date')   }}</th>
                                    <th class="min-w-50px">{{ trns('vote_end_date') }}</th>
                                    {{-- <th class="min-w-25px">{{ trns('owners_number') }}</th> --}}
                                    <th class="min-w-25px">{{ trns('audience_number') }}</th>
                                    {{-- <th class="min-w-50px">{{ trns('unVoted_number') }}</th> --}}
                                    <th class="min-w-50px">{{ trns('status') }}</th>
                                    <th class="min-w-50px rounded-start">{{ trns('actions') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <!-- addExcelFile Modal -->
        <div class="modal fade" id="addExcelFile" tabindex="-1" aria-labelledby="addExcelFileLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="addExcelFileLabel">{{ trns('import_excel_file') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-excel-body">

                    </div>
                </div>
            </div>
        </div>
        <!-- addExcelFile Modal -->

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

        <!-- Create Or Edit Modal -->
        <div class="modal fade" id="editOrCreate" data-backdrop="static" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">{{ trns('vote_details') }}</h5>
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
                        <p>
                            {{ trns('are_you_sure_you_want_to_delete_these_items') }}
                        </p>
                        <div class="selected-names-list mt-2"></div>
                        <div class="alert_massage"></div>

                    </div>

                    <div class="d-flex border-top">
                        <button type="button" class="btn btn-one m-2"
                            data-bs-dismiss="modal">{{ trns('cancel') }}</button>
                        <button type="button" class="btn btn-two m-2"
                            id="confirm-delete-btn">{{ trns('delete') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- delete selected  Modal -->

        <!-- update selected  Modal -->
        <div class="modal fade" id="updateConfirmModal" tabindex="-1" role="dialog"
            aria-labelledby="updateConfirmModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmModalLabel">{{ trns('confirm_change') }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pt-4 pb-4">
                        <p>{{ trns('are_you_sure_you_want_to_update_selected_items') }}</p>
                    </div>
                    <div class="d-flex border-top">
                        <button type="button" class="btn btn-one m-2"
                            data-bs-dismiss="modal">{{ trns('cancel') }}</button>
                        <button type="button" class="btn btn-two m-2"
                            id="confirm-update-btn">{{ trns('update') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- update selected  Modal -->



        <!-- addExcelFile Modal -->
        <div class="modal fade" id="addExcelFile" tabindex="-1" aria-labelledby="addExcelFileLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="addExcelFileLabel">{{ trns('import_excel_file') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-excel-body">

                    </div>
                </div>
            </div>
        </div>
        <!-- addExcelFile Modal -->



        <!-- Search MODAL -->
        <div class="modal fade" id="search_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ trns('search') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="search_select" class="form-label">{{ trns('chose_filter') }}</label>
                            <select class="form-select" id="search_select" name="search_select">
                                <option value="" selected disabled>{{ trns('choose_search_type') }}</option>
                                <option value="association_id">{{ trns('association') }}</option>
                                <option value="start_date">{{ trns('vote_start_date') }}</option>
                                <option value="end_date">{{ trns('vote_end_date') }}</option>
                                <option value="audience_count">{{ trns('audience_number') }}</option>
                                <option value="status">{{ trns('status') }}</option>
                                <option value="created_at">{{ trns('created_at') }}</option>
                            </select>
                        </div>

                        <div class="mb-3" id="search_input_group">
                            <label for="search" class="form-label">{{ trns('search_term') }}</label>
                            <input type="text" id="search" name="search_id" class="form-control"
                                placeholder="{{ trns('enter_search_text') }}">
                        </div>


                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer d-flex flex-column">
                        <div class="d-flex justify-content-end w-100">
                            <button type="button" class="btn btn-danger" id="reset_search">
                                {{ trns('reset_search') }}!
                            </button>
                        </div>
                        <div class="d-flex w-100">
                            <button type="button" class="btn btn-one" id="search_btn">{{ trns('search') }}</button>
                            <button type="button" class="btn btn-two" data-bs-dismiss="modal"
                                id="dismiss_delete_modal">
                                {{ trns('close') }}
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        

        {{-- // close search model --}}
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


    </div>

    @include('admin/layouts/NewmyAjaxHelper')
@endsection

@section('ajaxCalls')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        @php
            $user_id = null;
        @endphp
        var columns = [

            {
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    var hasRelations = row.has_relations;
                    var typeAttr = hasRelations ? 'update' : 'both';
                    return `<input type="checkbox" class="row-checkbox" data-type="${typeAttr}"  data-related="units" data-message="users" value="${row.id}" data-name="${row.name}">`;
                }
            },
            {
              data : "id",
              name : "id"
            },
            {
                data: 'association_id',
                name: 'association_id',

            },
            // {
            //     data: 'title',
            //     name: 'title',
            // },
            // {
            //     data: 'description',
            //     name: 'description',
            // },
            {
                data: "created_at",
                name : "created_at"
            },
            {
                data: "start_date",
                name : "start_date"
            }
            ,{
                data: "end_date",
                name : "end_date"
            },
            // {
            //     data: "owners_number",
            //     name : "owners_number"
            // },
            {
                data: "audience_number",
                name : "audience_number"
            }
            ,
            // {
            //     data: "unVoted",
            //     name : "unVoted"
            // },
            {
                data: "status",
                name : "status"
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ];





        const showRoute = @json(route($route . '.show', ['vote' => ':id']))

        showData(showRoute, "{{ route($route . '.index') }}", columns, 1);

        initBulkActions('{{ route($route . '.deleteSelected') }}', '{{ route($route . '.updateColumnSelected') }}');
        initCantDeleteModalHandler();





        const ajax = {
            url: "{{ route($route . '.index') }}",
            data: function(d) {
                d.search_select = $('#search_select').val();
                d.search = $('#search_input').val();
            }
        };

        $(document).on('click', '#search_btn', function() {
            const table = $('#dataTable').DataTable();
            table.draw();
            $('#search_modal').modal('hide');
        });




        $("#reset_search").on("click", function() {
            $("#search_input").val(" ");
            $("#search_select").val(" ");
            const table = $('#dataTable').DataTable();
            table.draw();
            $('#search_modal').modal('hide');
        });





        {{-- search --}}

        $(document).ready(function() {
            $("#search_input_group").hide();
        })


        CustomSearchSelectionAndRequest({
            selectId: 'search_select',
            inputWrapperId: 'search_input_group',
            inputId: 'search',
            searchButtonId: 'search_btn',
            url: '',
            together: false,
            onSuccess: function() {
                currentKeys = [document.getElementById('search_select').value];
                currentValues = [document.getElementById('search').value];
                currentTogether = false;

                $('#dataTable').DataTable().ajax.reload();
                $('#search_modal').modal('hide');
            }
        });

        document.getElementById('reset_search').addEventListener('click', function() {
            document.getElementById('search_select').value = "";
            document.getElementById('search').value = "";
            document.getElementById('search_input_group').style.display = "none";
            $('#search_modal').modal('hide');

            currentKeys = [];
            currentValues = [];
            currentTogether = false;

            $('#dataTable').DataTable().ajax.reload();
        });



        $(document).ready(function() {
            $("#search_select").on("change", function() {
                let val = $(this).val();
                if (val == "created_at" || val == "end_date" || val== "start_date") {
                    $("#search_input_group").find("input[name='search_id']").attr("type", "date");
                    $("#search_input_group").find("input[name='search_id']").val("");
                } else {
                    $("#search_input_group").find("input[name='search_id']").attr("type", "text");
                    $("#search_input_group").find("input[name='search_id']").val("");
                }
            });
        });


        {{-- search  --}}




        // Delete Using Ajax
        deleteScript("{{ route($route . '.destroy', ':id') }}");

        // Add Using Ajax
        showAddModal("{{ route($route . '.create') }}");
        addScript();
        // Add Using Ajax
        showEditModal("{{ route($route . '.edit', ':id') }}");
        editScript();
    </script>


    <script>
        {{--        show revote modal--}}
        var routeRevoteShow = "{{ route($route . '.revoteShow', ':id') }}";

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




//     revote store script
        $(document).on('click', '#revoteButton', function(e) {
            e.preventDefault();
            const form = $('#revote_form')[0];
            const url = @json(route($route . '.revote.revoting'));
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

    <script>
        $(document).on('click', '.toggleStatusBtn', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let currentStatus = parseInt($(this).data('status'));
            let newStatus = currentStatus === 1 ? 0 : 1;

            $.ajax({
                type: 'POST',
                url: '{{ route($route . '.updateColumnSelected') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'ids': [id],
                    'status': newStatus
                },
                success: function(data) {
                    if (data.status === 200) {
                        toastr.success("{{ trns('status_changed_successfully') }}");
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


    <script>
        $('#editOrCreate').on('hidden.bs.modal', function() {
            $(this).find('.modal-body').html(''); // Clear modal content
        });
    </script>

    <script>
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
                            $('#bulk-delete').prop('disabled', true);
                            $('#bulk-update').prop('disabled', true);
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
    </script>




    <script>
        $(document).on('change', '.delete-checkbox, #select-all', function() {
            let anyChecked = $('.delete-checkbox:checked').length > 0;
            $('#bulk-delete').prop('disabled', !anyChecked);
            $('#bulk-update').prop('disabled', !anyChecked);
        });

        $(document).on('change', '#select-all', function() {
            let checked = $(this).is(':checked');
            $('.delete-checkbox').prop('checked', checked).trigger('change');
        });

        $('#bulk-delete').on('click', function() {
            $('#deleteConfirmModal').modal('show');
        });

        $('#bulk-update').on('click', function() {
            $('#updateConfirmModal').modal('show');
        });
    </script>





    <script>
        // export js code
        // excep export
        $(document).on('click', '.exportExcel', function() {
            console.log('export excel clicked');
            let $btn = $(this);
            let originalHtml = $btn.html();
            let routeOfShow = '{{ route('votes.extract') }}';
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Exporting...');
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = routeOfShow;
            document.body.appendChild(iframe);
            setTimeout(() => {
                $btn.prop('disabled', false).html(originalHtml);
                document.body.removeChild(iframe);
            }, 3000);
        });



        //  show import modal
        $(document).on('click', '.addExcelFile', function() {
            console.log('addExcelFile clicked');
            let routeOfShow = '{{ route('votes.add.excel') }}';
            $('#modal-excel-body').html(loader);
            $('#addExcelFile').modal('show');

            setTimeout(function() {
                $('#modal-excel-body').load(routeOfShow, function() {
                    initExcelForm();
                });
            }, 250);
        });
    </script>
@endsection
