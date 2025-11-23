<div>


    <div class="modal fade" id="createAgendaModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trns('create_agenda') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="createAgendaModalBody">
                    <!-- Loader or content will be injected here -->
                </div>

                <div class="modal-footer" id="createAgendaModalFooter">
                    <!-- Footer buttons will be injected here -->
                </div>
            </div>
        </div>
    </div>




    <form id="addMeetingForm" class=" addMeetingForm" method="POST" enctype="multipart/form-data"
        action="{{ $storeRoute }}">
        @csrf
        <div class="row">

            {{-- Association --}}
            <div class="col-md-6">
                <div class="form-group">
                    <label for="association_id">{{ trns('association') }} <span class="text-danger">*</span></label>
                    <select class="form-control select2" id="association_id" name="association_id" required>
                        <option value="" selected disabled>{{ trns('select_association') }}</option>
                        @foreach ($associations as $association)
                            <option value="{{ $association->id }}">{{ $association->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>



            {{-- Admin (auto-filled from association) --}}
            <div class="col-md-6">
                <div class="form-group">
                    <label for="admin_name">{{ trns('association_owner') }} <span class="text-danger">*</span></label>
                    <input type="text" id="admin_name" class="form-control" readonly>
                    <input type="hidden" id="owner_id" name="owner_id">
                </div>
            </div>

            {{-- Users --}}
            <div class="col-12">
                <div class="form-group">
                    <label for="users_id">{{ trns('users') }} <span class="text-danger">*</span></label>
                    <select class="form-control select2" multiple id="users_id" name="users_id[]" required>
                        <option value="" disabled>{{ trns('select_users') }}</option>
                    </select>
                </div>
            </div>

            {{-- meet_number --}}
            {{-- <div class="col-6">
                <div class="form-group">
                    <label for="meet_number">{{ trns('meet_number') }} <span class="text-danger">*</span></label>
                    <input name="meet_number" class="form-control" type="number" required />
                </div>
            </div> --}}


            {{-- Topic --}}
            {{-- <div class="col-md-4">
                <div class="form-group">
                    <label for="topic_id">{{ trns('topic') }} <span class="text-danger">*</span></label>
                    <select class="form-control select2" multiple id="topic_id" name="topic_id[]" required>
                        <option value="" selected disabled>{{ trns('select_topic') }}</option>
                        @foreach ($topics as $topic)
                            <option value="{{ $topic->id }}">
                                {{ $topic->getTranslation('title', app()->getLocale()) }}</option>
                        @endforeach
                        <option value="other">{{ trns('others') }}</option>
                    </select>
                </div>
            </div> --}}

            {{-- Topic --}}
            <div class="col-md-4">
                <div class="form-group">
                    <label for="topic_id">{{ trns('topic') }} <span class="text-danger">*</span></label>
                    <input type="text" name="topic" class="form-control" id="topic" required />
                </div>
            </div>


            {{-- Date --}}
            <div class="col-md-4">
                <div class="form-group">
                    <label for="date">{{ trns('date') }} <span class="text-danger">*</span></label>
                    <input onclick="this.showPicker()" type="datetime-local" class="form-control" id="date"
                        name="date" required>
                </div>
            </div>

            {{-- Address --}}
            <div class="col-md-4">
                <div class="form-group">
                    <label for="address">{{ trns('address') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
            </div>

            {{-- Other topic input (hidden by default) --}}
            <div class="col-12" id="other_topic_wrapper" style="display: none;">
                <div class="form-group">
                    <label for="other_topic">{{ trns('other_topic') }}</label>
                    <input type="text" class="form-control" name="other_topic" id="other_topic"
                        placeholder="{{ trns('enter_other_topic') }}">
                </div>
            </div>

            {{-- Agenda --}}
            <div class="col-12 mt-3">
                <div class="form-group">


                    <div class="mt-2 row" id="agendaCardsContainer">
                        <h4 class="form-control-label" style="display:block">
                            {{ trns('agenda') }}
                        </h4>
                        <label class="form-control-label">
                            {{ trns('agenda') . ' ' . trns('(guide_line)') }}
                        </label>
                        @foreach ($agendas as $agenda)
                            <div class="col-12">
                                <div class="row align-items-center">
                                    <!-- الزرار (1) -->
                                    <div class="col-1 d-flex justify-content-center">
                                        <button type="button" class="btn btn-sm btn-danger delete_agenda_btn"
                                            data-id="{{ $agenda->id }}" title="{{ trns('delete') }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>

                                    <!-- الكارد (11) -->
                                    <div class="col-11">
                                        <div class="card custom-checkbox-card custom-checkbox-card-checked">
                                            <input class="form-check-input d-none" type="checkbox" name="agenda_id[]"
                                                id="agenda{{ $loop->index + 1 }}" value="{{ $agenda->id }}"
                                                {{ is_array(old('agenda_id')) && in_array($agenda->id, old('agenda_id', [])) ? 'checked' : '' }}>
                                            <label for="agenda{{ $loop->index + 1 }}"
                                                class="card-body text-right w-100">
                                                <h5 class="association-card-header" style="font-weight: bold;">
                                                    {{ $agenda->getTranslation('name', app()->getLocale()) }}
                                                </h5>
                                                @if (!empty($agenda->description))
                                                    <p class="association-card-para" style="color: #b5b5c3;">
                                                        {{ $agenda->description }}
                                                    </p>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div style="display:flex; justify-content: flex-end;">
                        <button type="button" class="createAgenda btn btn-icon text-white">
                            {{ trns('create_agenda') }}
                        </button>
                    </div>
                </div>
            </div>



        </div>
    </form>
</div>
</div>


<style>
    .select-display {
        background-color: #343a40;
        color: #fff;
        padding: 3px 20px;
        border-radius: 8px;
        display: inline-block;
        font-weight: 500;
        /* font-size: 10px; */
    }

    .select2-container--default .select2-selection--multiple {
        padding: 0.305rem 0.60rem;
    }
</style>

{{-- Delete Agenda --}}
<script>
    $(document).on('click', '.delete_agenda_btn', function(e) {
        e.preventDefault();

        let agendaId = $(this).data('id');
        let deleteUrl = "{{ route('agenda.destroy', ':id') }}".replace(':id', agendaId);

        $.ajax({
            url: deleteUrl,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status === 200) {
                    // Optional success toast
                    Swal.fire({
                        title: "{{ trns('deleted_successfully') }}",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 800
                    });

                    // Remove the deleted element visually
                    $(`.delete_agenda_btn[data-id="${agendaId}"]`)
                        .closest('.col-12')
                        .fadeOut(300, function() {
                            $(this).remove();
                        });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: "{{ trns('error') }}",
                        text: response.message || "{{ trns('something_went_wrong') }}"
                    });
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: "{{ trns('error') }}",
                    text: "{{ trns('something_went_wrong') }}"
                });
            }
        });
    });
