<!-- DATATABLE CSS -->
<link href="{{ asset('assets/admin') }}/assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets/admin') }}/assets/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
<link href="{{ asset('assets/admin') }}/assets/plugins/datatable/fileexport/buttons.bootstrap4.min.css"
    rel="stylesheet" />

<!-- JQUERY JS -->
<script src="{{ asset('assets/admin') }}/assets/js/jquery-3.4.1.min.js"></script>

<!-- DATATABLE JS -->
<script src="{{ asset('assets/admin') }}/assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/admin') }}/assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('assets/admin') }}/assets/plugins/datatable/datatable.js"></script>
<script src="{{ asset('assets/admin') }}/assets/plugins/datatable/dataTables.responsive.min.js"></script>
<script src="{{ asset('assets/admin') }}/assets/plugins/datatable/fileexport/dataTables.buttons.min.js"></script>
<script src="{{ asset('assets/admin') }}/assets/plugins/datatable/fileexport/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('assets/admin') }}/assets/plugins/datatable/fileexport/jszip.min.js"></script>
<script src="{{ asset('assets/admin') }}/assets/plugins/datatable/fileexport/pdfmake.min.js"></script>
<script src="{{ asset('assets/admin') }}/assets/plugins/datatable/fileexport/vfs_fonts.js"></script>
<script src="{{ asset('assets/admin') }}/assets/plugins/datatable/fileexport/buttons.html5.min.js"></script>
<script src="{{ asset('assets/admin') }}/assets/plugins/datatable/fileexport/buttons.print.min.js"></script>
<script src="{{ asset('assets/admin') }}/assets/plugins/datatable/fileexport/buttons.colVis.min.js"></script>

