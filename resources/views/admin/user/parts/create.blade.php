<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{ $storeRoute }}">
        @csrf
        <div class="row">



        <div class="col-6">
                <div class="form-group">
                    <label for="name" class="form-control-label">{{ trns('name') }}</label>
                    <input type="text" class="form-control" name="name" id="name">
                </div>
            </div>

            
            <div class="col-6">
                <div class="form-group">
                    <label for="national_id" class="form-control-label">{{ trns('national_id') }}</label>
                    <input type="number" class="form-control"
                        name="national_id" id="national_id" value="{{ old('national_id') }}" required>


                </div>
            </div>


            <div class="col-6">
                <label for="email" class="form-control-label mr-2">{{ trns('email') }}</label>
                <input type="text" class="form-control" name="email" id="email">
            </div>


            <div class="col-6">
                <label for="phone" class="form-control-label">{{ trns('phone_number') }}</label>
                <div class="form-group d-flex align-items-center">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                966+
                            </span>
                        </div>
                        <input type="number" class="form-control" name="phone" id="phone"
                            style="border-radius: 5px 0 0 5px;" pattern="^\d+$"
                            title="Please enter digits only, no + or symbols">
                    </div>
                </div>
            </div>


            <div class="col-12">
                <label>{{ trns('status') }}</label>
                <select name="status" class="form-control" id="statusSelect">
                    <option value=1>{{ trns('active') }}</option>
                    <option value=0>{{ trns('inactive') }}</option>
                </select>
            </div>

        </div>

        {{-- <div class="d-flex">
            <button type="button" class="btn m-2 fw-bold fs-6" style="background-color: #DFE3E7; color: #676767; width:50%;" data-bs-dismiss="modal">{{ trns('close') }}</button>
            <button type="submit" class="btn m-2 fw-bold fs-6" style="background-color: #00193A; color: #00F3CA; width:50%;" id="addButton">{{ trns('create') }}</button>
        </div> --}}


    </form>
</div>


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


    initializeSelect2InModal('#statusSelect');
</script>
