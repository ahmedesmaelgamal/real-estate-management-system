<style>
    .select2-selection__choice.hidden-selection {
        display: none !important;
    }
</style>

</style>
<div class="modal-body">
    <form id="updateForm" class="units_update_form" data-id="{{ $obj->id }}" method="POST"
        enctype="multipart/form-data" action="{{ $updateRoute }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $obj->id }}" name="id">
        <div class="row">


            <div class="col-12">
                <div class="form-group">
                    <label for="user_ids" class="form-control-label">{{ trns('choose_owner_name') }}</label>
                    <select class="form-control select2-multiple" name="user_ids[]" id="user_ids" multiple="multiple">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @if (in_array($user->id, $obj->unitOwners->pluck('user_id')->toArray())) selected @endif>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div id="dynamic-inputs" class="mt-3"></div>
            </div>




            <div class="col-12">
                <div class="form-group">
                    <label for="description"
                        class="form-control-label">{{ trns('real_state_unit_description') }}</label>
                    <textarea class="form-control" name="description" id="description">{{ $obj->description }}</textarea>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="unit_number" class="form-control-label">{{ trns('real_state_unit_number') }}</label>
                    <input type="text" class="form-control" name="unit_number" id="unit_number"
                        value="{{ $obj->unit_number }}">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="space" class="form-control-label">{{ trns('space') }}</label>
                    <input type="number" class="form-control" name="space" id="space"
                        value="{{ $obj->space }}">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="unit_code" class="form-control-label">{{ trns('unit_code') }}</label>
                    <input type="number" class="form-control" name="unit_code" id="unit_code"
                        value="{{ $obj->unit_code }}">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="floor_count" class="form-control-label">{{ trns('floor_count') }}</label>
                    <input type="number" class="form-control" name="floor_count" id="floor_count"
                        value="{{ $obj->floor_count }}">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="bathrooms_count" class="form-control-label">{{ trns('bathrooms_count') }}</label>
                    <input type="number" class="form-control" name="bathrooms_count" id="bathrooms_count"
                        value="{{ $obj->bathrooms_count }}">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="bedrooms_count" class="form-control-label">{{ trns('bedrooms_count') }}</label>
                    <input type="number" class="form-control" name="bedrooms_count" id="bedrooms_count"
                        value="{{ $obj->bedrooms_count }}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="northern_border" class="form-control-label">{{ trns('northern_border') }}</label>
                    <input type="number" class="form-control" name="northern_border" id="northern_border"
                        value="{{ $obj->northern_border }}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="southern_border" class="form-control-label">{{ trns('southern_border') }}</label>
                    <input type="number" class="form-control" name="southern_border" id="southern_border"
                        value="{{ $obj->southern_border }}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="eastern_border" class="form-control-label">{{ trns('eastern_border') }}</label>
                    <input type="number" class="form-control" name="eastern_border" id="eastern_border"
                        value="{{ $obj->eastern_border }}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="western_border" class="form-control-label">{{ trns('western_border') }}</label>
                    <input type="number" class="form-control" name="western_border" id="western_border"
                        value="{{ $obj->western_border }}">
                </div>
            </div>

            <div class="col-12">
                <div class="row form-group">


                    <div class="col-lg-4 col-12">
                        <h6 style="color:#00193a; font-weight: bold;">
                            {{ trns('status') }}<span class="text-danger">*</span>
                        </h6>
                        <div
                            style="background-color: #E9E9E9; border-radius: 6px; padding: 10px; margin-bottom: 20px; display:flex;">
                            <!-- Hidden input to ensure a value is always sent -->
                            <input type="hidden" name="status" value="0">

                            <div class="form-check form-switch">
                                <label class="form-check-label {{ lang() == 'ar' ? 'ms-2' : 'me-3' }}"
                                    for="statusToggle">{{ trns('activate') }}</label>
                                <input class="form-check-input ms-0" type="checkbox" id="statusToggle"
                                    name="status" value="1" @if ($obj->status == 1) checked @endif
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
                                class="form-control-label">{{ trns('stop_reason') }}</label>
                            <textarea class="form-control" name="stop_reason" id="interception_reason" rows="3">{{ $obj->stop_reason }}</textarea>
                        </div>
                    </div>


                   <hr style="opacity: 1 !important;">


            <div class="mt-4">
                <div class="row ">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="electric_name" class="form-control-label">{{ trns('meter_name') }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="electric_name">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="electric_account_number"
                                class="form-control-label">{{ trns('electric_account_number') }} <span
                                    class="text-danger">*</span></label>
                            <input type="number" min="1" class="form-control" id="electric_account_number">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="electric_subscription_number"
                                class="form-control-label">{{ trns('electric_subscription_number') }} <span
                                    class="text-danger">*</span></label>
                            <input type="number" min="1" class="form-control"
                                id="electric_subscription_number">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="electric_meter_number"
                                class="form-control-label">{{ trns('electric_meter_number') }} <span
                                    class="text-danger">*</span></label>
                            <input type="number" min="1" class="form-control" id="electric_meter_number">
                        </div>
                    </div>
                    <div class="col-md-2" style="align-content: center; margin-top: 8px;">
                        <button type="button" id="addElectricBtn" class="btn  btn-one w-100">
                            {{ trns('confirm') }}
                        </button>
                    </div>
                </div>

                <div id="electricCardsContainer" class="row g-3">
                    @foreach ($unitsElectrics as $electric)
                        <div class="col-md-4">
                            <div class="card" style="background-color: #f0f0f0; box-shadow: none;">
                                <div class="card-header d-flex justify-content-between"
                                    style="border-bottom: 1px solid #cecece; padding: 3px 10px;">
                                    <h5 class="mb-0">{{ $electric->electric_name }}</h5>
                                    <button type="button" class="btn text-danger fs-5 remove-card">x</button>
                                </div>
                                <div class="card-body" style="padding-top: 12px;">
                                    <input type="hidden" name="electric_account_number[]"
                                        value="{{ $electric->electric_account_number }}">
                                    <input type="hidden" name="electric_subscription_number[]"
                                        value="{{ $electric->electric_meter_number }}">
                                    <input type="hidden" name="electric_meter_number[]"
                                        value="{{ $electric->electric_subscription_number }}">
                                    <input type="hidden" name="electric_name[]"
                                        value="{{ $electric->electric_name }}">

                                    <div class="mb-2">
                                        <span class="fw-bold">{{ trns('electric_account_number') }}:</span>
                                        <span class="m-1">{{ $electric->electric_account_number }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="fw-bold">{{ trns('electric_subscription_number') }}:</span>
                                        <span class="m-1">{{ $electric->electric_subscription_number }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <span class="fw-bold">{{ trns('electric_meter_number') }}:</span>
                                        <span class="m-1">{{ $electric->electric_meter_number }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <span class="fw-bold">{{ trns('meter_name') }}:</span>
                                        <span class="m-1">{{ $electric->electric_name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr style="opacity: 1 !important;">
            </div>

            <div class="mt-4">

                <div class="row ">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="water_name" class="form-control-label">{{ trns('meter_name') }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="water_name[]" id="water_name">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="water_account_number"
                                class="form-control-label">{{ trns('water_account_number') }}
                                <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="water_account_number[]" id="water_account_number">
                        </div>
                    </div>



                    <div class="col-2">
                        <div class="form-group">
                            <label for="water_meter_number"
                                class="form-control-label">{{ trns('water_meter_number') }}
                                <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="water_meter_number[]" id="water_meter_number">
                        </div>
                    </div>


                    <div class="col-md-2" style="align-content: center; margin-top: 8px;">
                        <button type="button" id="addWaterBtn" class="btn  btn-one w-100">
                            {{ trns('confirm') }}
                        </button>
                    </div>
                </div>

                <div id="waterCardsContainer" class="row g-3">
                    @foreach ($unitsWaters as $water)
                        <div class="col-md-4">
                            <div class="card" style="background-color: #f0f0f0; box-shadow: none;">
                                <div class="card-header d-flex justify-content-between"
                                    style="border-bottom: 1px solid #cecece; padding: 3px 10px;">
                                    <h5 class="mb-0">{{ $water->water_name }}</h5>
                                    <button type="button" class="btn text-danger fs-5 remove-card">x</button>
                                </div>
                                <div class="card-body" style="padding-top: 12px;">
                                    <input type="hidden" name="water_account_number[]"
                                        value="{{ $water->water_account_number }}">
                                    <input type="hidden" name="water_meter_number[]"
                                        value="{{ $water->water_meter_number }}">
                                    <input type="hidden" name="water_name[]" value="{{ $water->water_name }}">


                                    <div class="mb-2">
                                        <span class="fw-bold">{{ trns('water_account_number') }}:</span>
                                        <span class="m-1">{{ $water->water_account_number }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="fw-bold">{{ trns('water_meter_number') }}:</span>
                                        <span class="m-1">{{ $water->water_meter_number }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <span class="fw-bold">{{ trns('meter_name') }}:</span>
                                        <span class="m-1">{{ $water->water_name }}</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr style="opacity: 1 !important;">
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
                                                $extension = strtolower(
                                                    pathinfo($media->file_name, PATHINFO_EXTENSION),
                                                );
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
                                {{ trns('You_can_upload_documents_in_the_following_formats') }}
                            </label>
                            <div class="file-upload-wrapper">
                                <input type="file" accept=".pdf,.doc,.xls,.xlsx,.docx,.ppt,.pptx,.txt,.zip,.rar"
                                    name="new_files[]" id="files-dropify" class="file-upload-input files-dropify"
                                    multiple>
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
        </div>
    </form>
</div>
<style>
    .file-upload-wrapper {
        position: relative;
        margin-bottom: 20px;
    }

    .file-upload-input {
        width: 100%;
        height: 150px;
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
        cursor: pointer;
        z-index: 2;
    }

    .file-upload-label {
        width: 100%;
        height: 150px;
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
        width: 180px;
        height: 180px;
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

<script>
    $(document).ready(function() {
        // Get the initial selected users from the server (passed via PHP)
        const initialSelectedUsers = @json($obj->unitOwners->pluck('user_id', 'user_id')->toArray());
        const initialPercentages = @json($obj->unitOwners->pluck('percentage', 'user_id')->toArray());

        // Set the initially selected users
        $('#user_ids').val(Object.keys(initialSelectedUsers)).trigger('change');

        // Function to update dynamic inputs
        function updateDynamicInputs() {
            const selectedOptions = $('#user_ids').find('option:selected');
            const dynamicInputsContainer = $('#dynamic-inputs');

            // Clear existing inputs
            dynamicInputsContainer.empty();

            // Add inputs in rows of two
            let rowDiv = null;
            selectedOptions.each(function(index) {
                const userId = $(this).val();
                const userName = $(this).text();

                if (userId) {
                    // Create a new row for every two inputs
                    if (index % 2 === 0) {
                        rowDiv = $('<div class="row"></div>');
                        dynamicInputsContainer.append(rowDiv);
                    }

                    // Get the existing percentage for this user (if any)
                    const existingPercentage = initialPercentages[userId] || 0;

                    // Append the input to the current row
                    rowDiv.append(`
                    <div class="col-6">
                        <div class="form-group">
                            <label for="input_${userId}" class="form-control-label">
                                {{ trns('percentage for') }} ${userName}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius: 0 5px 5px 0;">%</span>
                                <input type="number" class="form-control percentage-input"
                                       name="percentages[${userId}]"
                                       id="input_${userId}"
                                       max="100"
                                       min="0"
                                       style="border-radius: 5px 0 0 5px;"
                                       value="${existingPercentage}">
                            </div>
                        </div>
                    </div>
                `);
                }
            });
        }

        // Initialize the dynamic inputs on page load
        updateDynamicInputs();

        // Update dynamic inputs when selection changes
        $('#user_ids').on('change', updateDynamicInputs);

        // Real estate dropdown change handler
        $('#association_id').on('change', function() {
            const associationId = $(this).val();

            if (associationId) {
                $.ajax({
                    url: '{{ route('units.getRealState') }}',
                    type: 'GET',
                    data: {
                        id: associationId
                    },
                    success: function(response) {
                        $('#realstate_id').html(
                            '<option value="" selected disabled>{{ trns('select_realstate') }}</option>'
                        );
                        response.data.forEach(function(realState) {
                            $('#realstate_id').append(
                                `<option value="${realState.id}">${realState.name}</option>`
                            );
                        });
                        // Select the current realstate if exists
                        @if (isset($obj->realstate_id))
                            $('#realstate_id').val('{{ $obj->realstate_id }}').trigger(
                                'change');
                        @endif
                    },
                    error: function() {
                        alert(
                            '{{ trns('An error occurred while fetching real states.') }}'
                        );
                    }
                });
            } else {
                $('#realstate_id').html(
                    '<option value="" selected disabled>{{ trns('select_realstate') }}</option>');
            }
        });

        // Initialize real estate dropdown if association is already selected
        @if ($obj->association_id)
            $('#association_id').trigger('change');
        @endif
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
    $('.dropify').dropify();
    initializeSelect2WithSearchCustom('#user_ids');
    initializeSelect2('#association_id');
    initializeSelect2('#real_state_id');
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
<script>
    $(document).ready(function() {
        // Initialize Select2

        // Get the initial selected users and their percentages
        const initialSelectedUsers = @json($obj->unitOwners->pluck('user_id')->toArray());
        const initialPercentages = @json($obj->unitOwners->pluck('percentage', 'user_id')->toArray());

        // Function to update dynamic inputs
        function updateDynamicInputs() {
            const selectedOptions = $('#user_ids').find('option:selected');
            const dynamicInputsContainer = $('#dynamic-inputs');

            // Clear existing inputs
            dynamicInputsContainer.empty();

            // Add inputs in rows of two
            let rowDiv = null;
            selectedOptions.each(function(index) {
                const userId = $(this).val();
                const userName = $(this).text();

                if (userId) {
                    // Create a new row for every two inputs
                    if (index % 2 === 0) {
                        rowDiv = $('<div class="row"></div>');
                        dynamicInputsContainer.append(rowDiv);
                    }

                    // Get the existing percentage for this user (if any)
                    const existingPercentage = initialPercentages[userId] || '';

                    // Append the input to the current row
                    rowDiv.append(`
                    <div class="col-6">
                        <div class="form-group">
                            <label for="percentage_${userId}" class="form-control-label">
                                {{ trns('percentage for') }} ${userName}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius: 0 5px 5px 0;">%</span>
                                <input type="number" class="form-control percentage-input"
                                       name="percentages[${userId}]"
                                       id="percentage_${userId}"
                                       max="100"
                                       min="0"
                                       style="border-radius: 5px 0 0 5px;"
                                       value="${existingPercentage}"
                                       required>
                            </div>
                        </div>
                    </div>
                `);
                }
            });

            // Validate that percentages sum to 100% when form is submitted
            $('#updateForm').on('submit', function(e) {
                let total = 0;
                $('.percentage-input').each(function() {
                    total += parseFloat($(this).val()) || 0;
                });

                if (Math.round(total) !== 100) {
                    e.preventDefault();
                    alert('The sum of all ownership percentages must equal 100%');
                }
            });
        }

        // Initialize the dynamic inputs on page load
        updateDynamicInputs();

        // Update dynamic inputs when selection changes
        $('#user_ids').on('change', updateDynamicInputs);
    });
</script>


<script>
    let electricCounter = 0;

    document.getElementById('addElectricBtn').addEventListener('click', function(e) {
        e.preventDefault();

        // Get input values
        const accountNumber = document.getElementById('electric_account_number').value;
        const subscriptionNumber = document.getElementById('electric_subscription_number').value;
        const meterNumber = document.getElementById('electric_meter_number').value;
        const electricName = document.getElementById('electric_name').value;

        if (!accountNumber || !subscriptionNumber || !meterNumber || !electricName) {
            Swal.fire({
                icon: 'error',
                title: '{{ trns('error') }}',
                text: '{{ trns('please_fill_all_fields') }}'
            });
            return;
        }

        electricCounter++;

        const cardHtml = `
                    <div class="col-md-4">
                        <div class="card" style="background-color: #f0f0f0; box-shadow: none;">
                          <div class="card-header" style="      border-bottom: 1px solid #cecece;
                                                                padding-top: 3px; padding-bottom: 3px;
                                                                display: flex;
                                                                justify-content: space-between;">
                            <h5 class="d-flex align-items-center mb-0">
                                 ${electricName}
                            </h5>
                              <button type="button" class="btn text-danger fs-5 remove-card">
                                    x
                                </button>
                            </div>

                            <div class="card-body" style="padding-top: 12px;">
                                <input type="hidden" name="electric_account_number[]" value="${accountNumber}">
                                <input type="hidden" name="electric_subscription_number[]" value="${subscriptionNumber}">
                                <input type="hidden" name="electric_meter_number[]" value="${meterNumber}">
                                <input type="hidden" name="electric_name[]" value="${electricName}">

                                <!-- Displayed information -->
                                <div class="mb-2">
                                    <span class="fw-bold">{{ trns('electric_account_number') }}:</span>
                                    <span class="m-1">${accountNumber}</span>
                                </div>
                                <div class="mb-2">
                                    <span class="fw-bold">{{ trns('electric_subscription_number') }}:</span>
                                    <span class="m-1">${subscriptionNumber}</span>
                                </div>
                                <div class="mb-3">
                                    <span class="fw-bold">{{ trns('electric_meter_number') }}:</span>
                                    <span class="m-1">${meterNumber}</span>
                                </div>
                                <div class="mb-3">
                                    <span class="fw-bold">{{ trns('meter_name') }}:</span>
                                    <span class="m-1">${electricName}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                `;

        document.getElementById('electricCardsContainer').insertAdjacentHTML('beforeend', cardHtml);


        // Clear inputs
        document.getElementById('electric_account_number').value = '';
        document.getElementById('electric_subscription_number').value = '';
        document.getElementById('electric_meter_number').value = '';
        document.getElementById('electric_name').value = '';
    });

    document.getElementById('electricCardsContainer').addEventListener('click', function(e) {
        if (e.target.closest('.remove-card')) {
            const card = e.target.closest('.col-md-4');
            const row = card.parentElement;

            card.remove();

            if (row.children.length === 0) {
                row.remove();
            }
        }
    });
</script>




<script>
    let waterCounter = 0;

    document.getElementById('addWaterBtn').addEventListener('click', function(e) {
        e.preventDefault();

        const watterAccountNumber = document.getElementById('water_account_number').value;
        const waterMeterNumber = document.getElementById('water_meter_number').value;
        const waterName = document.getElementById('water_name').value;

        if (!watterAccountNumber || !waterMeterNumber || !waterName) {
            Swal.fire({
                icon: 'error',
                title: '{{ trns('error') }}',
                text: '{{ trns('please_fill_all_fields') }}'
            });
            return;
        }

        waterCounter++;

        const cardHtml = `
                    <div class="col-md-4">
                        <div class="card" style="background-color: #f0f0f0; box-shadow: none;">
                          <div class="card-header" style="      border-bottom: 1px solid #cecece;
                                                                padding-top: 3px; padding-bottom: 3px;
                                                                display: flex;
                                                                justify-content: space-between;">
                            <h5 class="d-flex align-items-center mb-0">
                                 ${waterName}
                            </h5>
                              <button type="button" class="btn text-danger fs-5 remove-card">
                                    x
                                </button>
                            </div>

                            <div class="card-body" style="padding-top: 12px;">
                                <input type="hidden" name="water_account_number[]" value="${watterAccountNumber}">
                                <input type="hidden" name="water_meter_number[]" value="${waterMeterNumber}">
                                <input type="hidden" name="water_name[]" value="${waterName}">
\
                                <div class="mb-2">
                                    <span class="fw-bold">{{ trns('water_account_number') }}:</span>
                                    <span class="m-1">${watterAccountNumber}</span>
                                </div>
                                <div class="mb-2">
                                    <span class="fw-bold">{{ trns('water_meter_number') }}:</span>
                                    <span class="m-1">${waterMeterNumber}</span>
                                </div>
                                <div class="mb-2">
                                    <span class="fw-bold">{{ trns('meter_name') }}:</span>
                                    <span class="m-1">${waterName}</span>
                                </div>

                            </div>

                        </div>
                    </div>
                `;

        document.getElementById('waterCardsContainer').insertAdjacentHTML('beforeend', cardHtml);
        // Clear inputs
        document.getElementById('water_account_number').value = '';
        document.getElementById('water_meter_number').value = '';
        document.getElementById('water_name').value = '';
    });

    document.getElementById('waterCardsContainer').addEventListener('click', function(e) {
        if (e.target.closest('.remove-card')) {
            const card = e.target.closest('.col-md-4');
            const row = card.parentElement;

            card.remove();

            if (row.children.length === 0) {
                row.remove();
            }
        }
    });
</script>