</script>


<script>
    $(document).ready(function() {

        // 🟢 فتح مودال الأجندة (منع أي تكرار للحدث)
        $(document).off('click', '.createAgenda').on('click', '.createAgenda', function(e) {
            e.preventDefault();

            $('#createAgendaModalFooter').html(`
            <div class="w-100 d-flex">
                <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('close') }}</button>
                <button type="button" class="btn btn-one me-2" id="createAgendaButton">{{ trns('create') }}</button>
            </div>
        `);

            $('#createAgendaModalBody').html(
                '<div class="text-center my-5"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>'
            );
            $('#createAgendaModal').modal('show');

            // تحميل الفورم بعد 250ms
            setTimeout(function() {
                $('#createAgendaModalBody').load('{{ route('agenda.create') }}');
            }, 250);
        });

        // 🟢 إرسال الفورم داخل المودال (معزول تمامًا)
        $(document).off('click', '#createAgendaButton').on('click', '#createAgendaButton', function(e) {
            e.preventDefault();

            const form = $('#createAgendaModalBody').find('form')[0];
            if (!form) return;

            const formData = new FormData(form);
            const url = $(form).attr('action');

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#createAgendaButton').html(
                        '<span class="spinner-border spinner-border-sm mr-2"></span> {{ trns('loading...') }}'
                    ).attr('disabled', true);
                },
                success: function(data) {
                    $('#createAgendaButton').html('{{ trns('create') }}').attr('disabled',
                        false);

                    if (data.status === 200) {
                        Swal.fire({
                            title: '<span style="margin-bottom:50px; display:block;">{{ trns('added_successfully') }}</span>',
                            imageUrl: '{{ asset('true.png') }}',
                            imageWidth: 80,
                            imageHeight: 80,
                            showConfirmButton: false,
                            timer: 800,
                        });

                        $('#createAgendaModal').modal('hide');

                        // إضافة الأجندة الجديدة داخل الفورم الرئيسي (#addForm)
                        if (data.agenda) {
                            const lastAgenda = data.agenda;
                            const index = $('#agendaCardsContainer .col-12').length + 1;
                            const name = lastAgenda.name ?? '';
                            const desc = lastAgenda.description ?? '';

                            const newAgendaHtml = `
        <div class="col-12">
            <div class="row align-items-center">
                
                <!-- العمود الأول لزرار الحذف -->
                <div class="col-1 d-flex justify-content-center">
                    <button type="button"
                            class="btn btn-sm btn-danger delete_agenda_btn"
                            data-id="${lastAgenda.id}"
                            title="{{ trns('delete') }}">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>

                <!-- العمود الثاني للكارد -->
                <div class="col-11"> 
                    <div readonly class="card custom-checkbox-card "
                        >
                        <input readonly class="form-check-input d-none" type="checkbox" name="agenda_id[]"
                            id="agenda${index}" value="${lastAgenda.id}" checked>

                        <label for="agenda${index}" class="card-body text-right w-100"
                            >
                            <h5 class="association-card-header" style="font-weight: bold;">${name}</h5>
                            ${desc ? `<p class="association-card-para" style="color:#b5b5c3;">${desc}</p>` : ''}
                        </label>
                    </div>
                </div>

            </div>
        </div>
    `;

                            $('#agendaCardsContainer').append(newAgendaHtml);
                        }


                    } else {
                        toastr.error('{{ trns('something_went_wrong') }}');
                    }
                },
                error: function(xhr) {
                    $('#createAgendaButton').html('{{ trns('create') }}').attr('disabled',
                        false);

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            const inputName = field.includes('.') ? field.replace(
                                /\./g, '[') + ']' : field;
                            const input = $('[name="' + inputName + '"]');
                            input.addClass('is-invalid');
                            input.after('<div class="invalid-feedback">' + messages[
                                0] + '</div>');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('error') }}',
                            text: '{{ trns('something_went_wrong') }}'
                        });
                    }
                }
            });
        });

    });
