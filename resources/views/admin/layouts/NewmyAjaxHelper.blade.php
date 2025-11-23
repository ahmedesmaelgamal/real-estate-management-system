<script>
    var loader = `
			<div id="skeletonLoader" class="skeleton-loader">
    <div class="loader-header">
        <div class="skeleton skeleton-text"></div>
    </div>
    <div class="loader-body">
        <div class="skeleton skeleton-textarea"></div>
    </div>

        </div>
        `;






    let currentKeys = [];
    let currentValues = [];



    function CustomSearchSelectionAndRequest({
        selectId,
        inputWrapperId,
        inputId,
        searchButtonId,
        together = false,
        onSuccess = null
    }) {
        const select = document.getElementById(selectId);
        const inputWrapper = document.getElementById(inputWrapperId);
        const input = document.getElementById(inputId);
        const button = document.getElementById(searchButtonId);




        if (!select || !inputWrapper || !input || !button) {
            console.error("{{ trns('please_select_select_first') }}");
            return;
        }
        if ( !inputWrapper ) {
            console.error("{{ trns('please_select_inputWrapper_first') }}");
            return;
        }
        if ( !input || !button) {
            console.error("{{ trns('please_select_input_first') }}");
            return;
        }
        if (!button) {
            console.error("{{ trns('please_select_button_first') }}");
            return;
        }

        select.addEventListener('change', function() {
            if (this.value) {
                inputWrapper.style.display = 'block';
            } else {
                inputWrapper.style.display = 'none';
                input.value = '';
            }
        });

        button.addEventListener('click', function() {
            const key = select.value;
            const input = document.getElementById(inputId); // جيب العنصر هنا
            const value = input ? input.value : '';

            if (!key || !value) {
                toastr.error("{{ trns('please_select_key_and_value_first') }}");
                return;
            }

            currentKeys = [key];
            currentValues = [value];
            currentTogether = together;

            if (typeof onSuccess === 'function') {
                onSuccess();
            }
        });

    }




    async function showData(showRoute, routeOfShow, columns, orderByColumn = 0 , showCol = 3) {
    let table = $('#dataTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: routeOfShow,
            data: function(d) {
                if (currentKeys.length > 0 && currentValues.length > 0) {
                    d.keys = currentKeys;
                    d.values = currentValues;
                    d.together = currentTogether;
                }
            }
        },
        columns: columns,
        order: [
            [orderByColumn ? orderByColumn : 0, "DESC"]
        ],
        createdRow: function(row, data, dataIndex) {
            $(row).attr('data-id', data.id); // الـ id بتاع العقد
            $(row).addClass('clickable-row');
        },
        language: {
            sProcessing: "{{ trns('processing...') }}",
            sLengthMenu: "{{ trns('show') }} _MENU_ {{ trns('records') }}",
            sZeroRecords: "{{ trns('no_records_found') }}",
            sInfo: "{{ trns('showing') }} _START_ {{ trns('to') }} _END_ {{ trns('of') }} _TOTAL_ {{ trns('records') }}",
            sInfoEmpty: "{{ trns('showing') }} 0 {{ trns('to') }} 0 {{ trns('of') }} 0 {{ trns('records') }}",
            sInfoFiltered: "({{ trns('filtered_from') }} _MAX_ {{ trns('total_records') }})",
            sSearch: "{{ trns('search') }} :    ",
            oPaginate: {
                sPrevious: "{{ trns('previous') }}",
                sNext: "{{ trns('next') }}",
            },
            buttons: {
                copyTitle: '{{ trns('copied') }} <i class="fa fa-check-circle text-success"></i>',
                copySuccess: {
                    1: "{{ trns('copied') }} 1 {{ trns('row') }}",
                    _: "{{ trns('copied') }} %d {{ trns('rows') }}"
                },
            }
        },
        buttons: [
            { extend: 'copy', text: "{{ trns('copy') }}", className: 'btn-primary' },
            { extend: 'print', text: '{{ trns('print') }}', className: 'btn-primary' },
            { extend: 'excel', text: '{{ trns('excel') }}', className: 'btn-primary' },
            { extend: 'pdf', text: '{{ trns('pdf') }}', className: 'btn-primary' },
            { extend: 'colvis', text: '{{ trns('column_visibility') }}', className: 'btn-primary' },
        ]
    });

        if (showRoute) {
            $('#dataTable tbody').on('mouseenter', `tr td:nth-child(${showCol})`, function() {
                $(this).css('cursor', 'pointer');
            }).on('mouseleave', `tr td:nth-child(${showCol})`, function() {
                $(this).css('cursor', '');
            });

            $('#dataTable tbody').on('click', `tr td:nth-child(${showCol})`, function(e) {
                if ($(e.target).is('input, button, a, .delete-checkbox, .editBtn, .statusBtn')) {
                    return;
                }

                let row = $(this).closest('tr'); 
                let id = row.data('id');

                if (id) {
                    let finalUrl = showRoute.replace(':id', id);
                    window.location.href = finalUrl;
                } else {
                    console.error("Row ID is undefined");
                }
            });
        }


    }




    function deleteScript(routeTemplate) {
        $(document).ready(function() {
            // Configure modal event listeners
            $('#delete_modal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var title = button.data('title');
                var modal = $(this);
                modal.find('.modal-body #delete_id').val(id);
                modal.find('.modal-body #title').text(title);
            });

            $(document).on('click', '#delete_btn', function() {
                var id = $("#delete_id").val();
                var routeOfDelete = routeTemplate.replace(':id', id);

                $.ajax({
                    type: 'DELETE',
                    url: routeOfDelete,
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'id': id
                    },
                    success: function(data) {
                        if (data.status === 200) {
                            $('#delete_modal').modal('hide');

                            $('#dataTable').DataTable().ajax.reload();

                            Swal.fire({
                                title: '<span style="margin-bottom: 50px; display: block;">{{ trns('success') }}</span>',
                                imageUrl: '{{ asset('true.png') }}',
                                imageWidth: 80,
                                imageHeight: 80,
                                imageAlt: 'Success',
                                showConfirmButton: false,
                                timer: 500,
                                customClass: {
                                    image: 'swal2-image-mt30'
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ trns('Deletion failed') }}',
                                text: data.message ||
                                    '{{ trns('Something went wrong') }}',
                                confirmButtonText: '{{ trns('OK') }}'
                            });
                        }
                    },

                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('Error') }}',
                            text: xhr.responseJSON?.message ||
                                '{{ trns('Something went wrong') }}',
                            confirmButtonText: '{{ trns('OK') }}'
                        });
                    }
                });
            });
        });
    }


    function showAddModal(routeOfShow) {
        $(document).on('click', '.addBtn', function() {
            console.log("test");
            $('#modal-footer').html(`
                <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('close') }}</button>
                    <button type="submit" class="btn btn-one me-2" id="addButton">{{ trns('create') }}</button>
                </div>
            `);

            $('#modal-body').html(loader);
            $('#editOrCreate').modal('show');
            setTimeout(function() {
                $('#modal-body').load(routeOfShow);
            }, 250);
        });
    }



    function addScript() {
        $(document).on('click', '#addButton', function(e) {
            console.log("test");
            e.preventDefault();
            // Clear previous validation errors
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            var form = $('#addForm')[0];
            var formData = new FormData(form);
            var url = $('#addForm').attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#addButton').html(
                            '<span class="spinner-border spinner-border-sm mr-2"></span> <span style="margin-left: 4px;">{{ trns('loading...') }}</span>'
                        )
                        .attr('disabled', true);
                },
                success: function(data) {
                    $('#addButton').html('{{ trns('add') }}').attr('disabled', false);

                    if (data.status == 200) {
                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('added_successfully') }}</span>',
                            imageUrl: '{{ asset('true.png') }}',
                            imageWidth: 80,
                            imageHeight: 80,
                            imageAlt: 'Success',
                            showConfirmButton: false,
                            timer: 500,
                            customClass: {
                                image: 'swal2-image-mt30'
                            }
                        });

                        // setTimeout(function() {
                        //     window.location.reload();
                        // }, 2000);
                        if (data.redirect_to) {
                            setTimeout(function() {
                                window.location.href = data.redirect_to;
                            }, 1000);
                            window.location.reload();

                        } else {
                            $('#editOrCreate').modal('hide');
                            // setTimeout(function() {
                            //     window.location.reload();
                            // }, 1000);
                            $('#dataTable').DataTable().ajax.reload();
                        }
                        // window.location.reload();

                    } else if (data.status == 405) {
                        toastr.error(data.mymessage);
                    } else {
                        toastr.error('{{ trns('something_went_wrong') }}');
                    }
                    $('#addButton').html(`{{ trns('add') }}`).attr('disabled', false);
                    $('#editOrCreate').modal('hide');
                },
                error: function(xhr) {
                    $('#addButton').html('{{ trns('add') }}').attr('disabled', false);

                    if (xhr.status === 500) {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('server_error') }}',
                            text: '{{ trns('internal_server_error') }}'
                        });
                    } else if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;

                        $.each(errors, function(field, messages) {
                            var fieldName = field.includes('.') ?
                                field.replace(/\./g, '[') + ']' :
                                field;

                            var input = $('[name="' + fieldName + '"]');

                            input.addClass('is-invalid');

                            input.next('.invalid-feedback').remove();

                            var errorHtml = '<div class="invalid-feedback">' + messages[0] +
                                '</div>';
                            input.after(errorHtml);
                        });

                        var firstField = Object.keys(errors)[0];
                        var firstFieldName = firstField.includes('.') ?
                            firstField.replace(/\./g, '[') + ']' :
                            firstField;

                        $('[name="' + firstFieldName + '"]').focus();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('error') }}',
                            text: '{{ trns('something_went_wrong') }}'
                        });
                    }

                    $('#addButton').html('{{ trns('add') }}').attr('disabled', false);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    }




    function showEditModal(routeOfEdit, titleModal = null) {
        $(document).on('click', '.editBtn', function() {

            var id = $(this).data('id');
            var url = routeOfEdit.replace(':id', id);

            $('#modal-body').html(loader);
            $('#editOrCreate').modal('show');
            if (titleModal != null) {
                $('#modalTitle').text(titleModal);
            }

            // footer buttons
            $('#modal-footer').html(`
                <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two"
                            data-bs-dismiss="modal">{{ trns('close') }}</button>
                    <button type="submit" class="btn btn-one me-2"
                            id="updateButton">{{ trns('update') }}</button>
                </div>
            `);

            setTimeout(function() {
                $('#modal-body').load(url);
            }, 500);
        });
    }



    function showEditModalWithButton(routeOfEdit, button) {
        $(document).on('click', `.${button}`, function() {
            var id = $(this).data('id')
            var url = routeOfEdit;
            url = url.replace(':id', id)
            const title = $(this).data('title');
            if ($('#example-Modal3').length) {
                $('#example-Modal3').text(title);
            }
            $('#modal-body').html(loader)
            $('#editOrCreate').modal('show')

            // footer buttons
            $('#modal-footer').html(`
                <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two"
                            data-bs-dismiss="modal">{{ trns('close') }}</button>
                    <button type="submit" class="btn btn-one me-2"
                            id="updateButton">{{ trns('update') }}</button>
                </div>
            `);

            setTimeout(function() {
                $('#modal-body').load(url)
            }, 500)
        })
    }


    function showUpdateProfileImage(routeOfEdit) {
        $(document).on('click', '.updateProfileImageBtn', function() {
            var id = $(this).data('id')
            var url = routeOfEdit;
            url = url.replace(':id', id)
            $('#modal-body').html(loader)
            $('#updateProfileImage').modal('show')

            setTimeout(function() {
                $('#modal-body').load(url)
            }, 500)
        })
    }



    function editScript() {
        $(document).on('click', '#updateButton', function(e) {
            e.preventDefault();
            const form = $('#updateForm')[0];
            const url = $('#updateForm').attr('action');
            const formData = new FormData(form);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                beforeSend: function() {
                    $('#updateButton')
                        .html('<span class="spinner-border spinner-border-sm me-2"></span>' +
                            '<span style="margin-left:4px;">{{ trns('loading...') }}</span>')
                        .attr('disabled', true);
                },
                success: function(data) {
                    $('#updateButton').html(`{{ trns('update') }}`).attr('disabled', false);

                    if (data.status === 200) {
                        $('#editOrCreate').modal('hide').on('hidden.bs.modal', function() {
                            $('#modal-body').html('');
                        });


                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('changed_successfully') }}</span>',
                            imageUrl: '{{ asset('true.png') }}',
                            imageWidth: 80,
                            imageHeight: 80,
                            imageAlt: 'Success',
                            showConfirmButton: false,
                            timer: 500,
                            customClass: {
                                image: 'swal2-image-mt30'
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('something_went_wrong') }}'
                        });
                    }

                    if (data.redirect) {
                        setTimeout(function() {
                            window.location.href = data.redirect;
                        }, 1000);
                    } else {

                        $('#dataTable').DataTable().ajax.reload();
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);

                    }
                },
                error: function(data) {
                    $('#updateButton').html(`{{ trns('update') }}`).attr('disabled', false);

                    if (data.status === 500) {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('something_went_wrong') }}'
                        });
                    } else if (data.status === 422) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors.errors, function(key, value) {
                            $('#' + key).next('.invalid-feedback').remove();
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).after('<div class="invalid-feedback">' + value[0] +
                                '</div>');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('something_went_wrong') }}'
                        });
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    }




    function editOwners() {
        $(document).on('submit', 'Form#editOwnersForm', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var url = $('#updateForm').attr('action');
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#updateButton').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                        ' ></span> <span style="margin-left: 4px;">{{ trns('loading...') }}</span>'
                    ).attr('disabled', true);
                },
                success: function(data) {
                    $('#updateButton').html(`{{ trns('update') }}`).attr('disabled', false);
                    if (data.status == 200) {
                        $('#editOrCreate').modal('hide')
                        $('#editOrCreate').on('hidden.bs.modal', function() {
                            $('#modal-body').html('');
                        });
                        toastr.success('{{ trns('updated_successfully') }}');
                        $('#editOrCreate').on('hidden.bs.modal', function() {
                            $('#modal-body').html('');
                        });
                    } else
                        toastr.error('{{ trns('something_went_wrong') }}');


                    $('#editOrCreate').modal('hide');
                    if (data.redirect) {
                        setTimeout(function() {
                            window.location.href = data.redirect;
                        }, 1000);
                    } else {
                        $('#dataTable').DataTable().ajax.reload();
                    }
                },
                error: function(data) {
                    if (data.status === 500) {
                        toastr.error('{{ trns('something_went_wrong') }}');
                    } else if (data.status === 422) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors.errors, function(key, value) {
                            $('#' + key).next('.invalid-feedback').remove();
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).after('<div class="invalid-feedback">' + value[0] +
                                '</div>');
                        });
                    } else
                        toastr.error('{{ trns('something_went_wrong') }}');
                    $('#updateButton').html(`{{ trns('update') }}`).attr('disabled', false);
                }, //end error method

                cache: false,
                contentType: false,
                processData: false
            });
        });
    }

    function deleteSelected(route, type = null) {
        $(document).ready(function() {
            $('#bulk-delete').prop('disabled', true);

            $('#select-all').on('click', function() {
                const isChecked = $(this).is(':checked');
                $('.delete-checkbox').prop('checked', isChecked);
                toggleBulkDeleteButton();
            });

            $(document).on('change', '.delete-checkbox', function() {
                toggleBulkDeleteButton();
            });

            $('#bulk-delete').on('click', function() {
                const selected = $('.delete-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selected.length > 0) {
                    $('#deleteConfirmModal').modal('show');

                    $('#confirm-delete-btn').off('click').on('click', function() {
                        $.ajax({
                            url: route,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ids: selected,
                                'type': type
                            },
                            success: function(response) {
                                if (response.status === 200) {

                                    Swal.fire({
                                        title: '<span style="margin-bottom: 50px; display: block;">{{ trns('changed_successfully') }}</span>',
                                        imageUrl: '{{ asset('true.png') }}',
                                        imageWidth: 80,
                                        imageHeight: 80,
                                        imageAlt: 'Success',
                                        showConfirmButton: false,
                                        timer: 500,
                                        customClass: {
                                            image: 'swal2-image-mt30'
                                        }
                                    });
                                    $('#select-all').prop('checked', false);
                                    $('.delete-checkbox').prop('checked', false);
                                    $('#dataTable').DataTable().ajax.reload();
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{ trns('something_went_wrong') }}'
                                    });
                                }
                                $('#deleteConfirmModal').modal('hide');
                                toggleBulkDeleteButton();
                            },
                            error: function() {
                                toastr.error('{{ trns('something_went_wrong') }}');
                                $('#deleteConfirmModal').modal('hide');
                                toggleBulkDeleteButton();
                            }
                        });
                    });
                }
            });

            function toggleBulkDeleteButton() {
                const anyChecked = $('.delete-checkbox:checked').length > 0;
                $('#bulk-delete').prop('disabled', !anyChecked);
            }
        });
    }

    function updateColumnSelected(route) {
        $(document).ready(function() {
            $('#bulk-update').prop('disabled', true);

            $('#select-all').on('click', function() {
                const isChecked = $(this).is(':checked');
                $('.delete-checkbox').prop('checked', isChecked);
                toggleBulkUpdateButton();
            });

            $(document).on('change', '.delete-checkbox', function() {
                toggleBulkUpdateButton();
            });

            $('#bulk-update').on('click', function() {
                const selected = $('.delete-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selected.length > 0) {
                    $('#updateConfirmModal').modal('show');

                    // Handle update confirmation
                    $('#confirm-update-btn').off('click').on('click', function() {
                        $.ajax({
                            url: route,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ids: selected
                            },
                            success: function(data) {
                                if (data.status === 200) {
                                    toastr.success(
                                        '{{ trns('updated_successfully') }}');
                                    $('#select-all').prop('checked', false);
                                    $('.delete-checkbox').prop('checked', false);
                                    $('#dataTable').DataTable().ajax.reload();
                                } else {
                                    toastr.error(
                                        '{{ trns('something_went_wrong') }}');
                                }
                                $('#updateConfirmModal').modal('hide');
                                toggleBulkUpdateButton();
                            },
                            error: function(xhr) {
                                toastr.error('{{ trns('something_went_wrong') }}');
                                $('#updateConfirmModal').modal('hide');
                                toggleBulkUpdateButton();
                            }
                        });
                    });
                } else {
                    toastr.error('{{ trns('please_select_first') }}');
                }
            });

            function toggleBulkUpdateButton() {
                const anyChecked = $('.delete-checkbox:checked').length > 0;
                $('#bulk-update').prop('disabled', !anyChecked);
            }
        });
    }

    function updateStatus(route) {

        $(document).on('click', '.statusBtnOne', function() {
            let ids = [];
            ids.push($(this).data('id'));
            var val = $(this).is(':checked') ? 'active' : 'inactive';

            $.ajax({
                type: 'POST',
                url: route,
                data: {
                    "_token": "{{ csrf_token() }}",
                    'ids': ids,
                },
                success: function(data) {
                    if (data.status === 200) {
                        // window.location.reload();
                        $('#dataTable').DataTable().ajax.reload();
                        if (val === 'active') {
                            toastr.success('Success', "{{ trns('active') }}");
                        } else {
                            toastr.warning('Success', "{{ trns('inactive') }}");
                        }
                    } else {
                        toastr.error('Error', "{{ trns('something_went_wrong') }}");
                    }
                },
                error: function() {
                    toastr.error('Error', "{{ trns('something_went_wrong') }}");
                }
            });
        });
    }
