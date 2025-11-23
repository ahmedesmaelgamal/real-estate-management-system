@extends('admin/layouts/master')

@section('title')
    {{ config()->get('app.name') }} | {{ trns('case_type_settings') }}
@endsection
@section('page_name')
    {{ trns('case_type_settings') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title"> {{ trns('case_type_settings') }}</h3>
                    <div class="">
                        <button class="btn btn-icon text-white addBtn" style="border: none;">
                            <span>
                                <i class="fe fe-plus"></i>
                            </span> {{ trns('add_new_case') }}
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
                                    <th class="min-w-50px">{{ trns('status') }}</th>
                                    <th class="min-w-50px">{{ trns('actions') }}</th>
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
        <div class="modal fade" id="editOrCreate" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">{{ trns('case_details') }}</h5>
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
    </div>
    @include('admin.layouts.NewmyAjaxHelper')
@endsection
@section('ajaxCalls')
    <script>
        var columns = [{

                data: 'id',
                name: 'id'
            },
            {

                data: 'title',
                name: 'title'
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
        showData(null, '{{ route($route . '.index') }}', columns);
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


        $(document).on('click', '.statusBtn', function(e) {
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
@endsection
