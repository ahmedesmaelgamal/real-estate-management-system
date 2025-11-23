@extends('admin.layouts.master')

@section('title', trns('users_details'))
@section('page_name')
    <a href="{{ route('users.index') }}">
        {{ trns('users') }} / {{ $obj?->name }}
    </a>
@endsection

@section('content')
    <div class="">


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

        <div class="container-fulid">
            <!-- Header -->
            <div class="row mb-4 align-items-center">


                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/userAvater.jpg') }}" style="width: 50px;" alt="User Avatar" />


                        <h5 style="color: #1E1E1E; font-weight: bold; font-size: 30px;" class="mb-0">{{ $obj->name }}
                        </h5>

                    </div>




                    <div class="d-flex">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle {{ lang() == 'ar' ? 'ms-2' : 'me-2' }}"
                                style="background-color: #00193b; color: #00F3CA;" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ trns('options') }}
                            </button>
                            <div class="dropdown-menu" style="background-color: #EAEAEA;"
                                aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item editBtn" href="javascript:void(0);" data-id="{{ $obj->id }}">
                                    <img src="{{ asset('edit.png') }}" alt="no-icon" class="img-fluid ms-1"
                                        style="width: 24px; height: 24px;"> {{ trns('Edit') }}

                                </a>
                                <a class="dropdown-item toggleStatusBtn" href="#" data-id="{{ $obj->id }}"
                                    data-status="{{ $obj->status }}">
                                    {{ $obj->status == 1 ? trns('Deactivate_user') : trns('Activate_user') }}
                                </a>

                                <a class="dropdown-item text-danger delete-btn" href="#" id="delete-btn"
                                    data-id="{{ $obj->id }}">
                                    <i class="fas fa-trash ms-2"></i> {{ trns('delete') }}
                                </a>

                            </div>
                        </div>
                        <div>
                            <a href="{{ route('users.index') }}" class="btn"
                                style="transform: rotate(180deg); border: 1px solid gray;">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>


            <!-- User Info Card -->
            <div class="card"
                style="border-radius: 6px;
    background-color: #fbf9f9;
