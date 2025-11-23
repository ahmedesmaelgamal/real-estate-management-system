@extends('admin/layouts/master')

@section('title')
    {{ config()->get('app.name') }} | {{ $bladeName }}
@endsection
@section('page_name')
    {{ $bladeName }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
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
            </div>
            <div class="">
                <div class="d-flex justify-content-between">
                    <h3 class="fw-bold mb-0" style="color: #00193a;"> {{ $bladeName }} </h3>
                    <div class="">
                        @can('create_unit')
                            <button class="btn btn-icon text-white addBtn">
                                <span>
                                    <i class="fe fe-plus"></i>
                                </span> {{ trns('add_unit') }}
                            </button>
                        @endcan

                        <button
                            class="btn btn-icon {{ lang() == 'ar' ? 'me-2' : 'ms-2' }} text-white exportExcel  exportBtn">
                            <span>
                                <img style="height: 24px;" src="{{ asset('assets/export.png') }}" alt="">
                            </span> {{ trns('export') }}
                        </button>

                        <button class="btn btn-icon ms-2 me-2 text-white addExcelFile importBtn">
                            <span>
                                <img style="height: 24px;" src="{{ asset('assets/import.png') }}" alt="">
                            </span> {{ trns('import') }}
                        </button>


                        <button class="btn btn-icon {{ lang() == 'ar' ? 'ms-2' : 'me-2' }} text-white"
                            data-bs-toggle="modal" data-bs-target="#search_modal">
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


                        @can('update_unit')
                            <button class="btn {{ lang() == 'ar' ? 'ms-2' : 'me-2' }} btn-icon text-white" id="bulk-update"
                                disabled>
                                <span><i class="fe fe-trending-up"></i></span> {{ trns('update selected') }}
                            </button>
                        @endcan

                        @can('delete_unit')
                            <button class="btn btn-icon text-white" id="bulk-delete" disabled>
                                <span><i class="fe fe-trash"></i></span> {{ trns('delete selected') }}
                            </button>
                        @endcan


                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="main-card">
                            <div>
                                <h2 class="fw-bold">{{ $allUnites }}</h2>
                                <h4>العدد الكلى</h4>
                            </div>
                            <div>
                                <img src="{{ asset('assets/greatwall_line.png') }}" alt="Building Icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="main-card">
                            <div>
                                <h2 class="fw-bold">{{ $activeUnites }}</h2>
                                <h4>النشط</h4>
                            </div>
                            <div>
                                <img src="{{ asset('assets/active.png') }}" alt="Building Icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="main-card">
                            <div>
                                <h2 class="fw-bold">{{ $inactiveUnites }}</h2>
                                <h4>الغير نشط</h4>
                            </div>
                            <div>
                                <img src="{{ asset('assets/inactive.png') }}" alt="Building Icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="table-responsive" style="overflow-x: inherit;">
                        <!--begin::Table-->
                        <table class="table text-nowrap w-100" id="dataTable"
                            style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;">
                            <thead>
                                <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">
                                    <th class="min-w-25px rounded-end">
                                        <input type="checkbox" id="select-all">
                                    </th>
                                    <th class="min-w-25px">{{ trns('series') }}</th>
                                    <th class="min-w-25px">{{ trns('unit_code') }}</th>

                                    <th class="min-w-25px">{{ trns('owners_name') }}</th>
                                    <th class="min-w-25px">{{ trns('RealStates_number') }}</th>
                                    <th class="min-w-25px">{{ trns('unit_number') }}</th>
                                    <th class="min-w-25px">{{ trns('unit_space') }}</th>
                                    <th class="min-w-25px">{{ trns('floor_count') }}</th>
                                    <th class="min-w-25px">{{ trns('assocation_name') }}</th>
                                    <th class="min-w-25px">{{ trns('status') }}</th>
                                    <th class="min-w-50px rounded-start">{{ trns('actions') }}</th>
                                </tr>
                            </thead>
                        </table>
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
                        <p>{{ trns('are_you_sure_you_want_to_delete_this_obj') }} </p>

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

        <!--Search MODAL -->
        <div class="modal fade" id="search_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ trns('search') }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="search_select" class="form-label">{{ trns('chose_filter') }}</label>
                            <select class="form-select" id="search_select" name="search_select">
                                <option value="" selected>{{ trns('chose_filter ') }}</option>
                                <option value="unit_code"> {{ trns('unit_code') }}</option>
                                <option value="RealStates_number"> {{ trns('RealStates_number') }}</option>
                                <option value="unit_number"> {{ trns('unit_number') }}</option>
                                <option value="floor_count"> {{ trns('floor_count') }}</option>
                                <option value="assocation_name"> {{ trns('assocation_name') }}</option>
                            </select>
                        </div>

                        <input id="search_input" name="search" type="text" class="form-control">
                    </div>
                    <div class="modal-footer d-flex flex-column">
                        <div class="d-flex justify-content-end w-100">
                            <button type="button" class="btn btn-danger"
                                id="reset_search">{{ trns('reset_search') }}</button>
                        </div>

                        <div class="d-flex w-100">
                            <button type="button" class="btn" id="search_btn"
                                style="background-color: #00193a; color: #00F3CA; border: none;padding: 5px 50px; margin-left: 10px; font-size: 16px; font-weight: bold; width: 50%;">{{ trns('search') }}</button>
                            <button type="button" class="btn" data-bs-dismiss="modal" id="dismiss_delete_modal"
                                style="padding: 5px 50px; font-size: 16px; font-weight: bold; background-color: #DFE3E7; color: #676767; width: 50%;">
                                {{ trns('cancel') }}
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Search CLOSED -->
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

        <!-- Search CLOSED -->




        <!-- Create Or Edit Modal -->
        <div class="modal fade" id="editOrCreate" data-backdrop="static" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">{{ trns('add_unit') }}</h5>
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


        <!-- Edit Owner Modal -->
        <div class="modal fade" id="editOwners" data-backdrop="static" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <!-- Content will be loaded via AJAX -->
                </div>
            </div>
        </div>
        <!-- Edit Owner Modal -->

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


        <!-- update cols selected  Modal -->
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
                    <div class="modal-body">
                        <p>{{ trns('are_you_sure_you_want_to_update_selected_items') }}</p>
                    </div>
                    <div class="modal-footer d-flex flex-nowrap">
                        <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('cancel') }}</button>
                        <button type="button" class="btn btn-one" id="confirm-update-btn">{{ trns('update') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- delete selected  Modal -->

        <!--stop reason MODAL -->
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
                                class="text-danger"></span>?</p>

                        <div id="stop_reason_div" class="d-none"> <!-- d-none = hidden -->
                            <label>{{ trns('stop_reason') }}</label>
                            <textarea class="form-control" id="stop_reason" name="stop_reason"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer d-flex flex-nowrap">
                        <button type="button" class="btn btn-two" data-bs-dismiss="modal" id="dismiss_delete_modal">
                            {{ trns('close') }}
                        </button>
                        <button type="button" class="btn btn-one statusStopReasonBtn"
                            id="change_status">{{ trns('change_Status') }} !</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL CLOSED -->





        <!-- addExcelFile Modal -->
        <div class="modal fade" id="addExcelFile" tabindex="-1" aria-labelledby="addExcelFileLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addExcelFileLabel">استيراد ملف Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-excel-body">
                    </div>
                </div>
            </div>
        </div>
        <!-- addExcelFile Modal -->
        @include('admin.layouts.NewmyAjaxHelper')
    @endsection
    @section('ajaxCalls')
        <script>
            function showEditUsers(routeTemplate) {
                $(document).on('click', '.editOwners', function() {
                    let id = $(this).data('id');
                    console.log(id)

                    if (!id) {
                        console.error('No ID found for this element');
                        return;
                    }

                    // Replace the placeholder with the actual ID
                    let url = routeTemplate.replace(':id', id);
                    console.log(url)

                    // Show loading state
                    $('#editOwners .modal-content').html(`
            <div class="modal-body text-center py-4">
                <i class="fas fa-spinner fa-spin fa-3x"></i>
            </div>
        `);

                    $('#editOwners').modal('show');

                    $.get(url)
                        .done(function(data) {
                            $('#editOwners .modal-content').html(data);
                        })
                        .fail(function(xhr) {
                            let errorMsg = xhr.responseJSON?.message || 'Failed to load content';
                            $('#editOwners .modal-content').html(`
                    <div class="modal-body">
                        <div class="alert alert-danger">${errorMsg}</div>
                    </div>
                `);
                        });
                });
            }

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
                let currentStatus = parseInt($(this).data('status'));
                let newStatus = currentStatus === 1 ? 0 : 1;

                $.ajax({
                    type: 'POST',
                    url: "{{ route($route . '.StopReason') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': id,
                        'stop_reason': stop_reason,
                        'status': newStatus
                    },
                    success: function(data) {
                        if (data.status === 200) {
                            toastr.success("{{ trns('status_changed_successfully') }}");
                            $('#bulk-delete').prop('disabled', "false");
                            $('#bulk-update').prop('disabled', "false");
                            $('#select-all').prop('checked', "false");
                            const modalEl = document.getElementById('stopReason_modal');
                            bootstrap.Modal.getOrCreateInstance(modalEl).hide();
                            $("#stop_reason").val('');


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



            // select buttons

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

            // Initialize with proper route template
            $(document).ready(function() {
                // Make sure the route is properly generated in Blade
                showEditUsers('{{ route('units.editOwners', ':id') }}');
            });

            // $(document).on('click', '#search_btn', function() {
            //     const table = $('#dataTable').DataTable();
            //     table.draw();
            //     $('#search_modal').modal('hide');
            // });


            $(document).on('click', '#search_btn', function() {
                const table = $('#dataTable').DataTable();
                const searchValue = $('#search').val();
                const searchSelect = $('#search_select').val();

                // Reload the DataTable with additional search parameters
                table.ajax.reload({
                    data: {
                        search: searchValue,
                        search_select: searchSelect
                    }
                }, false); // false means don't reset paging

                $('#search_modal').modal('hide');
            });


            var columns = [{
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `<input type="checkbox" class="delete-checkbox" value="${row.id}">`;
                    }
                },


                {
                    data: null,
                    name: 'order',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'unit_code',
                    name: 'unit_code',
                    render: function(data, type, row) {
                        var showUrl = '{{ route($route . '.show', 0) }}'.replace('/0', '/' + row.id);
                        return `<a href="${showUrl}">${data}</a>`;
                    }
                },
                {
                    data: 'user_id',
                    name: 'user_id'
                },

                {
                    data: 'real_state_number',
                    name: 'real_state_number'
                },
                {
                    data: 'unit_number',
                    name: 'unit_number'
                }, {
                    data: 'space',
                    name: 'space'
                },
                {
                    data: 'floor_count',
                    name: 'floor_count'
                },
                {
                    data: 'assocation_name',
                    name: 'assocation_name'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];

            $("#search_select").on("change", function() {
                $("#search_input_group").show();
            });


            $('#search_modal').on('shown.bs.modal', function() {
                $('select[name="search_select"]').select2({
                    width: '100%',
                    dropdownParent: $('#search_modal')
                });
            });

            const ajax = {
                url: "{{ route($route . '.index') }}",
                data: function(d) {
                    d.search_select = $('#search_select').val(); // Changed from $('select[name="search_select"]')
                    d.search = $('#search_input').val(); // Changed from $('input[name="search_id"]')
                }
            };

            $(document).on('click', '#search_btn', function() {
                const table = $('#dataTable').DataTable();
                table.draw();
                $('#search_modal').modal('hide');
            });




            $("#reset_search").on("click", function() {
                $("#search_input").val("");
                $("#search_select").val("id");
                const table = $('#dataTable').DataTable();
                table.draw();
                $('#search_modal').modal('hide');
            });


            const showRoute = @json(route($route . '.show', ['unit' => ':id']));

            showData(showRoute, "{{ route($route . '.index') }}", columns, 1);

            $(document).ready(function() {
                $("#search_select").on("change", function() {
                    let val = $(this).val();
                    if (val == "created_at") {
                        $("#search_input_group").find("input[name='search_id']").attr("type", "date");
                        $("#search_input_group").find("input[name='search_id']").val("");
                    } else {
                        $("#search_input_group").find("input[name='search_id']").attr("type", "text");
                        $("#search_input_group").find("input[name='search_id']").val("");
                    }
                });
            });

            deleteScript('{{ route($route . '.destroy', ':id') }}');

            showAddModal('{{ route($route . '.create') }}');
            addScript();
            showEditModal('{{ route($route . '.edit', ':id') }}');
            editScript();
        </script>

        <script>
            $(document).on('click', '.addExcelFile', function() {
                let routeOfShow = '{{ route('unit.add.excel') }}';
                $('#modal-excel-body').html(loader);
                $('#addExcelFile').modal('show');

                setTimeout(function() {
                    $('#modal-excel-body').load(routeOfShow, function() {
                        initExcelForm();
                    });
                }, 250);
            });

            function initExcelForm() {
                $('#excel-import-form').on('submit', function(e) {
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
                            $('#addExcelFile').modal('hide');
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
                            $('#dataTable').DataTable().ajax.reload(null, false);
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

            $(document).on('click', '.exportExcel', function() {
                console.log('export excel clicked');
                let $btn = $(this);
                let originalHtml = $btn.html();
                let routeOfShow = '{{ route('units.export') }}';
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
            $(document).on('click', '#confirm-delete-btn', function() {
                let ids = $('.delete-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (ids.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: '{{ trns('please_select_items_first') }}'
                    });
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: "{{ route($route . '.deleteSelected') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        ids: ids,
                    },
                    success: function(data) {
                        $('#deleteConfirmModal').modal('hide');

                        if (data.status === 200) {
                            Swal.fire({
                                icon: 'success',
                                title: '{{ trns('deleted_successfully') }}',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#bulk-delete').prop('disabled', true);
                            $('#bulk-update').prop('disabled', true);
                            $('#select-all').prop('checked', false);
                            $('#dataTable').DataTable().ajax.reload(null, false);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ trns('something_went_wrong') }}'
                            });
                        }
                    },
                    error: function() {
                        $('#deleteConfirmModal').modal('hide');
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('something_went_wrong') }}'
                        });
                    }
                });
            });




            $(document).on('click', '#confirm-update-btn', function() {
                let ids = $('.delete-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (ids.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: '{{ trns('please_select_items_first') }}'
                    });
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: '{{ route($route . '.updateColumnSelected') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        ids: ids,
                        status: 1
                    },
                    success: function(data) {
                        $('#updateConfirmModal').modal('hide');

                        if (data.status === 200) {
                            Swal.fire({
                                icon: 'success',
                                title: '{{ trns('updated_successfully') }}',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#bulk-delete').prop('disabled', true);
                            $('#bulk-update').prop('disabled', true);
                            $('#select-all').prop('checked', false);
                            $('#dataTable').DataTable().ajax.reload(null, false);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ trns('something_went_wrong') }}'
                            });
                        }
                    },
                    error: function() {
                        $('#updateConfirmModal').modal('hide');
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('something_went_wrong') }}'
                        });
                    }
                });
            });



            $(document).on('click', '.toggleStatusBtn', function(e) {
                e.preventDefault();

                let id = $(this).data('id');
                let currentStatus = parseInt($(this).data('status'));
                let newStatus = currentStatus === 1 ? 0 : 1;

                $.ajax({
                    type: 'POST',
                    url: "{{ route($route . '.updateColumnSelected') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        ids: [id],
                        status: newStatus
                    },
                    success: function(data) {
                        if (data.status === 200) {
                            Swal.fire({
                                icon: 'success',
                                title: '{{ trns('status_changed_successfully') }}',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#bulk-delete').prop('disabled', true);
                            $('#bulk-update').prop('disabled', true);
                            $('#select-all').prop('checked', false);
                            $('#dataTable').DataTable().ajax.reload(null, false);
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
                            } else {
                                toastr.warning('Success', "{{ trns('inactive') }}");
                            }
                        } else {
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
            $('#select-all').on('click', function() {
                const isChecked = $(this).is(':checked');
                $('.delete-checkbox').prop('checked', isChecked);
            });
        </script>
    @endsection