</script>

<script>
    function openModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('imageModal').style.display = "block";
    }

    function closeModal() {
        document.getElementById('imageModal').style.display = "none";
    }

    // Also close when clicking outside the image
    window.onclick = function(event) {
        const modal = document.getElementById('imageModal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>


<script>
    function initCantDeleteModalHandler() {
        $(document).on('click', '.show-cant-delete-modal', function() {
            const message = $(this).data('title');
            $('#cantDeleteMessage').text(message);
        });
    }
</script>

<script>
    function deleteScriptInShow(routeTemplate) {
        $(document).ready(function() {
            // Configure modal event listeners
            $('#delete_modal_of_show').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var title = button.data('title');
                var modal = $(this);
                modal.find('.modal-body #delete_id').val(id);
                modal.find('.modal-body #title').text(title);
            });

            $(document).on('click', '#delete_btn_of_show', function() {
                var id = $("#delete_id").val();
                var routeOfDelete = routeTemplate.replace(':id', id);

                $.ajax({
                    type: 'DELETE',
                    url: routeOfDelete,
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'id': id
                    },
                    success: function(data) {
                        if (data.status === 200) {
                            $('#delete_modal').modal('hide');


                            Swal.fire({
                                title: '<span style="margin-bottom: 50px; display: block;">{{ trns('success') }}</span>',
                                imageUrl: '{{ asset('true.png') }}',
                                imageWidth: 80,
                                imageHeight: 80,
                                imageAlt: 'Success',
                                showConfirmButton: false,
                                timer: 500,
                                customClass: {
                                    image: 'swal2-image-mt30'
                                }
                            });
                            // retrun redirect to table
                            window.location.href = document.referrer;
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ trns('Deletion failed') }}',
                                text: data.message ||
                                    '{{ trns('Something went wrong') }}',
                                confirmButtonText: '{{ trns('OK') }}'
                            });
                        }
                    },

                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ trns('Error') }}',
                            text: xhr.responseJSON?.message ||
                                '{{ trns('Something went wrong') }}',
                            confirmButtonText: '{{ trns('OK') }}'
                        });
                    }
                });
            });
        });
    }