border: 1px solid #ddd;
    padding: 15px;">
                <div class="card-body">
                    <div class="row g-4">

                        <div class="col-12 col-md-3">
                            <h6 class="text-uppercase text-muted">{{ trns('national_id') }}</h6>
                            <p class="fw-bold">
                                {!! $obj->national_id ? copyable_text($obj->national_id) . ' ' . $obj->national_id : trns('no data') !!}
                            </p>
                        </div>

                        <div class="col-12 col-md-3">
                            <h6 class="text-uppercase text-muted">{{ trns('name') }}</h6>
                            <p class="fw-bold">
                                {!! $obj->name ? copyable_text($obj->name) . ' ' . $obj->name : trns('-') !!}
                            </p>
                        </div>


                        <div class="col-12 col-md-3">
                            <h6 class="text-uppercase text-muted">{{ trns('email') }}</h6>
                            <p class="fw-bold">
                                {!! $obj->email ? copyable_text($obj->email) . ' ' . $obj->email : trns('no data') !!}
                            </p>
                        </div>

                        <div class="col-12 col-md-3">
                            <h6 class="text-uppercase text-muted">{{ trns('phone_number') }}</h6>
                            <p class="fw-bold">
                                {!! $obj->phone ? copyable_text(substr($obj->phone, 1)) . ' ' . substr($obj->phone, 1) : trns('no data') !!}
                            </p>
                        </div>

                        <div class="col-12 col-md-3">
                            <h6 class="text-uppercase text-muted">{{ trns('role') }}</h6>
                            <p class="fw-bold">{{ trns('user') }}</p>
                        </div>

                        <div class="col-12 col-md-3">
                            <h6 class="text-uppercase text-muted">{{ trns('status') }}</h6>
                            <p>
                                @if ($obj->status == 1)
                                    <span class="badge px-3 py-2"
                                        style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px">{{ trns('active') }}</span>
                                @else
                                    <span class="badge px-3 py-2"
                                        style="background-color: #FFBABA; color: #1F2A37; border-radius: 30px">{{ trns('inactive') }}</span>
                                @endif
                            </p>
                        </div>

                    </div>



                </div>



            </div>


            <ul class="nav nav-tabs" id="realEstateTabs">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#unitTab">{{ trns('units') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#association_contracts">{{ trns('contracts') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#caseTab">{{ trns('cases') }}</a>
                </li>
            </ul>



        </div>




        <div class="tab-content mt-4">
            <div id="unitTab" class="tab-pane fade show active">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="card-title">{{ trns('units') }}</h1>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap w-100" id="unitDataTable"
                            style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;">
                            <thead>
                                <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">
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

            <div id="association_contracts" class="tab-pane fade">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="card-title">{{ trns('contracts') }}</h1>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap w-100" id="dataTable"
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



            <div id="caseTab" class="tab-pane fade">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="card-title">{{ trns('court_case') }}</h1>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap w-100" id="caseDataTable"
                            style=" border-radius: 10px 10px 0 0; margin-bottom: 0 !important;">
                            <thead>
                                <tr style="background-color: #e3e3e3; color: #00193a;">
                                    <th>{{ trns('id') }}</th>
                                    <th>{{ trns('case_type') }}</th>
                                    <th>{{ trns('case_number') }}</th>
                                    <th>{{ trns('case_date') }}</th>
                                    <th>{{ trns('stuplish_at') }}</th>
                                    <th>{{ trns('owner_name') }}</th>
                                    <th>{{ trns('RealState name') }}</th>
                                    <th>{{ trns('actions') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


        <!-- Create Or Edit Modal -->
        <div class="modal fade" id="editOrCreate" data-bs-backdrop="static" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h5 class="modal-title" id="modalTitle">{{ trns('add new user') }}</h5>
                        <button type="button" class="btn-close m-0" data-bs-dismiss="modal"
                            aria-label="Close"></button>
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

        <!--Delete MODAL -->
        {{-- <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
        </div> --}}
        <!-- MODAL CLOSED -->


        <!--Delete unit MODAL -->
        <div class="modal fade" id="delete_unit_modal" tabindex="-1" role="dialog"
            aria-labelledby="deleteunitModalLabel" aria-hidden="true">
            <div class="modal-dialog model-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteunitModalLabel">{{ trns('delete') }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="delete_unit_id" name="id" type="hidden">
                        <p>{{ trns('are_you_sure_you_want_to_delete_this_obj') }} <span id="delete_unit_title"
                                class="text-danger"></span>?</p>
                    </div>
                    <div class="modal-footer d-flex flex-nowrap">
                        <button type="button" class="btn btn-two" data-bs-dismiss="modal"
                            id="dismiss_delete_unit_modal">
                            {{ trns('close') }}
                        </button>
                        <button type="button" class="btn btn-one" id="delete_unit_btn">{{ trns('delete') }} !</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- unit MODAL CLOSED -->
        
        <!--Delete unit MODAL -->
        <div class="modal fade" id="delete_case_modal" tabindex="-1" role="dialog"
            aria-labelledby="deletecaseModalLabel" aria-hidden="true">
            <div class="modal-dialog model-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deletecaseModalLabel">{{ trns('delete') }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="delete_case_id" name="id" type="hidden">
                        <p>{{ trns('are_you_sure_you_want_to_delete_this_obj') }} <span id="delete_case_title"
                                class="text-danger"></span>?</p>
                    </div>
                    <div class="modal-footer d-flex flex-nowrap">
                        <button type="button" class="btn btn-two" data-bs-dismiss="modal"
                            id="dismiss_delete_case_modal">
                            {{ trns('close') }}
                        </button>
                        <button type="button" class="btn btn-one" id="delete_case_btn">{{ trns('delete') }} !</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- unit MODAL CLOSED -->


        <!-- Delete Contract MODAL -->
        <div class="modal fade" id="delete_contract_modal" tabindex="-1" role="dialog"
            aria-labelledby="deleteContractLabel" aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ trns('delete') }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="delete_contract_id" name="id" type="hidden">
                        <p>{{ trns('are_you_sure_you_want_to_delete_this_obj') }} <span id="delete_contract_title"
                                class="text-danger"></span>?</p>
                    </div>
                    <div class="modal-footer d-flex flex-nowrap">
                        <button type="button" class="btn btn-two" data-bs-dismiss="modal"
                            id="dismiss_delete_contract_modal">
                            {{ trns('close') }}
                        </button>
                        <button type="button" class="btn btn-one" id="delete_contract_btn">{{ trns('delete') }}
                            !</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL CLOSED -->




    </div>

    @include('admin/layouts/NewmyAjaxHelper')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = new bootstrap.Modal(document.getElementById('editOrCreate'));

            document.querySelectorAll('.editBtn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const editUrl = '{{ route('users.edit', ':id') }}'.replace(':id', id);

                    document.getElementById('modalTitle').textContent = '{{ trns('edit_user') }}';

                    fetch(editUrl)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('modal-body').innerHTML = html;
                            editModal.show();
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
                        // footer buttons

                        editModal.show();
                    });
            };
        });
    </script>


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <script>
        $(document).on('click', '.toggleStatusBtn', function(e) {
            e.preventDefault();

            let id = $(this).data('id');
            let currentStatus = parseInt($(this).data('status'));
            let newStatus = currentStatus === 1 ? 0 : 1;

            $.ajax({
                type: 'POST',
                url: '{{ route('users.updateColumnSelected') }}',
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




        {{-- delete button  --}}
        $(document).on('click', '#delete-btn', function() {
            let id = $(this).data('id');

            $.ajax({
                type: 'DELETE',
                url: "{{ route('users.destroy', ':id') }}".replace(':id', id),
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(data) {
                    if (data.status === 200) {
                        toastr.success("{{ trns('deleted_successfully') }}");
                        window.location.href = "{{ route('users.index') }}"; // توجيه بعد الحذف
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
        editScript();





        // show the contracts of this user in datatable
        document.addEventListener("DOMContentLoaded", function() {
            let user_id = {{ $obj->id ?? 'null' }};

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
            showContractDataTable(null, '{{ route('contracts.index') }}', contractColumns, 0, 3, user_id);
        });




        // ===============================
        // 📌  functions for contracts datatable
        // ===============================
        async function showContractDataTable(showRoute, routeOfShow, columns, orderByColumn = 0, showCol = 3, user_id =
            null) {
            let table = $('#dataTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: routeOfShow,
                    data: function(d) {
                        if (user_id) d.user_id = user_id;
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
                    setTimeout(function() {
                        window.location.reload(); // ✅ fixed typo here
                    }, 1000);
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
            // فتح المودال وتهيئة البيانات
            $(document).on('click', '.contractDeleteBtn', function() {
                let id = $(this).data('id');
                let title = $(this).data('title');

                $('#delete_contract_id').val(id);
                $('#delete_contract_title').text(title);

                let modal = new bootstrap.Modal(document.getElementById('delete_contract_modal'));
                modal.show();
            });

            // تنفيذ عملية الحذف
            $('#delete_contract_btn').on('click', function() {
                let id = $('#delete_contract_id').val();
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
                                'delete_contract_modal'));
                            modal.hide();

                            // إشعار بالنجاح
                            Swal.fire({
                                title: '{{ trns('deleted_successfully') }}',
                                icon: 'success',
                                timer: 800,
                                showConfirmButton: false
                            });

                            $('#dataTable').DataTable().ajax.reload();
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




        //  unit datatale handle 
        // show the contracts of this user in datatable
        document.addEventListener("DOMContentLoaded", function() {
            let user_id = {{ $obj->id ?? 'null' }};

            let UnitColumns = [{
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
                        var showUrl = '{{ route('units.show', 0) }}'.replace('/0', '/' + row.id);
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
                },
                {
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

            let table = showUnitDataTable(null, '{{ route('units.index') }}', UnitColumns, 0, 3, user_id);

            // 🔥 مهم جداً — تفعيل الـ dropdown بعد كل draw
            table.on('draw', function() {
                let dropdowns = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
                dropdowns.map(function(el) {
                    return new bootstrap.Dropdown(el);
                });
            });
        });





        // ===============================
        // 📌  functions for unit datatable
        // ===============================
        async function showUnitDataTable(showRoute, routeOfShow, columns, orderByColumn = 0, showCol = 3, user_id =
            null) {
            let table = $('#unitDataTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: routeOfShow,
                    data: function(d) {
                        if (user_id) d.user_id = user_id;
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

        // get owners for the units 
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





        // the unit cruds update and delete 


        // ===============================
        // 📌 update unit
        // ===============================

        $(document).on('click', '.EditUnitBTN', function() {
            var id = $(this).data('id');
            var url = '{{ route('units.edit', ':id') }}'.replace(':id', id);

            $('#modal-body').html(loader);
            $('#editOrCreate').modal('show');
            $('#editOrCreate .modal-title').text('{{ trns('edit_unit') }}');

            $(".modal-dialog").addClass("modal-xl");
            // Footer buttons
            $('#modal-footer').html(`
                <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('close') }}</button>
                    <button type="button" class="btn btn-one me-2" id="unitUpdateBtn" data-id="${id}">{{ trns('update') }}</button>
                </div>
            `);

            setTimeout(function() {
                $('#modal-body').load(url);
            }, 500);
        });


        $(document).on('click', '#unitUpdateBtn', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            var form = $('.units_update_form');
            var formData = new FormData(form[0]);
            formData.append("_method", "PUT");
            var url = '{{ route('units.update', ':id') }}'.replace(':id', id);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#unitUpdateBtn').html(
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
                    $(".modal-dialog").addClass("modal-lg");

                    $('#unitUpdateBtn').html('{{ trns('update') }}').attr('disabled', false);
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
                    $('#unitUpdateBtn').html('{{ trns('update') }}').attr('disabled', false);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });




        // delete unit
        $(document).ready(function() {
            // فتح المودال وتهيئة البيانات
            $(document).on('click', '.deleteunitBtn', function() {
                let id = $(this).data('id');
                let title = $(this).data('title');

                $('#delete_unit_id').val(id);
                $('#delete_unit_title').text(title);

                let modal = new bootstrap.Modal(document.getElementById('delete_unit_modal'));
                modal.show();
            });

            // تنفيذ عملية الحذف
            $('#delete_unit_btn').on('click', function() {
                let id = $('#delete_unit_id').val();
                let routeOfDelete = "{{ route('units.destroy', ':id') }}".replace(':id', id);

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
                                'delete_unit_modal'));
                            modal.hide();

                            // إشعار بالنجاح
                            Swal.fire({
                                title: '{{ trns('deleted_successfully') }}',
                                icon: 'success',
                                timer: 800,
                                showConfirmButton: false
                            });

                            $('#unitDataTable').DataTable().ajax.reload();
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


        // for status
        $(document).on('click', '.toggleUnitStatus', function(e) {
            e.preventDefault();

            let id = $(this).data('id');
            let currentStatus = parseInt($(this).data('status'));
            let newStatus = currentStatus === 1 ? 0 : 1;

            $.ajax({
                type: 'POST',
                url: "{{ route('units.updateColumnSelected') }}",
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
                        $('#unitDataTable').DataTable().ajax.reload(null, false);
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




        //  court case datatable 


        //  case datatale handle 
        // show the case of this user in datatable
        document.addEventListener("DOMContentLoaded", function() {
            let user_id = {{ $obj->id ?? 'null' }};

            let caseColumns = [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'case_type',
                    name: 'case_type'
                },
                {
                    data: 'case_number',
                    name: 'case_number'
                },
                {
                    data: 'case_date',
                    name: 'case_date'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'owner_id',
                    name: 'owner_id'
                },
                {
                    data: 'unit_id',
                    name: 'unit_id'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ];

            let table = showCaseDataTable(null, '{{ route('court_case.index') }}', caseColumns, 0, 3,
                user_id);

            // 🔥 مهم جداً — تفعيل الـ dropdown بعد كل draw
            table.on('draw', function() {
                let dropdowns = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
                dropdowns.map(function(el) {
                    return new bootstrap.Dropdown(el);
                });
            });
        });





        // ===============================
        // 📌  functions for case datatable
        // ===============================
        async function showCaseDataTable(showRoute, routeOfShow, columns, orderByColumn = 0, showCol = 3, user_id =
            null) {
            let table = $('#caseDataTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: routeOfShow,
                    data: function(d) {
                        if (user_id) d.user_id = user_id;
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


        // update case 

        // ===============================
        // 📌 update unit
        // ===============================

        $(document).on('click', '.editCaseBtn', function() {
            var id = $(this).data('id');
            var url = '{{ route('court_case.edit', ':id') }}'.replace(':id', id);

            $('#modal-body').html(loader);
            $('#editOrCreate').modal('show');
            $('#editOrCreate .modal-title').text('{{ trns('edit_case') }}');

            $(".modal-dialog").addClass("modal-xl");
            // Footer buttons
            $('#modal-footer').html(`
                <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('close') }}</button>
                    <button type="button" class="btn btn-one me-2" id="courtCaseUpdateBtn" data-id="${id}">{{ trns('update') }}</button>
                </div>
            `);

            setTimeout(function() {
                $('#modal-body').load(url);
            }, 500);
        });


        $(document).on('click', '#courtCaseUpdateBtn', function(e) {
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
                    $('#courtCaseUpdateBtn').html(
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
                    $(".modal-dialog").addClass("modal-lg");

                    $('#courtCaseUpdateBtn').html('{{ trns('update') }}').attr('disabled', false);
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
                    $('#courtCaseUpdateBtn').html('{{ trns('update') }}').attr('disabled', false);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });


        // for status
        $(document).on('click', '.togglecaseStatus', function(e) {
                e.preventDefault();

                let id = $(this).data('id');
                let currentStatus = parseInt($(this).data('status'));
                let newStatus = currentStatus === 1 ? 0 : 1;

                $.ajax({
                    type: 'POST',
                    url: "{{ route('court_case.updateColumnSelected') }}",
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
                            $('#caseDataTable').DataTable().ajax.reload(null, false);
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

            // delete court case
            // delete case
        $(document).ready(function() {
            // فتح المودال وتهيئة البيانات
            $(document).on('click', '.courtCaseDeleteBtn', function() {
                let id = $(this).data('id');
                let title = $(this).data('title');

                $('#delete_case_id').val(id);
                $('#delete_case_title').text(title);

                let modal = new bootstrap.Modal(document.getElementById('delete_case_modal'));
                modal.show();
            });

            // تنفيذ عملية الحذف
            $('#delete_case_btn').on('click', function() {
                let id = $('#delete_case_id').val();
                let routeOfDelete = "{{ route('court_case.destroy', ':id') }}".replace(':id', id);

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
                                'delete_case_modal'));
                            modal.hide();

                            // إشعار بالنجاح
                            Swal.fire({
                                title: '{{ trns('deleted_successfully') }}',
                                icon: 'success',
                                timer: 800,
                                showConfirmButton: false
                            });

                            $('#caseDataTable').DataTable().ajax.reload();
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


    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection
