
<div>
    <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{ $updateRoute }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $obj->id }}" name="id">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="title_ar" class="form-control-label">{{ trns('title_ar') }}<span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="title[ar]" id="title[ar]"
                           value="{{ $obj->getTranslation('title', 'ar') }}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="title_en" class="form-control-label">{{ trns('title_en') }}
                        {{-- <span
                            class="text-danger">*</span> --}}
                        </label>
                    <input type="text" class="form-control" name="title[en]" id="title[en]"
                           value="{{ $obj->getTranslation('title', 'en') }}">
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
                    <input type="text" class="form-control" name="long" id="long" value="{{ $obj->long }}">

                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="lat" class="form-control-label">{{ trns('lat') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" name="lat" id="lat" value="{{ $obj->lat }}">

                </div>
            </div>
        </div>
    </form>
</div>

{{-- Leaflet CSS & JS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-sA+oYy5rjphsyV6qLdX5lFh3ugMQAxTVvD+FA2z6+3Y=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-oRkS4hJ2kMRSR2J7DHOY7FTh5E3uX9U4I9znKzJxM7E=" crossorigin=""></script>

<script>
    $(document).ready(function() {
        // Get values from inputs (or default if null)
        const defaultLat = parseFloat("{{ $obj->lat ?? 24.7136 }}");
        const defaultLng = parseFloat("{{ $obj->long ?? 46.6753 }}");

        // Initialize map
        const map = L.map('map').setView([defaultLat, defaultLng], 13);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Add draggable marker
        const marker = L.marker([defaultLat, defaultLng], { draggable: true })
            .addTo(map)
            .bindPopup('Drag me or click map to set location')
            .openPopup();

        // Update inputs when dragging marker
        marker.on('dragend', function(e) {
            const { lat, lng } = e.target.getLatLng();
            $('#lat').val(lat.toFixed(6));
            $('#long').val(lng.toFixed(6));
        });

        // Update marker when clicking on map
        map.on('click', function(e) {
            const { lat, lng } = e.latlng;
            marker.setLatLng([lat, lng]);
            $('#lat').val(lat.toFixed(6));
            $('#long').val(lng.toFixed(6));
        });

        // Update marker if user types manually in inputs
        function updateMarkerPosition() {
            let lat = parseFloat($("#lat").val());
            let lng = parseFloat($("#long").val());

            if (!isNaN(lat) && !isNaN(lng)) {
                marker.setLatLng([lat, lng]);
                map.panTo([lat, lng]);
            }
        }

        $("#lat, #long").on("input", updateMarkerPosition);
    });
</script>
