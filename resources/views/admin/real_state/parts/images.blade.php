
@extends('admin.layouts.master')
@section("title" , trns("images"))
@section('page_name')
 <a href="{{ route('real_states.index') }}" >
        {{ trns('real_states') }} / {{ $obj->name }}
 </a>
@endsection
@section('content')
    <style>
        .gallery-image {
            cursor: pointer;
            transition: 0.3s;
            margin: 5px;
        }

        .gallery-image:hover {
            opacity: 0.7;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
        }

        /* Modal Content (image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 75vw;
            height: auto;
        }

        /* Close Button */
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
    </style>


    <div class="p-5">

     <!-- Right side - Actions -->
     <div class="d-flex align-items-center justify-content-end">
            <!-- Options Dropdown -->
            <div class="dropdown mr-3">
                <button class="btn dropdown-toggle d-flex align-items-center" style="background-color: #00193a; color: white;"
                        type="button"
                        id="dropdownMenuButton"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                    {{ trns("options") }}
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item d-flex align-items-center"
                       href="{{ route('real_states.index') }}?edit_user={{ $obj->id }}&show_modal=true">
                        <i class="fas fa-edit mr-2"></i>
                        {{ trns("update") }}
                    </a>
                    <a class="dropdown-item d-flex align-items-center toggleStatusBtn"
                       href="#"
                       data-id="{{ $obj->id }}"
                       data-status="{{ $obj->status }}">
                        <i class="fas fa-power-off mr-2"></i>
                        {{ $obj->status == 1 ? trns('Deactivate_real_state') : trns('Activate_real_state') }}
                    </a>
                </div>
            </div>

            <!-- Back Button -->
            <a href="{{ route('real_states.index') }}"
               class="btn"
               style="background-color: white; border: 1px solid #00193a; color: #00193a; padding: 5px; transform: rotate(180deg); margin-right:10px;">
                <i class="fas fa-long-arrow-alt-right mr-2"></i>
            </a>
        </div>

    <ul class="nav nav-tabs" id="realEstateTabs">
        <li class="nav-item">
            <a class="nav-link  {{ routeActive("real-estate.main-information") }}" href="{{ route('real-estate.main-information', ['id' => $obj->id]) }}">{{ trns("main information") }}</a>
        </li>

{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="{{ route('real-estate.property', ['id' => $obj->id]) }}">{{ trns('property') }}</a>--}}
{{--        </li>--}}
        <li class="nav-item">
            <a class="nav-link {{ routeActive("real-estate.association") }}" href="{{ route('real-estate.association', ['id' => $obj->id]) }}">{{ trns('association') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link  {{ routeActive("real-estate.property") }}" href="{{ route('real-estate.property', ['id' => $obj->id]) }}">{{ trns('property') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ routeActive("real-estate.images") }}" href="{{ route('real-estate.images', ['id' => $obj->id]) }}">{{ trns("images") }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ routeActive("real-estate.documents") }}" href="{{ route('real-estate.documents', ['id' => $obj->id]) }}">{{ trns("documents") }}</a>
        </li>
    </ul>

    <div class="w-100">
         <!-- <div class="container-fluid px-0 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="flex-grow-1">
            <h4 class="mb-0 text-primary">{{ trns("basic information") }}</h4>
        </div>
    </div>
</div> -->


        </div>
        <hr class="divider">
        <div id="tab3">
            {{-- <h3>{{ trns("logo") }}</h3>
            @if($obj->getMedia('logos')->isNotEmpty())
                <div class="row">
                    @foreach($obj->getMedia('logos') as $media)
                        <div class="col-4 text-center">
                            <img
                                src="{{ asset('storage/' . $media->id . '/' . $media->file_name) }}"
                                alt="Logo"
                                style="max-height: 350px"
                                class="gallery-image"
                                onclick="openModal('{{ asset('storage/' . $media->id . '/' . $media->file_name) }}')">
                        </div>
                    @endforeach
                </div>
            @endif --}}

            <hr/>
            <br>

            <h3>{{ trns("images") }}</h3>
            {{-- @if($obj->getMedia('images')->isNotEmpty())
                <div class="row">
                    @foreach($obj->getMedia('images') as $media)
                        <div class="col-4 text-center">
                            <img
                                src="{{ asset('storage/' . $media->id . '/' . $media->file_name) }}"
                                alt="Image"
                                style="max-width: 350px"
                                height="150"
                                class="gallery-image"
                                onclick="openModal('{{ asset('storage/' . $media->id . '/' . $media->file_name) }}')">
                        </div>
                    @endforeach
                </div>
            @endif --}}

            <div id="imageModal" class="modal">
                <span class="close" onclick="closeModal()">&times;</span>
                <img class="modal-content" id="modalImage">
            </div>



    @if($obj->getMedia('images')->isNotEmpty())
            <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>{{trns("rated_number")}}</th>
                            <th>{{ trns('image_name') }}</th>
                            <th>{{ trns('Size (KB)') }}</th>
                            <th>{{ trns('created_at') }}</th>
                            <th>{{ trns('creator') }}</th>
                            <th>{{ trns('show') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($obj->getMedia('images') as $media)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                 <td style="cursor: pointer;" onclick="openModal('{{ asset('storage/' . $media->id . '/' . $media->file_name) }}')">
                                        {{$media->file_name}}
                                 </td>
                                <td>{{ number_format($media->size / 1024, 2) }}</td> {{-- التحويل من بايت إلى كيلوبايت --}}
                                <td>{{ $media->created_at->format('Y-m-d H:i') }}</td>
                                <td>{{ @$obj->admin?->name}}</td>
                                <td style="cursor: pointer;" onclick="openModal('{{ asset('storage/' . $media->id . '/' . $media->file_name) }}')">
                                    <i class="fas fa-aya"></i>
                                    <?php  $media->file_name ?>
                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @else

                <h1>{{trns("there is no data here")}}</h1>

@endif


        </div>

    </div>
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




           <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <script>

    $(document).on('click', '.toggleStatusBtn', function(e) {
        e.preventDefault();

        let id = $(this).data('id');
        let currentStatus = parseInt($(this).data('status'));
        let newStatus = currentStatus === 1 ? 0 : 1;

        $.ajax({
            type: 'POST',
            url: '{{ route('real_states.updateColumnSelected') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                'ids': [id],
                'status': newStatus
            },
            success: function(data) {
                if (data.status === 200) {
                    toastr.success("{{ trns('status_changed_successfully') }}");


                    $('#dataTable').DataTable().ajax.reload(null, false);
                } else {
                    toastr.error("{{ trns('something_went_wrong') }}");
                }
            },
            error: function() {
                toastr.error("{{ trns('something_went_wrong') }}");
            }
        });
    });


    </script>



           <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <script>

    $(document).on('click', '.toggleStatusBtn', function(e) {
        e.preventDefault();

        let id = $(this).data('id');
        let currentStatus = parseInt($(this).data('status'));
        let newStatus = currentStatus === 1 ? 0 : 1;

        $.ajax({
            type: 'POST',
            url: '{{ route('real_states.updateColumnSelected') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                'ids': [id],
                'status': newStatus
            },
            success: function(data) {
                if (data.status === 200) {
                    toastr.success("{{ trns('status_changed_successfully') }}");


                    $('#dataTable').DataTable().ajax.reload(null, false);
                } else {
                    toastr.error("{{ trns('something_went_wrong') }}");
                }
            },
            error: function() {
                toastr.error("{{ trns('something_went_wrong') }}");
            }
        });
    });


    </script>
@endsection

