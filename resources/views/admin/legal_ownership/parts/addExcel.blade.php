<div class="modal-body">
    @if(session('import_errors'))
        <div class="alert alert-danger">
            <h5>Import Errors</h5>
            <ul>
                @foreach(session('import_errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form id="excel-import-form" method="POST" enctype="multipart/form-data" action="{{ $storeExcelRoute }}">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="excel_file" class="form-control-label">
                        {{ trns('attach_real_state_file') }}
                    </label>
                    <input type="file" class="form-control" name="excel_file" id="excel_file" required>
                    <small class="text-muted">
                        {{ trns('allowed_formats') }}: .xlsx, .xls, .csv
                        <br>
{{--                        {{ trans('required_columns') }}: name, unified_number, establish_number, establish_date, due_date--}}
                    </small>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                {{ trns('close') }}
            </button>
            <button type="submit" class="btn btn-primary" id="addButton">
                {{ trns('import') }}
            </button>
        </div>
    </form>
</div>

@if(session('success'))
    <script>
        $(document).ready(function() {
            toastr.success("{{ session('success') }}");
            // Reload DataTable if exists
            if (typeof window.dataTable !== 'undefined') {
                window.dataTable.ajax.reload(null, false);
            }
        });
    </script>
@endif
