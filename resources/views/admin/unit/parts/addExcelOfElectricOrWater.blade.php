<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <label for="excel_file" class="form-control-label">
            {{ trns('attach_water_or_electric_file') }}
        </label>

        <a class="btn btn-icon text-white" href="{{ asset('unit_electric_or_water_example.xlsx') }}">
            <span><i class="fe fe-download"></i></span>
            {{ trns('download_example') }}
        </a>
    </div>

    @if (session('import_errors'))
        <div class="alert alert-danger">
            <h5>{{ trns('import_errors') }}</h5>
            <ul>
                @foreach (session('import_errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form id="excel-import-form-electric-or-water-of-unit" method="POST" enctype="multipart/form-data" action="{{ $storeExcelOfElectricOrWaterRoute }}">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="form-group">

                    <input type="file" class="form-control dropify" name="excel_file" accept=".xlsx, .xls, .csv"
                        id="excel_file" required>
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
            <button type="submit" class="btn btn-one" id="addExcelOfElectricOrWaterButton">
                {{ trns('import') }}
            </button>
        </div>
    </form>
</div>

<script>
    $('.dropify').dropify();
</script>


