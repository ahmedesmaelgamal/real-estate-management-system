<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <label for="court_case_excel_file" class="form-control-label">
            {{ trns('attach_court_case_file') }}
        </label>

        <a class="btn btn-icon text-white" href="{{ asset('court_case_example.xlsx') }}">
            <span><i class="fe fe-download"></i></span>
            {{ trns('download_example') }}
        </a>
    </div>

    {{-- Import Errors --}}
    @if(session('court_case_import_errors'))
        <div class="alert alert-danger">
            <h5>{{ trns('import_errors') }}</h5>
            <ul>
                @foreach(session('court_case_import_errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- General Error --}}
    @if(session('court_case_error'))
        <div class="alert alert-danger">
            {{ session('court_case_error') }}
        </div>
    @endif

    {{-- Import Form --}}
    <form id="court_case-excel-import-form" method="POST" enctype="multipart/form-data" action="{{ route('court_case.store.excel') }}">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <input type="file" class="form-control dropify" name="court_case_excel_file" accept=".xlsx, .xls, .csv" id="court_case_excel_file" required>
                    <small class="text-muted">
                        {{ trns('allowed_formats') }}: .xlsx, .xls, .csv
                        <br>
                    </small>
                </div>
            </div>
        </div>

        <div class="modal-footer d-flex flex-nowrap">
            <button type="button" class="btn btn-two" data-bs-dismiss="modal">
                {{ trns('close') }}
            </button>
            <button type="submit" class="btn btn-one" id="addcourt_caseExcelButton">
                {{ trns('import') }}
            </button>
        </div>
    </form>
</div>

<script>
    $('.dropify').dropify();
</script>

@if(session('court_case_success'))
    <script>
        $(document).ready(function() {
            toastr.success("{{ session('court_case_success') }}");
            // Reload DataTable if exists
            if (typeof window.dataTable !== 'undefined') {
                window.dataTable.ajax.reload(null, false);
            }
        });
    </script>
@endif

<script>
    $(document).ready(function() {
        // Initialize dropify
        $('.dropify').dropify();

        // Handle Excel import form via AJAX
        $('#court_case-excel-import-form').on('submit', function(e) {
            e.preventDefault(); // Prevent full page reload
            let formData = new FormData(this);
            let $btn = $('#addcourt_caseExcelButton');
            let originalHtml = $btn.html();

            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Importing...');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.status === 200) {
                        toastr.success(response.message);
                        setTimeout(function(){
                            window.location.reload();
                        } , 3000);
                        // Reload DataTable if exists
                        if (typeof window.dataTable !== 'undefined') {
                            window.dataTable.ajax.reload(null, false);
                        }
                    } else if(response.status === 422) {
                        // Validation errors
                        let errorsHtml = '';
                        response.message.forEach(function(err) {
                            errorsHtml += `<li>${err}</li>`;
                        });

                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns("import_errors") }}',
                            html: `<ul>${errorsHtml}</ul>`
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ trns("something_went_wrong") }}',
                        text: xhr.responseJSON?.message || 'Error'
                    });
                },
                complete: function() {
                    $btn.prop('disabled', false).html(originalHtml);
                }
            });
        });
    });
</script>