</script>

















<script>
    // handle topic other option
    $(document).ready(function() {
        $('#topic_id').on('change', function() {
            let selectedValues = $(this).val() || [];

            if (selectedValues.includes('other')) {
                $('#other_topic_wrapper').show();
            } else {
                $('#other_topic_wrapper').hide();
                $('#other_topic').val(''); // clear input when hidden
            }
        });
    });





    //  handle users loading based on association
    $(document).ready(function() {
        // When association changes
        $('#association_id').on('change', function() {
            let associationId = $(this).val();

            if (!associationId) return;

            // 🧹 Clear previous users but keep "Select All"
            $('#users_id').empty().trigger('change');

            $.ajax({
                url: '{{ route('getUserMeetByAssociation', ':id') }}'.replace(':id',
                    associationId),
                type: 'GET',
                beforeSend: function() {
                    $('#users_id').html(
                        '<option disabled selected>{{ trns('loading_users') }}...</option>'
                    );
                },
                success: function(response) {
                    $('#users_id').empty();

                    // 🟢 Add "Select All" option permanently
                    $('#users_id').append(
                        '<option value="all" id="select_all_option">{{ trns('select_all') }}</option>'
                    );

                    if (response.users && response.users.length > 0) {
                        $.each(response.users, function(index, user) {
                            // store user name in data-name for restore
                            let $opt = $('<option>')
                                .val(user.id)
                                .text(user.name)
                                .attr('data-name', user.name);
                            $('#users_id').append($opt);
                        });

                        // optional placeholder
                        $('#users_id').append(
                            '<option disabled>{{ trns('select_user') }}</option>');
                    } else {
                        $('#users_id').append(
                            '<option disabled>{{ trns('no_users_found') }}</option>');
                    }

                    // ✅ Initialize or refresh select2
                    $('#users_id').select2({
                        allowClear: true
                    });

                    // ✅ Counting + Display logic
                    let totalUsers = response.users ? response.users.length : 0;
                    let locale = "{{ app()->getLocale() }}";

                    $('#users_id').off('change.countDisplay').on('change.countDisplay',
                        function() {
                            let selectedValues = $(this).val() || [];

                            // ✅ If "Select All" chosen → select all IDs
                            $('#users_id').on('select2:select', function(e) {
                                if (!e.params || !e.params.data) return;

                                let clicked = e.params.data.id && e.params.data
                                    .id.toString();

                                if (clicked === 'all') {
                                    let current = $(this).val() || [];

                                    if (current.length === (response.users ?
                                            response.users.length : 0)) {
                                        $(this).val([]).trigger(
                                            'change.select2');

                                        $('#users_id').find(
                                            '#select_all_option').text(
                                            "{{ trns('select_all') }}");
                                        $('#users_id').select2().trigger(
                                            'change.select2');

                                        // ✅ change display text to default
                                        $('#users_id').next(
                                                '.select2-container')
                                            .find(
                                                '.select2-selection__rendered')
                                            .html(
                                                `<option style="
                                                        background-color: #343a40;
                                                        color: #fff;
                                                        padding: 4px 14px;
                                                        border-radius: 8px;
                                                        display: inline-block;
                                                        font-weight: 500;
                                                        font-size: 12px;
                                                    " selected>{{ trns('select_users') }}</option>`
                                            );



                                        return;
                                    }

                                    let allUserIds = response.users.map(u => u
                                        .id.toString());


                                    $(this).val(allUserIds).trigger(
                                        'change.select2');



                                    $('#users_id').find(
                                        '#select_all_option').text(
                                        "{{ trns('unselect_all') }}");
                                    $('#users_id').select2().trigger(
                                        'change.select2');



                                    // ✅ change display text to full selected
                                    $('#users_id').next(
                                            '.select2-container')
                                        .find('.select2-selection__rendered')
                                        .html(
                                            `<option style="
                                                    background-color: #343a40;  
                                                    color: #fff;
                                                    padding: 4px 14px;
                                                    border-radius: 8px;
                                                    display: inline-block;
                                                    font-weight: 500;
                                                    font-size: 12px;
                                                " selected>{{ trns('selected') }} ${response.users.length} {{ trns('from') }} ${response.users.length}</option>`
                                        );


                                }

                            });

                            let selectedCount = selectedValues.length;

                            // ✅ Text for top display
                            let displayText = selectedCount > 0 ?
                                "{{ trns('selected') }}" +
                                ` ${selectedCount} {{ trns('from') }} ${totalUsers}` :
                                "{{ trns('select_users') }}";

                            // ✅ When all are selected → show numbers instead of names
                            if (selectedCount === totalUsers && totalUsers > 0) {
                                $('#users_id option').each(function() {
                                    if ($(this).is(':disabled') || $(this)
                                        .val() === 'all') return;
                                    $(this).text($(this).val()); // show id
                                });
                            } else {
                                // restore names
                                $('#users_id option').each(function() {
                                    if ($(this).is(':disabled') || $(this)
                                        .val() === 'all') return;
                                    let originalName = $(this).attr(
                                        'data-name') || $(this).text();
                                    $(this).text(originalName);
                                });
                            }

                            // refresh select2 display
                            $('#users_id').trigger('change.select2');

                            // ✅ update the select2 header area
                            $('#users_id').next('.select2-container')
                                .find('.select2-selection__rendered')
                                .html(`
                        <span 
                            id="usersTextDisplay" 
                            style="
                                background-color: #343a40;
                                color: #fff;
                                padding: 4px 14px;
                                border-radius: 8px;
                                display: inline-block;
                                font-weight: 500;
                                font-size: 12px;
                            ">
                            ${displayText}
                        </span>
                    `);
                        }).trigger('change.countDisplay');
                },
                error: function() {
                    $('#users_id').html(
                        '<option disabled>{{ trns('error_loading_users') }}</option>'
                    );
                }
            });
        });;
    });
