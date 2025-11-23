@extends('admin/layouts/master')
@section('title')
    {{ config()->get('app.name') }} | {{ $bladeName }}
@endsection
@section('page_name')
    {{ $bladeName }}
@endsection
@section('content')
    <style>
        .gallery-image {
            cursor: pointer;
            transition: 0.3s;
            margin: 5px;
        }

        .gallery-image:hover {
            opacity: 0.7;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
        }

        /* Modal Content (image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 75vw;
            height: auto;
        }

        /* Close Button */
        /* .close {
                position: absolute;
                top: 15px;
                right: 35px;
                color: #f1f1f1;
                font-size: 40px;
                font-weight: bold;
                transition: 0.3s;
            }

            .close:hover,
            .close:focus {
                color: #bbb;
                text-decoration: none;
                cursor: pointer;
            } */
    </style>

    <style>
        .tab-content>div {
            display: none;
        }

        .tab-content>.active {
            display: block;
        }
    </style>
    <div class="row">

        <div class="col-md-12 col-lg-12">
            <div class="card p-15" style="padding: 25px ; padding-bottom: 60px">
                <button data-v-268c4d9a="" type="button" class="btn go-back btn-secondary"
                    style="position: absolute; top: 10px; left: 10px; font-size: 14px; border-radius: 3px;"
                    onclick="window.location.href='/admin/associations/{{ $obj->id }}';">

                    <svg data-v-268c4d9a="" viewBox="0 0 16 16" width="1em" height="1em" focusable="false"
                        role="img" aria-label="arrow left" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        class="bi-arrow-left b-icon bi">
                        <g data-v-268c4d9a="">
                            <path fill-rule="evenodd"
                                d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z">
                            </path>
                        </g>
                    </svg>
                </button>
                <div class="show-content mt-3">
                    <h4>{{ trns('real_state_basic_information') }}</h4>
                    <hr class="divider">
                    <div class="row m-4">
                        <div class="col-lg-2 col-md-2 mb-4">
                            <h4> {{ trns('association_name') }} </h4>
                            <p>{{ $obj->association->name }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 mb-4">
                            <h4> {{ trns('real_state_name') }}</h4>
                            <p>{{ $obj->name }}</p>

                        </div>
                        {{--                                        @dd($obj->RealStateOwnerShips) --}}

                        <div class="col-lg-2 col-md-2 mb-4">
                            <h4> {{ trns('real_state_street') }}</h4>
                            {{--                                        @foreach ($obj->RealStateOwnerShips as $owner) --}}
                            {{--                                            <p class="bg-success w-100 rounded-3 pl-2 pr-2">{{ User::where("id" , $owner->user_id)->first()->name }}</p> --}}
                            {{--                                        @endforeach --}}
                            <p>{{ $obj->realStateDetails?->street }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 mb-4">
                            <h4> {{ trns('real_state_space') }}</h4>
                            <p>{{ $obj->realStateDetails?->space }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 mb-4">
                            <h4> {{ trns('real_state_flat_space') }}</h4>
                            <p>{{ $obj->realStateDetails?->flat_space }}</p>
                        </div>

                        <div class="col-lg-2 col-md-2 mb-4">
                            <h4> {{ trns('real_state_part_number') }}</h4>
                            <p>{{ $obj->realStateDetails?->part_number }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 mb-4">
                            <h4> {{ trns('real_state_bank_account_number') }}</h4>
                            <p>{{ $obj->realStateDetails?->bank_account_number }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 mb-4">
                            <h4> {{ trns('real_state_mint_number') }}</h4>
                            <p>{{ $obj->realStateDetails?->mint_number }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 mb-4">
                            <h4> {{ trns('real_state_mint_source') }}</h4>
                            <p>{{ $obj->realStateDetails?->mint_source }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 mb-4">
                            <h4> {{ trns('real_state_floor_count') }}</h4>
                            <p>{{ $obj->realStateDetails?->floor_count }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 mb-4">
                            <h4> {{ trns('real_state_elevator_count') }}</h4>
                            <p>{{ $obj->realStateDetails?->elevator_count }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 mb-4">
                            <h4> {{ trns('real_state_building_type') }}</h4>
                            <p>{{ $obj->realStateDetails?->building_type }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 mb-4">
                            <h4> {{ trns('real_state_building_year') }}</h4>
                            <p>{{ $obj->realStateDetails?->building_year }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 mb-4">
                            <h4> {{ trns('real_state_electric_account_number') }}</h4>
                            <p>{{ $obj->realStateDetails?->electric_account_number }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 mb-4">
                            <h4> {{ trns('real_state_electric_subscription_number') }}</h4>
                            <p>{{ $obj->realStateDetails?->electric_subscription_number }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 mb-4">
                            <h4> {{ trns('real_state_electric_meter_number') }}</h4>
                            <p>{{ $obj->realStateDetails?->electric_meter_number }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 mb-4">
                            <h4> {{ trns('real_state_water_account_number') }}</h4>
                            <p>{{ $obj->realStateDetails?->water_account_number }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 mb-4">
                            <h4> {{ trns('real_state_water_meter_number') }}</h4>
                            <p>{{ $obj->realStateDetails?->water_meter_number }}</p>
                        </div>
                    </div>


                </div>
                <div class="show-content mt-3">
                    <h4>{{ trns('property_management') }}</h4>
                    <hr class="divider">
                    <div class="row m-4">
                        {{--                        <div class="card"> --}}
                        {{--                            <div class="card-header"> --}}
                        {{--                                <h3 class="card-title">{{ trns('property_management') }}</h3> --}}
                        {{-- --}}
                        {{--                            </div> --}}
                        {{--                            <div class="card-body"> --}}
                        <table class="table table-bordered table-hover text-nowrap w-100 usersTable" id=""
                            style="border: 1px solid #e3e3e3; border-radius: 10px;">
                            <thead style="background-color: #e3e3e3; color: #00193a;">
                                <tr class="fw-bolder text-muted bg-light">
                                    <th class="min-w-50px">#</th>
                                    <th class="min-w-150px">{{ trns('name') }}</th>
                                    <th class="min-w-150px">{{ trns('email') }}</th>
                                    <th class="min-w-100px">{{ trns('phone') }}</th>
                                    <th class="min-w-100px">{{ trns('national_id') }}</th>
                                    {{--                                        <th class="min-w-100px">{{ trns('status') }}</th> --}}
                                    {{--                                        <th class="min-w-150px">{{ trns('actions') }}</th> --}}
                                </tr>
                            </thead>
                        </table>
                        {{--                            </div> --}}
                        {{--                        </div> --}}
                        {{--                    </div> --}}
                    </div>


                    <div class="show-content mt-3">
                        <h4>{{ trns('unit_management') }}</h4>
                        <hr class="divider">
                        <div class="row m-4">
                            {{--                        <div class="card"> --}}
                            {{--                            <div class="card-header"> --}}
                            {{--                                <h3 class="card-title">{{ trns('property_management') }}</h3> --}}
                            {{-- --}}
                            {{--                            </div> --}}
                            {{--                            <div class="card-body"> --}}

                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-bordered text-nowrap w-100" id="dataTable"
                                    style="border: 1px solid #e3e3e3; border-radius: 10px;">
                                    <thead>
                                        <tr class="fw-bolder text-muted bg-light"
                                            style="background-color: #e3e3e3; color: #00193a;">
                                            <th class="min-w-50px rounded-end">{{ trns('unit_code') }}</th>
                                            <th class="min-w-50px rounded-end">{{ trns('real_state_number') }}</th>
                                            <th class="min-w-50px rounded-end">{{ trns('unit_number') }}</th>
                                            <th class="min-w-50px rounded-end">{{ trns('floor_count') }}</th>
                                            <th class="min-w-50px rounded-end">{{ trns('association_name') }}</th>
                                            {{--                                        <th class="min-w-50px rounded-end">{{ trns('status') }}</th> --}}
                                            {{--                                                    <th class="min-w-50px rounded-end">{{ trns('actions') }}</th> --}}
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            {{--                            </div> --}}
                            {{--                        </div> --}}
                            {{--                    </div> --}}
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
                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
                    integrity="sha256-sA+oYy5rjphsyV6qLdX5lFh3ugMQAxTVvD+FA2z6+3Y=" crossorigin="" />
                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                    integrity="sha256-oRkS4hJ2kMRSR2J7DHOY7FTh5E3uX9U4I9znKzJxM7E=" crossorigin=""></script>
                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                    integrity="sha256-oRkS4hJ2kMRSR2J7DHOY7FTh5E3uX9U4I9znKzJxM7E=" crossorigin=""></script>
                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
            @endsection
            @include('admin/layouts/NewmyAjaxHelper')
            @section('ajaxCalls')
                <script>
                    $(document).ready(function() {

                        // $('.usersTable tbody').on('click', 'tr', function (e) {
                        //     // Ignore clicks on checkboxes or action buttons
                        //     if ($(e.target).is('input, button, a, .delete-checkbox')) {
                        //         return;
                        //     }
                        //
                        // });
                        //
                        //
                        // $('.usersTable tbody').on('click', 'tr:not(.details-row)', function (e) {
                        //     if ($(e.target).is('input, button, a, .delete-checkbox, :has(input, button, a, .delete-checkbox)')) {
                        //         return;
                        //     }
                        //
                        //     const $row = $(this);
                        //     const id = $row.data('id');
                        //
                        //     // Redirect to the details page
                        //     window.location.href = `/admin/association/real_states/getData/${id}`;
                        //
                        // });

                        $('.usersTable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: '{{ route('realState.owners', ['id' => $obj->id]) }}',
                                type: 'GET'
                            },
                            columns: [{
                                    data: 'id',
                                    name: 'user.id'
                                },
                                {
                                    data: 'name',
                                    name: 'user.name'
                                },
                                {
                                    data: 'email',
                                    name: 'user.email'
                                },
                                {
                                    data: 'phone',
                                    name: 'user.phone'
                                },
                                {
                                    data: 'national_id',
                                    name: 'user.national_id'
                                },
                                // { data: 'status', name: 'status' },
                                // { data: 'action', name: 'action', orderable: false, searchable: false }
                            ],
                            order: [
                                [1, 'asc']
                            ],
                            language: {
                                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
                            },
                            createdRow: function(row, data, dataIndex) {
                                $(row).attr('data-id', data.id);
                            },
                            error: function(xhr, error, thrown) {
                                console.error('DataTables error:', error, thrown);
                            }
                        });


                    });
                </script>

                <script>
                    var columns = [

                        //     {
                        //         data: 'name',
                        //         render: function (data, type, row) {
                        //             return `
        //     <span class="copy-text">${data}</span>
        //     <button class="copy-btn" title="Copy" data-copy="${data}">
        //         <i class="fa-regular fa-copy"></i>
        //     </button>
        // `;
                        //         }
                        //     },
                        {
                            data: 'unit_code',
                            name: 'unit_code'
                        },
                        {
                            data: 'real_state_number',
                            name: 'real_state_number'
                        },
                        {
                            data: 'unit_number',
                            name: 'unit_number'
                        },
                        {
                            data: 'floor_count',
                            name: 'floor_count'
                        },
                        {
                            data: 'association_name',
                            name: 'association_name'
                        },
                        // {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]

                    var route = '{{ route('association.units.show', ':id') }}'.replace(':id', {{ $obj->id }});
                    // showData(route, columns);


                    // async function showData(routeOfShow, columns) {
                    $('#dataTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: route,
                        columns: columns,
                        order: [
                            [0, "DESC"]
                        ],
                        createdRow: function(row, data, dataIndex) {
                            $(row).attr('data-id', data.id); // set id on row
                            $(row).addClass('clickable-row'); // for styling if needed
                        },
                        language: {
                            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json",
                        },
                    },
                    buttons: [
                        // your buttons config...
                    ]
                    });

                    // Row click event
                    $('#dataTable tbody').on('click', 'tr', function(e) {
                        // Ignore clicks on checkboxes or action buttons
                        if ($(e.target).is('input, button, a, .delete-checkbox')) {
                            return;
                        }

                    });
                    // }


                    $('#dataTable tbody').on('click', 'tr:not(.details-row)', function(e) {
                        // Ignore clicks on interactive elements
                        if ($(e.target).is('input, button, a, .delete-checkbox, :has(input, button, a, .delete-checkbox)')) {
                            return;
                        }

                        const $row = $(this);
                        const id = $row.data('id');

                        // Create the route URL by replacing the placeholder
                        const url = "{{ route('association.units.getData', ':id') }}".replace(':id', id);

                        // Redirect to the URL
                        window.location.href = url;
                    });
                </script>
            @endsection
