@extends('admin.layouts.master')

@section('title')
    {{ $bladeName }}
@endsection
@section('page_name')
    <a href="{{ route($route . '.index') }}">
        {{ $bladeName }}
    </a>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="">
                <div class="d-flex justify-content-between">
                    <h2 class="fw-bold" style="color: #00193a; margin-bottom: 0px;">{{ $bladeName }} </h2>

                    <div class="d-flex">
                        <button class="btn btn-icon text-white addBtn">
                            <span>
                                <i class="fe fe-plus"></i>
                            </span> {{ trns('add_new') }}
                        </button>
                        @can('update_association_model')
                            <button class="btn me-2 btn-icon text-white" id="bulk-update" disabled>
                                <span><i class="fe fe-trending-up"></i></span> {{ trns('update selected') }}
                            </button>
                        @endcan
                    </div>
                </div>

               <div class="mt-5">
                    <div class="table-responsive" style="overflow: inherit;">

                        <!--begin::Table-->
                        <table class="table text-nowrap w-100 mb-0" style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;"
                            id="dataTable">
                            <thead>
                                <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">

                                    <th class="min-w-25px">
                                        <input type="checkbox" id="select-all">
                                    </th>

                                    <th class="min-w-50px">#</th>
                                    <th class="min-w-50px">{{ trns('title') }}</th>
                                    <th class="min-w-50px">{{ trns('description') }}</th>
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
                        <h5 class="modal-title" id="example-Modal3">{{ trns('associations_module_details') }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="" id="modal-body">

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
                    return `<input type="checkbox" class="delete-checkbox" value="${row.id}">`;
                }
            },
            {
                data: 'id',
                name: 'id',
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
        showData('{{ route($route . '.index') }}', '{{ route($route . '.index') }}', columns);
        // Delete Using Ajax
        deleteScript('{{ route($route . '.destroy', ':id') }}');
        {{--        deleteSelected('{{route($route.'.deleteSelected')}}'); --}}

        {{--        updateColumnSelected('{{route($route.'.updateColumnSelected')}}'); --}}


        // Add Using Ajax
        showAddModal('{{ route($route . '.create') }}');
        addScript();
        showEditModal('{{ route($route . '.edit', ':id') }}');
        editScript();
    </script>

    <script>


        $(document).on('click', '.toggleAssociationModelBtn', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let currentStatus = $(this).data('status');
            let newStatus = currentStatus === 1 ? 0 : 1;

            $.ajax({
                type: 'POST',
                url: '{{ route('association_models.updateColumnSelected') }}',
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
                    'status': val
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

        {{-- search  --}}
        $(document).on('change', '.delete-checkbox, #select-all', function() {
            let anyChecked = $('.delete-checkbox:checked').length > 0;
            $('#bulk-delete').prop('disabled', !anyChecked);
            $('#bulk-update').prop('disabled', !anyChecked);
        });

        $(document).on('change', '#select-all', function() {
            let checked = $(this).is(':checked');
            $('.delete-checkbox').prop('checked', checked).trigger('change');
        });

        $(document).on('click', '#bulk-update', function() {
            $('#updateConfirmModal').modal('show');
        });

        $(document).on('click', '#confirm-update-btn', function() {
            let ids = $('.delete-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (ids.length === 0) {
                toastr.warning("{{ trns('please_select_items_first') }}");
                return;
            }

            $.ajax({
                type: 'POST',
                url: '{{ route($route . '.updateColumnSelected') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'ids': ids,
                    'status': 1
                },
                success: function(data) {
                    if (data.status === 200) {
                        toastr.success("{{ trns('updated_successfully') }}");
                        $('#updateConfirmModal').modal('hide');
                        $('#bulk-delete').prop('disabled', true);
                        $('#bulk-update').prop('disabled', true);
                        $('#select-all').prop('checked', false);
                        $('.delete-checkbox').prop('checked', false);
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

        $('#select-all').on('click', function() {
            const isChecked = $(this).is(':checked');
            $('.delete-checkbox').prop('checked', isChecked);
        });

        $(document).on('click', '#confirm-delete-btn', function() {
            let ids = $('.delete-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (ids.length === 0) {
                toastr.warning("{{ trns('please_select_items_first') }}");
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
                    if (data.status === 200) {
                        toastr.success("{{ trns('deleted_successfully') }}");
                        $('#deleteConfirmModal').modal('hide');
                        $('#bulk-delete').prop('disabled', true);
                        $('#bulk-update').prop('disabled', true);
                        $('#select-all').prop('checked', false);
                        $('.delete-checkbox').prop('checked', false);
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
    </script>

    <script>
        $(document).on('click', '.body-span-msg', function () {
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
@endsection
