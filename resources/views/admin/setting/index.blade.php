@extends('admin/layouts/master')

@section('title')
    {{ config()->get('app.name') }} | {{ $bladeName }}
@endsection
@section('page_name')
    {{ $bladeName }}
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"> {{ $bladeName }}</h3>
        </div>
        <div class="card-body">
            <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{ route('settings.update') }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <input type="hidden" name="key" value="setting">

                    <div class="col-md-12">
                        <div class="p-3 py-5 mt-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{ getFile($settings->where('key', 'logo')->first()->value) }}" class=" "
                                        height="150">
                                </div>

                                <div class="col-md-4">
                                    <img src="{{ getFile($settings->where('key', 'fav_icon')->first()->value) }}"
                                        class="mt-1" height="150">
                                </div>
                                <div class="col-md-4">
                                    <img src="{{ getFile($settings->where('key', 'loader')->first()->value) }}"
                                        class=" mt-1" height="150">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mt-3">
                                    <label class="labels">{{ trns('logo') }}</label>
                                    <input type="file" class="form-control" name="logo">
                                </div>

                                <div class="col-md-4 mt-3">
                                    <label class="labels">{{ trns('fav_icon') }}</label>
                                    <input type="file" class="form-control" name="fav_icon">
                                </div>

                                <div class="col-md-4 mt-3">
                                    <label class="labels">{{ trns('loader') }}</label>
                                    <input type="file" class="form-control" name="loader">
                                </div>
                            </div>

                            <div class="row">
                                <div class=" col-md-6 mt-3">
                                    <label class="labels">{{ trns('app_mentainance') }}</label>
                                    <select class="form-control" name="app_mentainance">
                                        <option value="true"
                                            {{ $settings->where('key', 'app_mentainance')->first()->value == 'true' ? 'selected' : '' }}>
                                            {{ trns('yes') }}</option>
                                        <option value="false"
                                            {{ $settings->where('key', 'app_mentainance')->first()->value == 'false' ? 'selected' : '' }}>
                                            {{ trns('no') }}</option>
                                    </select>
                                </div>

                                <div class=" col-md-6 mt-3">
                                    <label class="labels">{{ trns('system_language') }}</label>
                                    <select class="form-control" name="system_language">
                                        <option value="ar" {{ lang() == 'ar' ? 'selected' : '' }}>العربية</option>
                                        <option value="en" {{ lang() == 'en' ? 'selected' : '' }}>English</option>
                                    </select>
                                </div>
                                
                                
                                <div class=" col-md-12 mt-3">
                                    <label class="labels">{{ trns('Letterhead') }}</label>
                                    <textarea type="text" class="form-control" name="letterhead"
                                        value="{{ $settings->where('key', 'letterhead')->first()?->value ?? "" }}">{{ $settings->where('key', 'letterhead')->first()?->value ?? "" }}</textarea>
                                </div>



                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="mt-5 text-right">
                                <button type="submit" class="btn btn-one" style="width: 200px;"
                                    id="updateButton">{{ trns('update') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- End Form -->
    @include('admin.layouts.myAjaxHelper')

@section('ajaxCalls')
    <script>
        editScript();
    </script>

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.editor').forEach((textarea) => {
                ClassicEditor
                    .create(textarea)
                    .then(editor => {
                        editor.ui.view.editable.element.style.minHeight = '300px';
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        });
    </script>
@endsection
@endsection
