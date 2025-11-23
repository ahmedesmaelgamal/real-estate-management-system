<div class="modal-body">
    <form id="updateForm" class="updateForm meetSummaryUpdateForm" method="POST" enctype="multipart/form-data"
        action="{{ $updateRoute }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $obj->id }}" name="id">

        <div class="row">
            {{-- Arabic Title --}}
            <div class="col-6">
                <div class="form-group">
                    <label for="title_ar" class="form-control-label">
                        {{ trns('title_ar') }}<span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" name="title[ar]" id="title[ar]"
                        value="{{ $obj->getTranslation('title', 'ar') }}">
                </div>
            </div>

            {{-- English Title --}}
            <div class="col-6">
                <div class="form-group">
                    <label for="title_en" class="form-control-label">
                        {{ trns('title_en') }}
                        {{-- <span class="text-danger">*</span> --}}
                    </label>
                    <input type="text" class="form-control" name="title[en]" id="title[en]"
                        value="{{ $obj->getTranslation('title', 'en') }}">
                </div>
            </div>

            {{-- Arabic description --}}
            <div class="col-6">
                <div class="form-group">
                    <label for="description_ar" class="form-control-label">
                        {{ trns('description_ar') }}<span class="text-danger">*</span>
                    </label>
                    <textarea rows="10" type="text" class="form-control" name="description[ar]" id="description[ar]"
                        value="{{ $obj->getTranslation('description', 'ar') }}">{{ $obj->getTranslation('description', 'ar') }}  </textarea>
                </div>
            </div>

            {{-- English description --}}
            <div class="col-6">
                <div class="form-group">
                    <label for="description_en" class="form-control-label">
                        {{ trns('description_en') }}
                        {{-- <span class="text-danger">*</span> --}}
                    </label>
                    <textarea rows="10" type="text" class="form-control" name="description[en]" id="description[en]"
                        value="{{ $obj->getTranslation('description', 'en') }}">{{ $obj->getTranslation('description', 'en') }}</textarea>
                </div>
            </div>

            {{-- Owner --}}
            <div class="col-12">
                <div class="form-group">
                    <label for="owner_id" class="form-control-label">
                        {{ trns('owner') }}<span class="text-danger">*</span>
                    </label>
                    <select class="form-control" name="owner_id" id="owner_id">
                        <option value="" disabled>{{ trns('select_owner') }}</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $obj->owner_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="time" class="form-control-label">
                        {{ trns('time') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="datetime-local" onclick="this.showPicker()" class="form-control" name="time"
                        id="time" required
                        value="{{ $obj->date ? now()->format('Y-m-d') . 'T' . \Carbon\Carbon::parse($obj->date)->format('H:i') : '' }}">


                </div>
            </div>
        </div>
    </form>
</div>

<!-- Dropify script -->
<script>
    $('.dropify').dropify();
</script>
