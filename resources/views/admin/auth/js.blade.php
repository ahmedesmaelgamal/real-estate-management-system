<style>
    .my-confirm-btn {
        background-color: #00193a;
        color: #00f3ca;
        border: none;
        font-weight: bold;
        padding: 5px 60px;
        border-radius: 5px;
    }
</style>

<script src="{{ asset('assets/admin') }}/assets/js/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script>
<script>
    function expand(lbl) {
        var elemId = lbl.getAttribute("for");
        document.getElementById(elemId).style.height = "45px";
        document.getElementById(elemId).classList.add("my-style");
        lbl.style.transform = "translateY(-45px)";
    }





    $("form#LoginForm").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var url = $('#LoginForm').attr('action');
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $('#LoginBtn').html(' <i class="fa fa-spinner fa-spin"></i>').attr('disabled',
                    true);

            },

            success: function(data) {
                if (data.status == 200) {
                    $(document).ready(function() {
                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('login_successfully') }}</span>',
                            imageUrl: '{{ asset('true.png') }}',
                            imageWidth: 80,
                            imageHeight: 80,
                            imageAlt: 'Success',
                            showConfirmButton: false,
                            timer: 1500,
                            customClass: {
                                image: 'swal2-image-mt30'
                            }
                        });
                    });
                    $('#LoginBtn').html(
                        `<i id="lockId" class="fa fa-lock" style="margin-left: 6px"></i> {{ trns('login') }}`
                    ).attr('disabled', true);

                    $('#LoginForm')[0].reset();
                    setTimeout(function() {
                        window.location.href = "{{ route('adminHome') }}";
                    }, 1500);

                } else {

                    $('#LoginBtn').html(
                        `<i id="lockId" class="fa fa-lock" style="margin-left: 6px"></i> {{ trns('login') }}`
                    ).attr('disabled', false);
                    Swal.fire({
                        title: '{{ trns('something_went_wrong') }}',

                        icon: 'error',
                        confirmButtonText: '{{ trns('OK') }}',
                        customClass: {
                            confirmButton: 'my-confirm-btn'
                        },
                        buttonsStyling: false,



                    });

                }

            },
            error: function(xhr) {
                $('#LoginBtn').html(
                        '{{ trns('login') }}')
                    .attr('disabled', false);

                if (xhr.status === 500) {
                    Swal.fire({
                        icon: 'error',
                        confirmButtonText: '{{ trns('OK') }}',
                        customClass: {
                            confirmButton: 'my-confirm-btn'
                        },
                        buttonsStyling: false,


                        title: '{{ trns('server_error') }}',
                        text: '{{ trns('internal_server_error') }}'
                    });
                } else if (xhr.status === 422) {


                    Swal.fire({
                        icon: 'error',
                        confirmButtonText: '{{ trns('OK') }}',
                        customClass: {
                            confirmButton: 'my-confirm-btn'
                        },
                        buttonsStyling: false,

                        title: '{{ trns('validation_error') }}',
                        text: '{{ trns('please_check_your_input') }}'
                    });

                } else if (xhr.status === 401) {


                    Swal.fire({
                        icon: 'error',

                        title: '{{ trns('invalid_credentials') }}',
                        text: '{{ trns('please_correct_your_password') }}',
                        confirmButtonText: '{{ trns('OK') }}',
                        customClass: {
                            confirmButton: 'my-confirm-btn'
                        },
                        buttonsStyling: false,
                    });


                } else {
                    Swal.fire({
                        icon: 'error',
                        confirmButtonText: '{{ trns('OK') }}',
                        customClass: {
                            confirmButton: 'my-confirm-btn'
                        },
                        buttonsStyling: false,


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
