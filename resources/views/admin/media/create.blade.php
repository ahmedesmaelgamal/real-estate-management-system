<form id="mediaCreate" class="mediaCreate" method="POST" enctype="multipart/form-data"
      action="{{ route('media.store') }}">
    @csrf
    <div class="row">
        <input type="hidden" name="type" value="{{ $type }}">
        <input type="hidden" name="model_id" value="{{ $model_id }}">
        <input type="hidden" name="model" value="{{ $model }}">
        @if($type == 'image')
            <div class="col-12">
                <div class="form-group">
                    <label for="images" class="form-control-label"
                           style="display: block; color: #00F3CA !important;">{{ trns('images') }}</label>

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
        @elseif($type == 'file')
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
        @endif
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

    // File preview functionality
    document.querySelectorAll('.files-dropify').forEach(input => {
        input.addEventListener('change', function (e) {
            const previewContainer = this.closest('.file-upload-wrapper').querySelector('.file-previews');
            previewContainer.innerHTML = '';

            for (let i = 0; i < this.files.length; i++) {
                const file = this.files[i];
                const reader = new FileReader();

                reader.onload = function (e) {
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

                    previewItem.querySelector('.remove-btn').addEventListener('click', function () {
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

    // Drag and drop functionality
    document.querySelectorAll('.file-upload-wrapper').forEach(wrapper => {
        const fileInput = wrapper.querySelector('.file-upload-input');
        const label = wrapper.querySelector('.file-upload-label');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            wrapper.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            wrapper.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            wrapper.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            label.style.borderColor = '#007bff';
            label.style.backgroundColor = '#e7f3ff';
        }

        function unhighlight(e) {
            label.style.borderColor = '#ccc';
            label.style.backgroundColor = '#f8f9fa';
        }

        wrapper.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            fileInput.files = files;
            fileInput.dispatchEvent(new Event('change'));
        }
    });

</script>

