<!-- <div class="modal-body"> -->
    <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{ $updateRoute }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $obj->id }}" name="id">
        <div class="row">


        <div class="col-6">
                <div class="form-group">
                    <label for="name" class="form-control-label">{{ trns('name') }}</label>
                    <input value="{{ $obj->name }}" type="text" class="form-control" name="name"
                        id="name">
                </div>
            </div>



            <div class="col-6">
                <div class="form-group">
                    <label for="national_id" class="form-control-label">{{ trns('national_id') }}</label>
                    <input value="{{ $obj->national_id }}"
                        oninput="if(this.value.length > 10) this.value = this.value.slice(0, 10);"
                        placeholder="Enter 10-digit" type="number" class="form-control" name="national_id"
                        id="national_id">
                </div>
            </div>


            <div class="col-6">
                <label for="email" class="form-control-label mr-2">{{ trns('email') }}</label>
                <input type="text" value="{{ $obj->email }}" class="form-control" name="email">
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
                        <input type="text" value="{{ substr($obj->phone, 3) }}" style="border-radius: 5px 0 0 5px;"
                            oninput="if(this.value.length > 10) this.value = this.value.slice(0, 10);"
                            placeholder="Enter 10-digit " class="form-control" name="phone">
                    </div>
                </div>
            </div>

            <div class="col-12">
                <label>{{ trns('status') }}</label>
                <select name="status" class="form-control" id="statusSelect">
                    <option {{ $obj->status == 1 ? 'selected' : '' }} value="1">{{ trns('active') }}</option>
                    <option {{ $obj->status == 0 ? 'selected' : '' }} value="0">{{ trns('inactive') }}</option>
                </select>
            </div>



            {{-- <div class="col-6">
                <div class="form-group">
                    <label for="password" autocomplete="new-password"
                        class="form-control-label">{{ trns('password') }}</label>
                    <input type="password" class="form-control" autocomplete="new-password" name="password"
                        id="password">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="password_confirmation" autocomplete="new-password"
                        class="form-control-label">{{ trns('password_confirmation') }}</label>
                    <input type="password" class="form-control" autocomplete="new-password" name="password_confirmation"
                        id="password_confirmation">
                </div>
            </div> --}}





        </div>
    </form>
<!-- </div> -->


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
