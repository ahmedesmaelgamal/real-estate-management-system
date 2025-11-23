@extends('admin/layouts/master')

@section('title')
    {{ config()->get('app.name') }} | {{ trns('mettings') }}
@endsection
@section('page_name')
    {{ trns('mettings') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mt-3">
                <div class="card-header">
                    <h1 class="card-title"> {{ trns('mettings') }}</h3>
                        <div class="">
                            <button class="btn btn-icon text-white addBtn" style="border: none;">
                                <span>
                                    <i class="fe fe-plus"></i>
                                </span> {{ trns('add_mettings') }}
                            </button>
                            <button
                                class="btn {{ lang() == 'ar' ? 'ms-2' : 'me-2' }} mr-3 btn-icon text-white exportExcel  exportBtn">
                                <span>
                                    <img style="height: 14px;" src="{{ asset('assets/export.png') }}" alt="">
                                </span> {{ trns('export') }}
                            </button>
                            <button
                                class="btn {{ lang() == 'ar' ? 'ms-2' : 'me-2' }} btn-icon text-white addExcelFile importBtn">
                                <span>
                                    <img style="height: 14px;" src="{{ asset('assets/import.png') }}" alt="">
                                </span> {{ trns('import') }}
                            </button>
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
                                </span> {{ trns('search') }}
                            </button>

                            <button class="btn {{ lang() == 'ar' ? 'ms-2' : 'me-2' }} btn-icon text-white"
                                id="bulk-delete-selected" disabled>
                                <span><i class="fe fe-trash"></i></span> {{ trns('delete selected') }}
                            </button>


                        </div>

                        <!-- addExcelFile Modal -->
                        <div class="modal fade" id="addExcelFile" tabindex="-1" aria-labelledby="addExcelFileLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addExcelFileLabel">{{ trns('import_excel_file') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" id="modal-excel-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- addExcelFile Modal -->
                        <!-- Search MODAL -->
                        <div class="modal fade" id="search_modal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ trns('search') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <div class="row ">
                                            <div class="col-12">
                                                <label for="search_select"
                                                    class="form-label">{{ trns('chose_filter') }}</label>
                                                <select class="form-select" id="search_select" name="search_select">
                                                    <option value="" selected disabled>
                                                        {{ trns('choose_search_type') }}</option>
                                                    <option value="association_id">{{ trns('association') }}</option>
                                                    <option value="date">{{ trns('date') }}</option>
                                                    <option value="address">{{ trns('address') }}</option>
                                                    <option value="agenda">{{ trns('agenda') }}</option>
                                                    <option value="created_at">{{ trns('created_at') }}</option>
                                                </select>
                                            </div>

                                            <div class="col-12" id="search_value_wrapper">
                                                <label for="search_value"
                                                    class="form-label">{{ trns('search_value') }}</label>
                                                <input type="text" class="form-control" id="search_value"
                                                    name="search_value">
                                            </div>
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
                                            <button type="button" class="btn btn-one"
                                                id="search_btn">{{ trns('search') }}</button>
                                            <button type="button" class="btn btn-two" data-bs-dismiss="modal"
                                                id="dismiss_delete_modal">
                                                {{ trns('close') }}
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table text-nowrap w-100" id="dataTable"
                            style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;">
                            <thead>
                                <tr style="background-color: #e3e3e3; color: #00193a;">
                                    <th class="min-w-25px rounded-end">
                                        <input type="checkbox" id="select-all">
                                    </th>
                                    <th class="rounded-end">{{trns("meeting_number")}}</th>
                                    <th class="min-w-50px">{{ trns('association_name') }}</th>
                                    <th class="min-w-50px">{{ trns('topic') }}</th>
                                    <th class="min-w-50px">{{ trns('date') }}</th>
                                    <th class="min-w-50px">{{ trns('created_by') }}</th>
                                    <th class="min-w-50px">{{ trns('created_at') }}</th>
                                    <th class="min-w-50px">{{ trns('address_space') }}</th>
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
            <div class="modal-dialog  " role="document">
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
        <div class="modal fade" id="editOrCreate" data-backdrop="static" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">{{ trns('add_new_meeting') }}</h5>
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





        <div class="modal fade" id="delayMeetModel" data-backdrop="static" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ trns('delay_meet') }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="delayModalbody">
                        <form id="updateDelayMeetForm" method="POST">
                            @csrf
                            <input type="hidden" id="delayMeet_id" name="id">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="date">{{ trns('delay_Date') }} <span
                                                class="text-danger">*</span></label>
                                        <input onclick="this.showPicker()" type="datetime-local" name="date" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">{{ trns('save_changes') }}</button>
                        </form>
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
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    var hasRelations = row.has_relations;
                    var typeAttr = hasRelations ? 'update' : 'both';
                    return `<input type="checkbox" class="row-checkbox" data-type="${typeAttr}"  data-related="units" data-message="users" value="${row.id}" data-name="${row.name}">`;
                }
            }, {

                data: 'id',
                name: 'id'
            },
            {
                data: 'association_id',
                name: 'association_id'
            },
            {
                data: 'topic',
                name: 'topic'
            },
            {
                data: 'date',
                name: 'date'
            },
            {
                data: 'created_by',
                name: 'created_by'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'address',
                name: 'address'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]

        initBulkActions('{{ route($route . '.deleteSelected') }}', '{{ route($route . '.updateColumnSelected') }}');


        const ajax = {
            url: "{{ route($route . '.index') }}",
            data: function(d) {
                d.keys = [$('#search_select').val()];
                d.values = [$('#search_value').val()]; // بدل search → search_value
            }
        };



        $(document).on('click', '#search_btn', function() {
            if (!$('#search_select').val()) {
                alert("{{ trns('choose_search_type') }}");
                return;
            }
            const table = $('#dataTable').DataTable();
            table.draw();
            $('#search_modal').modal('hide');
        });





        $("#reset_search").on("click", function() {
            $("#search_value").val("");
            $("#search_select").val("");
            const table = $('#dataTable').DataTable();
            table.draw();
            $('#search_modal').modal('hide');
        });









        const showRoute = @json(route($route . '.show', ['meeting' => ':id']));

        showData(showRoute, '{{ route($route . '.index') }}', columns, 0, 3);

        // Delete Using Ajax
        deleteScript('{{ route($route . '.destroy', ':id') }}');
        // Add Using Ajax
        showAddModal('{{ route($route . '.create') }}');
        addScript();
        // Add Using Ajax
        showEditModal('{{ route($route . '.edit', ':id') }}');
        editScript();



        function showEditModal(routeOfEdit, titleModal = null) {
            $(document).on('click', '.editBtn', function() {

                var id = $(this).data('id');
                var url = routeOfEdit.replace(':id', id);

                $('#modal-body').html(loader);
                $('#editOrCreate').modal('show');
                if (titleModal != null) {
                    $('#modalTitle').text(titleModal);
                }

                // footer buttons
                $('#modal-footer').html(`
                    <div class="w-100 d-flex">
                        <button type="button" class="btn btn-two"
                                data-bs-dismiss="modal">{{ trns('close') }}</button>
                        <button type="submit" class="btn btn-one me-2"
                                id="updateButton">{{ trns('update') }}</button>
                    </div>
                `);

                setTimeout(function() {
                    $('#modal-body').load(url);
                }, 500);
            });
        }


        

        function showAddModal(routeOfShow) {
            $(document).on('click', '.addBtn', function() {
                console.log("test");
                $('#modal-footer').html(`
                    <div class="w-100 d-flex">
                        <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('close') }}</button>
                        <button type="submit" class="btn btn-one me-2" id="addMeetButton">{{ trns('create') }}</button>
                    </div>
                `);

                $('#modal-body').html(loader);
                $('#editOrCreate').modal('show');
                setTimeout(function() {
                    $('#modal-body').load(routeOfShow);
                }, 250);
            });
        }


        function addScript() {
        $(document).on('click', '#addMeetButton', function(e) {
            console.log("test22222222");
            e.preventDefault();
            // Clear previous validation errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            var form = $('#addMeetingForm')[0];
            var formData = new FormData(form);
            var url = $('#addMeetingForm').attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#addButton').html(
                            '<span class="spinner-border spinner-border-sm mr-2"></span> <span style="margin-left: 4px;">{{ trns('loading...') }}</span>'
                        )
                        .attr('disabled', true);
                },
                success: function(data) {
                    $('#addButton').html('{{ trns('add') }}').attr('disabled', false);

                    if (data.status == 200) {
                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('added_successfully') }}</span>',
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
                        if (data.redirect_to) {
                            setTimeout(function() {
                                // window.location.href = data.redirect_to;
                            }, 1000);
                        } else {
                            $('#editOrCreate').modal('hide');
                            setTimeout(function() {
                                // window.location.reload();
                            }, 1000);
                            $('#dataTable').DataTable().ajax.reload();
                        }
                    } else if (data.status == 405) {
                        toastr.error(data.mymessage);
                    } else {
                        toastr.error('{{ trns('something_went_wrong') }}');
                    }
                    $('#addButton').html(`{{ trns('add') }}`).attr('disabled', false);
                    $('#editOrCreate').modal('hide');
                },
                error: function(xhr) {
                    $('#addButton').html('{{ trns('add') }}').attr('disabled', false);

                    if (xhr.status === 500) {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('server_error') }}',
                            text: '{{ trns('internal_server_error') }}'
                        });
                    } else if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;

                        $.each(errors, function(field, messages) {
                            var fieldName = field.includes('.') ?
                                field.replace(/\./g, '[') + ']' :
                                field;

                            var input = $('[name="' + fieldName + '"]');

                            input.addClass('is-invalid');

                            input.next('.invalid-feedback').remove();

                            var errorHtml = '<div class="invalid-feedback">' + messages[0] +
                                '</div>';
                            input.after(errorHtml);
                        });

                        var firstField = Object.keys(errors)[0];
                        var firstFieldName = firstField.includes('.') ?
                            firstField.replace(/\./g, '[') + ']' :
                            firstField;

                        $('[name="' + firstFieldName + '"]').focus();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('error') }}',
                            text: '{{ trns('something_went_wrong') }}'
                        });
                    }

                    $('#addButton').html('{{ trns('add') }}').attr('disabled', false);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    }




        //  delete selected js
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


        // for status
        $(document).on('click', '.statusBtn', function() {
            let ids = [];
            $('.statusBtn').each(function() {
                ids.push($(this).data('id'));
            });


            var val = $(this).is(':checked') ? 1 : 0;



            $.ajax({
                type: 'DELETE',
                url: '{{ route($route . '.deleteSelected') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'ids': ids,
                },
                success: function(data) {
                    if (data.status === 200) {
                        if (val !== 0) {
                            toastr.success('Success', "{{ trns('active') }}");
                            $('#updateConfirmModal').modal('hide');
                            $('#bulk-delete').prop('disabled', true);
                            $('#bulk-update').prop('disabled', true);
                            $('#select-all').prop('checked', false);
                            $('#dataTable').DataTable().ajax.reload(null, false);
                        } else {
                            $('#select-all').prop('checked', false);
                            toastr.warning('Success', "{{ trns('inactive') }}");
                        }
                    } else {
                        $('#select-all').prop('checked', false);
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
        // excep export
        $(document).on('click', '.exportExcel', function() {
            console.log('export excel clicked');
            let $btn = $(this);
            let originalHtml = $btn.html();
            let routeOfShow = '{{ route('meetings.extract') }}';
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

        //  show import modal
        $(document).on('click', '.addExcelFile', function() {
            console.log('addExcelFile clicked');
            let routeOfShow = '{{ route('meetings.add.excel') }}';
            $('#modal-excel-body').html(loader);
            $('#addExcelFile').modal('show');

            setTimeout(function() {
                $('#modal-excel-body').load(routeOfShow, function() {
                    initExcelForm();
                });
            }, 250);
        });
    </script>







    <script>
        $(document).ready(function() {
            // شغل الكستوم سيرش بتاعتك
            CustomSearchSelectionAndRequest({
                selectId: 'search_select',
                inputWrapperId: 'search_value_wrapper',
                inputId: 'search_value',
                searchButtonId: 'search_btn',
                url: '{{ route($route . '.index') }}',
                together: false,
                onSuccess: function() {
                    currentKeys = [$('#search_select').val()];
                    currentValues = [$('#search_value').val()];
                    currentTogether = false;

                    $('#dataTable').DataTable().ajax.reload();
                    $('#search_modal').modal('hide');
                }
            });

            // زرار reset
            $('#reset_search').on('click', function() {
                $('#search_select').val("");
                $('#search_value').val("");
                $('#search_modal').modal('hide');

                currentKeys = [];
                currentValues = [];
                currentTogether = false;

                $('#dataTable').DataTable().ajax.reload();
            });

            // تغيير نوع الفلتر
            $('#search_select').on('change', function() {
                let selected = $(this).val();
                let wrapper = $('#search_value_wrapper');
                let html = '';

                switch (selected) {
                    case 'association_id':
                        html = `
                        <label for="search_value" class="form-label">{{ trns('association') }}</label>
                        <select class="form-select" id="search_value" name="search_value">
                            @foreach ($associations as $association)
                                <option value="{{ $association->id }}">{{ $association->name }}</option>
                            @endforeach
                        </select>
                    `;
                        break;

                    case 'date':
                    case 'created_at':
                        html = `
                        <label for="search_value" class="form-label">{{ trns('choose_date') }}</label>
                        <input type="date" class="form-control" id="search_value" name="search_value">
                    `;
                        break;

                    case 'address':
                        html = `
                        <label for="search_value" class="form-label">{{ trns('address') }}</label>
                        <input type="text" class="form-control" id="search_value" name="search_value">
                    `;
                        break;

                    case 'agenda':
                        html = `
                        <label for="search_value" class="form-label">{{ trns('association') }}</label>
                        <select class="form-select" id="search_value" name="search_value">
                            @foreach ($agendas as $agenda)
                                <option value="{{ $agenda->id }}">{{ $agenda->getTranslation('name', app()->getLocale()) }}</option>
                            @endforeach
                        </select>
                    `;
                        break;

                    default:
                        html = `
                        <label for="search_value" class="form-label">{{ trns('search_value') }}</label>
                        <input type="text" class="form-control" id="search_value" name="search_value">
                    `;
                }

                wrapper.html(html);
            });
        });


        // notification model
        // $(document).on('click', '.sendNotification', function() {
        //         let id = $(this).data('id');
        //         let updateRoute = '{{ route('meetings.sendNotification', ':id') }}'.replace(':id', id);

        //         // Show modal
        //         $('#sendNotificationModal').modal('show');

        //         // Reset previous values
        //         $('#delayMeet_id').val(id);
        //         $('#notificationForm').attr('action', updateRoute);
        //     });

        //     $(document).on('submit', '#notificationForm', function(e) {
        //         e.preventDefault();
        //         let form = $(this);
        //         let url = form.attr('action');
        //         let data = form.serialize();

        //         $.ajax({
        //             url: url,
        //             method: 'POST',
        //             data: data,
        //             success: function() {
        //                 $('#sendNotificationModal').modal('hide');
        //                 toastr.success('notificatoin sent successfully!');
        //                 $('#dataTable').DataTable().ajax.reload();
        //                 // location.reload(); // optional: refresh table
        //             },
        //             error: function(err) {
        //                 toastr.error('Failed to update meeting.');
        //             }
        //         });
        //     });


        // delay meeting
        $(document).on('click', '.delayBtn', function() {
            let id = $(this).data('id');

            let fetchRoute = '{{ route('meetings.showDate', ':id') }}'.replace(':id', id);
            let updateRoute = '{{ route('meetings.update', ':id') }}'.replace(':id', id);

            // Show modal
            $('#delayMeetModel').modal('show');

            // Reset previous values
            $('#delayMeet_id').val(id);
            $('#date').val('');
            $('#updateDelayMeetForm').attr('action', updateRoute);

            // Loader (optional)
            $('#date').prop('disabled', true);

            // Fetch meeting data
            $.ajax({
                url: fetchRoute,
                method: 'GET',
                success: function(res) {
                    $('#date').val(res.date);
                    $('#date').prop('disabled', false);
                },
                error: function() {
                    $('#date').prop('disabled', false);
                    toastr.error('Failed to fetch meeting data.');
                }
            });
        });

        // Submit form via AJAX
        $(document).on('submit', '#updateDelayMeetForm', function(e) {
            e.preventDefault();
            let form = $(this);
            let url = form.attr('action');
            let data = form.serialize();

            $.ajax({
                url: url,
                method: 'PUT',
                data: data,
                success: function() {
                    $('#delayMeetModel').modal('hide');
                    toastr.success('Meeting delayed successfully!');
                    $('#dataTable').DataTable().ajax.reload();
                },
                error: function(err) {
                    toastr.error('Failed to update meeting.');
                }
            });
        });
    </script>
@endsection
