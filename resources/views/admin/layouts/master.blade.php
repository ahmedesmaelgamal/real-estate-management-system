<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('vendor/toastr/css/toastr.min.css') }}">


    @include('admin/layouts/head')
    @include('admin/layouts/css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .user-prfile {
            display: inline-block;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ddd;
        }

        .user-prfile i {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px !important;
            width: -webkit-fill-available;
            height: -webkit-fill-available;
        }

        .notActive {
            background-color: #ffb7b1;
            border-radius: 9px;
            width: 59px;
            height: 25px;
        }

        .table-unstatus {
            font-size: 12px !important;
        }

        .image-tab {
            width: -webkit-fill-available;
            height: 200px !important;
            cursor: pointer;
        }

        .image-container {
            position: relative;
        }

        .options-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Add any other custom styles here */
    </style>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
        .swal2-image-mt30 {
            margin-top: 50px !important;
        }
    </style>


</head>

<body class="app sidebar-mini">
    <!-- Start Switcher -->
    {{-- @include('admin/layouts/switcher') --}}
    <!-- End Switcher -->

    <!-- GLOBAL-LOADER -->
    @include('admin/layouts/loader')
    <!-- /GLOBAL-LOADER -->

    <!-- PAGE -->
    <div class="page">
        <div class="page-main">
            <!--APP-SIDEBAR-->
            @include('admin/layouts/main-sidebar')
            <!--/APP-SIDEBAR-->

            <!-- Header -->
            @include('admin/layouts/main-header')
            <!-- Header -->
            <!--Content-area open -->
            <div class="app-content">

                <div class="side-app">
                    @if (Route::currentRouteName() != 'adminHome')
                        <!-- PAGE-HEADER -->
                        <div class="page-header">
                            <div>
                                @if (Route::currentRouteName() == 'adminHome')
                                    <h1 class="page-title" id="pageTitle11" style="font-size: 28px;">
                                        {{ trns('welcome_back') }} {{ Auth::guard('admin')->user()->name }}
                                    </h1>
                                @endif
                                @if (Route::currentRouteName() != 'adminHome')
                                    <ol class="breadcrumb mt-5" style="font-size: 18px;">
                                        <li class="breadcrumb-item"><a href="{{ route('adminHome') }}"
                                                style="color: #00193a;">{{ trns('home') }}</a></li>
                                        <li class="mr-1 ml-1" style="color:#242e4c;"> /</li>
                                        <li class="breadcrumb-item"><a href="#">@yield('page_name')</a></li>
                                    </ol>
                                @endif
                            </div>
                        </div>
                    @endif
                    <!-- PAGE-HEADER END -->
                    @yield('content')
                    @include('admin/externalModal')
                </div>
                <!-- End Page -->
            </div>
            <!-- CONTAINER END -->
        </div>
        <!-- SIDE-BAR -->

        <!-- FOOTER -->
        @include('admin/layouts/footer')
        <!-- FOOTER END -->
    </div>
    <!-- BACK-TO-TOP -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up mt-4"></i></a>

    @include('admin/layouts/scripts')


    @yield('ajaxCalls')
    <script>
        // Function to set the page title
        $(document).ready(function() {
            setTimeout(e => {
                var pageTitle = $('#pageTitle11');
                pageTitle.addClass('d-none');
            }, 5000);
        });
    </script>

    <script src="{{ asset('vendor/toastr/js/toastr.min.js') }}"></script>
    {{-- the js for copy --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tabs = document.querySelectorAll('[data-tab]');
            const contents = document.querySelectorAll('.tab-content > div');

            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    const target = this.getAttribute('data-tab');
                    contents.forEach(c => c.classList.remove('active'));
                    document.getElementById(target).classList.add('active');
                });
            });
        });
    </script>

    {{-- <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                toastr.success('Copied successfully!');
            }, function(err) {
               x toastr.error('Failed to copy!');
            });
        }
    </script> --}}

    <script>
        @if (Session::has('success'))
            Swal.fire({
                title: '<span style="margin-bottom: 50px; display: block;">{{ trns('success') }}</span>',
                imageUrl: '{{ asset('true.png') }}',
                imageWidth: 80,
                imageHeight: 80,
                imageAlt: 'Success',
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                    image: 'swal2-image-mt30'
                }
            });
        @endif

        @if (Session::has('error'))
            Swal.fire({
                title: '<span style="margin-bottom: 50px; display: block;">{{ trns('error') }}</span>',
                imageUrl: '{{ asset('error.png') }}',
                imageWidth: 80,
                imageHeight: 80,
                imageAlt: 'Error',
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                    image: 'swal2-image-mt30'
                }
            });
        @endif

        @if (Session::has('warning'))
            Swal.fire({
                title: '<span style="margin-bottom: 50px; display: block;">{{ trns('warning') }}</span>',
                imageUrl: '{{ asset('warning.png') }}',
                imageWidth: 80,
                imageHeight: 80,
                imageAlt: 'Warning',
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                    image: 'swal2-image-mt30'
                }
            });
        @endif

        @if (Session::has('info'))
            Swal.fire({
                title: '<span style="margin-bottom: 50px; display: block;">{{ trns('info') }}</span>',
                imageUrl: '{{ asset('info.png') }}',
                imageWidth: 80,
                imageHeight: 80,
                imageAlt: 'Info',
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                    image: 'swal2-image-mt30'
                }
            });
        @endif



        // make input date when click open the calendar
        document.querySelectorAll('input[type="date"]').forEach(input => {
            input.addEventListener('click', function() {
                this.showPicker();
            });
        });
    </script>

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @yield('js')
    {{-- <script src="{{ mix('js/app.js') }}"></script> --}}


    <script>
        $(document).ready(function() {
            showModalWithButton('{{ route('associations.create') }}', 'create_association_access');
            showModalWithButton('{{ route('users.create') }}', 'create_user_access');
            showModalWithButton('{{ route('admins.create') }}', 'create_admin_access');
            showModalWithButton('{{ route('real_states.create') }}', 'create_real_state_access');
            showModalWithButton('{{ route('units.create') }}', 'create_unit_access');
            showModalWithButton('{{ route('contracts.create') }}', 'create_contract_access');
            showModalWithButton('{{ route('votes.create') }}', 'create_votes_access');
            showModalWithButton('{{ route('meetings.create') }}', 'create_meetings_access');
            showModalWithButton('{{ route('court_case.create') }}', 'create_court_cases_access');
        });

        function showModalWithButton(routeOfEdit, button) {
            $(document).on('click', `.${button}`, function() {
                console.log("test");
                var id = $(this).data('id');
                var url = routeOfEdit;
                url = url.replace(':id', id);
                let title = $(this).data('title');
                $(".modal-dialog").addClass("modal-xl");
                $(".modal-title").html(title);

                const loader = `
    <div class="text-center my-5">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
`;



                $('#modal-body').html(loader);
                $('#editOrCreate').modal('show');
                $('#modal-footer').html(`
                   <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two"

                            data-bs-dismiss="modal">{{ trns('close') }}</button>
                    <button type="submit" class="btn btn-one me-2"

                            id="addFastButton_${button}">{{ trns('create') }}</button>
                </div>
                `);



                setTimeout(function() {
                    $('#modal-body').load(url);
                }, 500);

                $('#editOrCreate').on('hidden.bs.modal', function() {
                    const currentUrl = window.location.href;

                    // check if current route contains "singlePageCreate"
                    if (currentUrl.includes('singlePageCreate')) {
                        console.log('Reloading page due to singlePageCreate...');
                        window.location.reload();
                    } else {
                        // normal reset (optional)
                        // $('#modal-body').html('');
                        // $('#modal-footer').html('');
                        // $('.modal-title').html('');
                        // $('.modal-dialog').removeClass('modal-xl modal-lg modal-sm');
                    }
                });




                $(".select2").select2({
                    dropdownParent: $('#editOrCreate'),
                    width: '100%'
                });
                $("#select2").select2({
                    dropdownParent: $('#editOrCreate'),
                    width: '100%'
                });
            });
        }


        //  store function 
        $(document).on('click', '[id^="addFastButton_"]', function(e) {
            e.preventDefault();

            console.log("Button clicked");

            // نحدد الفورم اللي جوه نفس المودال
            var form = $('#addForm');
            if (form.length === 0) {
                console.error('Form not found!');
                return;
            }

            // Clear previous validation errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            var formData = new FormData(form[0]);
            var url = form.attr('action');
            var button = $(this); // الزرار الحالي اللي ضغط عليه
            var buttonText = button.html();
            console.log(button.attr("id"));

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    button.html(
                        '<span class="spinner-border spinner-border-sm mr-2"></span> <span style="margin-left: 4px;">{{ trns('loading...') }}</span>'
                    ).attr('disabled', true);
                },
                success: function(data) {
                    button.html(buttonText).attr('disabled', false);
                    console.log(button);

                    if (data.status == 200) {
                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('success') }}</span>',
                            imageUrl: '{{ asset('true.png') }}',
                            imageWidth: 80,
                            imageHeight: 80,
                            imageAlt: 'Success',
                            showConfirmButton: false,
                            timer: 2000,
                            customClass: {
                                image: 'swal2-image-mt30'
                            }
                        });

                        if (button.attr("id") == "addFastButton_create_court_cases_access") {
                            setTimeout(function() {
                                window.location.href = "{{ route('court_case.index') }}";
                            }, 2000);
                        } else {
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        }



                    } else if (data.status == 405) {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('error') }}',
                            text: data.mymessage
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('error') }}',
                            text: '{{ trns('something_went_wrong') }}'
                        });
                    }
                },
                error: function(xhr) {
                    button.html(buttonText).attr('disabled', false);

                    if (xhr.status === 500) {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('server_error') }}',
                            text: '{{ trns('internal_server_error') }}'
                        });
                    } else if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;

                        $.each(errors, function(field, messages) {
                            var input = $('[name="' + field + '"]');
                            input.addClass('is-invalid');
                            var errorHtml = '<div class="invalid-feedback">' + messages[0] +
                                '</div>';
                            input.after(errorHtml);
                        });

                        var firstErrorField = Object.keys(errors)[0];
                        $('[name="' + firstErrorField + '"]').focus();

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('error') }}',
                            text: '{{ trns('something_went_wrong') }}'
                        });
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    </script>

    <script>
        function initializeSelect2InModal(selectElement) {
            const $select = $(selectElement);
            const $modal = $select.closest('.modal');

            $select.select2({
                dropdownParent: $modal,
                width: '100%'
            });
        }

        function initializeSelect2(selectElement) {
            const $select = $(selectElement);

            $select.select2({
                width: '100%'
            });
        }


        function initializeSelect2InModalWithSearch(selectElement, searchColumns = []) {
            const $select = $(selectElement);
            const $modal = $select.closest('.modal');

            $select.select2({
                dropdownParent: $modal,
                width: '100%',
                matcher: function(params, data) {
                    // If there are no search terms, return all data
                    if ($.trim(params.term) === '') {
                        return data;
                    }

                    // Skip if there is no 'text' property
                    if (typeof data.text === 'undefined') {
                        return null;
                    }

                    // Get the option element to access data attributes
                    const $option = $(data.element);

                    // Create search text from multiple columns
                    let searchText = data.text.toLowerCase();

                    // Add data from specified columns/attributes
                    searchColumns.forEach(column => {
                        const columnData = $option.data(column) || $option.attr('data-' + column);
                        if (columnData) {
                            searchText += ' ' + columnData.toString().toLowerCase();
                        }
                    });

                    // Check if search term matches any part of the combined text
                    const searchTerm = params.term.toLowerCase();
                    if (searchText.indexOf(searchTerm) > -1) {
                        return data;
                    }

                    return null;
                },
                templateResult: function(data) {
                    if (data.loading) {
                        return data.text;
                    }

                    const $option = $(data.element);
                    let displayText = data.text;

                    // Add additional info from data attributes
                    const additionalInfo = [];
                    searchColumns.forEach(column => {
                        const columnData = $option.data(column) || $option.attr('data-' + column);
                        if (columnData && columnData !== data.text) {
                            additionalInfo.push(columnData);
                        }
                    });

                    return $('<span>' + displayText + '</span>');
                }
            });
        }

        function initializeSelect2WithSearch(selectElement, searchColumns = []) {
            const $select = $(selectElement);

            $select.select2({
                width: '100%',
                matcher: function(params, data) {
                    // If there are no search terms, return all data
                    if ($.trim(params.term) === '') {
                        return data;
                    }

                    // Skip if there is no 'text' property
                    if (typeof data.text === 'undefined') {
                        return null;
                    }

                    // Get the option element to access data attributes
                    const $option = $(data.element);

                    // Create search text from multiple columns
                    let searchText = data.text.toLowerCase();

                    // Add data from specified columns/attributes
                    searchColumns.forEach(column => {
                        const columnData = $option.data(column) || $option.attr('data-' + column);
                        if (columnData) {
                            searchText += ' ' + columnData.toString().toLowerCase();
                        }
                    });

                    // Check if search term matches any part of the combined text
                    const searchTerm = params.term.toLowerCase();
                    if (searchText.indexOf(searchTerm) > -1) {
                        return data;
                    }

                    return null;
                },
                templateResult: function(data) {
                    if (data.loading) {
                        return data.text;
                    }

                    const $option = $(data.element);
                    let displayText = data.text;

                    // Add additional info from data attributes
                    const additionalInfo = [];
                    searchColumns.forEach(column => {
                        const columnData = $option.data(column) || $option.attr('data-' + column);
                        if (columnData && columnData !== data.text) {
                            additionalInfo.push(columnData);
                        }
                    });



                    return $('<span>' + displayText + '</span>');
                }
            });
        }

        function initializeSelect2WithSearchCustom(selectElement, searchColumns = []) {
            const $select = $(selectElement);

            $select.select2({
                width: '100%',
                matcher: function(params, data) {
                    // If there are no search terms, return all data
                    if ($.trim(params.term) === '') {
                        return data;
                    }

                    // Skip if there is no 'text' property
                    if (typeof data.text === 'undefined') {
                        return null;
                    }

                    // Get the option element to access data attributes
                    const $option = $(data.element);

                    // Create search text from multiple columns
                    let searchText = data.text.toLowerCase();

                    // Add data from specified columns/attributes
                    searchColumns.forEach(column => {
                        const columnData = $option.data(column) || $option.attr('data-' + column);
                        if (columnData) {
                            searchText += ' ' + columnData.toString().toLowerCase();
                        }
                    });

                    // Check if search term matches any part of the combined text
                    const searchTerm = params.term.toLowerCase();
                    if (searchText.indexOf(searchTerm) > -1) {
                        return data;
                    }

                    return null;
                },
                templateResult: function(data) {
                    if (data.loading) {
                        return data.text;
                    }

                    const $option = $(data.element);
                    let displayText = data.text;

                    // Add additional info from data attributes
                    const additionalInfo = [];
                    searchColumns.forEach(column => {
                        const columnData = $option.data(column) || $option.attr('data-' + column);
                        if (columnData && columnData !== data.text) {
                            additionalInfo.push(columnData);
                        }
                    });



                    return $('<span>' + displayText + '</span>');
                },
                templateSelection: function(data, container) {
                    const selectedValues = $select.val() || [];
                    const totalOptions = $select.find('option:not([disabled])').length;

                    if (selectedValues.length > 1) {
                        if (data.id === selectedValues[0]) {
                            return `${selectedValues.length} of ${totalOptions} selected`;
                        }
                        // Add a class to hide other selections
                        $(container).addClass('hidden-selection');
                        return data.text;
                    }

                    // Show actual text for single selection
                    return data.text || data.id;
                }
            });
        }

        function initializeSelect2InModalWithSearchCustom(selectElement, searchColumns = []) {
            const $select = $(selectElement);
            const $modal = $select.closest('.modal');

            $select.select2({
                dropdownParent: $modal,
                width: '100%',
                matcher: function(params, data) {
                    // If there are no search terms, return all data
                    if ($.trim(params.term) === '') {
                        return data;
                    }

                    // Skip if there is no 'text' property
                    if (typeof data.text === 'undefined') {
                        return null;
                    }

                    // Get the option element to access data attributes
                    const $option = $(data.element);

                    // Create search text from multiple columns
                    let searchText = data.text.toLowerCase();

                    // Add data from specified columns/attributes
                    searchColumns.forEach(column => {
                        const columnData = $option.data(column) || $option.attr('data-' + column);
                        if (columnData) {
                            searchText += ' ' + columnData.toString().toLowerCase();
                        }
                    });

                    // Check if search term matches any part of the combined text
                    const searchTerm = params.term.toLowerCase();
                    if (searchText.indexOf(searchTerm) > -1) {
                        return data;
                    }

                    return null;
                },
                templateResult: function(data) {
                    if (data.loading) {
                        return data.text;
                    }

                    const $option = $(data.element);
                    let displayText = data.text;

                    // Add additional info from data attributes
                    const additionalInfo = [];
                    searchColumns.forEach(column => {
                        const columnData = $option.data(column) || $option.attr('data-' + column);
                        if (columnData && columnData !== data.text) {
                            additionalInfo.push(columnData);
                        }
                    });



                    return $('<span>' + displayText + '</span>');
                },
                templateSelection: function(data, container) {
                    const selectedValues = $select.val() || [];
                    const totalOptions = $select.find('option:not([disabled])').length;

                    if (selectedValues.length > 1) {
                        if (data.id === selectedValues[0]) {
                            return `${selectedValues.length} of ${totalOptions} selected`;
                        }
                        // Add a class to hide other selections
                        $(container).addClass('hidden-selection');
                        return data.text;
                    }

                    // Show actual text for single selection
                    return data.text || data.id;
                }
            });
        }
    </script>




    <script>
        var contractsIndexUrl = "{{ route('contracts.index') }}";
    </script>


    <script>
        $(document).ready(function() {

            // CSRF token setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Submit form with AJAX
            $('#addContractForm').on('submit', function(e) {
                e.preventDefault();

                // remove previous errors
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                var form = $(this)[0];
                var formData = new FormData(form);
                var url = $(this).attr('action');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('button[type="submit"]').attr('disabled', true).each(function() {
                            $(this).html(
                                '<span class="spinner-border spinner-border-sm mr-2"></span> ' +
                                $(this).text());
                        });
                    },
                    success: function(data) {
                        $('button[type="submit"]').attr('disabled', false).each(function() {
                            $(this).html($(this).text().replace(/\s*$/, ''));
                        });

                        if (data.status === 200) {
                            Swal.fire({
                                title: '<span style="display:block;margin-bottom:10px;">' +
                                    (data.mymessage || 'Added successfully') +
                                    '</span>',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1000
                            });

                            setTimeout(function() {
                                window.location.href = contractsIndexUrl;
                            }, 1000);



                            // Optionally clear form if needed
                            $('#addContractForm')[0].reset();

                            // Reload terms if needed
                            if (typeof loadTerms === 'function') loadTerms();
                        } else {
                            toastr.error(data.mymessage || 'Something went wrong!');
                        }
                    },
                    error: function(xhr) {
                        $('button[type="submit"]').attr('disabled', false).each(function() {
                            $(this).html($(this).text().replace(/\s*$/, ''));
                        });

                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                var input = $('[name="' + field + '"], [name="' +
                                    field + '[]"]');
                                input.addClass('is-invalid');
                                input.after('<div class="invalid-feedback">' + messages[
                                    0] + '</div>');
                            });
                            var firstField = Object.keys(errors)[0];
                            $('[name="' + firstField + '"]').focus();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.mymessage ||
                                    'Internal server error!'
                            });
                        }
                    }
                });
            });

        });
    </script>


    <script>
        $(document).on('input', 'input[name="name[ar]"]', function() {
            if (/[A-Za-z]/.test(this.value)) {
                this.value = '';
                {{-- toastr.error("{{ trns('please_enter_arabic_only') }}"); --}}
                Swal.fire({
                    title: '<span style="margin-bottom: 50px; display: block;">{{ trns('please_enter_arabic_only') }}</span>',
                    icon: 'error',

                    imageWidth: 80,
                    imageHeight: 80,
                    imageAlt: 'Success',
                    showConfirmButton: false,
                    timer: 1000,
                    customClass: {
                        image: 'swal2-image-mt30'
                    }
                });
            }
        });

        $(document).on('input', 'input[name="name[en]"]', function() {
            if (/[\u0600-\u06FF]/.test(this.value)) {
                this.value = '';
                {{-- toastr.error("{{trns('please_enter_english_only') }}"); --}}

                Swal.fire({
                    title: '<span style="margin-bottom: 50px; display: block;">{{ trns('please_enter_english_only') }}</span>',
                    icon: 'error',
                    imageWidth: 80,
                    imageHeight: 80,
                    imageAlt: 'Success',
                    showConfirmButton: false,
                    timer: 1000,
                    customClass: {
                        image: 'swal2-image-mt30'
                    }
                });
            }
        });


        $(document).on('input', 'input[name="title[ar]"]', function() {
            if (/[A-Za-z]/.test(this.value)) {
                this.value = '';
                {{-- toastr.error("{{ trns('please_enter_arabic_only') }}"); --}}
                Swal.fire({
                    title: '<span style="margin-bottom: 50px; display: block;">{{ trns('please_enter_arabic_only') }}</span>',
                    icon: 'error',

                    imageWidth: 80,
                    imageHeight: 80,
                    imageAlt: 'Success',
                    showConfirmButton: false,
                    timer: 1000,
                    customClass: {
                        image: 'swal2-image-mt30'
                    }
                });
            }
        });

        $(document).on('input', 'input[name="title[en]"]', function() {
            if (/[\u0600-\u06FF]/.test(this.value)) {
                this.value = '';
                {{-- toastr.error("{{trns('please_enter_english_only') }}"); --}}

                Swal.fire({
                    title: '<span style="margin-bottom: 50px; display: block;">{{ trns('please_enter_english_only') }}</span>',
                    icon: 'error',
                    imageWidth: 80,
                    imageHeight: 80,
                    imageAlt: 'Success',
                    showConfirmButton: false,
                    timer: 1000,
                    customClass: {
                        image: 'swal2-image-mt30'
                    }
                });
            }
        });
    </script>

</body>

</html>
