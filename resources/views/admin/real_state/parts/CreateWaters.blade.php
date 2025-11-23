<form method="POST" id="addElectricOrWaterForm" class="addForm2" enctype="multipart/form-data" action="{{ $storeRoute }}">
    @csrf
    <div class="row ">
        <input type="hidden" name="real_state_id" value="{{ $realStateId }}">
        <div class="row ">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="water_name" class="form-control-label">{{ trns('meter_name') }} <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="water_name" name="water_name" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="water_account_number" class="form-control-label">{{ trns('water_account_number') }}
                        <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="water_account_number" id="water_account_number">
                </div>
            </div>





            <div class="col-6">
                <div class="form-group">
                    <label for="water_meter_number" class="form-control-label">{{ trns('water_meter_number') }}
                        <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="water_meter_number" id="water_meter_number">
                </div>
            </div>




        </div>
</form>


@section('ajaxCalls')
@endsection
