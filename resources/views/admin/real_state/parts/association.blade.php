@extends('admin.layouts.master')
@section('title', trns('association'))
@section('page_name')
    <a href="{{ route('real_states.index') }}">
        {{ trns('real_states') }} / {{ $obj->name }}
    </a>
@endsection
@section('content')
 <div class="p-5">


    <div class="d-flex align-items-center justify-content-end">
        <div class="dropdown mr-3">
            <button class="btn dropdown-toggle d-flex align-items-center" style="background-color: #00193a; color: white;"
                type="button"
                id="dropdownMenuButton"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
                {{ trns("options") }}
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item d-flex align-items-center"
                    href="{{ route('real_states.index') }}?edit_user={{ $obj->id }}&show_modal=true">
                    <i class="fas fa-edit mr-2"></i>
                    {{ trns("update") }}
                </a>
                <a class="dropdown-item d-flex align-items-center toggleStatusBtn"
                    href="#"
                    data-id="{{ $obj->id }}"
                    data-status="{{ $obj->status }}">
                    <i class="fas fa-power-off mr-2"></i>
                    {{ $obj->status == 1 ? trns('Deactivate_real_state') : trns('Activate_real_state') }}
                </a>
            </div>
        </div>

        <a href="{{ route('real_states.index') }}" style="background-color: white; border: 1px solid #00193a; color: #00193a; padding: 5px; transform: rotate(180deg); margin-right:10px;"
            class="btn">
            <i class="fas fa-long-arrow-alt-right mr-2"></i>
        </a>
    </div>

    <ul class="nav nav-tabs w-100" id="realEstateTabs">
        <li class="nav-item">
            <a class="nav-link  {{ routeActive("real-estate.main-information") }}" href="{{ route('real-estate.main-information', ['id' => $obj->id]) }}">{{ trns("main information") }}</a>
        </li>
        {{-- <li class="nav-item">--}}
        {{-- <a class="nav-link" href="{{ route('real-estate.property', ['id' => $obj->id]) }}">{{ trns('property') }}</a>--}}
        {{-- </li>--}}

        <li class="nav-item">
            <a class="nav-link {{ routeActive("real-estate.association") }}" href="{{ route('real-estate.association', ['id' => $obj->id]) }}">{{ trns('association') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ routeActive("real-estate.property") }}" href="{{ route('real-estate.property', ['id' => $obj->id]) }}">{{ trns('property') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ routeActive("real-estate.images") }}" href="{{ route('real-estate.images', ['id' => $obj->id]) }}">{{ trns("images") }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ routeActive("real-estate.documents") }}" href="{{ route('real-estate.documents', ['id' => $obj->id]) }}">{{ trns("documents") }}</a>
        </li>

    </ul>


    <div class="row">
        <div class="row text-center">
            <!-- Basic Information -->
            <div class="col-12 mt-4" style="border-radius: 6px;
    background-color: #fbf9f9;
    border: 1px solid #ddd;
    padding: 15px;">

                <div class="m-5 w-100">
                    <div class="container-fluid px-0 mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="flex-grow-1">
                                <h4 class="mb-0 text-primary text-end" style="font-weight: bold; color: #00193a;">{{ trns("basic information") }}</h4>
                            </div>


                        </div>
                    </div>


                </div>

                <hr style="background-color: black;">
                <div class="row">
                    <div class="col-2 mb-4">
                        <h4>{{ trns("Association Name") }}</h4>
                        <p>{{ $obj->association->name ?? trns('N/A') }}</p>
                    </div>
                    <div class="col-2 mb-4">
                        <h4>{{ trns("Association Number") }}</h4>
                        <p>{{ $obj->association->number ?? trns('N/A') }}</p>
                    </div>

                    <div class="col-2 mb-4">
                        <h4>{{ trns("Real State Count") }}</h4>
                        <p>{{ $obj->association->real_state_count ?? trns('N/A') }}</p>
                    </div>


                    <div class="col-2 mb-4">
                        <h4>{{ trns("Unit Count") }}</h4>
                        <p>{{ $obj->association->unit_count ?? trns('N/A') }}</p>
                    </div>


                    <!-- Dates -->
                    <div class="col-2 mb-4">
                        <h4>{{ trns("Approval Date") }}</h4>
                        <p>{{ $obj->association->approval_date ? $obj->association->approval_date : trns('N/A') }}</p>
                    </div>



                    <div class="col-2 mb-4">
                        <h4>{{ trns("Establish Date") }}</h4>
                        <p>{{ $obj->association->establish_date ? $obj->association->establish_date : trns('N/A') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4" style="border-radius: 6px;
    background-color: #fbf9f9;
    border: 1px solid #ddd;
    padding: 15px;">
                <h4 style="font-weight: bold; color: #00193a; text-align: right;"> ادارة الجمعية</h4>
                <hr style="background-color: black;">


                <div class="row">
                    <div class="col-3 mb-4">
                        <h4>{{ trns("Due Date") }}</h4>
                        <p>{{ $obj->association->due_date ? $obj->association->due_date : trns('N/A') }}</p>
                    </div>

                    <!-- Numbers -->
                    <div class="col-3 mb-4">
                        <h4>{{ trns("Unified Number") }}</h4>
                        <p>{{ $obj->association->unified_number ?? trns('N/A') }}</p>
                    </div>
                    <div class="col-3 mb-4">
                        <h4>{{ trns("Establish Number") }}</h4>
                        <p>{{ $obj->association->establish_number ?? trns('N/A') }}</p>
                    </div>
                    <div class="col-3 mb-4">
                        <h4>{{ trns("Status") }}</h4>
                        <p>{{ $obj->association->status ? trns('Active') : trns('Inactive') }}</p>
                    </div>

                    <!-- Manager Information -->
                    <div class="col-3 mb-4">
                        <h4>{{ trns("Interception Reason") }}</h4>
                        <p>{{ $obj->association->interception_reason ?? trns('N/A') }}</p>
                    </div>
                    <div class="col-3 mb-4">
                        <h4>{{ trns("Manager ID") }}</h4>
                        <p>{{ $obj->association->user->name ?? trns('N/A') }}</p>
                    </div>
                    <div class="col-3 mb-4">
                        <h4>{{ trns("Appointment Start") }}</h4>
                        <p>{{ $obj->association->appointment_start_date ? $obj->association->appointment_start_date : trns('N/A') }}</p>
                    </div>
                    <div class="col-3 mb-4">
                        <h4>{{ trns("Appointment End") }}</h4>
                        <p>{{ $obj->association->appointment_end_date ? $obj->association->appointment_end_date : trns('N/A') }}</p>
                    </div>

                    <!-- Financial Information -->
                    <div class="col-3 mb-4">
                        <h4>{{ trns("Monthly Fees") }}</h4>
                        <p>{{ $obj->association && $obj->association->monthly_fees ?$obj->association->monthly_fees : trns('N/A') }}</p>
                    </div>
                    <div class="col-3 mb-4">
                        <h4>{{ trns("Commission") }}</h4>
                        <p>{{ $obj->association->is_commission ? trns('Yes') : trns('No') }}</p>
                    </div>
                    <div class="col-3 mb-4">
                        <h4>{{ trns("Commission Name") }}</h4>
                        <p>{{ $obj->association->commission_name ?? trns('N/A') }}</p>
                    </div>
                    <div class="col-3 mb-4">
                        <h4>{{ trns("Commission Type") }}</h4>
                        <p>{{ $obj->association->commission_type ? trns('Type ' . $obj->association->commission_type) : trns('N/A') }}</p>
                    </div>
                    <div class="col-3 mb-4">
                        <h4>{{ trns("Created At") }}</h4>
                        <p>{{ $obj->association->created_at ? $obj->association->created_at->format("Y-m-d") : trns('N/A') }}</p>
                    </div>
                </div>
            </div>





            {{-- <!-- Location & Media -->
                  <div class="col-3 mb-4">
                      <h4>{{ trns("Latitude") }}</h4>
            <p>{{ $obj->association->lat ?? trns('N/A') }}</p>
        </div>
        <div class="col-3 mb-4">
            <h4>{{ trns("Longitude") }}</h4>
            <p>{{ $obj->association->lng ?? trns('N/A') }}</p>
        </div> --}}
        {{-- <div class="col-3 mb-4">--}}
        {{-- <h4>{{ trns("Logo") }}</h4>--}}
        {{-- <p>--}}
        {{-- @if($obj->association->logo)--}}
        {{-- <img src="{{ $obj->association->logo }}" alt="Logo" class="img-thumbnail" style="max-height: 50px;">--}}
        {{-- @else--}}
        {{-- {{ trns('N/A') }}--}}
        {{-- @endif--}}
        {{-- </p>--}}
        {{-- </div>--}}




        <div class="col-12 mt-4" style="border-radius: 6px;
                        background-color: #fbf9f9;
                        border: 1px solid #ddd;
                        padding: 15px;">
            <div class="form-group">
                <h4 for="lat" class="form-control-label" style="font-weight: bold; color: #00193a; text-align: right;">
                    {{ trns('Association Facilities Management') }}
                </h4>
                <hr style="background-color: black;">
                <div class="mt-2 row">
                    <div class="col-md-6 mb-3">
                        <div class="card custom-card text-right" style="box-shadow: none;background-color: #f8f9fa; border: 1px solid #b5b5c3; border-radius: 6px;">
                            <div class="card-body">
                                <div class="form-check form-check-inline float-end">
                                    <!-- <input class="form-check-input" type="radio"
                                            name="facility_management_template" id="template1" value="template1"> -->
                                    <label class="form-check-label" for="template1"></label>
                                </div>
                                <h5 class="association-card-header" style="color: #00193a; font-weight: bold;">
                                    {{ trns('Integrated Facilities Management') }}
                                </h5>
                                <p class="association-card-para">
                                    {{ trns('Here the service provider is able to provide most of the services') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-6 mb-3">
                            <div class="card custom-card text-right">
                                <div class="card-body">
                                    <div class="form-check form-check-inline float-end">
                                        <input class="form-check-input" type="radio"
                                            name="facility_management_template" id="template2" value="template2">
                                        <label class="form-check-label" for="template2"></label>
                                    </div>
                                    <h5 class="association-card-header">
                                        {{ trns('Basic Model (Contract per Service)') }}</h5>
                                    <p class="association-card-para">
                                        {{ trns('Here the association can contract directly with each of the service providers') }}
                                    </p>
                                </div>
                            </div>
                        </div> -->
                    <!-- <div class="col-md-6 mb-3">
                            <div class="card custom-card text-right">
                                <div class="card-body">
                                    <div class="form-check form-check-inline float-end">
                                        <input class="form-check-input" type="radio"
                                            name="facility_management_template" id="template3" value="template3">
                                        <label class="form-check-label" for="template3"></label>
                                    </div>
                                    <h5 class="association-card-header">
                                        {{ trns('Total Facilities Management') }}</h5>
                                    <p class="association-card-para">
                                        {{ trns('A single contract is concluded between the association and the service provider, and here the service provider is responsible for managing all services') }}
                                    </p>
                                </div>
                            </div>
                        </div> -->
                    <!-- <div class="col-md-6 mb-3">
                            <div class="card custom-card text-right">
                                <div class="card-body">
                                    <div class="form-check form-check-inline float-end">
                                        <input class="form-check-input" type="radio"
                                            name="facility_management_template" id="template4" value="template4">
                                        <label class="form-check-label" for="template4"></label>
                                    </div>
                                    <h5 class="association-card-header">
                                        {{ trns('Self-operation (agent model)') }}</h5>
                                    <p class="association-card-para">
                                        {{ trns("The property's board of directors manages contract matters and contracts are entered into directly") }}

                                    </p>
                                </div>
                            </div>
                        </div> -->
                </div>
            </div>
        </div>


        <div class="col-12 mt-5">
            <div id="map" style="height: 400px;"></div>
        </div>





                    
                @endif
                
                @else
                   <h1>{{trns("there is no data here")}}</h1>


    </div>
    <!-- Continue for all remaining fields -->
</div>
</div>
</div>


@endsection
@section('ajaxCalls')



<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if($obj - > association ? - > lat && $obj - > association ? - > long)
        var lat = {
            {
                $obj - > association - > lat
            }
        };
        var lng = {
            {
                $obj - > association - > long
            }
        };

                var map = L.map('association-map').setView([lat, lng], 16);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors',
                    maxZoom: 19
                }).addTo(map);

        L.marker([lat, lng])
            .addTo(map)
            .bindPopup('📍 Association Location')
            .openPopup();
        @else
        console.error("No latitude/longitude available.");
        @endif
    });



    map.invalidateSize();