</script>



<script>
    function showAddModalInShow(routeOfShow, data = {}) {
        $('#modal-footer').html(`
            <div class="w-100 d-flex">
                <button type="button" class="btn btn-two" data-bs-dismiss="modal">{{ trns('close') }}</button>
                <button type="submit" class="btn btn-one me-2" id="addButton">{{ trns('create') }}</button>
            </div>
        `);

        $('#modal-body').html(loader);
        $('#editOrCreate').modal('show');

        setTimeout(function() {
            $.ajax({
                url: routeOfShow,
                method: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#modal-body').html(response);

                    setTimeout(function() {
                        $(document).off('click', '#addButton').on('click', '#addButton',
                            function(e) {
                                e.preventDefault();

                                let form = $('#editOrCreate').find('form');
                                let action = form.attr('action');
                                let method = form.attr('method') || 'POST';
                                let formData = new FormData(form[0]);

                                $.ajax({
                                    url: action,
                                    method: method,
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(res) {
                                        $('#editOrCreate').modal('hide');
                                        Swal.fire({
                                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('added_successfully') }}</span>',
                                            imageUrl: '{{ asset('true.png') }}',
                                            imageWidth: 80,
                                            imageHeight: 80,
                                            imageAlt: 'Success',
                                            showConfirmButton: false,
                                            timer: 500,
                                            customClass: {
                                                image: 'swal2-image-mt30'
                                            }
                                        });

                                        setTimeout(function() {
                                            location.reload();
                                        }, 1500);
                                    },
                                    error: function(xhr) {
                                        $('#addButton').html(
                                                '{{ trns('add') }}')
                                            .attr('disabled', false);

                                        if (xhr.status === 500) {
                                            Swal.fire({
                                                icon: 'error',
                                                title: '{{ trns('server_error') }}',
                                                text: '{{ trns('internal_server_error') }}'
                                            });
                                        } else if (xhr.status === 422) {
                                            var errors = xhr.responseJSON
                                                .errors;
                                            $.each(errors, function(field,
                                                messages) {
                                                var input = $(
                                                    '[name="' +
                                                    field + '"]'
                                                );
                                                input.addClass(
                                                    'is-invalid'
                                                );
                                                var errorHtml =
                                                    '<div class="invalid-feedback">' +
                                                    messages[0] +
                                                    '</div>';
                                                input.after(
                                                    errorHtml);
                                            });

                                            var firstErrorField = Object
                                                .keys(errors)[0];
                                            $('[name="' + firstErrorField +
                                                '"]').focus();
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
                    }, 100);
                },
                error: function() {
                    $('#modal-body').html(
                        '<div class="alert alert-danger">فشل في تحميل البيانات</div>');
                }
            });
        }, 250);
    }








    function initBulkActions(deleteRoute, updateRoute, type = null) {
        $(document).ready(function() {
            $('#bulk-delete-selected').prop('disabled', true);
            $('#bulk-update-selected').prop('disabled', true);


            // Select All
            $('#select-all').on('click', function() {
                const isChecked = $(this).is(':checked');
                $('.row-checkbox').prop('checked', isChecked);
                toggleBulkButtons();
            });

            // On checkbox change
            $(document).on('change', '.row-checkbox', function() {
                toggleBulkButtons();
            });

            // Bulk Delete
            $('#bulk-delete-selected').on('click', function() {
                let selected_names = [];
                let checked_items = [];
                let data_message = [];
                let data_related = [];
                const selected = $('.row-checkbox:checked').filter(function() {
                    checked_items.push($(this).data('name'));

                    return $(this).data('type') === 'both';
                }).map(function() {
                    selected_names.push($(this).data('name'));
                    data_message.push($(this).data('message'));
                    data_related.push($(this).data('related'));
                    return $(this).val();
                }).get();



                let hasSelectedNames = selected_names.length < checked_items.length;


                // send selected names to modal
                let namesHtml = selected_names.length ?
                    '<ul style="  list-style: disclosure-closed; display:flex; flex-wrap: wrap;">' +
                    selected_names.map(name => `<li style="margin: 0 12px 10px 50px;">${name}</li>`)
                    .join('') + '</ul>' :
                    '{{ trns('no_items_selected') }}';
                $('#deleteConfirmModal .selected-names-list').html(namesHtml);

                if (hasSelectedNames) {
                    let messageHtml = `<p class="alert alert-danger">
                                        ${trnsJS(data_message[0],data_related[0])}
                                    </p>`;

                    $('#deleteConfirmModal .alert_massage').html(messageHtml);
                }



                $('#deleteConfirmModal').modal('show');

                $('#confirm-delete-btn').off('click').on('click', function() {
                    $.ajax({
                        url: deleteRoute,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ids: selected,
                            type: type
                        },
                        success: function(response) {
                            if (response.status === 200) {
                                Swal.fire({
                                    title: '<span style="margin-bottom: 50px; display: block;">{{ trns('deleted_successfully') }}</span>',
                                    imageUrl: '{{ asset('true.png') }}',
                                    imageWidth: 80,
                                    imageHeight: 80,
                                    showConfirmButton: false,
                                    timer: 500
                                });
                                $('#select-all').prop('checked', false);
                                $('.row-checkbox').prop('checked', false);
                                $('#dataTable').DataTable().ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: '{{ trns('something_went_wrong') }}'
                                });
                            }
                            $('#deleteConfirmModal').modal('hide');
                            toggleBulkButtons();
                        },
                        error: function() {
                            toastr.error('{{ trns('something_went_wrong') }}');
                            $('#deleteConfirmModal').modal('hide');
                            toggleBulkButtons();
                        }
                    });
                });
            });

            // Bulk Update
            $('#bulk-update-selected').on('click', function() {
                const selected = $('.row-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();



                $('#updateConfirmModal').modal('show');

                $('#confirm-update-btn').off('click').on('click', function() {
                    $.ajax({
                        url: updateRoute,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ids: selected
                        },
                        success: function(data) {
                            if (data.status === 200) {
                                Swal.fire({
                                    title: '<span style="margin-bottom: 50px; display: block;">{{ trns('updated_successfully') }}</span>',
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
                                $('#select-all').prop('checked', false);
                                $('.row-checkbox').prop('checked', false);
                                $('#dataTable').DataTable().ajax.reload();
                            } else {
                                toastr.error(
                                    '{{ trns('something_went_wrong') }}');
                            }
                            $('#updateConfirmModal').modal('hide');
                            toggleBulkButtons();
                        },
                        error: function() {
                            toastr.error('{{ trns('something_went_wrong') }}');
                            $('#updateConfirmModal').modal('hide');
                            toggleBulkButtons();
                        }
                    });
                });
            });

            // Toggle Buttons State
            function toggleBulkButtons() {
                const anyChecked = $('.row-checkbox:checked').length > 0;
                const anyDeletable = $('.row-checkbox:checked[data-type="both"]').length > 0;

                $('#bulk-update-selected').prop('disabled', !anyChecked);
                $('#bulk-delete-selected').prop('disabled', !anyDeletable);
            }
        });
    }

    function trnsJS(messageAttr, relatedAttr) {
        const lang = "{{ app()->getLocale() }}";
        const translations = {
            en: {
                users: "users",
                admins: "admins",
                associations: "associations",
                other_real_states: "other real states",
                real_states: "real states",
                units: "other units",
                cannot_be_deleted_because_they_related_to: "cannot be deleted because they is related to"

            },
            ar: {
                users: " المستخدمين الاخرين",
                admins: " المشرفين الاخرين",
                real_states: " عقارات",
                other_real_states: "العقارات أخرى",
                associations: "الجمعيات الاخري",
                units: "وحدات",
                cannot_be_deleted_because_they_related_to: "لا يمكن حذفهم  لأنهم مرتبطين بـ"

            },
        };


        const langDict = translations[lang] || translations['en'];
        const trans = langDict[messageAttr]+' '+langDict['cannot_be_deleted_because_they_related_to']+langDict[relatedAttr]   ;

        return trans;
    }
</script>
