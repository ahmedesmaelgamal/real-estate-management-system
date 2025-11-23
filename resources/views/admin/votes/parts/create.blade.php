<div>
    <form id="addForm" class="addForm addVoteForm" method="POST" enctype="multipart/form-data"
        action="{{ $storeRoute }}">
        @csrf

        <div class="row">
            <!-- Title (Arabic) -->
            <div class="col-6 mb-3">
                <label for="title_ar" class="form-control-label">{{ trns('vote_title_ar') }}</label>
                <input type="text" class="form-control" name="title[ar]" id="title_ar" value="{{ old('title.ar') }}"
                    placeholder="{{ trns('enter_vote_title_ar') }}" required>
            </div>

            <!-- Title (English) -->
            <div class="col-6 mb-3">
                <label for="title_en" class="form-control-label">{{ trns('vote_title_en') }}</label>
                <input type="text" class="form-control" name="title[en]" id="title_en" value="{{ old('title.en') }}"
                    placeholder="{{ trns('enter_vote_title_en') }}" >
            </div>

            <!-- Description (Arabic) -->
            <div class="col-12 mb-3">
                <label for="description_ar" class="form-control-label">{{ trns('description_ar') }}</label>
                <textarea class="form-control" name="description[ar]" id="description_ar" rows="2"
                    placeholder="{{ trns('enter_description_ar') }}" required>{{ old('description.ar') }}</textarea>
            </div>

            <!-- Description (English) -->
            <div class="col-12 mb-3">
                <label for="description_en" class="form-control-label">{{ trns('description_en') }}</label>
                <textarea class="form-control" name="description[en]" id="description_en" rows="2"
                    placeholder="{{ trns('enter_description_en') }}" >{{ old('description.en') }}</textarea>
            </div>

            <!-- Association -->
            <div class="col-8 mb-3">
                <label for="association_id" class="form-control-label">{{ trns('association') }}</label>
                <select name="association_id" id="association_id" class="form-control select2" required>
                    <option value="">{{ trns('select_association') }}</option>
                    @foreach ($associations as $association)
                        <option value="{{ $association->id }}">{{ $association->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Audience Number -->
            <div class="col-4 mb-3">
                <label for="audience_number" class="form-control-label">{{ trns('audience_number') }}</label>
                <input type="number" class="form-control" name="audience_number" id="audience_number" readonly
                    required>
            </div>

            <!-- Start Date -->
            <div class="col-4 mt-3">
                <label for="start_date" class="form-control-label">{{ trns('vote_start_date') }}</label>
                <input min="{{ now()->toDateString() }}" onclick="this.showPicker()" type="date"
                    class="form-control" name="start_date" id="start_date" required>
            </div>

            <!-- End Date -->
            <div class="col-4 mt-3">
                <label for="end_date" class="form-control-label">{{ trns('vote_end_date') }}</label>
                <input min="{{ now()->toDateString() }}" onclick="this.showPicker()" type="date"
                    class="form-control" name="end_date" id="end_date" required>
            </div>

            <!-- Vote Percentage -->
            <div class="col-4 mb-3">
                <label for="vote_percentage" class="form-control-label">{{ trns('vote_percentage') }}</label>
                <input type="number" step="0.01" class="form-control" name="vote_percentage" id="vote_percentage"
                    required>
            </div>


        </div>
    </form>
</div>




<script>
    document.getElementById('start_date').addEventListener('change', function() {
        const endDateInput = document.getElementById('end_date');
        endDateInput.min = this.value; // ensure end_date >= start_date
    });
</script>
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
    $('input[name="national_id"]').on('input', function() {

        this.value = this.value.replace(/\D/g, '');

        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10);
        }
    });


    $('input[name="phone"]').on('input', function() {

        this.value = this.value.replace(/\D/g, '');

        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10);
        }
    });

    $('.dropify').dropify();

    $('.select2').select2();

    initializeSelect2InModal('#association_id');
</script>
