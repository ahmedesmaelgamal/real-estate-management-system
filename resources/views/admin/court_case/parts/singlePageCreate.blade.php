@extends('admin/layouts/master')

@section('title')
    {{ config()->get('app.name') }} | {{ trns('create_case') }}
@endsection

@section('page_name')
    {{ trns('create_new_case') }}
@endsection

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <div>
        <form id="addForm" class="addForm caseAddForm" method="POST" enctype="multipart/form-data"
            action="{{ $storeRoute }}">
            @csrf
            <div class="row">



                {{-- ================= المعلومات الأساسية ================= --}}
                <div class="d-flex" style="flex-direction: column; padding-right: 15px; margin-bottom:20px">
                    <h5 class="fw-bold" style="color: #00F3CA;">{{ trns('main_information') }}</h5>
                    <p class="association-sub-para">
                        {{ trns('you_can_start_with_createing_new_court_case_and_control_main_information_from_here') }}</p>
                </div>



                <div class="col-md-4">
                    <div class="form-group">
                        <label for="judiciaty_type_id">{{ trns('judiciaty_type') }} <span
                                class="text-danger">*</span></label>
                        <select class="form-control select2" id="judiciaty_type_id" name="judiciaty_type_id" required>
                            <option value="" selected>{{ trns('select_judiciaty_type') }}</option>
                            @foreach ($judiciatyType as $judiciaty_type)
                                <option value="{{ $judiciaty_type->id }}">
                                    {{ $judiciaty_type->getTranslation('title', app()->getLocale()) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="case_type_id">{{ trns('case_type') }} <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="case_type_id" name="case_type_id" required>
                            <option value="" selected>{{ trns('select_case_type') }}</option>
                            @foreach ($case_types as $case_type)
                                <option value="{{ $case_type->id }}">
                                    {{ $case_type->getTranslation('title', app()->getLocale()) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>




                <div class="col-4">
                    <div class="form-group">
                        <label for="case_number" class="form-control-label">{{ trns('case_number') }}<span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="{{ trns('enter_the_case_number') }}"
                            name="case_number" id="case_number">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="association_id">{{ trns('association') }} <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="association_id" name="association_id" required>
                            <option value="" selected>{{ trns('select_association') }}</option>
                            @foreach ($associations as $association)
                                <option value="{{ $association->id }}">{{ $association->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{--  / Owner --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="owner_id">{{ trns('owners') }} <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="owner_id" name="owner_id" required>
                            <option value="" selected>{{ trns('select_owner') }}</option>
                        </select>
                    </div>
                </div>

                {{-- Units --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="unit_id">{{ trns('unit') }} <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="unit_id" name="unit_id" required>
                            <option value="" selected>{{ trns('select_unit_number') }}</option>
                        </select>
                    </div>
                </div>


                {{-- case date --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="case_date">{{ trns('case_date') }} <span class="text-danger">*</span></label>
                        <input class="form-control" onclick="this.showPicker()" type="date" name="case_date" />
                    </div>
                </div>

                {{-- case price --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="case_price">{{ trns('case_price') }} <span class="text-danger">*</span></label>
                        <input class="form-control" placeholder="{{ trns('enter_the_price') }}" type="integer"
                            name="case_price" />
                    </div>
                </div>

                {{-- judiciate date --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="judiciaty_date">{{ trns('judiciaty_date') }} <span class="text-danger">*</span></label>
                        <input class="form-control" type="date" onclick="this.showPicker()" name="judiciaty_date" />
                    </div>
                </div>

                {{-- case topic --}}
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="topic">{{ trns('topic') }} <span class="text-danger">*</span></label>
                        <input class="form-control" placeholder="{{ trns('enter_the_topic') }}" type="text"
                            name="topic" />
                    </div>
                </div>

                {{-- description --}}
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">{{ trns('case_description') }} <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control" type="date" name="description"
                            placeholder="{{ trns('write_the_case_description') }}"></textarea>
                    </div>
                </div>

                <input name="singlePage" type="hidden" value="1" />

                {{-- files --}}
                <div class="col-12">
                    <div class="form-group">
                        <label for="files" class="form-control-label"
                            style="display: block; color: #00F3CA !important;">{{ trns('files') }}</label>
                        <label for="address"
                            style="display: block; color: gray !important; font-weight: normal !important;"
                            class="form-control-label">{{ trns('you can control documents from here') }}</label>
                        <div class="file-upload-wrapper">
                            <input type="file" accept=".pdf, .doc, .xls, .xlsx, .docx , image/*" name="files[]"
                                class="file-upload-input files-dropify" multiple>
                            <label for="files-dropify" class="file-upload-label">
                                <span
                                    class="file-upload-text d-flex flex-column justify-content-center align-items-center">
                                    <i class="fa-solid fa-cloud-arrow-up mb-3"></i>
                                    {{ trns('drag_the_file_and_but_it_here') }}
                                </span>
                            </label>
                            <div class="file-previews"
                                style="position: absolute;
                                top: 0;
                                right: 10px;">
                            </div>
                        </div>
                    </div>
                </div>




                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" name="submit_type" value="create_and_stay" class="btn m-2"
                        style="padding: 5px 50px; font-size: 16px; font-weight: bold; background-color: #DFE3E7; color: #676767; width: 50%;">{{ trns('create_and_add_another') }}</button>
                    <button type="submit" name="submit_type" value="create_and_redirect" class="btn m-2"
                        style="background-color: #00193a; color: #00F3CA; border: none;padding: 5px 50px; margin-left: 10px; font-size: 16px; font-weight: bold; width: 50%;">{{ trns('create') }}</button>
                </div>


            </div>
        </form>
    </div>
@endsection

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>





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





@section('js')
    <!-- Dropify script -->
    <script>
        $('.dropify').dropify();
    </script>


    {{-- scripts agenda  --}}
    {{-- 
    1 - getting data ( get users , get units)

 --}}
    {{-- scripts agenda  --}}

    <script>
        $(document).ready(function() {
            $('.select2').select2();

            // جلب Owner حسب Association
            $('#association_id').on('change', function() {
                let associationId = $(this).val();

                // إعادة تعيين الـ selects
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
                            response.user.forEach(function(
                                owner) { // استخدم response.user بدل users
                                options +=
                                    `<option value="${owner.id}">${owner.name || owner.email || owner.id}</option>`;
                            });
                        } else {
                            // Swal.fire({
                            //     icon: 'error',
                            //     title: "{{ trns('error') }}",
                            //     text: "{{ trns('no_owner_found') }}"
                            // });
                        }

                        $('#owner_id').html(options).trigger('change');
                    },
                    error: function() {
                        $('#owner_id').html(
                                '<option value="">{{ trns('select_owner') }}</option>')
                            .trigger('change');
                        // Swal.fire({
                        //     icon: 'error',
                        //     title: "{{ trns('error') }}",
                        //     text: "{{ trns('failed_to_load_owner') }}"
                        // });
                    }
                });
            });

            // جلب Units حسب Owner
            $('#owner_id').on('change', function() {
                let ownerId = $(this).val();

                // إعادة تعيين الـ select
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
                                    `<option value="${unit.id}">${unit.unit_number}</option>`;
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
            input.replaceWith(input.cloneNode(true));
        });

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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const form = document.getElementById('addForm');
            const submitButtons = form.querySelectorAll('button[type="submit"]');

            // منع تسجيل listener مرتين
            if (!form.dataset.listenerAdded) {
                form.dataset.listenerAdded = true; // علم إن Listener اتضاف

                let isSubmitting = false;

                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    if (isSubmitting) return; // لو فيه طلب شغال، امنع الثاني
                    isSubmitting = true;

                    // تعطيل الأزرار لتجنب الضغط المزدوج
                    submitButtons.forEach(btn => btn.disabled = true);

                    let formData = new FormData(form);
                    const singlePage = formData.get('singlePage') || 0;
                    formData.set('singlePage', singlePage);

                    fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                            },
                            body: formData
                        })
                        .then(async response => {
                            let data;
                            try {
                                data = await response.json();
                            } catch (err) {
                                throw new Error('Invalid response from server');
                            }

                            if (data.status === 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'نجاح',
                                    text: data.message,
                                    confirmButtonText: 'حسناً',
                                    timer: 1500, // 1.5 ثانية
                                    timerProgressBar: true,
                                    willClose: () => {
                                        if (singlePage == 1) {
                                            window.location.href =
                                                "{{ route('court_case.index') }}";
                                        } else {
                                            form.reset();
                                        }
                                    }
                                }).then(() => {
                                    if (result.isConfirmed) {
                                        if (singlePage == 1) {
                                            window.location.href =
                                                "{{ route('court_case.index') }}";
                                        } else {
                                            form.reset();
                                        }
                                    }
                                });
                                setTimeout(() => {
                                    window.location.href =
                                        "{{ route('court_case.index') }}";
                                }, 1000);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'خطأ',
                                    text: data.message || 'حدث خطأ ما',
                                    confirmButtonText: 'حسناً'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'خطأ غير متوقع',
                                text: error.message || 'حدث خطأ غير متوقع. حاول مرة أخرى.',
                                confirmButtonText: 'حسناً'
                            });
                        })
                        .finally(() => {
                            isSubmitting = false;
                            submitButtons.forEach(btn => btn.disabled = false);
                        });

                });
            }

        });
    </script>
@endsection