</script>


<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
{{-- <style> --}}
{{-- .clickable-row { --}}
{{-- cursor: pointer; --}}
{{-- } --}}
{{-- </style> --}}
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        $('.dropify').dropify();
    </script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>



    {{-- </script> --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-sA+oYy5rjphsyV6qLdX5lFh3ugMQAxTVvD+FA2z6+3Y=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-oRkS4hJ2kMRSR2J7DHOY7FTh5E3uX9U4I9znKzJxM7E=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-oRkS4hJ2kMRSR2J7DHOY7FTh5E3uX9U4I9znKzJxM7E=" crossorigin=""></script>



<script>
    function updateMarkerPosition() {
        let lat = parseFloat($("#lat").val());
        let long = parseFloat($("#long").val());

        if (!isNaN(lat) || !isNaN(long)) {
            marker.setLatLng([lat, long]);
            map.panTo([lat, long]);
        }
    }

    $("#lat, #long").on("input", updateMarkerPosition);



        $(document).ready(function() {
            $('.dropify').dropify();

            function toggleCommissionedFields() {
                $('.commissioned').toggle($('input[name="is_commission"]:checked').val() === '1');
            }

            toggleCommissionedFields();
            $('input[name="is_commission"]').on("change", toggleCommissionedFields);

            $('#appointment_start_date').on('change', function() {
                const startDate = $(this).val();
                $('#appointment_end_date').attr('min', startDate);

                if ($('#appointment_end_date').val() && $('#appointment_end_date').val() < startDate) {
                    $('#appointment_end_date').val('');
                }
            });

            $('#appointment_end_date').on('change', function() {
                const endDate = $(this).val();
                $('#appointment_start_date').attr('max', endDate);

                if ($('#appointment_start_date').val() && $('#appointment_start_date').val() > endDate) {
                    $('#appointment_start_date').val('');
                }
            });

            const map = L.map('map').setView([24.7136, 46.6753], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            const marker = L.marker([24.7136, 46.6753], {
                    draggable: true
                }).addTo(map)
                .bindPopup('Drag me to set location')
                .openPopup();

            marker.on('dragend', function(e) {
                const {
                    lat,
                    lng
                } = e.target.getLatLng();
                $('#lat').val(lat.toFixed(6));
                $('#long').val(lng.toFixed(6));
            });

            map.on('click', function(e) {
                const {
                    lat,
                    lng
                } = e.latlng;
                marker.setLatLng([lat, lng]);
                $('#lat').val(lat.toFixed(6));
                $('#long').val(lng.toFixed(6));
            });

        @if(isset($locations))
        @foreach($locations as $location)
        L.marker([{
                {
                    $location - > lat
                }
            }, {
                {
                    $location - > lng
                }
            }])
            .addTo(map)
            .bindPopup('<b>{{ $location->name }}</b><br>{{ $location->description }}');
        @endforeach
        @endif
    });
</script>

    $(document).on('click', '.toggleStatusBtn', function(e) {
        e.preventDefault();

        let id = $(this).data('id');
        let currentStatus = parseInt($(this).data('status'));
        let newStatus = currentStatus === 1 ? 0 : 1;

        $.ajax({
            type: 'POST',
            url: '{{ route('real_states.updateColumnSelected') }}',
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
    

@endsection