<!-- <div class="modal-body"> -->
<form id="updateForm" class="votes_update_form" method="POST" enctype="multipart/form-data" action="{{ $updateRoute }}">
    @csrf
    @method('PUT')

    <input type="hidden" value="{{ $obj->id }}" name="id">

    <div class="row">
        <!-- Title (Arabic) -->
        <div class="col-6 mb-3">
            <label for="title_ar" class="form-control-label">{{ trns('vote_title_ar') }}</label>
            <input type="text" class="form-control" name="title[ar]" id="title_ar"
                value="{{ old('title.ar', $obj->getTranslation('title', 'ar') ?? '') }}" required>
        </div>

        <!-- Title (English) -->
        <div class="col-6 mb-3">
            <label for="title_en" class="form-control-label">{{ trns('vote_title_en') }}</label>
            <input type="text" class="form-control" name="title[en]" id="title_en"
                value="{{ old('title.en', $obj->getTranslation('title', 'en') ?? '') }}" >
        </div>

        <!-- Description (Arabic) -->
        <div class="col-12 mb-3">
            <label for="description_ar" class="form-control-label">{{ trns('description_ar') }}</label>
            <textarea class="form-control" name="description[ar]" id="description_ar" rows="2" required>{{ old('description.ar', $obj->getTranslation('description', 'ar') ?? '') }}</textarea>
        </div>

        <!-- Description (English) -->
        <div class="col-12 mb-3">
            <label for="description_en" class="form-control-label">{{ trns('description_en') }}</label>
            <textarea class="form-control" name="description[en]" id="description_en" rows="2" >{{ old('description.en', $obj->getTranslation('description', 'en') ?? '') }}</textarea>
        </div>

        <!-- Association -->
        <div class="col-8 mb-3">
            <label for="association_id" class="form-control-label">{{ trns('association') }}</label>
            <select name="association_id" id="association_id" class="form-control" disabled readonly>
                @foreach ($associations as $association)
                    <option value="{{ $association->id }}"
                        {{ $association->id == $obj->association_id ? 'selected' : '' }}>
                        {{ $association->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Audience Number -->
        <div class="col-4 mb-3">
            <label for="audience_number" class="form-control-label">{{ trns('audience_number') }}</label>
            <input type="number" value="{{ $owners_number }}" class="form-control" name="audience_number"
                id="audience_number" disabled readonly required>
        </div>

        <!-- Start Date -->
        <div class="col-6 mb-3">
            <label for="start_date" class="form-control-label">{{ trns('vote_start_date') }}</label>
            <input min="{{ now()->toDateString() }}" onclick="this.showPicker()" type="date" class="form-control" name="start_date" id="start_date"
                value="{{ optional($detail)->start_date ? $detail->start_date->format('Y-m-d') : '' }}" required>
        </div>

        <!-- End Date -->
        <div class="col-6 mb-3">
            <label for="end_date" class="form-control-label">{{ trns('vote_end_date') }}</label>
            <input min="{{ now()->toDateString() }}" onclick="this.showPicker()" type="date" class="form-control" name="end_date" id="end_date"
                value="{{ optional($detail)->end_date ? $detail->end_date->format('Y-m-d') : '' }}" required>
        </div>
    </div>
</form>



<script>
    $("#association_id").on("change", function() {
        let id = $(this).val();

        if (!id) return;

        $.ajax({
            url: "{{ route('getUserByAssociation', ':id') }}".replace(':id', id),
            type: "GET",
            dataType: "json",
            success: function(response) {
                // نحط العدد في input
                $("#audience_number").val(response.count);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    });
</script>


<script>
    $('.dropify').dropify();



    initializeSelect2InModal('#association_id');
</script>
