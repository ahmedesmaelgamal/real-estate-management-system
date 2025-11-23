<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{ $storeRoute }}">
        @csrf



        <div>
            <div class="d-flex justify-content-between">
                <!-- <h2 class="fw-bold mb-5" style="color: #00193a;">{{ trns('create new admin') }}</h2> -->
                <div class="">
                    {{-- <a href="{{ route('admins.index') }}" style="transform: rotate(180deg); border: 1px solid gray;"
                            class="btn">
                            <i class="fas fa-long-arrow-alt-right"></i>
                        </a> --}}
                </div>
            </div>
            <div class="row">


            <div class="col-6">
                    <div class="form-group">
                        <label for="name" class="form-control-label">{{ trns('admin_name') }}</label>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>
                </div>

                
                <div class="col-6">
                    <div class="form-group">
                        <label for="national_id" class="form-control-label">{{ trns('national_id') }}</label>
                        <input type="number" class="form-control" max="10" name="national_id" id="national_id">
                    </div>
                </div>

                <input type="hidden" class="form-control" name="code" id="code">

                <script>
                    // Generate random code and set it to the hidden input on page load
                    document.addEventListener('DOMContentLoaded', function() {
                        let code = Math.floor(10000000 + Math.random() * 90000000);
                        document.getElementById('code').value = code;
                    });
                </script>





                <div class="col-6">
                    <label for="email" class="form-control-label mr-2">{{ trns('email') }}</label>
                    <div class="form-group d-flex align-items-center">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    edarat365.com@
                                </span>
                            </div>
                            <input type="text" class="form-control" id="email" name="email" maxlength="15"
                                style="border-radius: 5px 0 0 5px;" pattern="^[^@]+$"
                                oninput="this.value = this.value.replace(/@/g, '')">
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
                            <input type="number" id="phone" class="form-control" name="phone"
                                style="border-radius: 5px 0 0 5px;" pattern="^\d+$">
                        </div>
                    </div>
                </div>

                {{--                    <div class="col-6"> --}}
                {{--                        <div class="form-group"> --}}
                {{--                            <label for="code" class="form-control-label">{{ trns('code') }}</label> --}}
                {{--                            <span class="form-control text-center">{{ $code }}</span> --}}
                {{--                            <input hidden type="hidden" class="form-control" name="code" value="{{ $code }}" --}}
                {{--                                id="code"> --}}
                {{--                        </div> --}}
                {{--                    </div> --}}
                <input hidden type="hidden" class="form-control" name="code" value="{{ $code }}">
                {{-- <div class="col-12">
                        <div class="form-group">
                            <label for="name" class="form-control-label">{{ trns('role') }}</label>
                            <input type="text" class="form-control" name="name" id="name">
                            <select id="role_id" name="role_id" class="form-control">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div> --}}





                {{-- <div class="col-6">
                        <div class="form-group">
                            <label for="password" autocomplete="new-password" class="form-control-label">{{ trns('password') }}</label>
                            <input type="password" autocomplete="new-password" class="form-control" name="password" id="password">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="password" autocomplete="new-password" class="form-control-label">{{ trns('password_confirmation') }}</label>
                            <input type="password" autocomplete="new-password" class="form-control" name="password_confirmation" id="password">
                        </div>
                    </div> --}}

                <div class="col-12">
                    <div class="form-group">
                        <label for="name" class="form-control-label">{{ trns('role') }}</label>
                        {{--                    <input type="text" class="form-control" name="name" id="name"> --}}
                        <select id="role_id" name="role_id" class="form-control">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
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
