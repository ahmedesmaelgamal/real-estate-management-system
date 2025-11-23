@extends('admin/layouts/master')

@section('title')
    {{ config()->get('app.name') }} | {{ trns('add_real_state_account') }}
@endsection
@section('page_name')
    {{ trns('add_real_state_account') }}
@endsection
@section('content')
    <style>
        .select2-selection__choice.hidden-selection {
            display: none !important;
        }
    </style>
    <style>
        .card {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .card-header {
            font-weight: 600;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .btn-outline-danger:hover {
            color: white;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-control-label {
            display: inline-block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus {
            color: #495057;
            background-color: #fff;
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style>
    <div class="">
        <!-- Create Or Edit Modal -->
        <div class="modal fade" id="editOrCreate" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">{{ trns('association_details') }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-body">

                    </div>
                    <div class="modal-footer" id="modal-footer">

                    </div>
                </div>
            </div>
        </div>
        <!-- Create Or Edit Modal -->

        <h2 class="fw-bold" style="color: #00193a;">{{ trns('add_real_state_account') }}</h2>
        <style>
            #map {
                height: 600px;
                width: 100%;
            }
        </style>
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <!-- <div class="">
                                                                                    <a href="{{ route('real_states.index') }}" style="transform: rotate(180deg); border: 1px solid gray;"
                                                                                       class="btn">
                                                                                        <i class="fas fa-long-arrow-alt-right"></i>
                                                                                    </a>
                                                                                </div> -->

        <form method="POST" id="addForm" enctype="multipart/form-data" action="{{ $storeRoute }}">
            @csrf
            <div class="row">

                <input name="submit_type" id="submit_type" type="hidden">
                <input type="hidden" name="singlePageCreate" value="1">


                <div class="col-12">
                    <div class="form-group">
                        <label for="logo" class="form-control-label">{{ trns('real_state_primary_image') }}</label>

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
                        <label for="association_id" class="form-control-label">{{ trns('association_name') }}</label>
                        <select class="form-control" name="association_id" id="association_id">

                            @foreach ($associations as $association)
                                <option value="{{ $association->id }}">{{ $association->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label for="legal_ownership_id" class="form-control-label">{{ trns('legal_ownership') }}</label>
                        <select class="form-control" name="legal_ownership_id" id="legal_ownership_id">
                            @foreach ($legalOwnerships as $legalOwnership)
                                <option value="{{ $legalOwnership->id }}">
                                    {{ $legalOwnership->title }}
                                </option>
                            @endforeach
                            <option value="other">{{ trns('other') }}</option>
                        </select>
                    </div>
                </div>

                <div class="col-4 d-none" id="legal_ownership_other_container">
                    <div class="form-group">
                        <label for="legal_ownership_other"
                            class="form-control-label">{{ trns('legal_ownership_other') }}<span
                                class="text-danger">*</span></label>
                        <input class="form-control" name="legal_ownership_other" id="legal_ownership_other">
                    </div>
                </div>


                <div class="col-4">
                    <div class="form-group">
                        <label for="name_ar" class="form-control-label">{{ trns('real_state_name_ar') }}
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="name[ar]" id="name[ar]">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="name_en" class="form-control-label">{{ trns('real_state_name_en') }}
                            {{-- <span class="text-danger">*</span> --}}
                        </label>
                        <input type="text" class="form-control" name="name[en]" id="name[en]">
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label for="real_state_number" class="form-control-label">{{ trns('real_state_number') }}
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control" name="real_state_number" id="real_state_number">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="street" class="form-control-label">{{ trns('street') }} <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="street" id="street">
                    </div>
                </div>


                <div class="col-4">
                    <div class="form-group">
                        <label for="space" class="form-control-label">{{ trns('space') }} <span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="space" id="space">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="flat_space" class="form-control-label">{{ trns('flat_space') }} <span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="flat_space" id="flat_space">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="real_state_part_number"
                            class="form-control-label">{{ trns('real_state_part_number') }} <span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="part_number" id="part_number">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="bank_account_number" class="form-control-label">{{ trns('bank_account_number') }}
                            <span class="text-danger">*</span></label>
                        <div class="d-flex">
                            <span class="input-group-text">SA</span>

                            <input type="text" class="form-control" name="bank_account_number"
                                id="bank_account_number" style="border-radius: 5px 0 0 5px;">
                        </div>


                    </div>

                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label for="mint_number" class="form-control-label">{{ trns('mint_number') }} <span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="mint_number" id="mint_number">
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label for="mint_source" class="form-control-label">{{ trns('mint_source') }} <span
                                class="text-danger">*</span></label>
                        <input type="string" class="form-control" name="mint_source" id="mint_source">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="real_state_floor_count"
                            class="form-control-label">{{ trns('real_state_floor_count') }} <span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="floor_count" id="floor_count">
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label for="elevator_count" class="form-control-label">{{ trns('elevator_count') }} <span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="elevator_count" id="elevator_count">
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label for="building_type" class="form-control-label">{{ trns('building_type') }} <span
                                class="text-danger">*</span></label>
                        <input type="string" class="form-control" name="building_type" id="building_type">
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label for="building_year" class="form-control-label">{{ trns('building_year') }} <span
                                class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="building_year" id="building_year">
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label for="northern_border" class="form-control-label">{{ trns('northern_border') }} <span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="northern_border" id="northern_border">
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label for="southern_border" class="form-control-label">{{ trns('southern_border') }} <span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="southern_border" id="southern_border">
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label for="eastern_border" class="form-control-label">{{ trns('eastern_border') }} <span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="eastern_border" id="eastern_border">
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label for="western_border" class="form-control-label">{{ trns('western_border') }} <span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="western_border" id="western_border">
                    </div>
                </div>


                <input class="form-check-input ms-0" type="hidden" name="status" value="0">
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
                                value="1" checked onchange="toggleInterceptionReason()">
                        </div>
                        <label class="form-check-label {{ lang() == 'ar' ? 'me-3' : 'ms-5' }}"
                            for="statusToggle">{{ trns('deactivate') }}</label>
                    </div>
                </div>


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




                {{-- الخريطة --}}
                <div class="col-12">
                    <div id="map" style="height: 400px;"></div>
                </div>
                {{-- إحداثيات الخريطة --}}
                <div class="col-6">
                    <div class="form-group">
                        <label for="lat" class="form-control-label">{{ trns('lat') }}
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" value="0" class="form-control" name="lat" id="lat">
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label for="long" class="form-control-label">{{ trns('long') }}
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" value="0" class="form-control" name="long" id="long">


                    </div>


                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label for="images" class="form-control-label"
                            style="display: block; color: #00F3CA !important;">{{ trns('real_state_images') }}</label>
                        <label for="images" class="form-control-label"
                            style="display: block; color: gray !important; font-weight: normal !important;">{{ trns('you can control iamges from here') }}</label>
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
                            class="form-control-label">{{ trns('You can upload documents in the following formats (excel - pdf - word - txt)') }}</label>
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


                <div class="mt-4">
                    <div class="d-flex justify-content-end">
                        <button type="submit" name="submit_type" value="create_and_stay" class="btn m-2"
                            onclick="document.getElementById('submit_type').value='create_and_stay';"
                            style="padding: 5px 50px; font-size: 16px; font-weight: bold; background-color: #DFE3E7; color: #676767; width: 50%;">{{ trns('create_and_add_another') }}</button>

                        <button type="submit" name="submit_type" value="create_and_redirect" class="btn m-2"
                            onclick="document.getElementById('submit_type').value='create_and_redirect';"
                            style="background-color: #00193a; color: #00F3CA; border: none;padding: 5px 50px; margin-left: 10px; font-size: 16px; font-weight: bold; width: 50%;">{{ trns('create') }}</button>

                    </div>
                </div>
            </div>
        </form>
    </div>
    @include('admin.layouts.myAjaxHelper')
@endsection
@section('ajaxCalls')
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
        addScript();
        editScript();


        document.addEventListener('DOMContentLoaded', function() {
            $('.dropify').dropify();

            initializeSelect2('#association_id');

            initializeSelect2('#legal_ownership_id');

            $(document).on('change', '#legal_ownership_id', function() {
                if ($(this).val() === 'other') {
                    $('#legal_ownership_other_container').removeClass('d-none');
                    $('#legal_ownership_other').prop('required', true);
                } else {
                    $('#legal_ownership_other_container').addClass('d-none');
                    $('#legal_ownership_other').prop('required', false);
                }
            });





            function toggleCommissionedFields() {
                const isCommissioned = $('input[name="is_commission"]:checked').val() === '1';
                $('.commissioned').toggle(isCommissioned);

                if (isCommissioned) {
                    $('.commissioned').find('input, select').prop('disabled', false);
                } else {
                    $('.commissioned').find('input, select').prop('disabled', true);
                }
            }

            toggleCommissionedFields();
            $('input[name="is_commission"]').on("change", toggleCommissionedFields);

            $('#appointment_start_date').on('change', function() {
                const startDate = $(this).val();
                $('#appointment_end_date').attr('min', startDate);
            });

            $('#appointment_end_date').on('change', function() {
                const endDate = $(this).val();
                $('#appointment_start_date').attr('max', endDate);
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
                const position = marker.getLatLng();
                $('#lat').val(position.lat.toFixed(6));
                $('#long').val(position.lng.toFixed(6));
            });

            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                $('#lat').val(e.latlng.lat.toFixed(6));
                $('#long').val(e.latlng.lng.toFixed(6));
            });

            function updateMarkerPosition() {
                let lat = parseFloat($("#lat").val());
                let long = parseFloat($("#long").val());

                if (!isNaN(lat) && !isNaN(long)) {
                    marker.setLatLng([lat, long]);
                    map.panTo([lat, long]);
                }
            }

            $("#lat, #long").on("input", updateMarkerPosition);
        });

        //show and hide stop reason according to the status of the realstate
        $(document).ready(function() {
            $('#status').on('change', function() {
                if ($(this).val() === '0') {
                    $('#stopReasonContainer').show();
                } else {
                    $('#stopReasonContainer').hide();
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
@endsection
