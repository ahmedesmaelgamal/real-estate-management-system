@extends('admin/layouts/master')

@section('title')
    {{ config()->get('app.name') }} | {{ trns('create_vote') }}
@endsection

@section('page_name')
    {{ trns('create_new_vote') }}
@endsection

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <div>
        <form id="addVoteForm" class="addVoteForm" method="POST" action="{{ $storeRoute }}">
            @csrf
            <input name="submit_type" id="submit_type" type="hidden">
            <input type="hidden" name="singlePageCreate" value="1">

            <div style="display: flex; margin-top: 20px; margin-bottom: 20px; justify-content: space-between;">
                <div>
                    <h2 class="fw-bold" style="color: #00193a; margin-bottom: 0px;">{{ trns('create_new_vote') }}</h2>
                    <h4 class="fw-bold" style="color: #00193a; margin-top: 30px;">{{ trns('main_information') }}</h4>
                    <small>{{ trns('you_can_start_new_vote_from_here') }}</small>
                </div>
            </div>

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
                    <input type="text" class="form-control" name="title[en]" id="title_en"
                        value="{{ old('title.en') }}" placeholder="{{ trns('enter_vote_title_en') }}" >
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
                <div class="col-4 mt-3">
                    <label for="vote_percentage" class="form-control-label">{{ trns('vote_percentage') }}</label>
                    <input type="number" step="0.01" class="form-control" name="vote_percentage" id="vote_percentage"
                        required>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-5">
                <button type="submit" name="submit_type" value="create_and_redirect" class="btn m-2"
                    onclick="document.getElementById('submit_type').value='create_and_redirect';"
                    style="background-color: #00193a; color: #00F3CA; border: none; padding: 5px 50px; font-size: 16px; font-weight: bold; width: 50%;">
                    {{ trns('create') }}
                </button>

                <button type="submit" name="submit_type" value="create_and_stay" class="btn m-2"
                    onclick="document.getElementById('submit_type').value='create_and_stay';"
                    style="padding: 5px 50px; font-size: 16px; font-weight: bold; background-color: #DFE3E7; color: #676767; width: 50%;">
                    {{ trns('create_and_add_another') }}
                </button>
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



@section('js')
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
        $('.dropify').dropify();

        $('.select2').select2();

        initializeSelect2InModal('#association_id');


        $(document).on('submit', '#addVoteForm', function(e) {
            e.preventDefault();

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            var form = this;
            var formData = new FormData(form);
            var url = $(form).attr('action');
            var submitType = $('#submit_type').val() || 'create_and_redirect';

            var submitButton = $(document.activeElement);
            var buttonHtml = submitButton.html();

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    submitButton.html(
                        '<span class="spinner-border spinner-border-sm mr-2"></span> {{ trns('loading...') }}'
                    ).attr('disabled', true);
                },
                success: function(data) {
                    submitButton.html(buttonHtml).attr('disabled', false);

                    if (data.status == 200) {
                        Swal.fire({
                            title: '{{ trns('added_successfully') }}',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1000
                        });

                        if (data.redirect_to) {
                            setTimeout(() => window.location.href = data.redirect_to, 800);
                        } else {
                            if (submitType === 'create_and_stay') {
                                form.reset();
                                $("#audience_number").val('');
                            } else {
                                setTimeout(() => window.location.reload(), 800);
                            }
                        }
                    } else if (data.status == 405) {
                        toastr.error(data.mymessage);
                    } else {
                        toastr.error('{{ trns('something_went_wrong') }}');
                    }
                },
                error: function(xhr) {
                    submitButton.html(buttonHtml).attr('disabled', false);

                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            var input = $('[name="' + field + '"]');
                            input.addClass('is-invalid');
                            input.after('<div class="invalid-feedback">' + messages[0] +
                                '</div>');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('error') }}',
                            text: '{{ trns('something_went_wrong') }}'
                        });
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    </script>
@endsection
