@extends('admin/layouts/master')

@section('title')
    {{ config()->get('app.name') }} | {{ $bladeName }}
@endsection
@section('page_name')
    {{ $bladeName }}
@endsection
@section('content')
    <div class="row ">

        <div class="col-md-12 col-lg-12 ">
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

            <div class="col-3 w-50">

            </div>
            <div class="">
                <div class="row">
                    <div class="col-4">
                        <h2 class="fw-bold mb-0" style="color: #00193a;">{{trns('real_state_management')}}</h2>
                    </div>
                    <div class="col-8 d-flex justify-content-end">
                        @can('create_real_state')
                            <button class="btn btn-icon text-white addBtn" data-bs-toggle="modal"
                                data-bs-target="#editOrCreate">
                                <span><i class="fe fe-plus"></i></span> {{ trns('add_new') }}
                            </button>
                        @endcan

                        <button class="btn ms-2 me-2 btn-icon text-white" data-bs-toggle="modal"
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

                        <button class="btn {{ lang() == 'ar' ? 'ms-2' : 'me-2' }} btn-icon text-white exportExcel  exportBtn">
                            <span>
                                <img style="height: 24px;" src="{{ asset('assets/export.png') }}" alt="">
                            </span> {{ trns('export') }}
                        </button>
                        <button class="btn {{ lang() == 'ar' ? 'ms-2' : 'me-2' }} btn-icon text-white addExcelFile importBtn">
                            <span>
                                <img style="height: 24px;" src="{{ asset('assets/import.png') }}" alt="">
                            </span> {{ trns('import') }}
                        </button>
                        @can('delete_real_state')
                            <button class="btn {{ lang() == 'ar' ? 'ms-2' : 'me-2' }} btn-icon text-white" id="bulk-delete-selected" disabled>
                                <span><i class="fe fe-trash"></i></span> {{ trns('delete selected') }}
                            </button>
                        @endcan

                        @can('update_real_state')
                            <button class="btn  btn-icon text-white" id="bulk-update-selected" disabled>
                                <span><i class="fe fe-trending-up"></i></span> {{ trns('update selected') }}
                            </button>
                        @endcan



                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="main-card">
                            <div>
                                <h2 class="fw-bold">{{ $allRealState }}</h2>
                                <h4>العدد الكلى</h4>
                            </div>
                            <div>
                                <img src="{{ asset('assets/building_1_line.png') }}" alt="Building Icon" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="main-card">
                            <div>
                                <h2 class="fw-bold">{{ $activeRealState }}</h2>
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
                                <h2 class="fw-bold">{{ $inactiveRealState }}</h2>
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
                        <table class="table text-nowrap w-100"
                            style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;"
                            id="dataTable">
                            <thead>
                                <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">
                                    <th class="min-w-25px">
                                        <input type="checkbox" id="select-all">
                                    </th>
                                    <th>{{ trns('series') }}</th>
                                    <th class="min-w-50px">{{ trns('real_state_name') }}</th>
                                    <th class="min-w-50px">{{ trns('real_State_location') }}</th>
                                    <th class="min-w-50px">{{ trns('unitNumber') }}</th>
                                    <th class="min-w-50px">{{ trns('created_at_realState') }}</th>
                                    <th class="min-w-50px">{{ trns('status') }}</th>
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

        <!-- Create Or Edit Modal -->
        <div class="modal fade" id="editOrCreate" data-backdrop="static" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">{{ trns('add_realState') }}</h5>
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
                        <!-- Form content will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
        <!-- addExcelFile Modal -->



        <!-- Search MODAL -->
        <div class="modal fade" id="search_modal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="searchModalLabel">{{ trns('search') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="search_select" class="form-label">{{ trns('chose_filter') }}</label>
                            <select class="form-select" id="search_select" name="search_select">
                                <option value="" selected>{{ trns('chose_filter') }}</option>
                                <option value="name">{{ trns('real_state_name') }}</option>
                                <option value="unitNumber">{{ trns('unitNumber') }}</option>
                                <option value="association_id">{{ trns('association_id') }}</option>
                                <option value="created_at">{{ trns('created_at') }}</option>
                            </select>
                        </div>

                        <div class="mb-3" id="search_input_group">
                            <label for="search" class="form-label">{{ trns('search_term') }}</label>
                            <input type="text" class="form-control" id="search" name="search_id"
                                placeholder="{{ trns('enter_search_term') }}">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="dismiss_delete_modal">
                            {{ trns('close') }}
                        </button>
                        <button type="button" class="btn btn-success" id="search_btn">{{ trns('search') }}</button>
                        <button type="button" class="btn btn-danger" id="reset_search">
                            {{ trns('reset_search') }}!
                        </button>
                    </div>

                </div>
            </div>
        </div>
        <!-- Search CLOSED -->


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
    <script>
        var columns = [{
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    var hasRelations = row.has_relations;
                    var typeAttr = hasRelations ? 'update' : 'both';
                    return `<input type="checkbox" class="row-checkbox" data-type="${typeAttr}"  data-related="units" data-message="other_real_states" value="${row.id}" data-name="${row.name}">`;
                }
            },
            {
                data: 'id',
                name: 'id',
                visible: false
            },
            {
                data: 'name',
                name: 'name',
                render: function(data, type, row) {
                    var showUrl = '{{ route($route . '.show', 0) }}'.replace('/0', '/' + row.id);
                    return `<a href="${showUrl}">${data}</a>`;
                }
            },
            {
                data: 'location',
                render: function(data, type, row) {
                    return `
                        <button
                            class="copy-btn"
                            title="Copy"
                            data-copy="${data}"
                            style="cursor:pointer;border:none;background-color:transparent;">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                        <span class="copy-text">{{ trns('location') }}</span>
                    `;
                }
            },
            {
                data: 'unitNumber',
                name: 'unitNumber'
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
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]

        initBulkActions('{{ route($route . '.deleteSelected') }}', '{{ route($route . '.updateColumnSelected') }}');

        const showRoute = @json(route($route . '.show', ['real_state' => ':id']));

        showData(showRoute, "{{ route($route . '.index') }}", columns, 1);


        $(document).ready(function() {
            $("#search_input_group").hide();
        })


        {{-- created at part  --}}
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

        {{-- const ajax = {
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




        $("#reset_search").on("click", function(){
            $("#search_input").val(" ");
            $("#search_select").val(" ");
            const table = $('#dataTable').DataTable();
            table.draw();
            $('#search_modal').modal('hide');
        }); --}}




        initCantDeleteModalHandler();

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
        $('#editOrCreate').on('hidden.bs.modal', function() {
            $(this).find('.modal-body').html('');
        });
    </script>





    <script>
        {{-- search --}}


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
                            $('#dataTable').DataTable().ajax.reload(null, false);
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
        $(document).on('click', '.addExcelFile', function() {
            console.log('addExcelFile clicked');
            let routeOfShow = '{{ route('real_state.add.excel') }}';
            $('#modal-excel-body').html(loader);
            $('#addExcelFile').modal('show');

            setTimeout(function() {
                $('#modal-excel-body').load(routeOfShow, function() {
                    initExcelForm();
                });
            }, 250);
        });


        $(document).on('click', '.exportExcel', function() {
            console.log('export excel clicked');
            let $btn = $(this);
            let originalHtml = $btn.html();
            let routeOfShow = '{{ route('real_states.export') }}';
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
    </script>



    <script>
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

        $("#search_select").on("change", function() {
            $("#search_input_group").show();
        });


        $('#search_modal').on('shown.bs.modal', function() {
            $('select[name="search_select"]').select2({
                width: '100%',
                dropdownParent: $('#search_modal')
            });
        });
    </script>
@endsection
