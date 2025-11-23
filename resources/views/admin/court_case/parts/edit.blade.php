<div class="modal-body">
    <form id="updateForm" class="updateForm CourtCaseUpdateForm" method="POST" enctype="multipart/form-data"
        action="{{ $updateRoute }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $obj->id }}" name="id">

        <div class="row">

            {{-- ================= المعلومات الأساسية ================= --}}
            <div class="d-flex" style="flex-direction: column; padding-right: 15px; margin-bottom:20px">
                <h5 class="fw-bold" style="color: #00F3CA;">{{ trns('main_information') }}</h5>
                <p class="association-sub-para">
                    {{ trns('you_can_start_with_editing_court_case_and_control_main_information_from_here') }}</p>
            </div>

            {{-- Judiciaty Type --}}
            <div class="col-md-4">
                <div class="form-group">
                    <label for="judiciaty_type_id">{{ trns('judiciaty_type') }} <span
                            class="text-danger">*</span></label>
                    <select class="form-control select2" id="judiciaty_type_id" name="judiciaty_type_id" required>
                        <option value="" selected>{{ trns('select_judiciaty_type') }}</option>
                        @foreach ($judiciatyType as $judiciaty_type)
                            <option value="{{ $judiciaty_type->id }}"
                                {{ $obj->judiciaty_type_id == $judiciaty_type->id ? 'selected' : '' }}>
                                {{ $judiciaty_type->getTranslation('title', app()->getLocale()) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Case Type --}}
            <div class="col-md-4">
                <div class="form-group">
                    <label for="case_type_id">{{ trns('case_type') }} <span class="text-danger">*</span></label>
                    <select class="form-control select2" id="case_type_id" name="case_type_id" required>
                        <option value="" selected>{{ trns('select_case_type') }}</option>
                        @foreach ($case_types as $case_type)
                            <option value="{{ $case_type->id }}"
                                {{ $obj->case_type_id == $case_type->id ? 'selected' : '' }}>
                                {{ $case_type->getTranslation('title', app()->getLocale()) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Case Number --}}
            <div class="col-4">
                <div class="form-group">
                    <label for="case_number" class="form-control-label">{{ trns('case_number') }}<span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="{{ trns('enter_the_case_number') }}"
                        name="case_number" id="case_number" value="{{ $obj->case_number }}">
                </div>
            </div>

            {{-- Association --}}
            <div class="col-md-4">
                <div class="form-group">
                    <label for="association_id">{{ trns('association') }} <span class="text-danger">*</span></label>
                    <select class="form-control select2" id="association_id" name="association_id" required>
                        <option value="">{{ trns('select_association') }}</option>
                        @foreach ($associations as $association)
                            <option value="{{ $association->id }}"
                                {{ $obj->association_id == $association->id ? 'selected' : '' }}>
                                {{ $association->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Owner --}}
            <div class="col-md-4">
                <div class="form-group">
                    <label for="owner_id">{{ trns('owners') }} <span class="text-danger">*</span></label>
                    <select class="form-control select2" id="owner_id" name="owner_id" required>
                        <option value="">{{ trns('select_owner') }}</option>
                        @if ($obj->owner)
                            <option value="{{ $obj->owner->id }}" selected>{{ $obj->owner->name }}</option>
                        @endif
                    </select>
                </div>
            </div>

            {{-- Units --}}
            <div class="col-md-4">
                <div class="form-group">
                    <label for="unit_id">{{ trns('unit') }} <span class="text-danger">*</span></label>
                    <select class="form-control select2" id="unit_id" name="unit_id" required>
                        <option value="">{{ trns('select_unit_number') }}</option>
                        @if ($obj->unit)
                            <option value="{{ $obj->unit->id }}" selected>{{ $obj->unit->unit_number }}</option>
                        @endif
                    </select>
                </div>
            </div>

            {{-- Case Date --}}
            <div class="col-md-4">
                <div class="form-group">
                    <label for="case_date">{{ trns('case_date') }} <span class="text-danger">*</span></label>
                    <input class="form-control" type="date" onclick="this.showPicker()" name="case_date"
                        value="{{ $obj->case_date }}">
                </div>
            </div>

            {{-- Case Price --}}
            <div class="col-md-4">
                <div class="form-group">
                    <label for="case_price">{{ trns('case_price') }} <span class="text-danger">*</span></label>
                    <input class="form-control" type="integer" name="case_price"
                        placeholder="{{ trns('enter_the_price') }}" value="{{ $obj->case_price }}">
                </div>
            </div>

            {{-- Judiciaty Date --}}
            <div class="col-md-4">
                <div class="form-group">
                    <label for="judiciaty_date">{{ trns('judiciaty_date') }} <span class="text-danger">*</span></label>
                    <input class="form-control" type="date" onclick="this.showPicker()" name="judiciaty_date"
                        value="{{ $obj->judiciaty_date }}">
                </div>
            </div>

            {{-- Case Topic --}}
            <div class="col-md-12">
                <div class="form-group">
                    <label for="topic">{{ trns('topic') }} <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="topic"
                        placeholder="{{ trns('enter_the_topic') }}" value="{{ $obj->topic }}">
                </div>
            </div>

            {{-- Description --}}
            <div class="col-md-12">
                <div class="form-group">
                    <label for="case_description">{{ trns('case_description') }} <span
                            class="text-danger">*</span></label>
                    <textarea class="form-control" name="description" placeholder="{{ trns('write_the_case_description') }}">{{ $obj->description }}</textarea>
                </div>
            </div>

            {{-- Files --}}
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
    </form>
