@extends('admin/layouts/master')

@section('title')
    {{ config()->get('app.name') }} | {{ trns('roles') }}
@endsection
@section('page_name')
    {{ trns('roles') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title"> {{ trns('roles') }}</h3>
                    <div class="">
                        @can('create_role')
                            <button class="btn btn-icon text-white addBtn" style="border: none;">
                                <span>
                                    <i class="fe fe-plus"></i>
                                </span> {{ trns('add_new_role') }}
                            </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table text-nowrap w-100" id="dataTable"
                            style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;">
                            <thead>
                                <tr style="background-color: #e3e3e3; color: #00193a;">
                                    <th class="rounded-end">#</th>
                                    <th class="min-w-50px">{{ trns('name') }}</th>
                                    <th class="min-w-50px">{{ trns('permissions') }}</th>
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
                        <h5 class="modal-title" id="example-Modal3">{{ trns('role_details') }}</h5>
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
            },{

                data: 'name',
                name: 'name'
            },
            {
                data: 'permissions',
                name: 'permissions'
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
    </script>
@endsection
