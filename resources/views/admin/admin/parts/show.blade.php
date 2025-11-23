@extends('admin.layouts.master')

@section('title', trns('admins_details'))
@section('page_name')
    <a href="{{ route('admins.index') }}">
        {{ trns('admin') }} / {{ $obj?->name }}
    </a>
@endsection

@section('content')
    <div class="">

        <div class="container-fulid">
            <!-- Header Section -->
            <div class="mb-4 align-items-center">

                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">

                        <img src="{{ asset('assets/userAvater.jpg') }}" style="width: 50px;" alt="admin Avatar" />
                        <h5 style="color: #1E1E1E; font-weight: bold; font-size: 30px;" class="mb-0"> {{ $obj->name }}
                        </h5>

                    </div>

                    <div class="d-flex">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle {{ lang() == 'ar' ? 'ms-2' : 'me-2' }}"
                                style="background-color: #00193b !important; color: #00F3CA;" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ trns('options') }}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                style="background-color: #EAEAEA;">
                                <a class="dropdown-item editBtn" href="javascript:void(0);" data-id="{{ $obj->id }}">
                                    <img src="{{ asset('edit.png') }}" alt="no-icon" class="img-fluid ms-1"
                                        style="width: 24px; height: 24px;"> {{ trns('Edit') }}
                                </a>
                                <a class="dropdown-item toggleStatusBtn" href="#" data-id="{{ $obj->id }}"
                                    data-status="{{ $obj->status }}">
                                    {{ $obj->status == 1 ? trns('Deactivate_admin') : trns('Activate_admin') }}
                                </a>
                                <a class="dropdown-item text-danger delete-btn" href="#" id="delete-btn"
                                    data-id="{{ $obj->id }}">
                                    <i class="fas fa-trash ms-2"></i> {{ trns('delete') }}
                                </a>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('admins.index') }}" class="btn"
                                style="transform: rotate(180deg); border: 1px solid gray;">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- <hr class="mb-5"> -->

            <!-- Admin Info Card -->
            <div class=""
                style="border-radius: 6px;
                    background-color: #fbf9f9;
                    border: 1px solid #ddd;
                    padding: 15px;">
                <div class="row m-5">

                    <div class="col-12 col-md-3 mb-4">
                        <h6 class="text-uppercase text-muted">{{ trns('national_id') }}</h6>
                        <p class="fw-bold">
                            {!! $obj->national_id ? copyable_text($obj->national_id) . ' ' . $obj->national_id : trns('no data') !!} </p>
                    </div>


                    <div class="col-12 col-md-3 mb-4">
                        <h6 class="text-uppercase text-muted">{{ trns('admin name') }}</h6>
                        <p class="fw-bold">
                            {!! $obj->name ? copyable_text($obj->name) . ' ' . $obj->name : trns('no data') !!} </p>
                    </div>



                    <div class="col-12 col-md-4 mb-4">
                        <h6 class="text-uppercase text-muted">{{ trns('email') }}</h6>
                        <p class="fw-bold">
                            {!! $obj->email ? copyable_text($obj->email) . ' ' . $obj->email : trns('no data') !!} </p>
                    </div>

                    <div class="col-12 col-md-2 mb-4">
                        <h6 class="text-uppercase text-muted">{{ trns('phone_number') }}</h6>
                        <p class="fw-bold">
                            {!! $obj->phone ? copyable_text($obj->phone) . ' ' . $obj->phone : trns('no data') !!}</p>
                    </div>

                    <div class="col-12 col-md-3">
                        <h6 class="text-uppercase text-muted">{{ trns('created_at') }}</h6>
                        <p class="fw-bold">{{ $obj->created_at->format('Y-m-d') }}</p>
                    </div>

                    <div class="col-12 col-md-3">
                        <h6 class="text-uppercase text-muted">{{ trns('role') }}</h6>
                        <p class="fw-bold">{{ $obj->getRoleNames()->first() }}</p>
                    </div>
                    <div class="col-12 col-md-2">
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


        <!-- Create Or Edit Modal -->
        <!-- Create Or Edit Modal -->
        <div class="modal fade" id="editOrCreate" data-bs-backdrop="static" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">{{ trns('add new admin') }}</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
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

    </div>

    @include('admin/layouts/NewmyAjaxHelper')