</div>

<!-- Dropify -->
<script>
    $('.dropify').dropify();
</script>

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
    $(document).ready(function() {
        $('.select2').select2();

        // Load owners by association
        $('#association_id').on('change', function() {
            let associationId = $(this).val();

            $('#owner_id').html('<option value="">{{ trns('select_owner') }}</option>').trigger(
                'change');
            $('#unit_id').html('<option value="">{{ trns('select_unit') }}</option>').trigger(
            'change');

            if (!associationId) return;

            $.ajax({
                url: "{{ route('association.getUsers', ':id') }}".replace(':id',
                    associationId),
                type: 'GET',
                success: function(response) {
                    let options = `<option value="">{{ trns('select_owner') }}</option>`;
                    if (response.status === 200 && response.user && response.user.length >
                        0) {
                        response.user.forEach(function(owner) {
                            options +=
                                `<option value="${owner.id}" ${owner.id == "{{ $obj->owner_id }}" ? 'selected' : ''}>${owner.name || owner.email || owner.id}</option>`;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: "{{ trns('error') }}",
                            text: "{{ trns('no_owner_found') }}"
                        });
                    }
                    $('#owner_id').html(options).trigger('change');
                },
                error: function() {
                    $('#owner_id').html(
                            '<option value="">{{ trns('select_owner') }}</option>')
                        .trigger('change');
                    Swal.fire({
                        icon: 'error',
                        title: "{{ trns('error') }}",
                        text: "{{ trns('failed_to_load_owner') }}"
                    });
                }
            });
        });

        // Load units by owner
        $('#owner_id').on('change', function() {
            let ownerId = $(this).val();
            $('#unit_id').html('<option value="">{{ trns('select_unit') }}</option>').trigger(
            'change');
            if (!ownerId) return;

            $.ajax({
                url: "{{ route('users.getUnits', ':id') }}".replace(':id', ownerId),
                type: 'GET',
                success: function(response) {
                    if (response.status === 200 && response.units) {
                        let options =
                        '<option value="">{{ trns('select_unit') }}</option>';
                        response.units.forEach(function(unit) {
                            options +=
                                `<option value="${unit.id}" ${unit.id == "{{ $obj->unit_id }}" ? 'selected' : ''}>${unit.unit_number}</option>`;
                        });
                        $('#unit_id').html(options).trigger('change');
                    }
                },
                error: function() {
                    $('#unit_id').html(
                        '<option value="">{{ trns('select_unit') }}</option>').trigger(
                        'change');
                    Swal.fire({
                        icon: 'error',
                        title: "{{ trns('error') }}",
                        text: "{{ trns('failed_to_load_units') }}"
                    });
                }
            });
        });
    });
</script>

<script>
    // File preview script
    function getFileExtension(filename) {
        return filename.split('.').pop().toLowerCase();
    }

    function getIconPath(extension) {
        const iconMap = {
            'xlsx': '{{ asset('svgs/excel.svg') }}',
            'xls': '{{ asset('svgs/excel.svg') }}',
            'docx': '{{ asset('svgs/word.svg') }}',
            'doc': '{{ asset('svgs/word.svg') }}',
            'pdf': '{{ asset('svgs/pdf.svg') }}',
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
                        previewItem.innerHTML = `
                            <img src="${e.target.result}" alt="${file.name}" style="max-width: 100px; max-height: 100px;">
                            <div class="file-info">
                                <div class="file-name">${file.name}</div>
                                <div class="file-size">${(file.size / 1024).toFixed(2)} KB</div>
                            </div>
                            <button class="remove-btn" data-index="${i}">×</button>
                        `;
                    } else {
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
