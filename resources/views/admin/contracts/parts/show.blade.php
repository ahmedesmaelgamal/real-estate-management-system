@extends('admin/layouts/master')
@section('title')
    {{ config()->get('app.name') }} | {{ trns('show_contract') }}
@endsection
@section('page_name')
    {{ trns('contract_management') }} / {{ trns('show_contract') }}
@endsection
@section('content')
    {{--  --}}
    <style>
        .gallery-image {
            cursor: pointer;
            transition: 0.3s;
            margin: 5px;
        }

        .gallery-image:hover {
            opacity: 0.7;
        }


        .table td,
        .table th {
            vertical-align: middle;
            word-break: break-word;
            max-width: 200px;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        #fileModal {
            display: none;
            position: fixed;

            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
        }

        #fileModalContent {
            position: relative;
            width: 80%;
            height: 80%;
            margin: 5% auto;
            background: #fff;
            padding: 10px;
        }

        #fileModal iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        #fileModal button {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            background: none;
            border: none;
            color: #000;
            cursor: pointer;
        }

        .tab-content>div {
            display: none;
        }

        .tab-content>.active {
            display: block;
        }

        .dropdown-menu {
            z-index: 99999 !important;
        }
    </style>

    <style>
        #imageModal {
            display: none;
            position: fixed;

            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
        }

        #modalImage {

            width: 75%;
            height: 75%;
        }
    </style>

    <style>
        .tab-content>div {
            display: none;
        }

        .tab-content>.active {
            display: block;
        }

        .btn-outline-success:not(:disabled):not(.disabled):active,
        .btn-outline-success:not(:disabled):not(.disabled).active {
            background-color: transparent !important;
            color: #00183b !important;
            border-bottom: 1px solid #00f3ca !important;
        }
    </style>



    {{-- file midel --}}

    <style>
        #fileModalContent {
            position: relative;
            width: 80%;
            height: 80%;
            margin: 5% auto;
            background: #fff;
            padding: 10px;
        }

        #fileIframe {
            width: 100%;
            height: 100%;
            border: none;
            display: none;
        }


        #imageModal {
            display: none;
            position: fixed;

            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
        }

        #modalImage {
            max-width: 75vw;
            max-height: 75vh;
        }
    </style>









    <div class="row">
        <!-- Create Or Edit Modal -->
        <div class="modal fade" id="editOrCreate" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ trns('delete') }}</h5>

                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-body">
                        <!-- Dynamic content will be loaded here -->
                    </div>
                    <div class="modal-footer" id="modal-footer">

                    </div>
                </div>
            </div>
        </div>
        <!-- Delete MODAL -->
        <div class="modal fade" id="delete_contract_modal" tabindex="-1" role="dialog"
            aria-labelledby="deleteContractLabel" aria-hidden="true">
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
                        <button type="button" class="btn btn-one" id="delete_btn_of_show">
                            {{ trns('delete') }}!
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <script>
            $(document).on("click", "#delete_btn_of_show", function() {
                var id = $("#delete_id").val();
                var url = '{{ route('contracts.destroy', ':id') }}';
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            toastr.success('{{ trns('deleted_successfully') }}');
                            $('#delete_contract_modal').modal('hide');

                            setTimeout(function() {
                                window.location.href = '{{ route('contracts.index') }}';
                            }, 2000);
                        } else {
                            toastr.error('{{ trns('something_went_wrong') }}');
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('{{ trns('something_went_wrong') }}');
                    }
                });
            });
        </script>



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


        <div class="col-md-12 col-lg-12">
            <div class="">


                <div style="padding-bottom: 60px">


                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <h2>{{ trns('show_contract') }}</h2>
                        </div>


                        <div class="dropdown">
                            <button class="btn dropdown-toggle m-2" type="button"
                                id="dropdownMenuButton{{ $obj->id }}" data-bs-toggle="dropdown" aria-expanded="false"
                                style="background-color: #00193a; color: #00F3CA;">
                                {{ trns('options') }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $obj->id }}"
                                style="background-color: #EAEAEA;">
                                <li>
                                    <a class="dropdown-item editBtn" href="javascript:void(0);"
                                        data-id="{{ $obj->id }}">
                                        <img src="{{ asset('edit.png') }}" alt="no-icon" class="img-fluid ms-1"
                                            style="width: 24px; height: 24px;"> {{ trns('Edit') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item " target="_blank"
                                        href="{{ route('contracts.download', $obj->id) }}"
                                        data-id="{{ $obj->id }}">
                                        {{ trns('donwload_contract') }}
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" style="color: red; cursor: pointer; margin-right: 5px;"
                                        data-bs-toggle="modal" data-bs-target="#delete_contract_modal"
                                        onclick="$('#delete_id').val({{ $obj->id }})">
                                        <i class="fas fa-trash" style="margin-left: 5px;"></i>
                                        {{ trns('delete') }}
                                    </a>
                                </li>
                            </ul>
                            <a href="{{ route('contracts.index') }}" class="btn"
                                style="transform: rotate(180deg); border: 1px solid gray; padding: 6px 11px;">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>

                    </div>

                    <ul class="nav nav-tabs" style="margin: 0 3px;" id="realEstateTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-tab="tab1" href="#">{{ trns('main information') }}</a>
                        </li>

                    </ul>


                    <!-- test the update -->


                    <div class="container-fluid mt-4">

                        <div class="card mb-4">
                            <div class="card-body">
                                <h4 style="font-weight: bold; color: #00193a;">
                                    {{ trns('basic_information_of_contract') }}
                                </h4>
                                <hr>
                                <div class="row">
                                    <div class="col-md-2">
                                        <h6 class="text-muted">{{ trns('contract_type') }}</h6>
                                        <p>{{ $obj->contractType->getTranslation('title', app()->getLocale()) ?? trns('N/A') }}
                                        </p>
                                    </div>
                                    <div class="col-md-2">
                                        <h6 class="text-muted">{{ trns('contract_name') }}</h6>
                                        <p>{{ $obj->contractName->name ?? trns('N/A') }}</p>
                                    </div>
                                    <div class="col-md-2">
                                        <h6 class="text-muted">{{ trns('contract_date') }}</h6>
                                        <p>{{ $obj->date?->format('Y-m-d') ?? trns('N/A') }}</p>
                                    </div>
                                    <div class="col-md-2">
                                        <h6 class="text-muted">{{ trns('contract_location') }}</h6>
                                        <p>
                                            @if ($obj->contractLocation && $obj->contractLocation->lat && $obj->contractLocation->long)
                                                @php
                                                    $lat = $obj->contractLocation->lat;
                                                    $long = $obj->contractLocation->long;
                                                    $url = "https://www.google.com/maps?q={$lat},{$long}";
                                                    $title = $obj->contractLocation->getTranslation(
                                                        'title',
                                                        app()->getLocale(),
                                                    );
                                                @endphp
                                                <a href="{{ $url }}" target="_blank"
                                                    class="btn btn-outline-success btn-sm">
                                                    {{ $title }}
                                                </a>
                                            @else
                                                {{ $obj->contract_location ?? '-' }}
                                            @endif
                                        </p>
                                    </div>

                                    <div class="col-md-2">
                                        <h6 class="text-muted">{{ trns('address') }}</h6>
                                        <p>{{ $obj->contract_address ?? trns('N/A') }}</p>
                                    </div>
                                </div>

                                <!-- <div class="row mt-3">
                            <div class="col-md-12">
                                <h6 class="text-muted">{{ trns('introduction') }}</h6>
                                <p>{{ $obj->introduction ?? trns('N/A') }}</p>
                            </div>
                        </div> -->
                            </div>
                        </div>

                        {{-- Parties --}}
                        <div class="card mb-4">
                            <div class="card-body">
                                <h4 style="font-weight: bold; color: #00193a;">{{ trns('contract_parties') }}</h4>
                                <hr style="opacity:1;">
                                <div class="row mb-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            {{-- @dd($obj->firstParties->first()) --}}

                                            <h6 class="text-muted">{{ 1 . ' ' . trns('first_party') }}</h6>
                                            <p>
                                                {{ $obj->firstParties->first()?->model_type === \App\Models\ContractParty::class
                                                    ? $obj->firstPartyContract?->getTranslation('title', app()->getLocale()) ?? trns('N/A')
                                                    : ($obj->firstParties->first()?->model_type === \App\Models\User::class
                                                        ? trns('association_user')
                                                        : trns('association_owner')) }}
                                            </p>

                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="text-muted">{{ trns('first_party_name') }}</h6>
                                            <p>{{ $obj->firstParties->first()->party_name ?? trns('N/A') }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="text-muted">{{ trns('first_party_national_id') }}</h6>
                                            <p>{{ $obj->firstParties->first()->party_nation_id ?? trns('N/A') }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <h6 class="text-muted">{{ trns('first_party_phone') }}</h6>
                                            <p>{{ $obj->firstParties->first()->party_phone ?? trns('N/A') }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <h6 class="text-muted">{{ trns('first_party_email') }}</h6>
                                            <p>{{ $obj->firstParties->first()->party_email ?? trns('N/A') }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <h6 class="text-muted">{{ trns('first_party_address') }}</h6>
                                            <p>{{ $obj->firstParties->first()->party_address ?? trns('N/A') }}</p>
                                        </div>

                                    </div>
                                    <hr style="width: 98% ; opacity:1;">

                                    <div class="row mt-4">
                                        <div class="col-md-4">
                                            <h6 class="text-muted">{{ 2 . ' ' . trns('second_party') }}</h6>
                                            <p>
                                                {{-- @dd($obj->secondPartyContract) --}}
                                                {{ $obj->secondParties->first()?->model_type === \App\Models\ContractParty::class
                                                    ? $obj->secondPartyContract?->getTranslation('title', app()->getLocale()) ?? trns('N/A')
                                                    : ($obj->secondParties->first()?->model_type === \App\Models\User::class
                                                        ? trns('association_user')
                                                        : trns('association_owner')) }}
                                            </p>

                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="text-muted">{{ trns('second_party_name') }}</h6>
                                            <p>{{ $obj->secondParties->first()->party_name ?? trns('N/A') }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="text-muted">{{ trns('second_party_national_id') }}</h6>
                                            <p>{{ $obj->secondParties->first()->party_nation_id ?? trns('N/A') }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <h6 class="text-muted">{{ trns('second_party_phone') }}</h6>
                                            <p>{{ $obj->secondParties->first()->party_phone ?? trns('N/A') }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <h6 class="text-muted">{{ trns('second_party_email') }}</h6>
                                            <p>{{ $obj->secondParties->first()->party_email ?? trns('N/A') }}</p>
                                        </div>

                                        <div class="col-md-4">
                                            <h6 class="text-muted">{{ trns('second_party_address') }}</h6>
                                            <p>{{ $obj->secondParties->first()->party_address ?? trns('N/A') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Terms --}}
                        {{-- contract terms --}}
                        <div class="col-12">
                            <div class="form-group">
                                <h4 class="form-control-label" style="display:block">
                                    {{ trns('contract_terms') }}
                                </h4>
                                <label class="form-control-label">
                                    {{ trns('contract_terms_main_guide') }}
                                </label>

                                @php
                                    $selectedTerms = $obj->contractTerms->pluck('id')->toArray();
                                @endphp

                                <div class="mt-2 row">
                                    @foreach ($obj->contractTerms as $contractTerm)
                                        <div class="col-12 mb-3">
                                            <div class="card custom-checkbox-card w-100">
                                                <input class="form-check-input d-none" type="checkbox" checked disabled
                                                    id="term{{ $loop->index }}" value="{{ $contractTerm->id }}">

                                                <label for="term{{ $loop->index }}" class="card-body w-100 text-end">
                                                    <h5 class="association-card-header fw-bold">
                                                        {{ $contractTerm->getTranslation('title', app()->getLocale()) }}
                                                    </h5>
                                                    <p class="association-card-para text-muted mb-0">
                                                        {{ $contractTerm->trns_desc }}
                                                    </p>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>



                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>




    </div>
    </div>
    </div>

    <div id="imageModal"
        style="display:none; position:fixed; z-index:9999;
                                left:0; top:0; width:100vw;  background:rgba(0,0,0,0.8);">
        <span class="close" onclick="closeModal()">&times;</span>
        <img style="width:80%; height:80%; margin:5% auto; display:block; border:0" class="modal-content"
            id="modalImage">
    </div>



    <div id="fileModal"
        style="display:none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.6);">
        <div
            style="position: relative; width: 90%; max-width: 900px; height: 90vh; margin: 5vh auto; background: white; padding: 20px;">
            <span onclick="closeFileModal()" style="position:absolute; top:10px; right:15px; cursor:pointer;">✖</span>

            <iframe id="fileFrame" width="100%" height="90%" style="display:none; border:none;"></iframe>

            <div id="fileFallback" style="display:none; text-align:center;">
                <p>لا يمكن عرض هذا الملف.</p>
                <a id="downloadButton" href="#" download class="btn btn-primary" target="_blank">تحميل
                    الملف</a>
            </div>
        </div>
    </div>


    </div>
    </div>

    <style>
        .min-w-150px {
            min-width: 150px;
        }

        .d-flex {
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
        }

        .text-muted {
            color: #6c757d;
        }

        .text-dark {
            color: #343a40;
        }

        .p-4 {
            background-color: #f8f9fa;
            border-radius: 8px;
        }
    </style>


    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Your map container -->
    {{-- <div id="map" style="height: 400px;"></div> --}}

    <!-- Input fields to update -->
    <input type="hidden" id="lat" value="{{ $obj->lat }}">
    <input type="hidden" id="long" value="{{ $obj->long }}">
    </div>
    @include('admin.layouts.NewmyAjaxHelper')
@endsection
@section('ajaxCalls')
    <script>
        initCantDeleteModalHandler();
        $(document).ready(function() {
            // Configure modal event listeners
            $('#delete_modal_of_show').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var title = button.data('title');
                var modal = $(this);
                modal.find('.modal-body #delete_id').val(id);
                modal.find('.modal-body #title').text(title);
            });

            $(document).on('click', '#delete_btn_of_show', function() {
                var id = $("#delete_id").val();
                var routeOfDelete = "{{ route('contracts.destroy', ':id') }}".replace(':id', id);

                $.ajax({
                    type: 'DELETE',
                    url: routeOfDelete,
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'id': id
                    },
                    success: function(data) {
                        if (data.status === 200) {
                            $('#delete_modal').modal('hide');
                            window.location.href = '{{ route('contracts.index') }}';

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
                            // retrun redirect to table
                            window.location.href = document.referrer;
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ trns('Deletion failed') }}',
                                text: data.message ||
                                    '{{ trns('Something went wrong') }}',
                                confirmButtonText: '{{ trns('OK') }}'
                            });
                        }
                    },

                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('Error') }}',
                            text: xhr.responseJSON?.message ||
                                '{{ trns('Something went wrong') }}',
                            confirmButtonText: '{{ trns('OK') }}'
                        });
                    }
                });
            });
        });
    </script>




    <script>
        $(document).on('click', '.editBtn', function() {
            var id = $(this).data('id')
            var url = '{{ route('contracts.edit', ':id') }}';
            url = url.replace(':id', id)
            $('#modal-body').html(loader)
            $('#editOrCreate').modal('show');
            $('#editOrCreate .modal-title').text('تعديل العقد');

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
                $('#modal-body').load(url)
            }, 500)
        })
        // editScript();


        // {{-- update contracts --}}

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        $(document).on('click', '#updateButton', function(e) {
            e.preventDefault();
            $('#updateButton').prop('disabled', true);
            var form = $('.contract_form');
            var url = @json(route('contracts.update', $obj->id));
            var formData = new FormData(form[0]);
            formData.append('_token', '{{ csrf_token() }}'); // CSRF token added

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status === 200) {
                        $('#editOrCreate').modal('hide');
                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('changed_successfully') }}</span>',
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

                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('something_went_wrong') }}'
                        });

                    }
                    $('#updateButton').prop('disabled', false);
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON?.errors;
                    if (errors) {
                        Object.keys(errors).forEach(function(key) {
                            toastr.error(errors[key][0]);
                        });
                    } else {
                        toastr.error('{{ trns('something_went_wrong') }}');
                    }
                    $('#updateButton').prop('disabled', false);
                }
            });
        });


        // {{-- end or updatea and edit --}}



        $(document).ready(function() {
            // Get values from inputs (or default if null)
            const defaultLat = parseFloat("{{ $obj->lat ?? 24.7136 }}");
            const defaultLng = parseFloat("{{ $obj->long ?? 46.6753 }}");

            // Initialize map
            const map = L.map('map').setView([defaultLat, defaultLng], 13);

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            // Add draggable marker
            const marker = L.marker([defaultLat, defaultLng], {
                    draggable: true
                })
                .addTo(map)
                // .bindPopup('Drag me or click map to set location')
                .openPopup();
            marker.options.interactive = false;
            marker.off(); // removes any event listeners attached
            if (marker.dragging) marker.dragging.disable();
            marker.unbindPopup();
            marker.unbindTooltip();


            // Update inputs when dragging marker
            // marker.on('dragend', function(e) {
            //     const { lat, lng } = e.target.getLatLng();
            //     $('#lat').val(lat.toFixed(6));
            //     $('#long').val(lng.toFixed(6));
            // });

            // Update marker when clicking on map
            // map.on('click', function(e) {
            //     const { lat, lng } = e.latlng;
            //     marker.setLatLng([lat, lng]);
            //     $('#lat').val(lat.toFixed(6));
            //     $('#long').val(lng.toFixed(6));
            // });

            // Update marker if user types manually in inputs
            // function updateMarkerPosition() {
            //     let lat = parseFloat($("#lat").val());
            //     let lng = parseFloat($("#long").val());

            //     if (!isNaN(lat) && !isNaN(lng)) {
            //         marker.setLatLng([lat, lng]);
            //         map.panTo([lat, lng]);
            //     }
            // }

            // $("#lat, #long").on("input", updateMarkerPosition);
        });






        $(document).ready(function() {
            // Handle tab switching from URL hash
            var hash = window.location.hash;
            if (hash) {
                setTimeout(function() {
                    // More specific selector for Bootstrap tabs
                    var tabLink = $('a[href="' + hash + '"]');

                    if (tabLink.length) {

                        var tabContent = $(hash);
                        console.log('Tab Content:', tabContent);

                        if (tabContent.length) {
                            tabLink.tab('show');
                            setTimeout(function() {
                                tabLink.tab('show');
                            }, 50);

                            $('.tab-content').children('div').removeClass('active');
                            tabContent.addClass('active');

                            console.log('Tab should be active now');
                        } else {
                            console.error('Tab content not found for:', hash);
                        }
                    } else {
                        console.log('Tab link not found for hash:', hash);
                    }
                }, 200);
            }
        });
    </script>
@endsection
