@extends('admin/layouts/master')
@section('title')
    {{ config()->get('app.name') }} | {{ trns('admin') }}
@endsection
@section('page_name')
    <a href="{{ route('admins.index') }}">
        {{ trns('admin') }}
    </a>
@endsection
@section('content')
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
        </div>
        <div class="col-md-12 col-lg-12">
            <div class="">
                <div class="d-flex justify-content-between">
                    <h2 class="fw-bold" style="color: #00193a; margin-bottom: 0px;"> {{ trns('admin') }}</h2>
                    <div class="d-flex">

                        @can('create_admin')
                            <button class="btn btn-icon text-white addBtn" style="border: none;">
                                <span>
                                    <i class="fe fe-plus"></i>
                                </span> {{ trns('add new admin') }}
                            </button>
                        @endcan

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
                            </span> {{ trns('filter') }}
                        </button>

                        @can('delete_admin')
                            <button class="btn {{ lang() == 'ar' ? 'ms-2' : 'me-2' }} btn-icon text-white" id="bulk-delete-selected" disabled>
                                <span><i class="fe fe-trash"></i></span> {{ trns('delete selected') }}
                            </button>
                        @endcan

                        @can('update_admin')
                            <button class="btn btn-icon text-white" id="bulk-update-selected" disabled>
                                <span><i class="fe fe-trending-up"></i></span> {{ trns('update selected') }}
                            </button>
                        @endcan

                    </div>
                </div>
                <div class="mt-5">
                    <div class="table-responsive" style="overflow-x: inherit;">

                        <!--begin::Table-->
                        <table class="table text-nowrap w-100 mb-0"
                            style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;"
                            id="dataTable">
                            <thead>
                                <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">
                                    <th class="min-w-25px rounded-end">
                                        <input type="checkbox" id="select-all">
                                    </th>
                                    <th>#</th>
                                    <th class="min-w-50px">{{ trns('national_id') }}</th>
                                    <th class="min-w-50px">{{ trns('admin_name') }}</th>
                                    {{-- <th class="min-w-50px">{{ trns('admin_user_name') }}</th> --}}
                                    <th class="min-w-125px">{{ trns('email') }}</th>
                                    <th class="min-w-125px">{{ trns('phone_number') }}</th>
                                    <!-- <th class="min-w-125px">{{ trns('created at') }}</th> -->
                                    <th class="min-w-125px">{{ trns('status') }}</th>
                                    <th class="min-w-125px">{{ trns('role') }}</th>
                                    {{-- <th class="min-w-125px">{{ trns('role') }}</th> --}}
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
        <div class="modal fade" id="editOrCreate" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">{{ trns('Add New Admin') }}</h5>
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
                    <div class="d-flex flex-nowrap modal-footer">
                        <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('cancel') }}</button>
                        <button type="button" class="btn btn-one" id="confirm-update-btn">{{ trns('update') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- update selected  Modal -->


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
                                <option value="name">{{ trns('user_name') }}</option>
                                <option value="national_id">{{ trns('national_id') }}</option>
                                <option value="email">{{ trns('email') }}</option>
                                <option value="phone">{{ trns('phone') }}</option>
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
    <script>
        var columns = [{
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    var hasRelations = row.has_relations;
                    var typeAttr = hasRelations ? 'update' : 'both';
                    return `<input type="checkbox" class="row-checkbox" data-type="${typeAttr}"  data-related="associations" data-message="admins" value="${row.id}" data-name="${row.name}">`;
                }
            },
            {
                data: 'id',
                name: 'id',
                visible: false
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
                data: 'name',
                name: 'name',
                render: function(data, type, row) {
                    var showUrl = '{{ route($route . '.show', 0) }}'.replace('/0', '/' + row.id);
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
                data: 'status',
                name: 'status'
            },
            {
                data: 'role',
                name: 'role'
            },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },

        ];


        const showRoute = @json(route($route . '.show', ['admin' => ':id']));

        showData(showRoute, "{{ route($route . '.index') }}", columns, 1);
        initBulkActions('{{ route($route . '.deleteSelected') }}', '{{ route($route . '.updateColumnSelected') }}');

        initCantDeleteModalHandler();


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

        deleteScript('{{ route('admins.destroy', ':id') }}');
        showAddModal('{{ route('admins.create') }}');
        addScript();
        showEditModal('{{ route('admins.edit', ':id') }}');
        editScript();

        $('.dropify').dropify();







        $(document).ready(function() {
            $("#search_input_group").hide();
        });



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



        {{-- search  --}}









        {{-- function showEditModalShow(url) {
        $('#modal-body').html(loader);
        $('#editOrCreate').modal('show');

        setTimeout(function() {
            $('#modal-body').load(url);
        }, 500);
    } --}}
    </script>
@endsection
