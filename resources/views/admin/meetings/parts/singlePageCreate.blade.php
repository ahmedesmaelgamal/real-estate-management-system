@extends('admin/layouts/master')

@section('title')
    {{ config()->get('app.name') }} | {{ trns('create_meeting') }}
@endsection

@section('page_name')
    {{ trns('create_new_meeting') }}
@endsection

@section('content')
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


    <div>


        <form id="addForm" class="addForm " method="POST" enctype="multipart/form-data" action="{{ $storeRoute }}">
            @csrf


            <div
                style="display: flex; margin-top: 20px; margin-bottom: 50px; justify-content: space-between; margin-bottom:20px;">
                <div>
                    <h2 class="fw-bold" style="color: #00193a; margin-bottom: 0px;">{{ trns('create_new_meet') }}</h2>
                    <h4 class="fw-bold " style="color: #00193a; margin-top: 30px;">{{ trns('main_information') }}</h4>
                    <small>{{ trns('you_can_contral_main_information_for_teem_from_here') }}</small>
                </div>
                {{-- <a href="{{ route('votes.index') }}" style="transform: rotate(180deg); margin-top: 20px; border: 1px solid gray;" class="btn">
                    <i class="fas fa-long-arrow-alt-right fa-lg"></i>
                </a> --}}
            </div>
            <div class="row">

                {{-- Association --}}
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="association_id_single_page">{{ trns('association') }} <span
                                class="text-danger">*</span></label>
                        <select class="form-control select2" id="association_id_single_page" name="association_id" required>
                            <option value="" selected disabled>{{ trns('select_association') }}</option>
                            @foreach ($associations as $association)
                                <option value="{{ $association->id }}">{{ $association->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Admin (auto-filled from association) --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="admin_name_single_page">{{ trns('association_owner') }} <span
                                class="text-danger">*</span></label>
                        <input type="text" id="admin_name_single_page" class="form-control" readonly>
                        <input type="hidden" id="owner_id_single_page" name="owner_id">
                    </div>
                </div>

                {{-- Users --}}
                <div class="col-12">
                    <div class="form-group">
                        <label for="users_id_select">{{ trns('users') }} <span class="text-danger">*</span></label>
                        <select class="form-control select2" multiple id="users_id_select" name="users_id[]" required>
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
                        <label for="topic_id_select">{{ trns('topic') }} <span class="text-danger">*</span></label>
                        <select class="form-control select2" multiple id="topic_id_select" name="topic_id[]" required>
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

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="date">{{ trns('date_and_time') }} <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" id="date" name="date" required
                            onclick="this.showPicker()">
                    </div>
                </div>






                {{-- Address --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="address">{{ trns('enter_meeting_address') }} <span
                                class="text-danger">*</span></label>
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
                            <div>
                                <h4 class="form-control-label" style="display:block">
                                    {{ trns('agenda') }}
                                </h4>
                                <label class="form-control-label">
                                    {{ trns('agenda') . ' ' . trns('(guide_line)') }}
                                </label>
                            </div>
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
                        {{-- <div class="d-flex justify-content-between"> --}}
                            
                            <div style="display:flex; justify-content: flex-end;">
                                <button type="button" class="createAgenda  btn btn-icon text-white">
                                    {{ trns('create_agenda') }}
                                </button>
                            </div>
                        {{-- </div> --}}
                    </div>
                </div>



            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" name="submit_type" value="create_and_stay" class="btn m-2"
                    style="padding: 5px 50px; font-size: 16px; font-weight: bold; background-color: #DFE3E7; color: #676767; width: 50%;">{{ trns('create_and_add_another') }}</button>
                <button type="submit" id="submitMeet" name="submit_type" value="create_and_redirect" class="btn m-2"
                    style="background-color: #00193a; color: #00F3CA; border: none;padding: 5px 50px; margin-left: 10px; font-size: 16px; font-weight: bold; width: 50%;">{{ trns('create') }}</button>
            </div>


        </form>
    </div>

    <style>
        .select-display {
            background-color: #343a40;
            color: #fff;
            padding: 3px 20px;
            border-radius: 8px;
            display: inline-block;
            font-weight: 500;
        }
    </style>
    <style>
        .select-display {
            background-color: #343a40;
            color: #fff;
            padding: 3px 20px;
            border-radius: 8px;
            display: inline-block;
            font-weight: 500;
            display: none;
        }


        .select2-container--default .select2-selection--multiple {
            padding: 0.305rem 0.60rem;
        }

        /* 👇 خاص بـ agenda فقط نفس الشكل لكن أصغر */
        #agendaTextDisplay {
            background-color: #343a40;
            color: #fff;
            padding: 6px 20px;
            border-radius: 8px;
            display: inline-block;
            font-weight: 500;
            font-size: 12px;
            /* تصغير الحجم فقط */
        }
    </style>
@endsection

@include('admin/layouts/myAjaxHelper')

@section('ajaxCalls')
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
                    <div class="card custom-checkbox-card "
                        >
                        <input class="form-check-input d-none" type="checkbox" name="agenda_id[]"
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





        // delete agenda 
        $(document).on('click', '.delete_agenda_btn', function() {
            let agendaId = $(this).data('id');

            $.ajax({
                url: "{{ route('agenda.destroy', ':id') }}".replace(':id', agendaId),
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    $(`.delete_agenda_btn[data-id="${agendaId}"]`).closest('.col-12').fadeOut(300,
                        function() {
                            $(this).remove();
                        });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: "{{ trns('error') }}",
                        text: response.message || "{{ trns('something_went_wrong') }}"
                    });
                }
            });
        });

        $(document).ready(function() {
            $('#topic_id_select').on('change', function() {
                let selectedValues = $(this).val() || [];

                if (selectedValues.includes('other')) {
                    $('#other_topic_wrapper').show();
                } else {
                    $('#other_topic_wrapper').hide();
                    $('#other_topic').val(''); // clear input when hidden
                }
            });
        });



        $(document).ready(function() {
            // When association changes
            $('#association_id_single_page').on('change', function() {
                let associationId = $(this).val();

                if (!associationId) return;


                // 🟡 نحتفظ بخيار "Select All" حتى بعد التغيير
                let selectAllOption =
                    '<option value="all" id="select_all_option">{{ trns('select_all') }}</option>';

                $.ajax({
                    url: '{{ route('getUserMeetByAssociation', ':id') }}'.replace(':id',
                        associationId),
                    type: 'GET',
                    beforeSend: function() {
                        $('#users_id_select').html(
                            '<option disabled selected>{{ trns('loading_users') }}...</option>'
                        );
                    },
                    success: function(response) {
                        // build select all option (keep it)
                        let selectAllOptionHtml =
                            '<option value="all" id="select_all_option">{{ trns('select_all') }}</option>';

                        $('#users_id_select').empty();
                        $('#users_id_select').append(selectAllOptionHtml);

                        if (response.users && response.users.length > 0) {
                            $.each(response.users, function(index, user) {
                                // add option with data-name = actual user name
                                // value = user.id, text = user.name
                                let $opt = $('<option>')
                                    .val(user.id)
                                    .text(user.name)
                                    .attr('data-name', user.name);
                                $('#users_id_select').append($opt);
                            });
                        } else {
                            $('#users_id_select').append(
                                '<option disabled>{{ trns('no_users_found') }}</option>');
                        }

                        // Reinitialize select2 (keep your existing select2 settings)
                        $('#users_id_select').select2({
                            allowClear: true
                        });

                        // counting and display logic
                        let totalUsers = response.users ? response.users.length : 0;
                        let locale = "{{ app()->getLocale() }}";

                        $('#users_id_select').off('change.countDisplay').on(
                            'change.countDisplay',
                            function() {
                                let selectedValues = $(this).val() || [];

                                // If Select All chosen -> actually select all IDs
                                if (selectedValues.includes('all')) {

                                    // toggle unselect all if already all selected
                                    if (selectedValues.length == totalUsers) {
                                        $("#users_id_select").val('');
                                        $("#select_all_option").text(
                                            "{{ trns('select_all') }}");
                                        return;
                                    }

                                    let allUserIds = response.users.map(u => u.id
                                        .toString());
                                    $(this).val(allUserIds).trigger('change.select2');
                                    selectedValues = allUserIds;
                                    $("#select_all_option").text(
                                        "{{ trns('unselect_all') }}");
                                }



                                $('#users_id_select').on('select2:select', function(e) {
                                    if (!e.params || !e.params.data) return;

                                    let clicked = e.params.data.id && e.params.data
                                        .id.toString();

                                    if (clicked === 'all') {
                                        let current = $(this).val() || [];

                                        if (current.length === (response.users ?
                                                response.users.length : 0)) {
                                            $(this).val([]).trigger(
                                                'change.select2');

                                            $('#users_id_select').find(
                                                '#select_all_option').text(
                                                "{{ trns('select_all') }}");
                                            $('#users_id_select').select2().trigger(
                                                'change.select2');

                                            // ✅ change display text to default
                                            $('#users_id_select').next(
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



                                        $('#users_id_select').find(
                                            '#select_all_option').text(
                                            "{{ trns('unselect_all') }}");
                                        $('#users_id_select').select2().trigger(
                                            'change.select2');



                                        // ✅ change display text to full selected
                                        $('#users_id_select').next(
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
                                let displayText = selectedCount > 0 ?
                                    "{{ trns('selected') }}" +
                                    ` ${selectedCount} {{ trns('from') }} ${totalUsers}` :
                                    "{{ trns('select_users') }}";

                                // --- IMPORTANT: switch displayed option texts between names and ids ---
                                if (selectedCount === totalUsers && totalUsers > 0) {
                                    // ALL selected -> show numbers (IDs) instead of names
                                    // $('#users_id_select option').each(function() {
                                    //     // skip disabled or the "all" option
                                    //     if ($(this).is(':disabled') || $(this)
                                    //         .val() === 'all') return;
                                    //     // set visible text to the option value (ID)
                                    //     $(this).text($(this).val());
                                    // });
                                } else {
                                    // Not all -> restore original names from data-name
                                    $('#users_id_select option').each(function() {
                                        if ($(this).is(':disabled') || $(this)
                                            .val() === 'all') return;
                                        let originalName = $(this).attr(
                                            'data-name') || $(this).text();
                                        $(this).text(originalName);
                                    });
                                }

                                // Refresh select2 rendered area manually to show our changes
                                $('#users_id_select').trigger('change.select2');

                                // Finally set the custom top display (selected X from Y)
                                $('#users_id_select').next('.select2-container')
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
                        $('#users_id_select').html(
                            '<option disabled>{{ trns('error_loading_users') }}</option>'
                        );
                    }
                });
            });

        });


        //  select2 with count for users 
        $(document).ready(function() {
            initializeSelect2WithSearchCustom('#users_id_select');

            let totalUsers = {{ count($users) }};
            let locale = "{{ app()->getLocale() }}";

            $('#users_id_select').on('change', function() {
                let selectedCount = $(this).val() ? $(this).val().length : 0;
                let displayText = selectedCount > 0 ?
                    getDisplayText(selectedCount, totalUsers, locale) :
                    "{{ trns('select_users') }}";

                $('#users_id_select').next('.select2-container')
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
            initializeSelect2WithSearchCustom('#topic_id_select');

            // 🧩 احسب العدد الصحيح للـ topics مش الـ users
            let totalTopics = $('#topic_id_select option').length;
            let locale = "{{ app()->getLocale() }}";

            $('#topic_id_select').on('change', function() {
                let selectedCount = $(this).val() ? $(this).val().length : 0;
                let displayText = selectedCount > 0 ?
                    getDisplayText(selectedCount, totalTopics, locale) :
                    "{{ trns('select_topic') }}";

                // 🟢 زي ما انت عامل في الـ agenda
                $('#topic_id_select').next('.select2-container')
                    .find('.select2-selection__rendered')
                    .html(`
                <span 
                    id="topicTextDisplay" 
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
                    .html(`
                        <span 
                            id="agendaTextDisplay" 
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
            }).trigger('change');

            function getDisplayText(selectedCount, total, locale) {
                if (locale === 'ar') {
                    return "{{ trns('selected') }}" + ` ${selectedCount} {{ trns('from') }} ${total}`;
                } else {
                    return "{{ trns('selected') }}" + ` ${selectedCount} {{ trns('from') }} ${total}`;
                }
            }
        });

        $('.select2').select2();

        $(document).ready(function() {

            $('.addForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $('#addButton').prop('disabled', true).html(
                            '<span class="spinner-border spinner-border-sm mr-2"></span> {{ trns('loading...') }}'
                        );
                    },
                    success: function(response) {
                        $('#addButton').prop('disabled', false).html('{{ trns('add') }}');

                        if (response.status === 200) {
                            Swal.fire({
                                title: '<span style="display:block;margin-bottom:10px;">' +
                                    (response.mymessage ||
                                        '{{ trns('added_successfully') }}') +
                                    '</span>',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1000
                            });

                            setTimeout(() => {
                                window.location.href =
                                    "{{ route('meetings.index') }}";
                            }, 1000);

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ trns('error') }}',
                                text: response.mymessage ||
                                    '{{ trns('something_went_wrong') }}'
                            });
                        }
                    },
                    error: function(xhr) {
                        $('#addButton').prop('disabled', false).html('{{ trns('add') }}');

                        let messages = [];

                        // إذا validation failed
                        if (xhr.status === 422) {
                            if (xhr.responseJSON.errors) {
                                $.each(xhr.responseJSON.errors, function(field, msgs) {
                                    msgs.forEach(function(msg) {
                                        messages.push(msg);
                                    });
                                });
                            }
                            if (xhr.responseJSON.message) {
                                messages.push(xhr.responseJSON.message);
                            }

                            Swal.fire({
                                icon: 'error',
                                title: '{{ trns('validation_error') }}',
                                html: messages.join('<br>')
                            });

                        } else if (xhr.status === 500) {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ trns('server_error') }}',
                                text: xhr.responseJSON?.mymessage ||
                                    '{{ trns('internal_server_error') }}'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ trns('error') }}',
                                text: xhr.responseJSON?.mymessage ||
                                    '{{ trns('something_went_wrong') }}'
                            });
                        }
                    }
                });

            });

        });









        $('#users_id_select').select2();

        $('#association_id_single_page').on('change', function() {
            let associationId = $(this).val();

            if (!associationId) {
                $('#admin_name_single_page').val('');
                $('#owner_id_single_page').val('');
                return;
            }

            $.ajax({
                url: "{{ route('meetings.getOwners', ':id') }}".replace(':id', associationId),
                type: 'GET',
                success: function(response) {
                    if (response.status === 200 && response.user) {
                        $('#admin_name_single_page').val(response.user.name); // يعرض الاسم
                        $('#owner_id_single_page').val(response.user.id); // يخزن id في الفورم
                    } else {
                        $('#admin_name_single_page').val('');
                        $('#owner_id_single_page').val('');
                        Swal.fire({
                            icon: 'error',
                            title: "{{ trns('error') }}",
                            text: response.message || "{{ trns('something_went_wrong') }}"
                        });

                    }
                },
                error: function() {
                    $('#admin_name_single_page').val('');
                    $('#owner_id_single_page').val('');
                    Swal.fire({
                        icon: 'error',
                        title: "{{ trns('error') }}",
                        text: response.message || "{{ trns('failed_to_load_user') }}"
                    });
                }
            });
        });
    </script>
@endsection


{{-- $2y$10$zqm2eDLC53LtAkAkHx/Mve2tyxOhlEelsVq/hQ0uZCZnBkZoQ.Gqq --}}
