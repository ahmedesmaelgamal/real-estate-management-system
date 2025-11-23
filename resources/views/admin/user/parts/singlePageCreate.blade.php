@extends('admin/layouts/master')

@section('title')
    {{ config()->get('app.name') }} | {{ trns('create_user') }}
@endsection
@section('page_name')
    {{ trns('create_new_owner') }}
@endsection
@section('content')
    <div>
    <!-- Create Or Edit Modal -->
        <div class="modal fade" id="editOrCreate" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">{{ trns('association_details') }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-body">

                    </div>
                    <div class="modal-footer" id="modal-footer">

                    </div>
                </div>
            </div>
        </div>
        <!-- Create Or Edit Modal -->
        <div class="col-12 w-100">
            <div class="col-6">
                {{--        <h2 class="fw-bold" style="color: #00193a;">{{trns("create_user")}}</h2>      --}}
            </div>

        </div>
        <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{ route('users.store') }}">

            <div style="display: flex; justify-content: space-between; margin-bottom:20px;">
                <h2 class="fw-bold" style="color: #00193a; margin-bottom: 0px;">{{ trns('create_new_owner') }}</h2>
                <a href="{{ route('users.index') }}" style="transform: rotate(180deg); border: 1px solid gray;"
                    class="btn">
                    <i class="fas fa-long-arrow-alt-right fa-lg"></i>
                </a>
            </div>

            <input name="submit_type" id="submit_type" type="hidden">
            <input type="hidden" name="singlePageCreate" value="1">

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
                        <input type="number" class="form-control" min="10" name="national_id">
                    </div>
                </div>





                <div class="col-6">
                    <label for="email" class="form-control-label mr-2">{{ trns('email') }}</label>
                    <div class="form-group d-flex align-items-center">
                        <div class="input-group">
                            <div class="input-group-prepend">

                            </div>
                            <input type="text" class="form-control" name="email" id="email"
                                title="Please enter only the main username">
                        </div>
                    </div>
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
                            <input type="number" class="form-control" min="10" name="phone" id="phone" style="border-radius: 5px 0 0 5px;"
                                pattern="^\d+$" title="Please enter digits only, no + or symbols">
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <label>{{ trns('status') }}</label>
                    <select name="status" class="form-control">
                        <option value=1>{{ trns('active') }}</option>
                        <option value=0>{{ trns('inactive') }}</option>
                    </select>
                </div>

            </div>

            <div class="d-flex justify-content-end mt-5">



                <button type="submit" name="submit_type" value="create_and_redirect" class="btn m-2"
                    onclick="document.getElementById('submit_type').value='create_and_redirect';"
                    style="background-color: #00193a; color: #00F3CA; border: none;padding: 5px 50px; margin-left: 10px; font-size: 16px; font-weight: bold; width: 50%;">{{ trns('create') }}</button>

                <button type="submit" name="submit_type" value="create_and_stay" class="btn m-2"
                    onclick="document.getElementById('submit_type').value='create_and_stay';"
                    style="padding: 5px 50px; font-size: 16px; font-weight: bold; background-color: #DFE3E7; color: #676767; width: 50%;">{{ trns('create_and_add_another') }}</button>
            </div>
        </form>
    </div>
@endsection
@include('admin/layouts/myAjaxHelper')
@section('ajaxCalls')
    <script>
        addScript();



        //
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


        $('#addForm').on('submit', function(e) {
            let nationalIdInput = $('input[name="national_id"]');
            let phoneInput = $('input[name="phone"]');
            let nationalId = nationalIdInput.val();
            let phone = phoneInput.val();
            let valid = true;

            // Remove previous is-invalid classes
            nationalIdInput.removeClass('is-invalid');
            phoneInput.removeClass('is-invalid');

            if (nationalId.length < 9 || nationalId.length > 10) {
            nationalIdInput.addClass('is-invalid');
            valid = false;
            }

            if (phone.length !== 10) {
            phoneInput.addClass('is-invalid');
            valid = false;
            }

            if (!valid) {
            e.preventDefault();
            }
        });
        </script>
    @endsection

