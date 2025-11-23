@extends('admin/layouts/master')
@section('title')
    {{ trns('My Profile') }}
@endsection

@section('page_name')
    {{ trns('My Profile') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="wideget-user text-center">
                        <div class="wideget-user-desc">
                            <div class="wideget-user-img">
                                <img class="image-popup avatar avatar-md rounded-circle"
                                    href="{{ getFile(auth()->user()->image, 'avatar.gif') }}"
                                    src="{{ getFile(auth()->user()->image, 'avatar.gif') }}" alt="img">
                            </div>
                            <div class="user-wrap">
                                <h4 class="mb-1 text-capitalize">{{ auth()->user()->name }}</h4>
                                <h6 class="text-muted mb-4"> {{ auth()->user()->email }}</h6>
                            </div>
                            <div class="">
                                <button class="btn btn-secondary btn-icon text-white m-2 border-0" data-bs-toggle="modal"
                                    data-bs-target="#updateProfile">
                                    <span>
                                        <i class="fe fe-edit"></i>
                                    </span>
                                    {{ trns('update_profile') }}
                                </button>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="wideget-user-tab">
                    <div class="tab-menu-heading">
                        <div class="tabs-menu1">
                            <ul class="nav">
                                <li class="">
                                    <a href="#tab-1" class="active show tab-action" data-toggle="tab">
                                        {{ trns('update_profile') }}
                                    </a>
                                </li>

                                <li class="">
                                    <a href="#tab-2" class="tab-action" data-toggle="tab">
                                        {{ trns('activities') }}
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane active show" id="tab-1">
                    <div class="card">
                        <div class="card-body">
                            <div id="profile-log-switch">

                                <div class="row">

                                    <div class="col-lg-4 col-12">
                                        <div class="text-capitalize"><strong>{{ trns('Name') }}
                                                :</strong> <br>
                                            {{ auth()->user()->name }}</div>
                                    </div>
                                    <div class="col-lg-4 col-12">
                                        <div class="text-capitalize"><strong>{{ trns('Email') }} :</strong><br>
                                            {{ auth()->user()->email }} </div>
                                    </div>
                                    <div class="col-lg-4 col-12">
                                        <div class="text-capitalize"><strong>{{ trns('Register Date') }}:</strong> <br>
                                            {{ auth()->user()->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="tab-pane" id="tab-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-nowrap w-100"
                                    style="border: 1px solid #e3e3e3; border-radius: 10px;" id="dataTable">
                                    <thead>
                                        <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">
                                            <th>{{ trns('Description') }}</th>
                                            <th>{{ trns('Subject Name') }}</th>
                                            <th>{{ trns('Subject Type') }}</th>
                                            <th>{{ trns('created_at') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($activities as $activity)
                                            <tr>
                                                <td>{{ $activity->description }}</td>
                                                <td class="text-capitalize">{{ $activity->subject->name ?? 'N/A' }}</td>
                                                <td class="text-capitalize">{{ $activity->subject_type ?? 'N/A' }}</td>
                                                <td>{{ $activity->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> --}}
                </div>
                <div class="tab-pane" id="tab-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-nowrap w-100"
                                    style="border: 1px solid #e3e3e3; border-radius: 10px;" id="dataTable">
                                    <thead>
                                        <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">
                                            <th>{{ trns('Description') }}</th>
                                            <th>{{ trns('Subject Name') }}</th>
                                            <th>{{ trns('Subject Type') }}</th>
                                            <th>{{ trns('created_at') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($activities as $activity)
                                            <tr>
                                                <td>{{ $activity->description }}</td>
                                                <td class="text-capitalize">{{ $activity->subject->name ?? 'N/A' }}</td>
                                                <td class="text-capitalize">{{ $activity->subject_type ?? 'N/A' }}</td>
                                                <td>{{ $activity->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- COL-END -->

        </div>

        <!-- update password and name -->
        <div class="modal fade" id="updateProfile" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateProfile">{{ trns('update_profile') }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-body" style="max-height:  400px;">
                        <form id="updateProfileForm" method="POST" enctype="multipart/form-data"
                            action="{{ route('myProfile.update') }}">
                            @csrf
                            <input type="hidden" value="{{ auth()->user()->id }}" name="id">
                            <div class="row">

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="image" class="form-control-label">{{ trns('image') }}</label>
                                        <input type="file" class="dropify" name="image" id="image"
                                            data-default-file="{{ getFile(auth()->user()->image, 'avatar.gif') }}"
                                            accept="image/*">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name" class="form-control-label">{{ trns('name') }}</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ auth()->user()->name }}" id="name">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="password"
                                            class="form-control-label">{{ trns('new_password') }}</label>
                                        <input type="password" class="form-control" autocomplete="new-password"
                                            name="password" id="password">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="password"
                                            class="form-control-label">{{ trns('new_password_confirmation') }}</label>
                                        <input type="password" class="form-control" autocomplete="new-password"
                                            name="password_confirmation" id="password">
                                    </div>
                                </div>
                            </div>

                        </form>


                    </div>
                    <div class="modal-footer" id="modal-footer">
                        <div class="d-flex justify-content-between w-100">
                            <button type="button" class="btn btn-two"
                                data-bs-dismiss="modal">{{ trns('close') }}</button>
                            <button type="submit" class="btn btn-one me-2" form="updateProfileForm"
                                id="updateProfileButton">{{ trns('update') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- update password and name -->


    </div>
    @include('admin.layouts.myAjaxHelper')
@endsection
@section('ajaxCalls')
    <script>
        $(document).on('click', '#updateProfileButton', function(e) {

            e.preventDefault();
            const form = $('#updateProfileForm')[0];
            const url = $('#updateProfileForm').attr('action');
            const formData = new FormData(form);


            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#updateProfileButton')
                        .html('<span class="spinner-border spinner-border-sm me-2"></span>' +
                            '<span style="margin-left:4px;">{{ trns('loading...') }}</span>')
                        .attr('disabled', true);
                },
                success: function(data) {
                    $('#updateProfileButton').html(`{{ trns('update') }}`).attr('disabled', false);

                    if (data.status === 200) {
                        $('#updateProfile').modal('hide').on('hidden.bs.modal', function() {
                            $('#modal-body').html('');
                        });


                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('updated_successfully') }}</span>',
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
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('something_went_wrong') }}'
                        });
                    }

                },
                error: function(data) {
                    $('#updateProfileButton').html(`{{ trns('update') }}`).attr('disabled', false);

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
                            $('#' + key).after('<div class="invalid-feedback">' + value[0] +
                                '</div>');
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
    </script>
    <script>
        $('.tab-action').on('click', function(e) {
            $('.tab-action').removeClass('active show');
            $('.tab-pane').removeClass('active show');

            $(this).addClass('active show');
            let href = $(this).attr('href');
            $(`${href}`).addClass('active show');
        });

               async function showDataTable() {
            $('#dataTable').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
                },
            });
        }

        $(document).ready(function() {
            showDataTable();
        })
    </script>
@endsection