</script>











<script>
    $('.select2').select2();



    $(document).ready(function() {
        initializeSelect2WithSearchCustom('#users_id');

        let totalUsers = {{ count($users) }};
        let locale = "{{ app()->getLocale() }}";

        $('#users_id').on('change', function() {
            let selectedCount = $(this).val() ? $(this).val().length : 0;
            let displayText = selectedCount > 0 ?
                getDisplayText(selectedCount, totalUsers, locale) :
                "{{ trns('select_users') }}";

            $('#users_id').next('.select2-container')
                .find('.select2-selection__rendered')
                .html(`<span class="select-display">${displayText}</span>`);
        }).trigger('change');

        function getDisplayText(selectedCount, total, locale) {
            if (locale === 'ar') {
                return "{{ trns('selected') }}" + ` ${selectedCount} {{ trns('from') }} ${total}`;
            } else {
                return "{{ trns('selected') }}" + ` ${selectedCount} {{ trns('from') }} ${total}`;
            }
        }
    });


    $(document).ready(function() {
        initializeSelect2WithSearchCustom('#topic_id');

        let totalUsers = {{ count($users) }};
        let locale = "{{ app()->getLocale() }}";

        $('#topic_id').on('change', function() {
            let selectedCount = $(this).val() ? $(this).val().length : 0;
            let displayText = selectedCount > 0 ?
                getDisplayText(selectedCount, totalUsers, locale) :
                "{{ trns('select_topic') }}";

            $('#topic_id').next('.select2-container')
                .find('.select2-selection__rendered')
                .html(`<span class="select-display">${displayText}</span>`);
        }).trigger('change');

        function getDisplayText(selectedCount, total, locale) {
            if (locale === 'ar') {
                return "{{ trns('selected') }}" + ` ${selectedCount} {{ trns('from') }} ${total}`;
            } else {
                return "{{ trns('selected') }}" + ` ${selectedCount} {{ trns('from') }} ${total}`;
            }
        }
    });



    $(document).ready(function() {
        initializeSelect2WithSearchCustom('#agenda_id');

        let totalUsers = {{ count($users) }};
        let locale = "{{ app()->getLocale() }}";

        $('#agenda_id').on('change', function() {
            let selectedCount = $(this).val() ? $(this).val().length : 0;
            let displayText = selectedCount > 0 ?
                getDisplayText(selectedCount, totalUsers, locale) :
                "{{ trns('select_agenda') }}";

            $('#agenda_id').next('.select2-container')
                .find('.select2-selection__rendered')
                .html(`<span class="select-display">${displayText}</span>`);
        }).trigger('change');

        function getDisplayText(selectedCount, total, locale) {
            if (locale === 'ar') {
                return "{{ trns('selected') }}" + ` ${selectedCount} {{ trns('from') }} ${total}`;
            } else {
                return "{{ trns('selected') }}" + ` ${selectedCount} {{ trns('from') }} ${total}`;
            }
        }
    });


    $('#association_id').on('change', function() {
        let associationId = $(this).val();

        if (!associationId) {
            $('#admin_name').val('');
            $('#owner_id').val('');
            return;
        }

        $.ajax({
            url: "{{ route('meetings.getOwners', ':id') }}".replace(':id', associationId),
            type: 'GET',
            success: function(response) {
                if (response.status === 200 && response.user) {
                    $('#admin_name').val(response.user.name); // يعرض الاسم
                    $('#owner_id').val(response.user.id); // يخزن id في الفورم
                } else {
                    $('#admin_name').val('');
                    $('#owner_id').val('');
                    Swal.fire({
                        icon: 'error',
                        title: "{{ trns('error') }}",
                        text: response.message || "{{ trns('something_went_wrong') }}"
                    });
                }
            },
            error: function() {
                $('#admin_name').val('');
                $('#owner_id').val('');
                Swal.fire({
                    icon: 'error',
                    title: "{{ trns('error') }}",
                    text: response.message || "{{ trns('failed_to_load_user') }}"
                });
            }
        });
    });
</script>
