@extends('admin/layouts/master')

@section('title')
    {{ config()->get('app.name') }} | {{ trns('court_case') }}
@endsection
@section('page_name')
    {{ trns('court_case') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title"> {{ trns('court_case') }}</h3>
                    <div class="">
                        <button class="btn btn-icon text-white addBtn" style="border: none;">
                            <span>
                                <i class="fe fe-plus"></i>
                            </span> {{ trns('add_new_case') }}
                        </button>
                        {{-- Search Button --}}
                        <button class="btn btn-icon text-white {{ lang() == 'ar' ? 'ms-2' : 'me-2' }}" data-bs-toggle="modal"
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
                            </span>
                            {{ trns('search') }}
                        </button>
                        <button
                            class="btn {{ lang() == 'ar' ? 'ms-2' : 'me-2' }} btn-icon text-white exportExcel  exportBtn">
                            <span>
                                <img style="height: 24px;" src="{{ asset('assets/export.png') }}" alt="">
                            </span> {{ trns('export') }}
                        </button>
                        <button
                            class="btn {{ lang() == 'ar' ? 'ms-2' : 'me-2' }} btn-icon text-white addExcelFile importBtn">
                            <span>
                                <img style="height: 24px;" src="{{ asset('assets/import.png') }}" alt="">
                            </span> {{ trns('import') }}
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

        <!-- Search Modal -->
        <div class="modal fade" id="search_modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ trns('search') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="search_select" class="form-label">{{ trns('chose_filter') }}</label>
                            <select class="form-select" id="search_select" name="search_select">
                                <option value="" selected>{{ trns('chose_filter') }}</option>
                                <option value="case_number">{{ trns('case_number') }}</option>
                                <option value="case_type">{{ trns('case_type') }}</option>
                                <option value="case_date">{{ trns('case_date') }}</option>
                                <option value="created_at">{{ trns('stuplish_at') }}</option>
                                <option value="owner_id">{{ trns('owner_name') }}</option>
                                <option value="RealState_name">{{ trns('RealState name') }}</option>
                            </select>
                        </div>
                        <div class="mb-3" id="search_input_group">
                            <label for="search" class="form-label">{{ trns('search_term') }}</label>
                            <input type="text" id="search" name="search_value" class="form-control"
                                placeholder="{{ trns('enter_search_text') }}">
                        </div>

                    </div>
                    <div class="modal-footer d-flex flex-column">
                        <div class="d-flex justify-content-end w-100 mb-2">
                            <button type="button" class="btn btn-danger"
                                id="reset_search">{{ trns('reset_search') }}</button>
                        </div>
                        <div class="d-flex w-100">
                            <button type="button" class="btn btn-one" id="search_btn">{{ trns('search') }}</button>
                            <button type="button" class="btn btn-two"
                                data-bs-dismiss="modal">{{ trns('close') }}</button>
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

        <!-- Can't Delete Modal -->
        <div class="modal fade" id="cantDeleteModal" tabindex="-1" aria-labelledby="cantDeleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ trns('delete') }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning mt-3" role="alert">
                            <p id="cantDeleteMessage" class="text-danger fw-bold fs-7">
                                {{ trns('sorry_you_cannot_delete_this_case_it_has_related_meetings') }}</p>
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

        <!-- Create Or Edit Modal -->
        <div class="modal fade" id="editOrCreate" data-backdrop="static" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">{{ trns('court_case_details') }}</h5>
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
                        <button type="button" class="btn btn-two" data-bs-dismiss="modal" id="dismiss_delete_modal">
                            {{ trns('close') }}
                        </button>
                        <button type="button" class="btn btn-one statusStopReasonBtn"
                            id="change_status">{{ trns('change_Status') }} !</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.layouts.NewmyAjaxHelper')
@endsection
@section('ajaxCalls')
    <script>
        var columns = [
            {
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
        ]

        const showRoute = "{{ route($route . '.show', ['court_case' => ':id']) }}";

        showData(showRoute, "{{ route($route . '.index') }}", columns, 0, 2);

        // Delete Using Ajax
        deleteScript('{{ route($route . '.destroy', ':id') }}');
        // Add Using Ajax
        showAddModal('{{ route($route . '.create') }}');
        addScript();
        // Add Using Ajax
        showEditModal('{{ route($route . '.edit', ':id') }}');
        editScript();

        $(document).on('click', '.cantDeleteButton', function() {
            var id = $(this).data('id');
            var url = routeOfEdit.replace(':id', id);

            $('#modal-body').html(loader);
            $('#cantDeleteModal').modal('show');
            if (titleModal != null) {
                $('#modalTitle').text(titleModal);
            }

            setTimeout(function() {
                $('#modal-body').load(url);
            }, 500);
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
                    } else {
                        toastr.error("{{ trns('something_went_wrong') }}");
                    }
                },
                error: function() {
                    toastr.error("{{ trns('something_went_wrong') }}");
                }
            });
        });


        // search script 
        // search js
        // change the inputs according to the selection in the search modal
        $(document).ready(function() {
            $("#search_select").on("change", function() {
                let val = $(this).val();
                let html = '';

                if (val === "case_type") {
                    html = `<label for="search" class="form-label">{{ trns('search_term') }}</label>
                    <select id="search" name="search_value" class="form-control">
                        @foreach ($case_types as $case_type)
                    <option value='{{ $case_type->id }}'>{{ $case_type->getTranslation('title', app()->getLocale()) }}</option>
                        @endforeach
                    </select>`;
                } else if (val === "owner_id") {
                    html = `<label for="search" class="form-label">{{ trns('search_term') }}</label>
                    <select id="search" name="search_value" class="form-control">
                        @foreach ($users as $users)
                    <option value='{{ $users->id }}'>{{ $users->name }}</option>
                        @endforeach
                    </select>`;
                } else if (val === "RealState_name") {
                    html = `<label for="search" class="form-label">{{ trns('search_term') }}</label>
                    <select id="search" name="search_value" class="form-control">
                        @foreach ($realStates as $realState)
                    <option value='{{ $realState->id }}'>{{ $realState->getTranslation('name', app()->getLocale()) }}</option>
                        @endforeach
                    </select>`;
                } else if (val === "case_date") {
                    html =
                        `<label for="search" class="form-label">{{ trns('search_term') }}</label>
                        <input onclick="this.showPicker()" type="date" id="search" name="search_value" class="form-control">`;
                } else if (val === "created_at") {
                    html =
                        `<label for="search" class="form-label">{{ trns('search_term') }}</label>
                        <input onclick="this.showPicker()" type="date" id="search" name="search_value" class="form-control">`;
                } else if (val === "case_number") {
                    html =
                        `<label for="search" class="form-label">{{ trns('search_term') }}</label>
                        <input type="number" id="search" name="search_value" class="form-control" placeholder="{{ trns('enter_search_text') }}">`;
                } else {
                    html =
                        `<label for="search" class="form-label">{{ trns('search_term') }}</label>
                        <input type="text" id="search" name="search_value" class="form-control" placeholder="{{ trns('enter_search_text') }}">`;
                }


                $("#search_input_group").html(html).show();

                $("select#search").select2({
                    width: '100%',
                    dropdownParent: $('#search_modal')
                });
            });

            // Reset button
            $("#reset_search").on("click", function() {
                $("#search_select").val("");
                $("#search_input_group").html(
                    `<label for="search" class="form-label">{{ trns('search_term') }}</label>
                                        <input type="text" id="search" name="search_value" class="form-control" placeholder="{{ trns('enter_search_text') }}">`
                );
                $('#dataTable').DataTable().ajax.reload();
                $('#search_modal').modal('hide');
            });
        });

        CustomSearchSelectionAndRequest({
            selectId: 'search_select',
            inputWrapperId: 'search_input_group',
            inputId: 'search',
            searchButtonId: 'search_btn',
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
                if (val == "establish_date") {
                    $("#search_input_group").find("input[name='search_id']").attr("type", "date");
                    $("#search_input_group").find("input[name='search_id']").val("");
                } else {
                    $("#search_input_group").find("input[name='search_id']").attr("type", "text");
                    $("#search_input_group").find("input[name='search_id']").val("");
                }
            });
        });


        $("#search_select").on("change", function() {
            $("#search_input_group").show();
        });

        $('#search_modal').on('shown.bs.modal', function() {
            $('select[name="search_select"]').select2({
                width: '100%',
                dropdownParent: $('#search_modal')
            });
        });

        // search js




        // export and import script 

        // excep export
        $(document).on('click', '.exportExcel', function() {
            console.log('export excel clicked');
            let $btn = $(this);
            let originalHtml = $btn.html();
            let routeOfShow = '{{ route('court_case.extract') }}';
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







        $(document).on('click', '.addExcelFile', function() {
            console.log('addExcelFile clicked');
            let routeOfShow = '{{ route('court_case.add.excel') }}';
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
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 200) {

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
                        } else if (response.status == 422) {
                            console.log(response);
                            Swal.fire({
                                icon: 'error',
                                title: '{{ trns('error') }}',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = xhr.responseJSON?.message ||
                            '{{ trns('server_connection_error') }}';
                        if (xhr.responseJSON?.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors)[0][0];
                        }
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('error') }}',
                            text: errorMessage,
                        });
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).html(originalBtnText);
                    }
                });
            });
        }
    </script>
@endsection
