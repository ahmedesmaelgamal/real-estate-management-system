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
                        @can('create_association_model')
                            <button class="btn btn-icon text-white addBtn">
                                <span>
                                    <i class="fe fe-plus"></i>
                                </span> {{ trns('add_legal_ownership') }}
                            </button>
                        @endcan
                    </div>
                </div>

                <div class="mt-5">
                    <div class="table-responsive" style="overflow: inherit;">

                        <!--begin::Table-->
                        <table class="table text-nowrap w-100 mb-0"
                            style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;"
                            id="dataTable">
                            <thead>
                                <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">

                                    <th class="min-w-25px">
                                    {{ trns('rated_number')}}
                                    </th>
                                    <th class="min-w-50px">{{ trns('title') }}</th>
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
                        <h5 class="modal-title" id="example-Modal3">{{ trns('legal_ownership_details') }}</h5>
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
    </div>
    @include('admin/layouts/NewmyAjaxHelper')
@endsection
@section('ajaxCalls')
    <script>
        var columns = [{
                data: 'id',
                name: 'id',
            },
            {
                data: 'title',
                name: 'title'
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

        // Add Using Ajax
        showAddModal('{{ route($route . '.create') }}');
        addScript();
        // Add Using Ajax
        showEditModal('{{ route($route . '.edit', ':id') }}');
        editScript();
    </script>


@endsection
