@extends('admin.layouts.master')
@section('page_name')
 <a href="{{ route('real_states.index') }}" >
        {{ trns('real_states') }}
 </a>
@endsection



@section('title', trns('main-information'))

@section('content')
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
                        style="background-color: white; border: 1px solid #00193a; color: #00193a; padding: 5px; transform: rotate(180deg); margin-right:10px;"
                        class="btn" style="min-width: 150px;">
                        <i class="fas fa-long-arrow-alt-right mr-2"></i>

                    </a>
                </div>
                <ul class="nav nav-tabs" id="realEstateTabs">
                    <li class="nav-item">
                        <a class="nav-link  {{ routeActive('real-estate.main-information') }}"
                            href="{{ route('real-estate.main-information', ['id' => $obj->id]) }}">{{ trns('main information') }}</a>
                    </li>

                    {{--        <li class="nav-item"> --}}
                    {{--            <a class="nav-link" href="{{ route('real-estate.property', ['id' => $obj->id]) }}">{{ trns('property') }}</a> --}}
                    {{--        </li> --}}
                    <li class="nav-item">
                        <a class="nav-link {{ routeActive('real-estate.association') }}"
                            href="{{ route('real-estate.association', ['id' => $obj->id]) }}">{{ trns('association') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  {{ routeActive('real-estate.property') }}"
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
            </div>

            <div style="border-radius: 6px;
    background-color: #fbf9f9;
    border: 1px solid #ddd;
    padding: 15px;">

                <div class="container m-5">

                    <div class="px-0 mb-5">
                        <div class="mb-4">
                            <!-- Left side - Title -->
                            <div class="flex-grow-1">
                                <h4 class="mb-0 text-primary" style="font-weight: bold; color: #00193a;">
                                    {{ trns('basic information') }}</h4>
                            </div>


                        </div>
                    </div>




                </div>
                <hr style="background-color: black;">
                <div class="row">
                    <div class="col-12 row text-center">


                        <div class="col-3 mb-4">
                            <h4> {{ trns('association name') }} </h4>
                            <p>{{ $obj->association->name }} {!! copyable_text($obj->association->name) !!}</p>
                        </div>

                        <div class="col-3 mb-4">
                            <h4> {{ trns('real_state_name') }} </h4>
                            <p>{{ $obj->name }} {!! copyable_text($obj->name) !!}</p>
                        </div>


                        <div class="col-3 mb-4">
                            <h4> {{ trns('street') }} </h4>
                            <p>{{ $obj->realStateDetails?->street }}</p>
                        </div>
                        <div class="col-3 mb-4">
                            <h4> {{ trns('space') }} </h4>
                            <p>{{ $obj->realStateDetails?->space }}</p>
                        </div>




                        <div class="col-3 mb-4">
                            <h4> {{ trns('area') }} </h4>
                            <p>{{ $obj->realStateDetails?->area }}</p>
                        </div>
                        <div class="col-3 mb-4">
                            <h4> {{ trns('flat space') }} </h4>
                            <p>{{ $obj->realStateDetails?->flat_space }}</p>
                        </div>
                        <div class="col-3 mb-4">
                            <h4> {{ trns('part number') }} </h4>
                            <p>{{ $obj->realStateDetails?->part_number }}</p>
                        </div>
                        <div class="col-3 mb-4">
                            <h4> {{ trns('bank account number') }} </h4>
                            <p>{{ $obj->realStateDetails?->bank_account_number }} {!! copyable_text($obj->realStateDetails?->bank_account_number) !!}</p>
                        </div>
                        <div class="col-3 mb-4">
                            <h4> {{ trns('mint number') }} </h4>
                            <p>{{ $obj->realStateDetails?->mint_number }} {!! copyable_text($obj->realStateDetails?->mint_number) !!}</p>
                        </div>

                        <div class="col-3 mb-4">
                            <h4> {{ trns('mint source') }} </h4>
                            <p>{{ $obj->realStateDetails?->mint_source }}</p>
                        </div>
                        <div class="col-3 mb-4">
                            <h4> {{ trns('floor count') }} </h4>
                            <p>{{ $obj->realStateDetails?->floor_count }}</p>
                        </div>
                        <div class="col-3 mb-4">
                            <h4> {{ trns('elevator count') }} </h4>
                            <p>{{ $obj->realStateDetails?->elevator_count }}</p>
                        </div>
                        <div class="col-3 mb-4">
                            <h4> {{ trns('building year') }} </h4>
                            <p>{{ $obj->realStateDetails?->building_year }}</p>
                        </div>
{{--                        <div class="col-3 mb-4">--}}
{{--                            <h4> {{ trns('building count') }} </h4>--}}
{{--                            <p>{{ $obj->realStateDetails?->building_count }}</p>--}}
{{--                        </div>--}}
                        <div class="col-3 mb-4">
                            <h4> {{ trns('electric account number') }} </h4>
                            <p>{{ $obj->realStateDetails?->electric_account_number }} {!! copyable_text($obj->realStateDetails?->electric_account_number) !!}</p>
                        </div>
                        <div class="col-3 mb-4">
                            <h4> {{ trns('electric meter number') }} </h4>
                            <p>{{ $obj->realStateDetails?->electric_meter_number }} {!! copyable_text($obj->realStateDetails?->electric_meter_number) !!}</p>
                        </div>
                        <div class="col-3 mb-4">
                            <h4> {{ trns('water account number') }} </h4>
                            <p>{{ $obj->realStateDetails?->water_account_number }} {!! copyable_text($obj->realStateDetails?->water_account_number) !!}</p>
                        </div>
                        <div class="col-3 mb-4">
                            <h4> {{ trns('water meter number') }} </h4>
                            <p>{{ $obj->realStateDetails?->water_meter_number }} {!! copyable_text($obj->realStateDetails?->water_meter_number) !!}</p>
                        </div>
                        <div class="col-3 mb-4">
                            <h4> {{ trns('northern border') }} </h4>
                            <p>{{ $obj->realStateDetails?->northern_border }}</p>
                        </div>
                        <div class="col-3 mb-4">
                            <h4> {{ trns('southern border') }} </h4>
                            <p>{{ $obj->realStateDetails?->southern_border }}</p>
                        </div>
                        <div class="col-3 mb-4">
                            <h4> {{ trns('eastern border') }} </h4>
                            <p>{{ $obj->realStateDetails?->eastern_border }}</p>
                        </div>
                        <div class="col-3 mb-4">
                            <h4> {{ trns('western border') }} </h4>
                            <p>{{ $obj->realStateDetails?->western_border }}</p>

                        </div>




                        <div class="col-3 mb-4">
                            <h4> {{ trns('status') }} </h4>
                            <p>
                                @if ($obj->status == 1)
                                    <span style="border-radius: 10%"
                                        class="bg-success text-white rounded px-3 py-2">{{ trns('active') }}</span>
                                @else
                                    <span style="border-radius: 10%"
                                        class="bg-danger text-white rounded px-3 py-2">{{ trns('inactive') }}</span>
                                @endif
                            </p>
                        </div>


                        <div class="col-3 mb-4">
                            <h4> {{ trns('location') }} </h4>
                            <p> <a href="https://www.google.com/maps?q={{ $obj->lat }},{{ $obj->long }}"
                                    target="_blank" class="btn btn-sm btn-primary">{{ trns('go location') }}</a></p>
                        </div>

                        <div class="col-3 mb-4">
                            <h4> {{ trns('stop reason') }} </h4>
                            <p>{{ $obj->stop_reason }}</p>
                        </div>





                    </div>
                </div>


{{--            </div>--}}

            <div class="p-5 w-100 mt-4"
                style="border-radius: 6px;
                                    background-color: #fbf9f9;
                                    border: 1px solid #ddd;
                                    padding: 15px;">
                <div class="col-12 mb-4 w-100">

                    <h4>{{ trns('owners_management') }}</h4>

                    <h4 style="font-weight: bold; color: #00193a;">{{ trns('owners_management') }}</h4>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="text-white">{{ trns('national_id') }}</th>
                                    <th scope="col" class="text-white">{{ trns('name') }}</th>
                                    <th scope="col" class="text-white">{{ trns('email') }}</th>
                                    <th scope="col" class="text-white">{{ trns('phone') }}</th>

                                    <th scope="col" class="text-white">{{ trns('status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($obj->users as $user)
                                    <tr>
                                        <td>{{ $user->national_id }} {!! copyable_text($user->national_id) !!}</td>
                                        <td>{{ $user->name }} {!! copyable_text($user->name) !!}</td>
                                        <td>{{ $user->email }} {!! copyable_text($user->email) !!}</td>
                                        <td>{{ $user->phone }} {!! copyable_text($user->phone) !!}</td>

                                        <td>
                                            <div class="status-badge">
                                                @if ($user->status == 1)
                                                    <span
                                                        class="badge bg-success text-white px-3 py-2 rounded">{{ trns('active') }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-danger text-white px-3 py-2 rounded">{{ trns('inactive') }}</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <th scope="col" class="text-white">{{ trns('national_id') }}</th>
                                    <th scope="col" class="text-white">{{ trns('name') }}</th>
                                    <th scope="col" class="text-white">{{ trns('email') }}</th>
                                    <th scope="col" class="text-white">{{ trns('phone') }}</th>

                                    <th scope="col" class="text-white">{{ trns('status') }}</th>
                                </tr>
                                </thead>
                            <tbody>
                                @foreach ($obj->users as $user)
                                    <tr>
                                        <td>{{ $user->national_id }} {!! copyable_text($user->national_id) !!}</td>
                                        <td>{{ $user->name }} {!! copyable_text($user->name) !!}</td>
                                        <td>{{ $user->email }} {!! copyable_text($user->email) !!}</td>
                                        <td>{{ $user->phone }} {!! copyable_text($user->phone) !!}</td>

                                        <td>
                                            <div class="status-badge">
                                                @if ($user->status == 1)
                                                    <span class="badge text-white px-3 py-2"
                                                        style="background-color: #06e7c1; color: #00193a;">{{ trns('active') }}</span>
                                                @else
                                                    <span class="badge text-white px-3 py-2"
                                                        style="background-color: #ffb7b1; color: #00193a;">{{ trns('inactive') }}</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
    </div>


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>


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
                    window.location.reload();


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
