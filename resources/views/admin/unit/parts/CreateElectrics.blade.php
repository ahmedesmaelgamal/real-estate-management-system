<form method="POST" id="addElectricOrWaterForm" class="addForm2" enctype="multipart/form-data" action="{{ $storeRoute }}">
    @csrf
    <div class="row ">
        <input type="hidden" name="unit_id" value="{{ $unitId }}">
        <div class="col-md-6">
            <div class="form-group">
                <label for="electric_name" class="form-control-label">{{ trns('meter_name') }} <span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control" id="electric_name" name="electric_name" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="electric_account_number" class="form-control-label">{{ trns('electric_account_number') }}
                    <span class="text-danger">*</span></label>
                <input type="number" min="1" class="form-control" id="electric_account_number"
                    name="electric_account_number" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="electric_subscription_number"
                    class="form-control-label">{{ trns('electric_subscription_number') }} <span
                        class="text-danger">*</span></label>
                <input type="number" min="1" class="form-control" id="electric_subscription_number"
                    name="electric_subscription_number" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="electric_meter_number" class="form-control-label">{{ trns('electric_meter_number') }} <span
                        class="text-danger">*</span></label>
                <input type="number" min="1" class="form-control" id="electric_meter_number"
                    name="electric_meter_number" required>
            </div>
        </div>



    </div>
</form>


@section('ajaxCalls')

@endsection
