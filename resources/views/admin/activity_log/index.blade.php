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
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title"> {{ $bladeName }}</h3>
                    <div class="">
                        <a href="{{ route('activity_logs.delete_all') }}" class="btn btn-danger text-white"
                            onclick="confirmDelete(event)">
                            <span><i class="fe fe-trash"></i></span> {{ trns('delete All Logs') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table text-nowrap w-100" id="dataTable"
                            style="border: 1px solid #e3e3e3; border-radius: 10px;">
                            <thead>
                                <tr style="background-color: #e3e3e3; color: #00193a;">
                                    <th class="min-w-25px rounded-end">{{ trns('operation') }}</th>
                                    <th class="min-w-25px">{{ trns('module_type') }}</th>
                                    <th class="min-w-25px">{{ trns('module_id') }}</th>
                                    <th class="min-w-25px">{{ trns('caused_by') }}</th>
                                    <th class="min-w-25px rounded-start">{{ trns('operation_at') }}</th>
{{--                                    <th class="min-w-50px rounded-start">{{ trns('actions') }}</th>--}}
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
                data: 'description',
                name: 'description'
            },
            {
                data: 'subject_type',
                name: 'subject_type'
            },
            {
                data: 'subject_id',
                name: 'subject_id'
            },
            {
                data: 'causer_id',
                name: 'causer_id'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            // {
            //     data: 'action',
            //     name: 'action',
            //     orderable: false,
            //     searchable: false
            // },
        ]
        showData(null, '{{ route($route . '.index') }}', columns);

        // Delete Using Ajax
        deleteScript('{{ route($route . '.destroy', ':id') }}');
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            const url = event.currentTarget.getAttribute('href');

            Swal.fire({
                title: '{{ trns('Are you sure?') }}',
                text: '{{ trns('You wouldnt be able to revert this!') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ trns('Yes, delete all!') }}',
                cancelButtonText: '{{ trns('Cancel') }}',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-primary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit a form instead of using a link directly
                    const form = document.createElement('form');
                    form.method = 'GET'; // Use GET or POST as needed
                    form.action = url;

                    // Add CSRF token
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    // Add method spoofing for DELETE if needed
                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';
                    form.appendChild(method);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection
