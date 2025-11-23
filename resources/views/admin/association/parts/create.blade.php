<div class="modal-body">
    <form id="addForm" class="addForm associationCreate" method="POST" enctype="multipart/form-data"
        action="{{ $storeRoute }}">
        @csrf
        <div class="row ">
            <div class="col-12">
                <div class="form-group">
                    <label for="logo" class="form-control-label">{{ trns('association_logo') }}</label>
                    <!-- <input type="file" accept="image/*" multiple class="dropify" name="logo" id="logo"> -->

                    <div class="logo-upload-wrapper">
                        <input type="file" id="logoInput" name="logo" accept="image/*"
                            onchange="previewLogo(this)">
                        <img src="{{ asset('assets/avatar.png') }}" id="logoPreview" alt="Avatar"
                            class="avatar-circle">
                        <div class="camera-icon" onclick="document.getElementById('logoInput').click()">
                            <img src="{{ asset('assets/camera.png') }}" alt="Camera" />
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="name_ar" class="form-control-label">{{ trns('name_ar') }}<span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name[ar]" id="name.ar">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="name_en" class="form-control-label">{{ trns('name_en') }}
                        {{-- <span class="text-danger">*</span> --}}
                    </label>
                    <input type="text" class="form-control" name="name[en]" id="name.en">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="number" class="form-control-label">{{ trns('association_number') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control" name="number" id="number">
                    @error('number')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="approval_date" class="form-control-label">{{ trns('approval_date') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="date" class="form-control" name="approval_date" id="approval_date">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="establish_date" class="form-control-label">{{ trns('establish_date') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="date" class="form-control" name="establish_date" id="establish_date">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="due_date" class="form-control-label">{{ trns('due_date') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="date" class="form-control" name="due_date" id="due_date">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="unified_number" class="form-control-label">{{ trns('unified_number') }}<span
                            class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="unified_number" id="unified_number">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="establish_number" class="form-control-label">{{ trns('establish_number') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control" name="establish_number" id="establish_number">
                </div>
            </div>



            <div class="col-lg-4 col-12">
                <h6 style="color:#00193a; font-weight: bold;">
                    {{ trns('status') }}<span class="text-danger">*</span>
                </h6>
                <div
                    style="background-color: #E9E9E9; border-radius: 6px; padding: 10px; margin-bottom: 20px; display:flex;">
                    <div class="form-check form-switch">
                        <label class="form-check-label {{ lang() == 'ar' ? 'ms-2' : 'me-3' }}"
                            for="statusToggle">{{ trns('activate') }}</label>
                        <input class="form-check-input ms-0" type="checkbox" id="statusToggle" name="status"
                            checked onchange="toggleInterceptionReason()">
                    </div>
                    <label class="form-check-label {{ lang() == 'ar' ? 'me-3' : 'ms-5' }}"
                        for="statusToggle">{{ trns('deactivate') }}</label>
                </div>
            </div>



            <div class="col-12" id="interception_reason_container" style="display: none;">
                <div class="form-group">
                    <label for="interception_reason"
                        class="form-control-label">{{ trns('interception_reason') }}</label>
                    <textarea class="form-control" name="interception_reason" id="interception_reason" rows="3"></textarea>
                </div>
            </div>

            <div class="d-flex" style="flex-direction: column; padding-right: 15px;">
                <h5 class="fw-bold" style="color: #00F3CA;">{{ trns('association_management') }}</h5>
                <p class="association-sub-para">{{ trns('management_data') }}</p>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label for="association_manager_id" class="form-control-label">
                        {{ trns('association_manager_id') }}<span class="text-danger">*</span>
                    </label>
                    <select class="form-control" name="association_manager_id" id="association_manager_id">
                        @foreach ($associationManagers as $associationManager)
                            <option data-national-id="{{ $associationManager->national_id }}"
                                data-email="{{ $associationManager->email }}"
                                data-phone="{{ $associationManager->phone }}" value="{{ $associationManager->id }}">
                                {{ $associationManager->name ?? '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="appointment_start_date" class="form-control-label">
                        {{ trns('appointment_start_date') }}<span class="text-danger">*</span>
                    </label>
                    <input type="date" class="form-control" name="appointment_start_date"
                        id="appointment_start_date">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="appointment_end_date" class="form-control-label">
                        {{ trns('appointment_end_date') }}<span class="text-danger">*</span>
                    </label>
                    <input type="date" class="form-control" name="appointment_end_date"
                        id="appointment_end_date">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="monthly_fees" class="form-control-label">{{ trns('monthly_fees') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control" name="monthly_fees" id="monthly_fees">
                </div>
            </div>

            <div class="col-4" id="is_commissioned">
                <div class="form-group">
                    <label class="form-control-label">{{ trns('is_commissioned') }}</label>
                    <div class="row">
                        <div class="col">
                            <input type="radio" name="is_commission" id="commissioned" value="1">
                            <label for="commissioned">{{ trns('yes') }}</label>
                        </div>
                        <div class="col">
                            <input type="radio" name="is_commission" id="notCommissioned" value="0" checked>
                            <label for="notCommissioned">{{ trns('no') }}</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4 commissioned">
                <div class="form-group">
                    <label for="commission_name" class="form-control-label">{{ trns('commission_name') }}</label>
                    <input type="text" class="form-control" name="commission_name" id="commission_name">
                </div>
            </div>

            <div class="col-4 commissioned">
                <div class="form-group">
                    <label for="commission_type" class="form-control-label">{{ trns('commission_type') }}</label>
                    <select class="form-control" name="commission_type" id="commission_type">
                        <option value="0">{{ trns('percentage') }}</option>
                        <option value="1">{{ trns('constant') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-4 commissioned">
                <div class="form-group">
                    <label for="commission_percentage" id="commission_percentage_label"
                        class="form-control-label">{{ trns('commission_percentage') }}</label>
                    <input type="number" class="form-control" max="100" min="0"
                        name="commission_percentage" id="commission_percentage">
                </div>
            </div>
            <hr class="divider">


            <div class="col-12">
                <div class="form-group">
                    <h4 for="lat" class="form-control-label" style="display:block">
                        {{ trns('Association Facilities Management') }}
                    </h4>
                    <label for="lat" class="form-control-label">
                        {{ trns('Select the template to manage the association') }}
                    </label>
                    <div class="mt-2 row">
                        @foreach ($associationModels as $associationModel)
                            <div class="col-md-4 col-12 mb-3">
                                <div class="card custom-radio-card custom-radio-card-checked">
                                    <input class="form-check-input d-none" type="radio" name="association_model_id"
                                        id="template{{ $loop->index + 1 }}" value="{{ $associationModel->id }}">
                                    <label for="template{{ $loop->index + 1 }}" class="card-body w-100">
                                        <h5 class="association-card-header" style="font-weight: bold;">
                                            {{ $associationModel->getTranslation('title', app()->getLocale()) }}
                                        </h5>
                                        <p class="association-card-para" style="color: #b5b5c3;">
                                            {{ $associationModel->getTranslation('description', app()->getLocale()) }}
                                        </p>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>



        <div class="col-12">
            <div class="form-group">
                <h4 for="lat" class="form-control-label" style="display:block">
                    {{ trns('association_location_on_the_map') }}</h4>
                <label for="lat"
                    class="form-control-label">{{ trns('Select from the map and automatically determine the latitude and longitude') }}</label>
                <div id="map" style="height: 400px;"></div>
            </div>
        </div>



        <div class="col-12 row">
            <div class="col-6">
                <div class="form-group">
                    <label for="long" class="form-control-label">{{ trns('long') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" name="long" id="long" value="46.6753">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="lat" class="form-control-label">{{ trns('lat') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" name="lat" id="lat" value="24.7136">
                </div>
            </div>
        </div>


        <div class="col-12">
            <div class="form-group">
                <label for="images" class="form-control-label"
                    style="display: block; color: #00F3CA !important;">{{ trns('association_images') }}</label>

                <label for="images" class="form-control-label"
                    style="display: block; color: gray !important; font-weight: normal !important;">{{ trns('you can control iamges from here') }}</label>

                <div class="file-upload-wrapper">
                    <input type="file" accept="image/*" name="images[]" id="multi-dropify"
                        class="file-upload-input files-dropify" multiple>
                    <label for="multi-dropify" class="file-upload-label">
                        <span class="file-upload-text d-flex flex-column justify-content-center align-items-center">
                            <i class="fa-solid fa-cloud-arrow-up mb-3"></i>
                            قم بسحب وإسقاط الصور الخاصة بك هنا
                        </span>
                    </label>
                    <div class="file-previews" style="position: absolute;top: 0;right: 10px;"></div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="files" class="form-control-label"
                    style="display: block; color: #00F3CA !important;">{{ trns('files') }}</label>
                <label for="address" style="display: block; color: gray !important; font-weight: normal !important;"
                    class="form-control-label">{{ trns('You can upload documents in the following formats excel - pdf - word - txt') }}</label>
                <div class="file-upload-wrapper">
                    <input type="file" accept=".pdf, .doc, .xls, .xlsx, .docx" name="files[]"
                        class="file-upload-input files-dropify" multiple>
                    <label for="files-dropify" class="file-upload-label">
                        <span class="file-upload-text d-flex flex-column justify-content-center align-items-center">
                            <i class="fa-solid fa-cloud-arrow-up mb-3"></i>
                            قم بسحب وإسقاط الملفات الخاصة بك هنا
                        </span>
                    </label>
                    <div class="file-previews" style="position: absolute;
    top: 0;
    right: 10px;"></div>
                </div>
            </div>
        </div>


</div>
</div>
</form>
</div>


{{-- @endsection
@section('ajaxCalls') --}}


<!-- CSS -->
<style>
    .file-upload-wrapper {
        position: relative;
        margin-bottom: 20px;
    }

    .file-upload-input {
        width: 100%;
        height: 200px;
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
        cursor: pointer;
    }

    .file-upload-label {
        width: 100%;
        height: 200px;
        border: 2px dashed #ccc;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }

    .file-upload-text {
        color: #6c757d;
    }

    .file-previews {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
    }

    .preview-item {
        width: 100px;
        /* height: 100px; */
        position: relative;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
    }

    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .remove-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: red;
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        cursor: pointer;
    }
</style>


<script>
    // Function to get file extension
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

                            document.querySelectorAll('.files-dropify').forEach(input => {
                                input.addEventListener('change', function(e) {
                                    const previewContainer = this.closest('.file-upload-wrapper').querySelector(
                                        '.file-previews');
                                    previewContainer.innerHTML = '';

                                    for (let i = 0; i < this.files.length; i++) {
                                        const file = this.files[i];
                                        const reader = new FileReader();

                                        reader.onload = function(e) {
                                            const previewItem = document.createElement('div');
                                            previewItem.className = 'preview-item';

                                            if (file.type.match('image.*')) {
                                                // For images, show the actual image preview
                                                previewItem.innerHTML = `
                                                    <img src="${e.target.result}" alt="${file.name}" style="max-width: 100px; max-height: 100px;">
                                                    <div class="file-info">
                                                        <div class="file-name">${file.name}</div>
                                                        <div class="file-size">${(file.size / 1024).toFixed(2)} KB</div>
                                                    </div>
                                                    <button class="remove-btn" data-index="${i}">×</button>
                                                `;
                                            } else {
                                                // For non-images, show SVG icon
                                                const extension = getFileExtension(file.name);
                                                const iconPath = getIconPath(extension);

                                                previewItem.innerHTML = `
                                                    <div class="file-preview">
                                                        <img src="${iconPath}" alt="${extension} file" class="file-icon">
                                                    </div>
                                                    <button class="remove-btn" data-index="${i}">×</button>
                                                `;
                                            }

                                            previewContainer.appendChild(previewItem);
                                                                                                                                                                        
                                            previewItem.querySelector('.remove-btn').addEventListener('click', function() {
                                                const index = parseInt(this.getAttribute('data-index'));
                                                const dt = new DataTransfer();
                                                const files = Array.from(input.files);

                                                files.splice(index, 1);
                                                files.forEach(file => dt.items.add(file));

                                                input.files = dt.files;
                                                previewItem.remove();
                                            });
                                        }

                                        reader.readAsDataURL(file);
                                    }
                                });
                            });
</script>

<script>
    initializeSelect2InModalWithSearch('#association_manager_id', ['national-id', 'email', 'phone']);
</script>


<script>
    //show or hide the interception reason based on the status toggle

    function toggleInterceptionReason() {
        const statusToggle = document.getElementById('statusToggle');
        const interceptionContainer = document.getElementById('interception_reason_container');
        interceptionContainer.style.display = statusToggle.checked ? 'none' : 'block';
    }
    document.addEventListener('DOMContentLoaded', function() {
        toggleInterceptionReason();
    });
</script>

{{-- </script> --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-sA+oYy5rjphsyV6qLdX5lFh3ugMQAxTVvD+FA2z6+3Y=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-oRkS4hJ2kMRSR2J7DHOY7FTh5E3uX9U4I9znKzJxM7E=" crossorigin=""></script>
<script>
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





    $(document).ready(function() {
        $('#status').on('change', function() {
            if ($(this).val() === '0') {
                $('#interception_reason').show();
            } else {
                $('#interception_reason').hide();
            }
        }).trigger('change');
    });


    $(document).ready(function() {
        function updateCommissionLabel() {
            const type = $('#commission_type').val();
            const $label = $('#commission_percentage_label');

            const LABEL_AMOUNT = "{{ trns('amount') }}";
            const LABEL_PERCENTAGE = "{{ trns('percentage') }} %";
            if (type === '1') {
                $label.text(LABEL_AMOUNT);
            } else {
                $label.text(LABEL_PERCENTAGE);
            }
        }

        updateCommissionLabel();

        $('#commission_type').on('change', function() {
            updateCommissionLabel();
        });
    });

    function previewLogo(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('logoPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // make input date when click open the calendar
    document.querySelectorAll('input[type="date"]').forEach(input => {
        input.addEventListener('click', function() {
            this.showPicker();
        });
    });
</script>
