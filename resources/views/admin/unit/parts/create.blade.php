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

    .select2-selection__choice.hidden-selection {
        display: none !important;
    }
</style>
<!-- <div class="modal-body"> -->
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{ $storeRoute }}">
        @csrf
        <div class="row">


            <!-- اختيار المستخدمين -->
            <div class="col-12">
                <div class="form-group">
                    <label for="user_ids" class="form-control-label">{{ trns('choose_owner_name') }}</label>
                    <select class="form-control select2-multiple" name="user_ids[]" id="user_ids" multiple="multiple">
                        @if ($users->count())
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name ?? '' }}</option>
                            @endforeach
                        @else
                            <option value="" disabled>{{ trns('no_owners_found') }}</option>
                        @endif
                    </select>
                </div>

                <div id="dynamic-inputs" class="mt-3"></div>

                <div id="percentage-error" class="text-danger mt-2" style="display: none;">
                    {{ trns('total_percentage_must_equal_100') }}
                </div>

                <div id="remaining-percentage" class="text-muted mt-1" style="display: none;"></div>
            </div>


            {{-- Association --}}
            <div class="col-4">
                <div class="form-group">
                    <label for="association_id" class="form-control-label">
                        {{ trns('association_name') }} <span class="text-danger">*</span>
                    </label>

                    @if ($association_id)
                        {{-- Show only the selected option and make it disabled --}}
                        <select class="form-control" disabled>
                            @foreach ($associations as $association)
                                @if ($association->id == $association_id)
                                    <option selected>{{ $association->name }}</option>
                                @endif
                            @endforeach
                        </select>

                        <input type="hidden" name="association_id" value="{{ $association_id }}">
                    @else
                        <select class="form-control" name="association_id" id="association_id">
                            <option value="" disabled selected>{{ trns('select_association') }}</option>
                            @foreach ($associations as $association)
                                <option value="{{ $association->id }}"
                                    @if (old('association_id') == $association->id) selected @endif>
                                    {{ $association->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif

                </div>
            </div>



            {{-- Real State (Dynamic from AJAX) --}}
            <div class="col-4">
                <div class="form-group">
                    <label for="real_state_id" class="form-control-label">{{ trns('real_state') }}
                        <span class="text-danger">*</span>
                    </label>
                    <select name="real_state_id" id="real_state_id" class="form-control">
                        <option value="" disabled selected>{{ trns('select_real_state') }}</option>
                    </select>

                </div>
            </div>



            <div class="col-4">
                <div class="form-group">
                    <label for="unit_number" class="form-control-label">{{ trns('unit_number_description') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" name="unit_number" id="unit_number">
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label for="description" class="form-control-label">{{ trns('description_unit') }}
                        <span class="text-danger">*</span>
                    </label>
                    <textarea type="text" rows="8" class="form-control" name="description" id="description"></textarea>
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="space" class="form-control-label">{{ trns('space') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control" name="space" id="space">
                </div>
            </div>



            {{-- Basic Fields --}}
            <div class="col-4">
                <div class="form-group">
                    <label for="unit_code" class="form-control-label">{{ trns('unit_code') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control" name="unit_code" id="unit_code">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="floor_count" class="form-control-label">{{ trns('floor_count') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control" name="floor_count" id="floor_count">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="bathrooms_count" class="form-control-label">{{ trns('bathrooms_count') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control" name="bathrooms_count" id="bathrooms_count">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="bedrooms_count" class="form-control-label">{{ trns('bedrooms_count') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control" name="bedrooms_count" id="bedrooms_count">
                </div>
            </div>

            {{-- Borders --}}
            <div class="col-4">
                <div class="form-group">
                    <label for="northern_border" class="form-control-label">{{ trns('northern_border') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control" name="northern_border" id="northern_border">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="southern_border" class="form-control-label">{{ trns('southern_border') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control" name="southern_border" id="southern_border">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="eastern_border" class="form-control-label">{{ trns('eastern_border') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control" name="eastern_border" id="eastern_border">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="western_border" class="form-control-label">{{ trns('western_border') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control" name="western_border" id="western_border">
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

            {{-- Stop Reason --}}
            <div class="col-12" id="interception_reason_container" style="display: none;">
                <div class="form-group">
                    <label for="stop_reason" class="form-control-label">{{ trns('clearify_stop_reason') }}</label>
                    <textarea class="form-control" name="stop_reason" id="stop_reason" rows="3"></textarea>
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
                        <input type="number" min="1" class="form-control" id="electric_subscription_number">
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

            <div id="electricCardsContainer" class="row g-3"></div>
        </div>

        <hr style="opacity: 1 !important; margin-top:50px ;">



        <div class="mt-4">


            <div class="row ">
                 <div class="col-md-4">
                    <div class="form-group">
                        <label for="water_name" class="form-control-label">{{ trns('meter_name') }} <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="water_name">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="water_account_number"
                            class="form-control-label">{{ trns('water_account_number') }}
                            <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="water_account_number"
                            id="water_account_number">
                    </div>
                </div>





                <div class="col-3">
                    <div class="form-group">
                        <label for="water_meter_number" class="form-control-label">{{ trns('water_meter_number') }}
                            <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="water_meter_number"
                            id="water_meter_number">
                    </div>
                </div>


                <div class="col-md-2" style="align-content: center; margin-top: 8px;">
                    <button type="button" id="addWaterBtn" class="btn  btn-one w-100">
                        {{ trns('confirm') }}
                    </button>
                </div>
            </div>

            <div id="waterCardsContainer" class="row g-3"></div>
        </div>

        <hr style="opacity: 1 !important; margin-top:50px ;">


            <div class="col-12">
                <div class="form-group">
                    <label for="images" class="form-control-label"
                        style="display: block; color: #00F3CA !important;">{{ trns('unit_images') }}</label>
                    <label for="images" class="form-control-label"
                        style="display: block; color: gray !important; font-weight: normal !important;">{{ trns('You can upload documents in the following formats excel - pdf - word - txt') }}</label>
                    <div class="file-upload-wrapper" style="position: relative;">
                        <input type="file" accept="image/*" name="images[]" id="multi-dropify"
                            class="file-upload-input files-dropify" multiple>
                        <label for="multi-dropify" class="file-upload-label">
                            <span
                                class="file-upload-text d-flex flex-column justify-content-center align-items-center">
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
                    <label for="address"
                        style="display: block; color: gray !important; font-weight: normal !important;"
                        class="form-control-label">{{ trns('You_can_upload_documents_in_the_following_formats') }}(excel
                        - pdf - word - txt)</label>
                    <div class="file-upload-wrapper" style="position: relative;">
                        <input type="file" accept=".pdf, .doc, .xls, .xlsx, .docx" name="files[]"
                            class="file-upload-input files-dropify" multiple>
                        <label for="files-dropify" class="file-upload-label">
                            <span
                                class="file-upload-text d-flex flex-column justify-content-center align-items-center">
                                <i class="fa-solid fa-cloud-arrow-up mb-3"></i>
                                قم بسحب وإسقاط الملفات الخاصة بك هنا
                            </span>
                        </label>
                        <div class="file-previews" style="position: absolute;top: 0;right: 10px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<!-- </div> -->

<script>
    function toggleInterceptionReason() {
        const statusToggle = document.getElementById('statusToggle');
        const interceptionContainer = document.getElementById('interception_reason_container');
        interceptionContainer.style.display = statusToggle.checked ? 'none' : 'block';
    }
    document.addEventListener('DOMContentLoaded', function() {
        toggleInterceptionReason();
    });
    initializeSelect2WithSearchCustom('#user_ids');
    initializeSelect2('#association_id');
    initializeSelect2('#real_state_id');
</script>
<script>
    $(document).ready(function() {
        function updateDynamicInputs() {
            const selectedOptions = $('#user_ids').find('option:selected');
            const dynamicInputsContainer = $('#dynamic-inputs');

            let existingValues = {};
            $('.percentage-input').each(function() {
                const inputId = $(this).attr('id');
                const userId = inputId.split('_')[1];
                existingValues[userId] = $(this).val();
            });

            dynamicInputsContainer.empty();

            let rowDiv = null;
            selectedOptions.each(function(index) {
                const userId = $(this).val();
                const userName = $(this).text();
                const value = existingValues[userId] || '';

                if (userId) {
                    if (index % 2 === 0) {
                        rowDiv = $('<div class="row"></div>');
                        dynamicInputsContainer.append(rowDiv);
                    }

                    rowDiv.append(`
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="percentage_${userId}" class="form-control-label">
                                    {{ trns('percentage_for') }} ${userName}
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text" style="border-radius: 0 5px 5px 0;">%</span>
                                    <input type="number" class="form-control percentage-input"
                                           name="percentages[${userId}]"
                                           id="percentage_${userId}"
                                           style="border-radius: 5px 0 0 5px;"
                                           max="100" min="0"
                                           value="${value}" required>
                                </div>
                            </div>
                        </div>
                    `);
                }
            });

            attachPercentageInputListeners();
            updateRemainingPercentage();
        }

        function updateRemainingPercentage() {
            let total = 0;
            $('.percentage-input').each(function() {
                total += parseFloat($(this).val()) || 0;
            });

            let remaining = 100 - total;
            const display = $('#remaining-percentage');
            display.text(`{{ trns('remaining_percentage') }}: ${remaining}%`);

            if ($('.percentage-input').length) {
                display.show();
            } else {
                display.hide();
            }

            // إظهار أو إخفاء رسالة الخطأ
            if (Math.round(total) === 100) {
                $('#percentage-error').hide();
            }
        }

        function attachPercentageInputListeners() {
            $('.percentage-input').on('input', function() {
                let total = 0;
                const currentInput = $(this);

                $('.percentage-input').not(currentInput).each(function() {
                    total += parseFloat($(this).val()) || 0;
                });

                const remaining = 100 - total;
                let currentValue = parseFloat(currentInput.val()) || 0;

                if (currentValue > remaining) {
                    currentInput.val(remaining);
                    currentValue = remaining;
                }

                updateRemainingPercentage();
            });
        }


        $('#addForm').on('submit', function(e) {
            let total = 0;
            $('.percentage-input').each(function() {
                total += parseFloat($(this).val()) || 0;
            });

            if (Math.round(total) !== 100) {
                e.preventDefault();
                $('#percentage-error').show();
                return false;
            } else {
                $('#percentage-error').hide();
            }
        });

        // أول مرة عند تحميل الصفحة
        updateDynamicInputs();

        // عند تغيير المستخدمين
        $('#user_ids').on('change', updateDynamicInputs);
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
        function loadRealStates(associationId, selectedRealStateId = null) {
            if (associationId) {
                $.ajax({
                    url: '{{ route('real_states.byAssociation') }}',
                    method: 'GET',
                    data: {
                        id: associationId
                    },
                    success: function(response) {
                        let realStateSelect = $('#real_state_id');
                        realStateSelect.empty();

                        let currentLocale = '{{ app()->getLocale() }}';

                        if (response.length > 0) {

                            if (selectedRealStateId) {
                                // فقط عرض العقار المحدد
                                let selectedRealState = response.find(item => item.id ==
                                    selectedRealStateId);
                                if (selectedRealState) {
                                    let name = selectedRealState.name[currentLocale] ||
                                        selectedRealState.name['en'] || 'N/A';
                                    realStateSelect.append(
                                        `<option value="${selectedRealState.id}" selected>${name}</option>`
                                        );
                                }

                                // جعل الـ select مقفول (disabled)
                                realStateSelect.prop('disabled', true);

                                // إضافة hidden input علشان القيمة تتبعت
                                if ($('#real_state_id_hidden').length === 0) {
                                    $('<input>').attr({
                                        type: 'hidden',
                                        id: 'real_state_id_hidden',
                                        name: 'real_state_id',
                                        value: selectedRealStateId
                                    }).insertAfter(realStateSelect);
                                }

                            } else {
                                // عرض جميع الخيارات
                                realStateSelect.append(
                                    '<option value="" disabled selected>{{ trns('select_real_state') }}</option>'
                                );

                                response.forEach(realState => {
                                    let name = realState.name[currentLocale] || realState
                                        .name['en'] || 'N/A';
                                    realStateSelect.append(
                                        `<option value="${realState.id}">${name}</option>`
                                    );
                                });
                            }
                        } else {
                            realStateSelect.append(
                                '<option value="" disabled selected>{{ trns('no_real_states_found') }}</option>'
                            );
                        }
                    },
                    error: function() {
                        alert("{{ trns('error_happened') }}");
                    }
                });
            }
        }

        $('#association_id').on('change', function() {
            let associationId = $(this).val();
            // clear hidden input if any
            $('#real_state_id_hidden').remove();
            $('#real_state_id').prop('disabled', false);
            loadRealStates(associationId);
        });

        let initialAssociationId = '{{ $association_id ?? '' }}';
        let initialRealStateId = '{{ $real_state_id ?? '' }}';

        if (initialAssociationId) {
            $('#association_id').val(initialAssociationId).trigger('change');
            loadRealStates(initialAssociationId, initialRealStateId);
        }
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

            const container = document.getElementById('electricCardsContainer');
            const existingCards = container.querySelectorAll('.col-md-4');

            if (existingCards.length % 3 === 0) {
                const newRow = document.createElement('div');
                newRow.className = 'row g-3 mb-3';
                newRow.innerHTML = cardHtml;
                container.appendChild(newRow);
            } else {
                const lastRow = container.lastElementChild;
                if (lastRow) {
                    lastRow.innerHTML += cardHtml;
                } else {
                    const newRow = document.createElement('div');
                    newRow.className = 'row g-3 mb-3';
                    newRow.innerHTML = cardHtml;
                    container.appendChild(newRow);
                }
            }

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

            // Get input values
            const watterAccountNumber = document.getElementById('water_account_number').value;
            const waterMeterNumber = document.getElementById('water_meter_number').value;
            const waterName = document.getElementById('water_name').value;

            if (!watterAccountNumber || !waterMeterNumber|| !waterName) {
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

            const container = document.getElementById('waterCardsContainer');
            const existingCards = container.querySelectorAll('.col-md-4');

            if (existingCards.length % 3 === 0) {
                const newRow = document.createElement('div');
                newRow.className = 'row g-3 mb-3';
                newRow.innerHTML = cardHtml;
                container.appendChild(newRow);
            } else {
                const lastRow = container.lastElementChild;
                if (lastRow) {
                    lastRow.innerHTML += cardHtml;
                } else {
                    const newRow = document.createElement('div');
                    newRow.className = 'row g-3 mb-3';
                    newRow.innerHTML = cardHtml;
                    container.appendChild(newRow);
                }
            }

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
