<div class="modal-body">
    <form id="updateForm" class="updateForm termFormUpdate" method="POST" enctype="multipart/form-data"
        action="{{ $updateRoute }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $obj->id }}" name="id">

        <div class="row">
            {{-- Arabic name --}}
            <div class="col-6">
                <div class="form-group">
                    <label for="name_ar" class="form-control-label">
                        {{ trns('name_ar') }}<span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" name="name[ar]" id="name_ar"
                        value="{{ $obj->getTranslation('name', 'ar') }}">
                </div>
            </div>

            {{-- English name --}}
            <div class="col-6">
                <div class="form-group">
                    <label for="name_en" class="form-control-label">
                        {{ trns('name_en') }}
                        {{-- <span class="text-danger">*</span> --}}
                    </label>
                    <input type="text" class="form-control" name="name[en]" id="name_en"
                        value="{{ $obj->getTranslation('name', 'en') }}">
                </div>
            </div>

            {{-- Arabic description --}}
            <div class="col-6">
                <div class="form-group">
                    <label for="description_ar" class="form-control-label">
                        {{ trns('description_ar') }}
                        {{-- <span class="text-danger">*</span> --}}
                    </label>
                    <textarea class="form-control" name="description[ar]" id="description_ar">{{ $obj->getTranslation('description', 'ar') }}</textarea>
                </div>
            </div>

            {{-- English description --}}
            <div class="col-6">
                <div class="form-group">
                    <label for="description_en" class="form-control-label">
                        {{ trns('description_en') }}
                        {{-- <span class="text-danger">*</span> --}}
                    </label>
                    <textarea class="form-control" name="description[en]" id="description_en">{{ $obj->getTranslation('description', 'en') }}</textarea>
                </div>
            </div>

            {{-- Date field --}}
            <div class="col-12">
                <div class="col-12">
                    <div class="form-group">
                        <label for="date" class="form-control-label">
                            {{ trns('time') }} <span class="text-danger">*</span>
                        </label>
                        <input onclick="this.showPicker()" type="time" class="form-control" name="date" id="date"
                            value="{{ old('date', $obj->date ?? '') }}" required>
                    </div>
                </div>

            </div>
    </form>
</div>

<!-- Dropify script -->
<script>
    $('.dropify').dropify();
</script>
