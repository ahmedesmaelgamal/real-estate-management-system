    <form id="updateForm" class="updateForm caseUpdateModel" method="POST" enctype="multipart/form-data"
        action="{{ $updateRoute }}">
        @csrf
        @method('PUT')

        <div class="row">

            <input type="hidden" name="court_cases_id" id="case_id" value="{{ $caseUpdate->court_cases_id }}" />

            <div class="col-6">
                <div class="form-group">
                    <label for="title_ar" class="form-control-label">
                        {{ trns('title_ar') }}<span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" name="title[ar]" id="title_ar"
                        value="{{ $caseUpdate->getTranslation('title', 'ar') }}">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="title_en" class="form-control-label">
                        {{ trns('title_en') }}
                    </label>
                    <input type="text" class="form-control" name="title[en]" id="title_en"
                        value="{{ $caseUpdate->getTranslation('title', 'en') }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="case_update_type_id">
                        {{ trns('caseType') }} <span class="text-danger">*</span>
                    </label>
                    <select class="form-control select2" id="case_update_type_id" name="case_update_type_id" required>
                        <option value="">{{ trns('select_caseUpdateType') }}</option>
                        @foreach ($caseUpdateTypes as $caseType)
                            <option value="{{ $caseType->id }}"
                                {{ $caseUpdate->case_update_type_id == $caseType->id ? 'selected' : '' }}>
                                {{ $caseType->getTranslation('title', app()->getLocale()) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="end_date">{{ trns('end_date') }} <span class="text-danger">*</span></label>
                    <input class="form-control" type="date" name="end_date" value="{{ $caseUpdate->end_date }}">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="description">{{ trns('description') }} <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="description" placeholder="{{ trns('description') }}">{{ $caseUpdate->description }}</textarea>
                </div>
            </div>

        </div>
    </form>

    <!-- Dropify script -->
    <script>
        $('.dropify').dropify();
    </script>