<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<!-- Bootstrap JS (with Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- BOOTSTRAP JS -->
{{-- <script src="{{asset('assets/admin')}}/assets/plugins/bootstrap5/js/bootstrap.bundle.min.js"></script> --}}
{{-- <script src="{{asset('assets/admin')}}/assets/plugins/bootstrap5/js/popper.min.js"></script> --}}

<!-- SPARKLINE JS-->
<script src="{{ asset('assets/admin') }}/assets/js/jquery.sparkline.min.js"></script>

<!-- CHART-CIRCLE JS-->
<script src="{{ asset('assets/admin') }}/assets/js/circle-progress.min.js"></script>

<!-- RATING STARJS -->
<script src="{{ asset('assets/admin') }}/assets/plugins/rating/jquery.rating-stars.js"></script>

<!-- EVA-ICONS JS -->
<script src="{{ asset('assets/admin') }}/assets/iconfonts/eva.min.js"></script>

<!-- INPUT MASK JS-->
<script src="{{ asset('assets/admin') }}/assets/plugins/input-mask/jquery.mask.min.js"></script>

<!-- SIDE-MENU JS-->
<script src="{{ asset('assets/admin') }}/assets/plugins/sidemenu/sidemenu.js"></script>

{{-- <!-- PERFECT SCROLL BAR js--> --}}
<script src="{{ asset('assets/admin') }}/assets/plugins/p-scroll/perfect-scrollbar.min.js"></script>
<script src="{{ asset('assets/admin') }}/assets/plugins/sidemenu/sidemenu-scroll-rtl.js"></script>

<!-- CUSTOM SCROLLBAR JS-->
<script src="{{ asset('assets/admin') }}/assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- SIDEBAR JS -->
<script src="{{ asset('assets/admin') }}/assets/plugins/sidebar/sidebar-rtl.js"></script>

<!-- CUSTOM JS -->
<script src="{{ asset('assets/admin') }}/assets/js/custom.js"></script>

<!-- Switcher JS -->
<script src="{{ asset('assets/admin') }}/assets/switcher/js/switcher-rtl.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script> --}}
<script src="{{ asset('assets/dropify/js/dropify.min.js') }}"></script>

<script src="{{ asset('assets/admin/assets/js/select2.js') }}"></script>

<script src="{{ asset('assets/website/js/all.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.4/dist/sweetalert2.all.min.js"></script>

<script src="{{ asset('assets/fileUpload/fileUpload.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/uploadjs/image-uploader.min.js') }}"></script>

{{-- toastr --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        $('.dropify').dropify();
    });
</script>

<script>
    window.addEventListener('online', () => {
        // window.location.reload();
        toastr.success("{{ trns('Internet connection has been restored.') }}");
    });
    window.addEventListener('offline', () => {
        toastr.error("{{ trns('Disconnected, please check your internet quality') }}");
    });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

<script>
    $(document).on('click', '.image-popup', function(e) {
        e.preventDefault(); // Prevent the default action
        $(this).magnificPopup({
            items: {
                src: $(this).attr('href') // Ensure this pulls the correct URL
            },
            type: 'image',
            closeOnContentClick: true,
            image: {
                verticalFit: true
            }
        }).magnificPopup('open');
    });
</script>
<script type="text/javascript" src="{{ asset('richtexteditor') }}/rte.js"></script>
<script type="text/javascript" src='{{ asset('richtexteditor') }}/plugins/all_plugins.js'></script>
{{-- test test --}}

<script src="{{ asset('assets/admin') }}/assets/leaflet/js/leaflet.js"></script>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>



<script>
    // Function to toggle logos
    function toggleLogos(isCollapsed) {
        const desktopLogo = document.querySelector('.desktop-logo');
        const mobileLogo = document.querySelector('.mobile-logo');

        if (isCollapsed) {
            desktopLogo.style.display = 'none';
            mobileLogo.style.display = 'block';
            // alert('Sidebar collapsed! Mobile logo is now showing.');
        } else {
            desktopLogo.style.display = 'block';
            mobileLogo.style.display = 'none';
            // alert('Sidebar expanded! Desktop logo is now showing.');
        }
    }

    // Event listener for sidebar toggle
    document.addEventListener('DOMContentLoaded', function() {
        const body = document.body;

        // Create a MutationObserver to watch for class changes
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    // Check for collapsed state (sidenav-toggled without sidenav-toggled-open)
                    const isCollapsed = body.classList.contains('sidenav-toggled') &&
                        !body.classList.contains('sidenav-toggled-open');

                    // Check for open state (sidenav-toggled-open)
                    const isOpen = body.classList.contains('sidenav-toggled-open');

                    // Show desktop logo if open, otherwise check collapsed state
                    if (isOpen) {
                        toggleLogos(false); // Show desktop logo
                    } else {
                        toggleLogos(isCollapsed); // Follow collapsed state
                    }
                }
            });
        });

        // Start observing
        observer.observe(body, {
            attributes: true,
            attributeFilter: ['class']
        });

        // Initial check
        const initialOpen = body.classList.contains('sidenav-toggled-open');
        const initialCollapsed = body.classList.contains('sidenav-toggled') &&
            !body.classList.contains('sidenav-toggled-open');

        if (initialOpen) {
            toggleLogos(false); // Show desktop logo
        } else {
            toggleLogos(initialCollapsed); // Follow collapsed state
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var selectAll = document.getElementById('select-all');
        if (selectAll) selectAll.checked = false;

        document.addEventListener('click', function(e) {
            // Replace '.sidebar-toggle' with your actual toggle button selector
            if (e.target.matches('.sidebar-toggle') || e.target.closest('.sidebar-toggle')) {
                setTimeout(() => {
                    const isOpen = document.body.classList.contains('sidenav-toggled-open');
                    const isCollapsed = document.body.classList.contains('sidenav-toggled') &&
                        !document.body.classList.contains('sidenav-toggled-open');

                    if (isOpen) {
                        toggleLogos(false);
                    } else {
                        toggleLogos(isCollapsed);
                    }
                }, 100);
            }
        });






        document.querySelectorAll('.copy-btn').forEach(button => {
            button.addEventListener('click', function() {
                const textToCopy = this.getAttribute('data-copy');
                navigator.clipboard.writeText(textToCopy).then(() => {
                    Swal.fire({
                        title: '<span style="margin-bottom: 40px; display: block;  font-size: 20px;">{{ trns('copied_successfully') }}' +
                            '</span>',
                        imageUrl: '{{ asset('true.png') }}',
                        imageWidth: 70,
                        imageHeight: 70,
                        imageAlt: 'Success',
                        showConfirmButton: false,
                        timer: 1500,
                        customClass: {
                            image: 'swal2-image-mt30'
                        }
                    });

                    this.innerHTML = '<i class="fa-solid fa-check"></i>';
                    setTimeout(() => {
                        this.innerHTML =
                            '<i class="fa-regular fa-copy"></i>';
                    }, 1500);
                }).catch(err => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to copy text: ' + err,
                        showConfirmButton: false,
                        timer: 500
                    });
                });
            });
        });

    });

    document.addEventListener("click", function(e) {
        if (e.target.closest(".copy-btn")) {
            let btn = e.target.closest(".copy-btn");
            let text = btn.getAttribute("data-copy");

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => {
                    Swal.fire({
                        title: '<span style="margin-bottom: 40px; display: block;  font-size: 20px;">{{ trns('copied_successfully') }}' +
                            '</span>',
                        imageUrl: '{{ asset('true.png') }}',
                        imageWidth: 70,
                        imageHeight: 70,
                        imageAlt: 'Success',
                        showConfirmButton: false,
                        timer: 1500,
                        customClass: {
                            image: 'swal2-image-mt30'
                        }
                    });

                    this.innerHTML = '<i class="fa-solid fa-check"></i>';
                    setTimeout(() => {
                        this.innerHTML =
                            '<i class="fa-regular fa-copy"></i>';
                    }, 1500);
                }).catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to copy text: ' + err,
                        showConfirmButton: false,
                        timer: 500
                    });
                });
            } else {
                let textArea = document.createElement("textarea");
                textArea.value = text;
                textArea.style.position = "fixed";
                textArea.style.left = "-999999px";
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();

                try {
                    document.execCommand("copy");
                    Swal.fire({
                        title: '<span style="margin-bottom: 40px; display: block;  font-size: 20px;">{{ trns('copied_successfully') }}' +
                            '</span>',
                        imageUrl: '{{ asset('true.png') }}',
                        imageWidth: 70,
                        imageHeight: 70,
                        imageAlt: 'Success',
                        showConfirmButton: false,
                        timer: 1500,
                        customClass: {
                            image: 'swal2-image-mt30'
                        }
                    });

                    this.innerHTML = '<i class="fa-solid fa-check"></i>';
                    setTimeout(() => {
                        this.innerHTML =
                            '<i class="fa-regular fa-copy"></i>';
                    }, 1500);
                } catch (err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to copy text: ' + err,
                        showConfirmButton: false,
                        timer: 500
                    });
                }
                document.body.removeChild(textArea);
            }
        }
    });
</script>

@yield('js')
