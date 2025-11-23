<style>
    .select2-selection__choice.hidden-selection {
        display: none !important;
    }
</style>

<style>
    .card {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
        margin-bottom: 1rem;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .card-header {
        font-weight: 600;
        padding: 0.75rem 1.25rem;
    }

    .card-body {
        padding: 1.25rem;
    }

    .card-footer {
        padding: 0.75rem 1.25rem;
        background-color: rgba(0, 0, 0, 0.03);
        border-top: 1px solid rgba(0, 0, 0, 0.125);
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

    #electricCardsContainer .row {
        margin-bottom: 1rem;
    }
</style>

<div class="modal-body">
    <form id="updateForm" class="real_state_update_form" method="POST" data-id="{{ $obj->id }}"
        enctype="multipart/form-data" action="{{ $updateRoute }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $obj->id }}" name="id">
        <div class="row">

            <input name="submit_type" id="submit_type" type="hidden">
            <input type="hidden" name="singlePageCreate" value="1">


            <div class="col-12">
                <div class="form-group">
                    <label for="logo" class="form-control-label">{{ trns('real_state_primary_image') }}</label>

                    <div class="logo-upload-wrapper">
                        <input type="file" id="logoInput" name="logo" accept="image/*"
                            onchange="previewLogo(this)">
                        @if ($obj->getMedia('logo')->first())
                            <img src="{{ getFile('storage/realstate/' . $obj->getMedia('logos')->first()?->model_id . '/logos/' . $obj->getMedia('logos')->first()?->file_name) }}"
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

            <div class="col-4">
                <div class="form-group">
                    <label for="association_id" class="form-control-label">{{ trns('association_name') }}<span
                            class="text-danger">*</span></label>
                    <select class="form-control" name="association_id" id="association_id">
                        @foreach ($associations as $association)
                            <option value="{{ $association->id }}" @if ($obj->association_id == $association->id) selected @endif>
                                {{ $association->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>



            <div class="col-4">
                <div class="form-group">
                    <label for="legal_ownership_id" class="form-control-label">{{ trns('legal_ownership') }}<span
                            class="text-danger">*</span></label>
                    <select class="form-control" name="legal_ownership_id" id="legal_ownership_id">
                        @foreach ($legalOwnerships as $legalOwnership)
                            <option value="{{ $legalOwnership->id }}"
                                {{ $legalOwnership->id == $obj->legal_ownership_id ? 'selected' : '' }}>
                                {{ $legalOwnership->title }}
                            </option>
                        @endforeach
                        <option value="other" {{ $obj->legal_ownership_other != null ? 'selected' : '' }}>
                            {{ trns('other') }}</option>
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
                    <input type="text" class="form-control" name="name[ar]" id="name_ar"
                        value="{{ $obj->getTranslation('name', 'ar') }}">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="name_en" class="form-control-label">{{ trns('real_state_name_en') }}
                        {{-- <span class="text-danger">*</span> --}}
                    </label>
                    <input type="text" class="form-control" name="name[en]" id="name_ar"
                        value="{{ $obj->getTranslation('name', 'en') }}">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="real_state_number" class="form-control-label">{{ trns('real_state_number') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control" name="real_state_number" id="real_state_number"
                        value="{{ @$obj->real_state_number }}">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="street" class="form-control-label">{{ trns('street') }} <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="street" id="street"
                        value="{{ @$obj->realStateDetails->street }}">
                </div>
            </div>



            <div class="col-4">
                <div class="form-group">
                    <label for="space" class="form-control-label">{{ trns('space') }} <span
                            class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="space" id="space"
                        value="{{ @$obj->realStateDetails->space }}">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="flat_space" class="form-control-label">{{ trns('flat_space') }} <span
                            class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="flat_space" id="flat_space"
                        value="{{ @$obj->realStateDetails->flat_space }}">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="real_state_part_number"
                        class="form-control-label">{{ trns('real_state_part_number') }} <span
                            class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="part_number" id="part_number"
                        value="{{ @$obj->realStateDetails->part_number }}">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="bank_account_number" class="form-control-label">{{ trns('bank_account_number') }}
                        <span class="text-danger">*</span></label>
                    <div class="d-flex">
                        <span class="input-group-text">SA</span>

                        <input type="text" class="form-control" name="bank_account_number"
                            id="bank_account_number"
                            value="{{ @$obj->realStateDetails->bank_account_number ? substr(@$obj->realStateDetails->bank_account_number, 2) : '' }}"
                            style="border-radius: 5px 0 0 5px;" required>
                    </div>


                </div>

            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="mint_number" class="form-control-label">{{ trns('mint_number') }} <span
                            class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="mint_number" id="mint_number"
                        value="{{ @$obj->realStateDetails->mint_number }}">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="mint_source" class="form-control-label">{{ trns('mint_source') }} <span
                            class="text-danger">*</span></label>
                    <input type="string" class="form-control" name="mint_source" id="mint_source"
                        value="{{ @$obj->realStateDetails->mint_source }}">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="real_state_floor_count"
                        class="form-control-label">{{ trns('real_state_floor_count') }} <span
                            class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="floor_count" id="floor_count"
                        value="{{ @$obj->realStateDetails->floor_count }}">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="elevator_count" class="form-control-label">{{ trns('elevator_count') }} <span
                            class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="elevator_count" id="elevator_count"
                        value="{{ @$obj->realStateDetails->elevator_count }}">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="building_type" class="form-control-label">{{ trns('building_type') }} <span
                            class="text-danger">*</span></label>
                    <input type="string" class="form-control" name="building_type" id="building_type"
                        value="{{ @$obj->realStateDetails->building_type }}">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="building_year" class="form-control-label">{{ trns('building_year') }} <span
                            class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="building_year" id="building_year"
                        value="{{ @$obj->realStateDetails->building_year }}">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="northern_border" class="form-control-label">{{ trns('northern_border') }} <span
                            class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="northern_border" id="northern_border"
                        value="{{ @$obj->realStateDetails->northern_border }}">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="southern_border" class="form-control-label">{{ trns('southern_border') }} <span
                            class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="southern_border" id="southern_border"
                        value="{{ @$obj->realStateDetails?->southern_border }}">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="eastern_border" class="form-control-label">{{ trns('eastern_border') }} <span
                            class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="eastern_border" id="eastern_border"
                        value="{{ @$obj->realStateDetails->eastern_border }}">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label for="western_border" class="form-control-label">{{ trns('western_border') }} <span
                            class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="western_border" id="western_border"
                        value="{{ @$obj->realStateDetails->western_border }}">
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
                        <input class="form-check-input ms-0" type="checkbox" id="statusToggle" value="1"
                            @if ($obj->status == 1) checked @endif onchange="toggleInterceptionReason()">
                        <input type="hidden" name="status"
                            value="@if ($obj->status == 1) 0 @else 1 @endif">
                    </div>
                    <label class="form-check-label {{ lang() == 'ar' ? 'me-3' : 'ms-5' }}"
                        for="statusToggle">{{ trns('deactivate') }}</label>
                </div>
            </div>

            {{-- Stop Reason --}}
            <div class="col-12" id="interception_reason_container"
                style="display: {{ $obj->status == 0 ? 'block' : 'none' }};">
                <div class="form-group">
                    <label for="interception_reason" class="form-control-label">{{ trns('stop_reason') }}</label>
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
                    @foreach ($realStateElectrics as $electric)
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
                            <input type="text" class="form-control" id="water_name">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="water_account_number"
                                class="form-control-label">{{ trns('water_account_number') }}
                                <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="water_account_number"
                                id="water_account_number">
                        </div>
                    </div>



                    <div class="col-2">
                        <div class="form-group">
                            <label for="water_meter_number"
                                class="form-control-label">{{ trns('water_meter_number') }}
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

                <div id="waterCardsContainer" class="row g-3">
                    @foreach ($realStateWaters as $water)
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
                    <input type="text" value="{{ $obj->lat }}" class="form-control" name="lat"
                        id="lat">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="long" class="form-control-label">{{ trns('long') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" value="{{ $obj->long }}" class="form-control" name="long"
                        id="long">
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
                        {{ trns('You can upload documents in the following formats excel - pdf - word - txt') }}
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



<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
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


<script>
    initializeSelect2InModal('#legal_ownership_id');
    initializeSelect2InModal('#association_id');
</script>






<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>



<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-sA+oYy5rjphsyV6qLdX5lFh3ugMQAxTVvD+FA2z6+3Y=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-oRkS4hJ2kMRSR2J7DHOY7FTh5E3uX9U4I9znKzJxM7E=" crossorigin=""></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-oRkS4hJ2kMRSR2J7DHOY7FTh5E3uX9U4I9znKzJxM7E=" crossorigin=""></script>

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

        if (!isNaN(lat) && !isNaN(long)) {
            marker.setLatLng([lat, long]);
            map.panTo([lat, long]);
            $('#lat').val(lat.toFixed(6));
            $('#long').val(long.toFixed(6));
        }
    }

    $("#lat, #long").on("input", updateMarkerPosition);



    $(document).ready(function() {

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
