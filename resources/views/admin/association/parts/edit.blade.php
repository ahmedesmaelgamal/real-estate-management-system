<div class="modal-body">
    <form id="updateForm" class="association_update_form" data-id="{{ $obj->id }}" method="POST"
        enctype="multipart/form-data" action="{{ $updateRoute }}">
        @csrf
        @method('PUT')

        <input type="hidden" value="{{ $obj->id }}" name="id">
        <div class="row">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="image" class="form-control-label">{{ trns('association_logo') }}</label>
                        <div class="logo-upload-wrapper">
                            <input type="file" id="logoInput" name="logo" accept="image/*"
                                onchange="previewLogo(this)">
                            @if ($obj->getMedia('logo')->first())
                                <img
                                    src="{{ getFile('storage/association/' . $obj->getMedia('logo')->first()?->model_id . '/logo/' . $obj->getMedia('logo')->first()?->file_name) }}"
                                    id="logoPreview" alt="Avatar" class="avatar-circle">
                            @else
                                <img src="{{ asset('assets/uploads/empty.png') }}" id="logoPreview" alt="Avatar"
                                    class="avatar-circle">
                            @endif
                            <div class="camera-icon" onclick="document.getElementById('logoInput').click()">
                                <img src="{{ asset('assets/camera.png') }}" alt="Camera" />
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="name_ar" class="form-control-label">{{ trns('name_ar') }}<span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" value="{{ $obj->getTranslation('name', 'ar') }}"
                        name="name[ar]" id="name[ar]">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="name_en" class="form-control-label">{{ trns('name_en') }}
                        {{-- <span class="text-danger">*</span> --}}
                    </label>
                    <input type="text" class="form-control" value="{{ $obj->getTranslation('name', 'en') }}"
                        name="name[en]" id="name[en]">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="number" class="form-control-label">{{ trns('association_number') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="number" value="{{ $obj->number }}" class="form-control" name="number"
                        id="number">
                </div>
            </div>
            {{-- <div class="col-4">
                    <div class="form-group">
                        <label for="unit_count" class="form-control-label">{{ trns('unit_count') }}
                        <span class="text-danger">*</span>
                        </label>
                        <input type="number" value="{{ $obj->unit_count}}" class="form-control" name="unit_count" id="unit_count">
                    </div>
                </div> --}}
            {{-- <div class="col-4">
                    <div class="form-group">
                        <label for="real_state_count" class="form-control-label">{{ trns('real_state_count') }}</label>
                        <input type="number" class="form-control" value="{{ $obj->real_state_count}}" name="real_state_count" id="real_state_count">
                    </div>
                </div> --}}
            <div class="col-4">
                <div class="form-group">
                    <label for="approval_date" class="form-control-label">{{ trns('approval_date') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="date" class="form-control" name="approval_date" value="{{ $obj->approval_date }}"
                        id="approval_date">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="establish_date" class="form-control-label">{{ trns('establish_date') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="date" class="form-control" name="establish_date" value="{{ $obj->establish_date }}"
                        id="establish_date">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="due_date" class="form-control-label">{{ trns('due_date') }}

                    </label>
                    <input type="date" class="form-control" name="due_date" value="{{ $obj->due_date }}"
                        id="due_date">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="unified_number" class="form-control-label">{{ trns('unified_number') }}<span
                            class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="unified_number"
                        value="{{ $obj->unified_number }}" id="unified_number">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="establish_number" class="form-control-label">{{ trns('establish_number') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control" name="establish_number"
                        value="{{ $obj->establish_number }}" id="establish_number">
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
                            value="1" @if ($obj->status == 1) checked @endif
                            onchange="toggleInterceptionReason()">
                    </div>
                    <label class="form-check-label {{ lang() == 'ar' ? 'me-3' : 'ms-5' }}"
                        for="statusToggle">{{ trns('deactivate') }}</label>
                </div>
            </div>

            <div class="col-12" id="interception_reason_container"
                style="display: {{ $obj->status == 0 ? 'block' : 'none' }};">
                <div class="form-group">
                    <label for="interception_reason"
                        class="form-control-label">{{ trns('interception_reason') }}</label>
                    <textarea class="form-control" name="interception_reason" id="interception_reason" rows="3">{{ $obj->interception_reason }}</textarea>
                </div>
            </div>



            <div class="d-flex" style="flex-direction: column; padding-right: 15px;">
                <h5 class="fw-bold" style="color: #00193a;">{{ trns('association_management') }}</h5>
                <p class="association-sub-para">{{ trns('management_data') }}</p>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label for="association_manager_id" class="form-control-label">
                        {{ trns('association_manager_id') }}<span class="text-danger">*</span>
                    </label>
                    <select class="form-control" name="association_manager_id" id="association_manager_id">
                        @foreach ($associationManagers as $associationManager)
                            <option @if ($associationManager->id == $obj->association_manager_id) selected @endif
                                value="{{ $associationManager->id }}">{{ $associationManager->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="appointment_start_date" class="form-control-label">
                        {{ trns('appointment_start_date') }}<span class="text-danger">*</span>
                    </label>
                    <input type="date" class="form-control" value="{{ $obj->appointment_start_date }}"
                        name="appointment_start_date" id="appointment_start_date">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="appointment_end_date" class="form-control-label">
                        {{ trns('appointment_end_date') }}<span class="text-danger">*</span>
                    </label>
                    <input type="date" class="form-control" value="{{ $obj->appointment_end_date }}"
                        name="appointment_end_date" id="appointment_end_date">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="monthly_fees" class="form-control-label">{{ trns('monthly_fees') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control" value="{{ $obj->monthly_fees }}" name="monthly_fees"
                        id="monthly_fees">
                </div>
            </div>


            <div class="col-4" id="is_commissioned">
                <div class="form-group">
                    <label class="form-control-label">{{ trns('is_commissioned') }}</label>
                    <div class="row">
                        <div class="col">
                            <input type="radio" name="is_commission" id="commissioned" value="1"
                                @if ($obj->is_commission == 1) checked @endif>
                            <label for="commissioned">{{ trns('yes') }}</label>
                        </div>
                        <div class="col">
                            <input type="radio" name="is_commission" id="notCommissioned" value="0"
                                @if ($obj->is_commission == 0) checked @endif>
                            <label for="notCommissioned">{{ trns('no') }}</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4"></div>


            <div class="col-4 commissioned">
                <div class="form-group">
                    <label for="commission_name" class="form-control-label">{{ trns('commission_name') }}</label>
                    <input type="text" class="form-control" value="{{ $obj->commission_name }}"
                        name="commission_name" id="commission_name">
                </div>
            </div>

            <div class="col-4 commissioned">
                <div class="form-group">
                    <label for="commission_type" class="form-control-label">{{ trns('commission_type') }}</label>
                    <select class="form-control" name="commission_type" id="commission_type">
                        <option @if ($obj->commission_type == 0) selected @endif value="0">
                            {{ trns('percentage') }}</option>
                        <option @if ($obj->commission_type == 1) selected @endif value="1">
                            {{ trns('constant') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-4 commissioned">
                <div class="form-group">
                    <label for="commission_percentage" class="form-control-label"
                        id="commission_percentage_label">{{ trns('commission_percentage') }}</label>

                    <input type="number" class="form-control" max="100" min="0"
                        name="commission_percentage" id="commission_percentage"
                        value="{{ $obj->commission_percentage }}">

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
                        {{--                            {{$obj->AssociationModel->getTranslation('title', app()->getLocale())}} --}}
                        @foreach ($associationModels as $associationModel)
                            <div class="col-md-4 col-12 mb-3">
                                <div class="card custom-radio-card custom-radio-card-checked  text-right">
                                    <input class="form-check-input d-none" type="radio"
                                        @if ($obj->AssociationModel?->id == $associationModel->id) checked @endif name="association_model_id"
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

            <div class="col-12">
                <div class="form-group">
                    <h4 for="lat" class="form-control-label" style="display:block">
                        {{ trns('association_location_on_the_map') }}</h4>
                    <label for="lat"
                        class="form-control-label">{{ trns('Select from the map and automatically determine the latitude and longitude') }}</label>
                    <div id="map" style="height: 400px;"></div>
                </div>
            </div>



            <div class="col-6">
                <div class="form-group">
                    <label for="long" class="form-control-label">{{ trns('long') }}</label>
                    <input type="text" class="form-control" value="{{ $obj->long }}" name="long"
                        id="long" value="46.6753">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="lat" class="form-control-label">{{ trns('lat') }}</label>
                    <input type="text" value="{{ $obj->lat }}" class="form-control" name="lat"
                        id="lat" value="24.7136">
                </div>
            </div>






            <div class="col-12 mb-4">
                <label class="form-control-label text-primary-custom">
                    {{ trns('current_images') }}
                </label>
                <div class="d-flex flex-wrap" id="existing-images-container">
                    @if ($obj->getMedia('images')->count() > 0)
                        @foreach ($obj->getMedia('images') as $media)
                            <div class="image-preview-item me-2 mb-2" data-id="{{ $media->id }}">
                                <img src="{{ asset('storage/association/' . $obj->id . '/images/' . $media->file_name) }}"
                                    alt="Association Image"
                                    style="width: 180px; height: 180px; object-fit: cover; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.15);"
                                    class="img-fluid"
                                    onerror="this.onerror=null;this.src='{{ asset('assets/avatar.png') }}';">
                                <button type="button" class="btn btn-danger btn-sm remove-existing-image"
                                    style="position: absolute; top: 5px; right: 5px; width: 25px; height: 25px; padding: 0; border-radius: 50%; z-index: 10;">
                                    ×
                                </button>
                                <input type="hidden" name="existing_images[]" value="{{ $media->id }}">
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">{{ trns('no_images_found') }}</p>
                    @endif
                </div>
            </div>

            <!-- Upload new images -->
            <div class="col-12 mb-4">
                <div class="form-group">
                    <label for="images"
                        class="form-control-label text-primary-custom">{{ trns('add_new_images') }}</label>
                    <label class="form-control-label text-muted-custom">
                        {{ trns('you_can_control_images_from_here') }}
                    </label>
                    <div class="file-upload-wrapper">
                        <input type="file" accept="image/*" name="new_images[]" id="multi-dropify"
                            class="file-upload-input files-dropify" multiple>
                        <label for="multi-dropify" class="file-upload-label">
                            <span
                                class="file-upload-text d-flex flex-column justify-content-center align-items-center">
                                <i class="fa-solid fa-cloud-arrow-up mb-3"></i>
                                قم بسحب وإسقاط الصور الخاصة بك هنا
                            </span>
                        </label>
                        <div class="file-previews" id="new-images-preview"
                            style="position: absolute;
    top: 0;
    right: 10px;"></div>
                    </div>
                </div>
            </div>

            <!-- Display existing files -->
            <div class="col-12 mb-4">
                <label class="form-control-label text-primary-custom">
                    {{ trns('current_files') }}
                </label>
                <div class="d-flex flex-wrap" id="existing-files-container">
                    @if ($obj->getMedia('files')->count() > 0)
                        @foreach ($obj->getMedia('files') as $media)
                            <div class="file-preview-item me-2 mb-2" data-id="{{ $media->id }}">
                                <div class="file-thumbnail">
                                    @php
                                        $extension = strtolower(pathinfo($media->file_name, PATHINFO_EXTENSION));
                                        $iconClass = match ($extension) {
                                            'pdf' => 'fas fa-file-pdf text-danger',
                                            'doc', 'docx' => 'fas fa-file-word text-primary',
                                            'xls', 'xlsx' => 'fas fa-file-excel text-success',
                                            'txt' => 'fas fa-file-alt text-secondary',
                                            'ppt', 'pptx' => 'fas fa-file-powerpoint text-warning',
                                            'zip', 'rar' => 'fas fa-file-archive text-info',
                                            default => 'fas fa-file text-secondary',
                                        };
                                    @endphp
                                    <i class="{{ $iconClass }}" style="font-size: 40px;"></i>
                                    <div class="file-name">{{ $media->file_name }}</div>
                                    {{--                                     <div class="file-size">{{ formatBytes($media->size) }}</div> --}}
                                </div>
                                <button type="button" class="btn btn-danger btn-sm remove-existing-file"
                                    style="position: absolute; top: 5px; right: 5px; width: 25px; height: 25px; padding: 0; border-radius: 50%; z-index: 10;">
                                    ×
                                </button>
                                <input type="hidden" name="existing_files[]" value="{{ $media->id }}">
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">{{ trns('no_files_found') }}</p>
                    @endif
                </div>
            </div>

            <!-- Upload new files -->
            <div class="col-12 mb-4">
                <div class="form-group">
                    <label for="files"
                        class="form-control-label text-primary-custom">{{ trns('add_new_files') }}</label>
                    <label class="form-control-label text-muted-custom">
                        {{ trns('you_can_upload_documents_formats') }}
                    </label>
                    <div class="file-upload-wrapper">
                        <input type="file" accept=".pdf,.doc,.xls,.xlsx,.docx,.ppt,.pptx,.txt,.zip,.rar"
                            name="new_files[]" id="files-dropify" class="file-upload-input files-dropify" multiple>
                        <label for="files-dropify" class="file-upload-label">
                            <span
                                class="file-upload-text d-flex flex-column justify-content-center align-items-center">
                                <i class="fa-solid fa-cloud-arrow-up mb-3"></i>
                                قم بسحب وإسقاط الملفات الخاصة بك هنا
                            </span>
                        </label>
                        <div class="file-previews" id="new-files-preview"
                            style="position: absolute;
    top: 0;
    right: 10px;"></div>
                    </div>
                </div>
            </div>



        </div>
</div>
</form>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>


<!-- dropify -->
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
        z-index: 2;
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
        transition: all 0.3s ease;
    }

    .file-upload-label:hover {
        border-color: #00F3CA;
        background-color: #f0fffe;
    }

    .file-upload-text {
        color: #6c757d;
        pointer-events: none;
    }

    .file-previews {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
    }

    .preview-item {
        width: 100px;
        /* height: 180px; */
        position: relative;
        border: 1px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
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
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        z-index: 3;
    }

    .remove-btn:hover {
        background: #c82333;
    }

    /* Make sure remove buttons are clickable */
    .remove-existing-image,
    .remove-existing-file {
        position: absolute !important;
        top: 5px !important;
        right: 5px !important;
        z-index: 10 !important;
        background: #dc3545 !important;
        color: white !important;
        border: none !important;
        border-radius: 50% !important;
        width: 25px !important;
        height: 25px !important;
        padding: 0 !important;
        cursor: pointer !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 16px !important;
        line-height: 1 !important;
    }

    .remove-existing-image:hover,
    .remove-existing-file:hover {
        background: #c82333 !important;
        transform: scale(1.1);
    }

    /* Existing items styles */
    .image-preview-item,
    .file-preview-item {
        position: relative;
        width: 180px;
        height: 180px;
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .file-thumbnail {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 10px;
        padding: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .file-name {
        margin-top: 10px;
        text-align: center;
        word-break: break-all;
        font-size: 12px;
    }

    .file-info {
        text-align: center;
        padding: 10px;
        background: #f8f9fa;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .form-control-label {
        font-weight: 600;
        margin-bottom: 8px;
    }

    .text-primary-custom {
        color: #00F3CA !important;
    }

    .text-muted-custom {
        color: #6c757d !important;
        font-weight: normal !important;
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
<!-- dropify -->



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
<script>
    function updateMarkerPosition() {
        let lat = parseFloat($("#lat").val());
        let long = parseFloat($("#long").val());

        if (!isNaN(lat) || !isNaN(long)) {
            marker.setLatLng([lat, long]);
            map.panTo([lat, long]);
        }
    }

    // Listen for input changes on both fields
    $("#lat, #long").on("input", updateMarkerPosition);


    $(document).ready(function() {
        // Initialize Dropify
        $('.dropify').dropify();

        // Initialize Select2
        initializeSelect2InModal('#commission_type')
        initializeSelect2InModalWithSearch('#association_manager_id', ['national-id', 'email', 'phone']);




        // Commissioned fields toggle
        function toggleCommissionedFields() {
            const isCommissioned = $('input[name="is_commission"]:checked').val() === '1';
            $('.commissioned').toggle(isCommissioned);

            if (isCommissioned) {
                $('.commissioned').find('input, select').prop('disabled', false);
            } else {
                $('.commissioned').find('input, select').prop('disabled', true);
            }
        }

        // Initialize commissioned fields
        toggleCommissionedFields();
        $('input[name="is_commission"]').on("change", toggleCommissionedFields);

        // Date validation
        $('#appointment_start_date').on('change', function() {
            const startDate = $(this).val();
            $('#appointment_end_date').attr('min', startDate);
        });

        $('#appointment_end_date').on('change', function() {
            const endDate = $(this).val();
            $('#appointment_start_date').attr('max', endDate);
        });





        // Date validation
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

        // Initialize map
        const initialLat = parseFloat("{{ $obj->lat ?? 24.7136 }}");
        const initialLng = parseFloat("{{ $obj->long ?? 46.6753 }}");

        const map = L.map('map').setView([initialLat, initialLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        const marker = L.marker([initialLat, initialLng], {
                draggable: true
            }).addTo(map)
            .bindPopup('Selected location')
            .openPopup();

        // Update coordinates when marker is dragged
        marker.on('dragend', function(e) {
            const {
                lat,
                lng
            } = e.target.getLatLng();
            $('#lat').val(lat.toFixed(6));
            $('#long').val(lng.toFixed(6));
        });

        // Update marker position when map is clicked
        map.on('click', function(e) {
            const {
                lat,
                lng
            } = e.latlng;
            marker.setLatLng([lat, lng]);
            $('#lat').val(lat.toFixed(6));
            $('#long').val(lng.toFixed(6));
        });
    });



    $(document).ready(function() {
        $('#status').on('change', function() {
            if ($(this).val() === '0') {
                $('#interception_reason_div').show();
            } else {
                $('#interception_reason_div').hide();
            }
        }).trigger('change');
    });

    $(document).ready(function() {
        $('#commission_type').on('change', function() {
            let data = $(this).val();
            if (data === '0') {
                $('#commission_percentage_label').html("{{ trns('commission_percentage') }} %");
            } else {
                $('#commission_percentage_label').html("{{ trns('commission_amount') }}");
            }
        }).trigger('change');
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
</script>
