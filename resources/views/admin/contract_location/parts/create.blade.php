<div >
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{ $storeRoute }}">
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="title_ar" class="form-control-label">{{ trns('title_ar') }}
                        <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="title[ar]" id="title_ar">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="title_en" class="form-control-label">{{ trns('title_en') }}
                        {{-- <span class="text-danger">*</span> --}}
                    </label>
                    <input type="text" class="form-control" name="title[en]" id="title_en">
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <h4 class="form-control-label" style="display:block">
                        {{ trns('association_location_on_the_map') }}
                    </h4>
                    <label class="form-control-label">
                        {{ trns('Select from the map and automatically determine the latitude and longitude') }}
                    </label>
                    <div id="map" style="height: 400px;"></div>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="long" class="form-control-label">{{ trns('long') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control" name="long" id="long" value="46.6753">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="lat" class="form-control-label">{{ trns('lat') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control" name="lat" id="lat" value="24.7136">
                </div>
            </div>
        </div>
    </form>
</div>


{{-- Scripts --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-sA+oYy5rjphsyV6qLdX5lFh3ugMQAxTVvD+FA2z6+3Y=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-oRkS4hJ2kMRSR2J7DHOY7FTh5E3uX9U4I9znKzJxM7E=" crossorigin=""></script>
@include('admin/layouts/NewmyAjaxHelper')

<script>


    function getFileExtension(filename) {
        return filename.split('.').pop().toLowerCase();
    }

    // Function to get SVG icon path based on file extension
    function getIconPath(extension) {
        const iconMap = {
            // Microsoft Office
            'xlsx': '{{ asset('svgs/excel.svg') }}',
            'xls': '{{ asset('svgs/excel.svg') }}',
            'docx': '{{ asset('svgs/word.svg') }}',
            'doc': '{{ asset('svgs/word.svg') }}',

            // PDF
            'pdf': '{{ asset('svgs/pdf.svg') }}',


            // Default fallback
            'default': '{{ asset('svgs/file.svg') }}'
        };

        return iconMap[extension] || iconMap['default'];
    }



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

        @if (isset($locations))
        @foreach ($locations as $location)
        L.marker([{{ $location->lat }}, {{ $location->lng }}])
            .addTo(map)
            .bindPopup('<b>{{ $location->name }}</b><br>{{ $location->description }}');
        @endforeach
        @endif


        // Update marker position when lat/long inputs change
        function updateMarkerPosition() {
            let lat = parseFloat($("#lat").val());
            let long = parseFloat($("#long").val());

            if (!isNaN(lat) && !isNaN(long)) {
                marker.setLatLng([lat, long]);
                map.panTo([lat, long]);
            }
        }

        // Listen for input changes on both fields
        $("#lat, #long").on("input", updateMarkerPosition);
    });
</script>
