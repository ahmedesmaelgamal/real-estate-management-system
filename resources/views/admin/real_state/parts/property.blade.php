@extends('admin.layouts.master')
@section('title', trns('property'))
@section('page_name')
    <a href="{{ route('real_states.index') }}">
        {{ trns('real_states') }} / {{ $obj->name }}
    </a>
@endsection
@section('content')
    <div class="p-5">

        <!-- Right side - Actions -->
        <div class="d-flex align-items-center justify-content-end">
            <!-- Options Dropdown -->
            <div class="dropdown mr-3">
                <button class="btn dropdown-toggle d-flex align-items-center" style="background-color: #00193a; color: white;"
                    type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ trns('options') }}
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item d-flex align-items-center"
                        href="{{ route('real_states.index') }}?edit_user={{ $obj->id }}&show_modal=true">
                        <i class="fas fa-edit mr-2"></i>
                        {{ trns('update') }}
                    </a>
                    <a class="dropdown-item d-flex align-items-center toggleStatusBtn" href="#"
                        data-id="{{ $obj->id }}" data-status="{{ $obj->status }}">
                        <i class="fas fa-power-off mr-2"></i>
                        {{ $obj->status == 1 ? trns('Deactivate_real_state') : trns('Activate_real_state') }}
                    </a>
                </div>
            </div>

            <!-- Back Button -->
            <a href="{{ route('real_states.index') }}" class="btn"
                style="background-color: white; border: 1px solid #00193a; color: #00193a; padding: 5px; transform: rotate(180deg); margin-right:10px;">
                <i class="fas fa-long-arrow-alt-right mr-2"></i>
            </a>
        </div>

        <ul class="nav nav-tabs" id="realEstateTabs">
            <li class="nav-item">
                <a class="nav-link {{ routeActive('real-estate.main-information') }}"
                    href="{{ route('real-estate.main-information', ['id' => $obj->id]) }}">{{ trns('main information') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ routeActive('real-estate.association') }}"
                    href="{{ route('real-estate.association', ['id' => $obj->id]) }}">{{ trns('association') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ routeActive('real-estate.property') }}"
                    href="{{ route('real-estate.property', ['id' => $obj->id]) }}">{{ trns('property') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ routeActive('real-estate.images') }}"
                    href="{{ route('real-estate.images', ['id' => $obj->id]) }}">{{ trns('images') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ routeActive('real-estate.documents') }}"
                    href="{{ route('real-estate.documents', ['id' => $obj->id]) }}">{{ trns('documents') }}</a>
            </li>
        </ul>

        <div class="container m-5">

            <div class="row">
                <!-- <div class="container-fluid px-0 mb-5">
        <div class="d-flex align-items-center mb-4">
            <div class="flex-grow-1">
                <h4 class="mb-0 text-primary">{{ trns('basic information') }}</h4>
            </div>


        </div>
    </div> -->
                <div class="table-responsive">
                   @if($units)


                             <table class="table table-striped table-bordered w-100">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-white">{{ trns('unit_number') }}</th>
                                <th class="text-white">{{ trns('space') }}</th>
                                <th class="text-white">{{ trns('unit_code') }}</th>
                                <th class="text-white">{{ trns('status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($units as $unit)
                                <tr data-bs-toggle="collapse" data-bs-target="#collapseExample-{{ $unit->unit_number }}"
                                    aria-expanded="false" aria-controls="collapseExample-{{ $unit->unit_number }}">
                                    <td>{{ $unit->unit_number }} {!! copyable_text($unit->unit_number) !!}</td>
                                    <td>{{ $unit->space }}</td>
                                    <td>{{ $unit->unit_code }}</td>
                                    <td>
                                        <div class="status-badge">
                                            @if ($unit->status == 1)
                                                <span class="badge px-3 py-2"
                                                    style="background-color: #06e7c1; color: #00193a; border-radius: 10px;">{{ trns('active') }}</span>
                                            @else
                                                <span class="badge px-3 py-2"
                                                    style="background-color: #ffb7b1; color: #00193a; border-radius: 10px;">{{ trns('inactive') }}</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <div class="collapse" id="collapseExample-{{ $unit->unit_number }}">
                                            <div class="card card-body">
                                                <div class="row">
                                                    <div class="col-3 mb-4">
                                                        <h4>{{ trns('unit number') }}</h4>
                                                        <p>{{ $unit->unit_number }}</p>
                                                    </div>
                                                    <div class="col-3 mb-4">
                                                        <h4>{{ trns('RealState name') }}</h4>
                                                        <p>{{ $obj->name }}</p>
                                                    </div>
                                                    <div class="col-3 mb-4">
                                                        <h4>{{ trns('description') }}</h4>
                                                        <p>{{ $unit->description }}</p>
                                                    </div>
                                                    <div class="col-3 mb-4">
                                                        <h4>{{ trns('space') }}</h4>
                                                        <p>{{ $unit->space }}</p>
                                                    </div>
                                                    <div class="col-3 mb-4">
                                                        <h4>{{ trns('unit_code') }}</h4>
                                                        <p>{{ $unit->unit_code }}</p>
                                                    </div>
                                                    <div class="col-3 mb-4">
                                                        <h4>{{ trns('floor_count') }}</h4>
                                                        <p>{{ $unit->floor_count }}</p>
                                                    </div>
                                                    <div class="col-3 mb-4">
                                                        <h4>{{ trns('bathrooms_count') }}</h4>
                                                        <p>{{ $unit->bathrooms_count }}</p>
                                                    </div>
                                                    <div class="col-3 mb-4">
                                                        <h4>{{ trns('northern_border') }}</h4>
                                                        <p>{{ $unit->northern_border }}</p>
                                                    </div>
                                                    <div class="col-3 mb-4">
                                                        <h4>{{ trns('eastern_border') }}</h4>
                                                        <p>{{ $unit->eastern_border }}</p>
                                                    </div>
                                                    <div class="col-3 mb-4">
                                                        <h4>{{ trns('western_border') }}</h4>
                                                        <p>{{ $unit->western_border }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                @else
                   <h1>{{trns("there is no data here")}}</h1>

                   @endif

                   
                </div>

                <div class="mt-4">
                    {{ $units->links() }}
                </div>

            </div>
        </div>
    </div>
    </div>



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