@endsection
@section('ajaxCalls')
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <script>
        function editScriptAdmin() {
            $(document).on('click', '#updateButton', function(e) {
                e.preventDefault();
                const form = $('#updateForm')[0];
                const url = $('#updateForm').attr('action');
                const formData = new FormData(form);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#updateButton')
                            .html(
                                '<span class="spinner-border spinner-border-sm me-2"></span>' +
                                '<span style="margin-left:4px;">{{ trns('loading...') }}</span>'
                            )
                            .attr('disabled', true);
                    },
                    success: function(data) {
                        $('#updateButton').html(`{{ trns('update') }}`).attr('disabled', false);

                        if (data.status === 200) {
                            // Bootstrap 4 modal close
                            $('#editOrCreate').modal('hide');

                            // Clear modal content after it's hidden
                            $('#editOrCreate').on('hidden.bs.modal', function() {
                                $('#modal-body').html('');
                                $(this).off(
                                'hidden.bs.modal'); // Remove event listener to prevent multiple bindings
                            });

                            Swal.fire({
                                title: '<span style="margin-bottom: 50px; display: block;">{{ trns('changed_successfully') }}</span>',
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
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ trns('something_went_wrong') }}'
                            });
                        }

                        if (data.redirect) {
                            setTimeout(function() {
                                window.location.href = data.redirect;
                            }, 1000);
                        } else {
                            // Reload page instead of DataTable if not available
                            if (typeof $('#dataTable').DataTable === 'function') {
                                $('#dataTable').DataTable().ajax.reload();
                            } else {
                                window.location.reload();
                            }
                        }
                    },
                    error: function(data) {
                        $('#updateButton').html(`{{ trns('update') }}`).attr('disabled', false);

                        if (data.status === 500) {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ trns('something_went_wrong') }}'
                            });
                        } else if (data.status === 422) {
                            var errors = $.parseJSON(data.responseText);
                            $.each(errors.errors, function(key, value) {
                                $('#' + key).next('.invalid-feedback').remove();
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).after(
                                    '<div class="invalid-feedback">' + value[0] + '</div>'
                                );
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ trns('something_went_wrong') }}'
                            });
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const editModal = new bootstrap.Modal(document.getElementById('editOrCreate'));

            document.querySelectorAll('.editBtn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const editUrl = '{{ route('admins.edit', ':id') }}'.replace(':id', id);

                    document.getElementById('modalTitle').textContent = '{{ trns('Edit Admin') }}';

                    $('#modal-footer').html(`
                <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two"
                            data-dismiss="modal">{{ trns('close') }}</button>
                    <button type="submit" class="btn btn-one me-2"
                            id="updateButton">{{ trns('update') }}</button>
                </div>
            `);

                    fetch(editUrl)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('modal-body').innerHTML = html;
                            editModal.show();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error loading form');
                        });
                });
            });

            window.showCreateModal = function(url) {
                document.getElementById('modalTitle').textContent = '{{ trns('Add New Admin') }}';
                fetch(url)
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
                    });
            };



            editScriptAdmin();

        });
    </script>


    <script>
        $(document).on('click', '.toggleStatusBtn', function(e) {
            e.preventDefault();

            let id = $(this).data('id');
            let currentStatus = parseInt($(this).data('status'));
            let newStatus = currentStatus === 1 ? 0 : 1;

            $.ajax({
                type: 'POST',
                url: '{{ route('admins.updateColumnSelected') }}',
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



        $(document).on('click', '#delete-btn', function() {
            let id = $(this).data('id');

            $.ajax({
                type: 'DELETE',
                url: "{{ route('admins.destroy', ':id') }}".replace(':id', id),
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(data) {
                    if (data.status === 200) {
                        toastr.success("{{ trns('deleted_successfully') }}");
                        window.location.href = "{{ route('admins.index') }}"; // توجيه بعد الحذف
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
