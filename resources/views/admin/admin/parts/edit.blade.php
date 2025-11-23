<div class="modal-body">
    <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{ $updateRoute }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $admin->id }}" name="id">
        <div class="row">


         <div class="col-6">
                <div class="form-group">
                    <label for="name" class="form-control-label">{{ trns('admin_name') }}</label>
                    <input type="text" class="form-control" name="name" value="{{ $admin->name }}"
                        id="name">
                </div>
            </div>

            
            <div class="col-6">
                <div class="form-group">
                    <label for="national_id" class="form-control-label">{{ trns('national_id') }}</label>
                    <input value="{{ $admin->national_id }}" max="10" type="number" class="form-control"
                        name="national_id" id="national_id">
                </div>
            </div>





            <div class="col-6">
                <label for="email" class="form-control-label mr-2">{{ trns('email') }}</label>
                <div class="form-group d-flex align-items-center">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                edarat365.com@
                            </span>
                        </div>
                        <input type="text" value="{{ strstr($admin->email, '@', true) ?? '' }}" class="form-control" name="email" maxlength="15"
                            pattern="^[^@]+$" style="border-radius: 5px 0 0 5px;"
                          >


                    </div>
                </div>
            </div>

            <div class="col-6">
                <label for="phone" class="form-control-label">{{ trns('phone') }}</label>
                <div class="form-group d-flex align-items-center">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                966+
                            </span>
                        </div>
                        <input type="number" value="{{ substr($admin->phone, 4) }}" class="form-control" max="10"
                            name="phone" style="border-radius: 5px 0 0 5px;" pattern="^\d+$">
                    </div>
                </div>
            </div>


            <div class="col-12">
                <div class="form-group">
                    <label for="name" class="form-control-label">{{ trns('role') }}</label>
                    {{--                    <input type="text" class="form-control" name="name" id="name"> --}}
                    {{--                        @dd($admin->getRoleNames()->first()) --}}
                    <select id="role_id" name="role_id" class="form-control">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @if ($role->name == $admin->getRoleNames()->first()) selected @endif>
                                {{ $role->name }}</option>
                        @endforeach
                    </select>

                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
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
    })

    $('.dropify').dropify();

    initializeSelect2InModal('#role_id');
</script>
