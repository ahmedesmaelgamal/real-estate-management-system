@extends('admin/layouts/master')
@section('title')
    {{ config()->get('app.name') }} | {{ trns('create_admin') }}
@endsection
@section('page_name')
    <a href="{{ route('admins.index') }}">
        {{ trns('admin') }}
    </a>
@endsection
@section('content')
    <div class="">
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
        <!-- <h2 class="fw-bold mb-5" style="color: #00193a;">{{ trns('create new admin') }}</h2> -->
        <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{ $storeRoute }}">
            @csrf
            <input type="hidden" name="submit_type" value=1>
            <div>
                <div class="d-flex justify-content-between">
                    <h2 class="fw-bold mb-5" style="color: #00193a;">{{ trns('create new admin') }}</h2>
                    <div class="">
                        <a href="{{ route('admins.index') }}" style="transform: rotate(180deg); border: 1px solid gray;"
                            class="btn">
                            <i class="fas fa-long-arrow-alt-right"></i>
                        </a>
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
                            <input type="number" class="form-control" name="national_id" id="national_id">
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
                                <input type="text" class="form-control" name="email" id="email" pattern="^[^@]+$"
                                    style="border-radius: 5px 0 0 5px;" title="Please enter only the main username">

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
                                <input type="number" class="form-control" name="phone" id="phone" pattern="^\d+$"
                                    style="border-radius: 5px 0 0 5px;" title="Please enter digits only, no + or symbols">

                            </div>
                        </div>
                    </div>



                    {{--                    <div class="col-6"> --}}
                    {{--                        <div class="form-group"> --}}
                    {{--                            <label for="code" class="form-control-label">{{ trns('code') }}</label> --}}
                    {{--                            <span class="form-control text-center">{{ $code }}</span> --}}
                    <input hidden type="hidden" class="form-control" name="code" value="{{ $code }}"
                        id="code">
                    {{--                        </div> --}}
                    {{--                    </div> --}}

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

                    <div class="col-6">
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
                    {{-- <div class="col-6">
                <div class="form-group">
                    <input type="hidden" class="form-control" name="user_name" id="user_name">
                </div>
            </div> --}}

                    <input name="submit_type" id="submit_type" type="hidden">
                    <input type="hidden" name="singlePageCreate" value="1">
                </div>

                <div class="d-flex justify-content-end mt-5">
                    <button type="submit" name="submit_type" value="create_and_stay" class="btn m-2"
                        onclick="document.getElementById('submit_type').value='create_and_stay';"
                        style="padding: 5px 50px; font-size: 16px; font-weight: bold; background-color: #DFE3E7; color: #676767; width: 50%;">{{ trns('create_and_add_another') }}</button>
                    <button type="submit" name="submit_type" value="create_and_redirect" class="btn m-2"
                        onclick="document.getElementById('submit_type').value='create_and_redirect';"
                        style="background-color: #00193a; color: #00F3CA; border: none;padding: 5px 50px; margin-left: 10px; font-size: 16px; font-weight: bold; width: 50%;">{{ trns('create') }}</button>

                </div>
            </div>
        </form>
    </div>

    @include('admin.layouts.myAjaxHelper')
@endsection

@section('ajaxCalls')
    <script>
        $('.dropify').dropify();

        {{-- showAddModal('{{ route('admins.create') }}'); --}}
        addScript();

        $('.dropify').dropify();


        $('#role_id').select2({
            placeholder: "{{ trns('select') }}",
        });


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
    </script>
@endsection
