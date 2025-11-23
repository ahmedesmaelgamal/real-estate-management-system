<div class="modal-header">
    <h5 class="modal-title">{{ trns('edit_owners') }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form id="editOwnersForm" method="POST" enctype="multipart/form-data" action="{{ $updateRoute }}">
    @csrf
    <div class="modal-body">
        <div class="owners-container">
            <!-- Existing owners will be added here -->
            @if (isset($obj->unitOwners) && count($obj->unitOwners) > 0)
                @foreach ($obj->unitOwners as $index => $owner)
                    <div class="owner-row row mb-3 align-items-end">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">{{ trns('select owner') }}</label>
                                <select class="form-control owner-select" name="user_ids[]" required>
                                    <option value="" disabled>{{ trns('select owner') }}</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $owner->user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{--                        <div class="col-md-4"> --}}
                        {{--                            <div class="form-group"> --}}
                        {{--                                <label class="form-control-label">{{ trns('percentage') }}</label> --}}
                        {{--                                <div class="input-group"> --}}
                        {{--                                    <input type="number" class="form-control percentage-input" name="percentages[]" --}}
                        {{--                                           min="1" --}}
                        {{--                                           max="100" placeholder="0-100" value="{{ $owner->percentage }}" required> --}}
                        {{--                                    <div class="input-group-append"> --}}
                        {{--                                        <span class="input-group-text">%</span> --}}
                        {{--                                    </div> --}}
                        {{--                                </div> --}}
                        {{--                            </div> --}}
                        {{--                        </div> --}}
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-remove-owner"
                                {{ $loop->first ? 'disabled' : '' }}>
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Initial empty row if no owners exist -->
                <div class="owner-row row mb-3 align-items-end">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">{{ trns('select owner') }}</label>
                            <select class="form-control owner-select" name="user_ids[]" required>
                                <option value="" selected disabled>{{ trns('select owner') }}</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label">{{ trns('percentage') }}</label>
                            <div class="input-group">
                                <input type="number" class="form-control percentage-input" name="percentages[]"
                                    min="1" max="100" placeholder="0-100" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-remove-owner" disabled>
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <div class="text-right mb-3">
            <button type="button" id="btnAddOwner" class="btn btn-primary">
                <i class="fas fa-plus"></i> {{ trns('add owner') }}
            </button>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trns('close') }}</button>
        <button type="submit" class="btn btn-primary" id="ajaxSubmitBtn"> {{ trns('save changes') }}</button>
    </div>
</form>
@include('admin/layouts/NewmyAjaxHelper')
<script>
    $(document).ready(function() {
        // Initialize Select2 for all existing owner selects
        $('.owner-select').select2({
            dropdownParent: $('#editOwnersForm').closest('.modal-content'),
            placeholder: "{{ trns('select owner') }}"
        });

        // Add new owner row
        $('#btnAddOwner').click(function() {
            const $template = $('.owner-row:first').clone();
            const $ownersContainer = $('.owners-container');

            // Clear values in the new row
            $template.find('.owner-select').val('').trigger('change');
            $template.find('.percentage-input').val('');
            $template.find('.btn-remove-owner').prop('disabled', false);

            // Add the new row
            $ownersContainer.append($template);

            // Initialize Select2 for the new select
            $template.find('.owner-select').select2({
                dropdownParent: $('#editOwnersForm').closest('.modal-content'),
                placeholder: "{{ trns('select owner') }}"
            });
        });

        // Remove owner row
        $(document).on('click', '.btn-remove-owner', function() {
            if ($('.owner-row').length > 1) {
                $(this).closest('.owner-row').remove();
                // Recalculate percentages if needed
                checkPercentageTotal();
            }
        });

        // Validate percentage sum
        function checkPercentageTotal() {
            let total = 0;
            $('.percentage-input').each(function() {
                const value = parseFloat($(this).val()) || 0;
                total += value;
            });

            if (total > 100) {
                toastr.error('Total percentage cannot exceed 100%');
                return false;
            }
            return true;
        }

        $(document).on('change', '.percentage-input', function() {
            checkPercentageTotal();
        });

        // Form submission
        $('#editOwnersForm').on('submit', function(e) {
            if (!checkPercentageTotal()) {
                e.preventDefault();
                return false;
            }
            return true;
        });

        $('#ajaxSubmitBtn').click(function(e) {
            e.preventDefault();

            if (!checkPercentageTotal()) {
                return false;
            }

            // Prepare form data
            const form = $('#editOwnersForm');
            const formData = new FormData(form[0]);

            // Manually add user_ids and percentages in correct format
            // formData.delete('user_ids[]');
            // formData.delete('percentages[]');

            $('.owner-row').each(function() {
                const userId = $(this).find('.owner-select').val();
                const percentage = $(this).find('.percentage-input').val();
                console.log(percentage)
                if (userId && percentage) {
                    formData.append('user_ids[]', userId);
                    formData.append('percentages[]', percentage);
                }
            });

            $('#ajaxSubmitBtn').click(function(e) {
                e.preventDefault();

                if (!checkPercentageTotal()) {
                    return false;
                }

                // Prepare form data - start fresh
                const formData = new FormData();

                // Add CSRF token
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                // Add method spoofing for PUT if needed
                // formData.append('_method', 'PUT');

                // Collect user_ids and percentages
                const user_ids = [];
                const percentages = [];

                $('.owner-row').each(function() {
                    const userId = $(this).find('.owner-select').val();
                    const percentage = $(this).find('.percentage-input').val();

                    if (userId && percentage) {
                        user_ids.push(userId);
                        percentages.push(percentage);
                    }
                });

                // Add arrays to formData properly
                user_ids.forEach((id, index) => {
                    formData.append('user_ids[]', id);
                    formData.append('percentages[]', percentages[index]);
                });

                $.ajax({
                    url: $('#editOwnersForm').attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 200) {
                            toastr.success(response.message);
                            $('#editOwners').modal('hide');
                            // reloadDataTableIfExists();
                        } else {
                            toastr.warning(response.message ||
                                'Operation completed with unexpected response');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            toastr.error(xhr.responseJSON.message);
                        } else {
                            toastr.error(
                                'An error occurred while processing your request'
                                );
                        }
                    }
                });
            });
        });
    });
</script>

<style>
    .owner-row {
        transition: all 0.3s ease;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .owner-row:hover {
        background-color: #e9ecef;
    }

    .btn-remove-owner {
        margin-bottom: 1rem;
    }

    .input-group-text {
        min-width: 40px;
        justify-content: center;
    }
</style>
