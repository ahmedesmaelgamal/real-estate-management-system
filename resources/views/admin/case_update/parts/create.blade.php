    <form id="addForm" class="addForm addCaseUpdateTypeForm" method="POST" enctype="multipart/form-data"
        action="{{ $storeRoute }}">
        @csrf
        <div class="row">

            {{-- ================= المعلومات الأساسية ================= --}}
            <div class="d-flex" style="flex-direction: column; padding-right: 15px; margin-bottom:20px">
                <h5 class="fw-bold" style="color: #00F3CA;">{{ trns('main_information') }}</h5>
                <p class="association-sub-para">
                    {{ trns('you_can_start_with_createing_new_court_case_and_control_main_information_from_here') }}</p>
            </div>
            <input type="hidden" name="court_cases_id" id="case_id" />

            <div class="col-6">
                <div class="form-group">
                    <label for="title_ar" class="form-control-label">{{ trns('title_ar') }}<span
                            class="text-danger">*</span></label>
                    <input placeholder="{{trns("enter_update_topic")}}" type="text" class="form-control" name="title[ar]" id="title[ar]">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="title_en" class="form-control-label">{{ trns('title_en') }}
                    </label>
                    <input placeholder="{{trns("enter_update_topic")}}"  type="text" class="form-control" name="title[en]" id="title[en]">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="case_update_type_id">{{ trns('case_update_Type') }} <span
                            class="text-danger">*</span></label>
                    <select class="form-control select2" id="case_update_type_id" name="case_update_type_id" required>
                        <option value="" selected>{{ trns('select_caseUpdateType') }}</option>
                        @foreach ($caseUpdateTypes as $caseType)
                            <option value="{{ $caseType->id }}">
                                {{ $caseType->getTranslation('title', app()->getLocale()) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="end_date">{{ trns('end_date') }} <span class="text-danger">*</span></label>
                    <input class="form-control" onclick="this.showPicker()" type="date" name="end_date" />
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="description">{{ trns('description') }} <span class="text-danger">*</span></label>
                    <textarea class="form-control" type="date" name="description" placeholder="{{ trns('update_description') }}"></textarea>
                </div>
            </div>


            {{-- files --}}
            <div class="col-12">
                <div class="form-group">
                    <label for="files" class="form-control-label"
                        style="display: block; color: #00F3CA !important;">{{ trns('files') }}</label>
                    <label for="address"
                        style="display: block; color: gray !important; font-weight: normal !important;"
                        class="form-control-label">{{ trns('you can control files from here') }}</label>
                    <div class="file-upload-wrapper">
                        <input type="file" accept=".pdf, .doc, .xls, .xlsx, .docx , image/*" name="files[]"
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
    </form>



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




<!-- Dropify script -->
<script>
    $('.dropify').dropify();
</script>



<script>
    $('.dropify').dropify();
</script>

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
