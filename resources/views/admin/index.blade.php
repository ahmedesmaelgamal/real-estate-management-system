@extends('admin/layouts/master')
@section('title')
    {{ config()->get('app.name') }} | {{ trns('home') }}
@endsection
@section('page_name')
    <h2 class="text-center">الصفحة الرسمية قيد التطوير</h2>
@endsection
@section('content')
    <!-- Create Or Edit Modal -->
    <div class="modal fade" id="editOrCreate" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="example-Modal3"></h5>
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




    <div class="d-flex justify-content-between mb-5 mt-5">
        <div>
            <h2 class="mb-0 fw-bold">{{ trns('welcome') }}
                <span>{{ auth()->user()->name }}</span>
            </h2>
            <p class="mb-0">
                {{ auth()->user()->last_login_at ? trns('latest_login_in_at') . ' ' . auth()->user()->last_login_at : '' }}
            </p>
            {{-- <p class="mb-0">
                {{ auth()->user()->last_logout_at
                    ? trns('latest_logout_in_at') . ' ' . auth()->user()->last_logout_at
                    : '' }}
            </p> --}}

        </div>  
        <div class="d-flex">
            @can('create_association')
                <button type="button" class="btn add_association" data-title="{{ trns('add_association') }}"
                    style="background-color: #00193a; color: #00F3CA; border: none;height: 35px; margin-left: 10px; font-size: 14px; font-weight: bold;">
                    {{ trns('add_association') }}
                </button>
            @endcan
            @can('create_real_state')
                <button type="button" class="btn add_realState" data-title="{{ trns('add_realState') }}"
                    style="background-color: #00F3CA; color: #00193a; border: none;height: 35px; margin-left: 10px; font-size: 14px; font-weight: bold;">
                    {{ trns('add_realState') }}
                </button>
            @endcan

        </div>
    </div>

    <div class="row">

        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="main-card1">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="fw-bold fs-2 ms-2">{{ $users }}</span>
                        <span class="perc-card {{ $userChange > 0 ? 'color-up' : ($userChange < 0 ? 'color-down' : '') }}">
                            {{ number_format(abs(floatval($userChange)), 1) }}%
                            @if ($userChange > 0)
                                <i class="fa-solid fa-arrow-up"></i>
                            @elseif ($userChange < 0)
                                <i class="fa-solid fa-arrow-down"></i>
                            @else
                                <i class="fa-solid fa-arrow-right"></i>
                            @endif
                        </span>
                    </div>
                    <div>
                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_264_31505)">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9.58576 15C10.1162 15.0001 10.6248 15.2109 10.9998 15.586L11.9998 16.586L12.9998 15.586C13.3747 15.2109 13.8834 15.0001 14.4138 15H18.4378C19.1067 15.0001 19.7564 15.2237 20.2836 15.6354C20.8109 16.047 21.1854 16.6231 21.3478 17.272L21.9698 19.758C22.0042 19.8862 22.0127 20.02 21.9948 20.1516C21.977 20.2831 21.9331 20.4098 21.8658 20.5243C21.7985 20.6387 21.709 20.7386 21.6027 20.8181C21.4964 20.8975 21.3753 20.9551 21.2465 20.9873C21.1177 21.0195 20.9837 21.0257 20.8525 21.0056C20.7213 20.9855 20.5953 20.9395 20.4821 20.8702C20.3688 20.8009 20.2705 20.7098 20.1929 20.6021C20.1152 20.4944 20.0597 20.3723 20.0298 20.243L19.4088 17.758C19.3548 17.5416 19.23 17.3494 19.0542 17.212C18.8785 17.0747 18.6618 17.0001 18.4388 17H14.4138L13.4138 18C13.0387 18.3749 12.5301 18.5856 11.9998 18.5856C11.4694 18.5856 10.9608 18.3749 10.5858 18L9.58576 17H5.56176C5.3387 17.0001 5.12206 17.0747 4.9463 17.212C4.77054 17.3494 4.64574 17.5416 4.59176 17.758L3.96976 20.243C3.93977 20.3723 3.88433 20.4944 3.80667 20.6021C3.72901 20.7098 3.63069 20.8009 3.51743 20.8702C3.40418 20.9395 3.27826 20.9855 3.14703 21.0056C3.01579 21.0257 2.88187 21.0195 2.75307 20.9873C2.62427 20.9551 2.50317 20.8975 2.39684 20.8181C2.2905 20.7386 2.20106 20.6387 2.13373 20.5243C2.06641 20.4098 2.02254 20.2831 2.00469 20.1516C1.98684 20.02 1.99536 19.8862 2.02976 19.758L2.65076 17.272C2.81309 16.6231 3.18763 16.047 3.71488 15.6354C4.24214 15.2237 4.89184 15.0001 5.56076 15H9.58576ZM11.9998 2C12.7838 2 13.6608 2.19 14.3798 2.391C16.0428 2.854 16.9998 4.41 16.9998 5.997V10.003C16.9998 11.591 16.0428 13.146 14.3798 13.609C13.6608 13.809 12.7838 14 11.9998 14C11.2158 14 10.3388 13.81 9.61976 13.609C7.95676 13.146 6.99976 11.591 6.99976 10.003V5.997C6.99976 4.41 7.95676 2.854 9.61976 2.391C10.3388 2.191 11.2158 2 11.9998 2ZM11.9998 4C11.4908 4 10.8228 4.132 10.1568 4.318C9.48876 4.504 8.99976 5.165 8.99976 5.997V10.003C8.99976 10.835 9.48876 11.496 10.1568 11.683C10.8228 11.868 11.4908 12 11.9998 12C12.5088 12 13.1768 11.868 13.8428 11.682C14.5108 11.496 14.9998 10.835 14.9998 10.003V5.997C14.9998 5.165 14.5108 4.504 13.8428 4.317C13.1768 4.133 12.5098 4 11.9998 4Z" />
                            </g>
                            <defs>
                                <clipPath id="clip0_264_31505">
                                    <rect width="24" height="24" />
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                </div>
                <h4 class="fw-bold mt-2">{{ trns('users') }}</h4>
            </div>
        </div>

        <!-- Associations Card -->
        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="main-card1">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="fw-bold fs-2 ms-2">{{ $Associations }}</span>
                        <span
                            class="perc-card {{ $associationChange > 0 ? 'color-up' : ($associationChange < 0 ? 'color-down' : '') }}">
                            {{ number_format(abs($associationChange), 1) }}%
                            @if ($associationChange > 0)
                                <i class="fa-solid fa-arrow-up"></i>
                            @elseif ($associationChange < 0)
                                <i class="fa-solid fa-arrow-down"></i>
                            @else
                                <i class="fa-solid fa-arrow-right"></i>
                            @endif
                        </span>
                    </div>
                    <div>
                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_264_31511)">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M10.753 2.19664C10.4792 2.10526 10.189 2.07422 9.90207 2.10564C9.61518 2.13705 9.33849 2.23018 9.091 2.37864L4.971 4.85064C4.67485 5.02833 4.42976 5.27969 4.25959 5.58023C4.08943 5.88078 4 6.22027 4 6.56564V19.9996H3C2.73478 19.9996 2.48043 20.105 2.29289 20.2925C2.10536 20.4801 2 20.7344 2 20.9996C2 21.2649 2.10536 21.5192 2.29289 21.7067C2.48043 21.8943 2.73478 21.9996 3 21.9996H21C21.2652 21.9996 21.5196 21.8943 21.7071 21.7067C21.8946 21.5192 22 21.2649 22 20.9996C22 20.7344 21.8946 20.4801 21.7071 20.2925C21.5196 20.105 21.2652 19.9996 21 19.9996H20V6.71964C19.9998 6.30017 19.8676 5.8914 19.6223 5.55115C19.377 5.21091 19.0309 4.9564 18.633 4.82364L10.753 2.19664ZM18 19.9996V6.71964L11 4.38764V19.9996H18ZM9 4.76564L6 6.56564V19.9996H9V4.76564Z" />
                            </g>
                            <defs>
                                <clipPath id="clip0_264_31511">
                                    <rect width="24" height="24" />
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                </div>
                <h4 class="fw-bold mt-2">{{ trns('associations') }}</h4>
            </div>
        </div>

        <!-- RealStates Card -->
        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="main-card1">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="fw-bold fs-2 ms-2">{{ $RealStates }}</span>
                        <span
                            class="perc-card {{ $realStateChange > 0 ? 'color-up' : ($realStateChange < 0 ? 'color-down' : '') }}">
                            {{ number_format(abs($realStateChange), 1) }}%
                            @if ($realStateChange > 0)
                                <i class="fa-solid fa-arrow-up"></i>
                            @elseif ($realStateChange < 0)
                                <i class="fa-solid fa-arrow-down"></i>
                            @else
                                <i class="fa-solid fa-arrow-right"></i>
                            @endif
                        </span>
                    </div>
                    <div>
                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_264_31517)">
                                <path
                                    d="M12.9999 3C13.5044 2.99984 13.9904 3.19041 14.3604 3.5335C14.7304 3.87659 14.957 4.34684 14.9949 4.85L14.9999 5V9H17.9999C18.5044 8.99984 18.9904 9.19041 19.3604 9.5335C19.7304 9.87659 19.957 10.3468 19.9949 10.85L19.9999 11V19H20.9999C21.2547 19.0003 21.4999 19.0979 21.6852 19.2728C21.8706 19.4478 21.9821 19.687 21.997 19.9414C22.012 20.1958 21.9292 20.4464 21.7656 20.6418C21.602 20.8373 21.37 20.9629 21.1169 20.993L20.9999 21H2.99987C2.74499 20.9997 2.49984 20.9021 2.3145 20.7272C2.12916 20.5522 2.01763 20.313 2.0027 20.0586C1.98776 19.8042 2.07054 19.5536 2.23413 19.3582C2.39772 19.1627 2.62977 19.0371 2.88287 19.007L2.99987 19H3.99987V5C3.99971 4.49542 4.19027 4.00943 4.53337 3.63945C4.87646 3.26947 5.34671 3.04284 5.84987 3.005L5.99987 3H12.9999ZM17.9999 11H14.9999V19H17.9999V11ZM12.9999 5H5.99987V19H12.9999V5ZM10.9999 15V17H7.99987V15H10.9999ZM10.9999 11V13H7.99987V11H10.9999ZM10.9999 7V9H7.99987V7H10.9999Z" />
                            </g>
                            <defs>
                                <clipPath id="clip0_264_31517">
                                    <rect width="24" height="24" />
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                </div>
                <h4 class="fw-bold mt-2">{{ trns('RealStates') }}</h4>
            </div>
        </div>

        <!-- Units Card -->
        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="main-card1">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="fw-bold fs-2 ms-2">{{ $units }}</span>
                        <span class="perc-card {{ $unitChange > 0 ? 'color-up' : ($unitChange < 0 ? 'color-down' : '') }}">
                            {{ number_format(abs($unitChange), 1) }}%
                            @if ($unitChange > 0)
                                <i class="fa-solid fa-arrow-up"></i>
                            @elseif ($unitChange < 0)
                                <i class="fa-solid fa-arrow-down"></i>
                            @else
                                <i class="fa-solid fa-arrow-right"></i>
                            @endif
                        </span>
                    </div>
                    <div>
                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_405_10714)">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M6.5 3C6.87288 3.00002 7.23239 3.13892 7.50842 3.38962C7.78445 3.64032 7.9572 3.98484 7.993 4.356L8 4.5V6H9V4.5C9.00002 4.12712 9.13892 3.76761 9.38962 3.49158C9.64032 3.21555 9.98484 3.0428 10.356 3.007L10.5 3H13.5C13.8729 3.00002 14.2324 3.13892 14.5084 3.38962C14.7844 3.64032 14.9572 3.98484 14.993 4.356L15 4.5V6H16V4.5C16 4.12712 16.1389 3.76761 16.3896 3.49158C16.6403 3.21555 16.9848 3.0428 17.356 3.007L17.5 3H20.5C20.8729 3.00002 21.2324 3.13892 21.5084 3.38962C21.7844 3.64032 21.9572 3.98484 21.993 4.356L22 4.5V19.5C22 19.8729 21.8611 20.2324 21.6104 20.5084C21.3597 20.7844 21.0152 20.9572 20.644 20.993L20.5 21H3.5C3.12712 21 2.76761 20.8611 2.49158 20.6104C2.21555 20.3597 2.0428 20.0152 2.007 19.644L2 19.5V4.5C2.00002 4.12712 2.13892 3.76761 2.38962 3.49158C2.64032 3.21555 2.98484 3.0428 3.356 3.007L3.5 3H6.5ZM20 16H17V19H20V16ZM15 16H9V19H15V16ZM7 16H4V19H7V16ZM20 12H13V14H20V12ZM11 12H4V14H11V12ZM6 5H4V10H20V5H18V6.5C18 6.89782 17.842 7.27936 17.5607 7.56066C17.2794 7.84196 16.8978 8 16.5 8H14.5C14.1022 8 13.7206 7.84196 13.4393 7.56066C13.158 7.27936 13 6.89782 13 6.5V5H11V6.5C11 6.89782 10.842 7.27936 10.5607 7.56066C10.2794 7.84196 9.89782 8 9.5 8H7.5C7.10218 8 6.72064 7.84196 6.43934 7.56066C6.15804 7.27936 6 6.89782 6 6.5V5Z" />
                            </g>
                            <defs>
                                <clipPath id="clip0_405_10714">
                                    <rect width="24" height="24" />
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                </div>
                <h4 class="fw-bold mt-2">{{ trns('units_real_state') }}</h4>
            </div>
        </div>
    </div>

    <div class="mt-5 p-5" style="border: 1px solid #F0F0F0; border-radius: 6px;">
        <div class="d-flex justify-content-between mb-3">
            <h3 class="fw-bold">{{ trns('associations') }}</h3>
            <div class="dropdown">
                {{-- <button class="btn dropdown-toggle" style="background-color: #F9F9F9; border: 1px solid #F3F3F3;"
                    type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    {{trns("chose_year")}}
                </button> --}}
                <select id="associations_year" class="form-select">
                    <option value="{{ date('Y') }}" selected>{{ trns('chose_year') }}</option>
                    @for ($i = 2020; $i <= date('Y'); $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>

            </div>
        </div>
        <div>
            <canvas id="myChart" style="width: 100%; height: 400px;"></canvas>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="mt-5 p-5" style="border: 1px solid #F0F0F0; border-radius: 6px;">
                <div class="d-flex justify-content-between mb-3">
                    <h3 class="fw-bold">{{ trns('real_states') }}</h3>
                    <div class="dropdown">
                        {{-- <button class="btn dropdown-toggle" style="background-color: #F9F9F9; border: 1px solid #F3F3F3;"
                            type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            {{trns("chose_year")}}
                        </button> --}}
                        <select id="realState_year" class="form-select">
                            <option value="{{ date('Y') }}" selected>{{ trns('chose_year') }}</option>
                            @for ($i = 2020; $i <= date('Y'); $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div>
                    <canvas id="myChart1" style="width: 100%; height: 400px;"></canvas>
                </div>
            </div>
        </div>
        <div class=" col-6">
            <div class="mt-5 p-5" style="border: 1px solid #F0F0F0; border-radius: 6px;">
                <div class="d-flex justify-content-between mb-3">
                    <h3 class="fw-bold">{{ trns('units_real_state') }}</h3>
                    <div class="dropdown">
                        {{-- <button class="btn dropdown-toggle" style="background-color: #F9F9F9; border: 1px solid #F3F3F3;"
                            type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            {{trns("chose_year")}}
                        </button> --}}
                        <select id="units_year" class="form-select">
                            <option value="{{ date('Y') }}" selected>{{ trns('chose_year') }}</option>
                            @for ($i = 2020; $i <= date('Y'); $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div>
                    <canvas id="myChart2" style="width: 100%; height: 400px;"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <h3 class="fw-bold">{{ trns('added_latest') }}</h3>





        <!-- Nav Tabs -->
        <ul class="nav nav-tabs mb-3" id="tableTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="associations-tab" data-bs-toggle="tab"
                    data-bs-target="#associations" type="button" role="tab">
                    {{ trns('associations_management') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="realstate-tab" data-bs-toggle="tab" data-bs-target="#realstate"
                    type="button" role="tab">
                    {{ trns('real_state_management') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="units-tab" data-bs-toggle="tab" data-bs-target="#units" type="button"
                    role="tab">
                    {{ trns('Units_management') }}
                </button>
            </li>
            {{-- <li class="nav-item" role="presentation">
                <button class="nav-link" id="meet-tab" data-bs-toggle="tab" data-bs-target="#meet" type="button"
                    role="tab">
                    {{ trns('meetings') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="vote-tab" data-bs-toggle="tab" data-bs-target="#vote" type="button"
                    role="tab">
                    {{ trns('votes') }}
                </button>
            </li> --}}
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="tableTabsContent">

            <!-- Associations Table Tab -->
            <div class="tab-pane fade show active" id="associations" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap w-100"
                        style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;"
                        id="associations_table">
                        <thead>
                            <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">
                                <th>{{ trns('series') }}</th>
                                <th>{{ trns('Association_Name') }}</th>
                                <th>{{ trns('association number') }}</th>
                                <th>{{ trns('building_count') }}</th>
                                {{-- <th>{{ trns('unit_count') }}</th> --}}
                                {{-- <th>{{ trns('owner_number') }}</th> --}}
                                <th>{{ trns('approval_date') }}</th>
                                <th>{{ trns('Establishment_Date') }}</th>
                                <th>{{ trns('status') }}</th>
                                <th>{{ trns('unified_number') }}</th>
                                <th>{{ trns('actions') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <!-- Real State Table Tab -->
            <div class="tab-pane fade" id="realstate" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap w-100"
                        style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;"
                        id="real_state_datatable">
                        <thead>
                            <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">
                                <th>{{ trns('real_State_location') }}</th>
                                <th>{{ trns('real_state_name') }}</th>
                                <th>{{ trns('unitNumber') }}</th>
                                <th>{{ trns('created_at_realState') }}</th>
                                <th>{{ trns('status') }}</th>
                                <th>{{ trns('actions') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <!-- Units Table Tab -->
            <div class="tab-pane fade" id="units" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap w-100"
                        style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;"
                        id="units_datatable">
                        <thead>
                            <tr class="fw-bolder" style="background-color: #e3e3e3; color: #00193a;">
                                <th>{{ trns('owners_name') }}</th>
                                <th>{{ trns('unit_code') }}</th>
                                <th>{{ trns('RealStates_number') }}</th>
                                <th>{{ trns('unit_number') }}</th>
                                <th>{{ trns('floor_count') }}</th>
                                <th>{{ trns('assocation_name') }}</th>
                                <th>{{ trns('status') }}</th>
                                <th>{{ trns('actions') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- meet Table Tab -->
            <div class="tab-pane fade" id="meet" role="tabpanel">
                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table text-nowrap w-100" 
                        id="MeetingDataTable"
                            style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;">
                            <thead>
                                <tr style="background-color: #e3e3e3; color: #00193a;">
                                    <th class="rounded-end">#</th>
                                    <th class="min-w-50px">{{ trns('association_name') }}</th>
                                    <th class="min-w-50px">{{ trns('date') }}</th>
                                    <th class="min-w-50px">{{ trns('created_by') }}</th>
                                    <th class="min-w-50px">{{ trns('created_at') }}</th>
                                    {{-- <th class="min-w-50px">{{ trns('agenda') }}</th> --}}
                                    <th class="min-w-50px">{{ trns('address_space') }}</th>
                                    {{-- <th class="min-w-50px">{{ trns('actions') }}</th> --}}
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <!-- vote Table Tab -->
            <div class="tab-pane fade" id="vote" role="tabpanel">
                <div class="mt-5">
                    <div class="table-responsive" style="overflow-x: inherit;">
                        <!--begin::Table-->
                        <table class="table text-nowrap w-100"
                            style="border: 1px solid #e3e3e3; border-radius: 10px 10px 0 0; margin-bottom: 0 !important;"
                            id="voteDataTable">
                            <thead>
                                <tr class="fw-bolder" style="background-color: #E9E9E9; color: #00193a;">
                                
                                    <th>#</th>
                                    <th class="min-w-50px">{{ trns('association_name') }}</th>
                                    <th class="min-w-50px">{{ trns('title') }}</th>
                                    <th class="min-w-50px">{{ trns('description') }}</th>
                                    <th class="min-w-50px">{{ trns('stuplish_at') }}</th>
                                    <th class="min-w-50px">{{ trns('vote_start_date')   }}</th>
                                    <th class="min-w-50px">{{ trns('vote_end_date') }}</th>
                                    <th class="min-w-50px">{{ trns('owners_number') }}</th>
                                    <th class="min-w-50px">{{ trns('audience_number') }}</th>
                                    <th class="min-w-50px">{{ trns('unVoted_number') }}</th>
                                    <th class="min-w-50px">{{ trns('status') }}</th>
                                    {{-- <th class="min-w-50px rounded-start">{{ trns('actions') }}</th> --}}
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>


    </div>





    <!--show owners MODAL -->
    <div class="modal fade" id="show_owners" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trns('owners') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ trns('unit_owner_name') }}</th>
                                    <th>{{ trns('unit_ownership_percentage') }}</th>
                                </tr>
                            </thead>
                            <tbody id="show_owners_body">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                        style="background-color: #00193a; color: white; border: none;padding: 5px 50px; margin-left: 10px;"
                        data-bs-dismiss="modal">
                        {{ trns('close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Search CLOSED -->



    <!-- Edit Owner Modal -->
    <div class="modal fade" id="editOwners" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <!-- Content will be loaded via AJAX -->
            </div>
        </div>
    </div>
    <!-- Edit Owner Modal -->


    <!-- Create Or Edit Modal -->
    <div class="modal fade" id="editOrCreate" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="example-Modal3">{{ trns('object_details') }}</h5>
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
@endsection

@section('ajaxCalls')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



    <script>
        // ===============================
        // 📌 show datatable for meetings
        // ===============================
        document.addEventListener("DOMContentLoaded", function() {

            // Summary table
            let summaryColumns = [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'association_id',
                    name: 'association_id'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'created_by',
                    name: 'created_by'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                
                {
                    data: 'address',
                    name: 'address'
                },
                // {
                //     data: 'action',
                //     name: 'action',
                //     orderable: false,
                //     searchable: false
                // },
            ];
            showMeetingData(null, '{{ route('meetings.index') }}', summaryColumns, 0, 3);


            // ===============================
            // 📌 doube functions for summary and topic datatable
            // ===============================
            async function showMeetingData(showRoute, routeOfShow, columns, orderByColumn = 0, showCol = 3,
                association_id = null) {
                let table = $('#MeetingDataTable').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: {
                        url: routeOfShow,
                        data: function(d) {
                            if (association_id) d.association_id = association_id;
                        }
                    },
                    columns: columns,
                    order: [
                        [orderByColumn ? orderByColumn : 0, "DESC"]
                    ],
                    createdRow: function(row, data) {
                        $(row).attr('data-id', data.id).addClass('clickable-row');
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
                });

                if (showRoute) {
                    $('#dataTable tbody').on('click', `tr td:nth-child(${showCol})`, function(e) {
                        if ($(e.target).is('input, button, a, .delete-checkbox, .editBtn, .statusBtn'))
                            return;
                        let id = $(this).closest('tr').data('id');
                        if (id) window.location.href = showRoute.replace(':id', id);
                    });
                }
            }
        });





        // ===============================
        // 📌 show datatable for votes
        // ===============================
        document.addEventListener("DOMContentLoaded", function() {

            // Summary table
            let summaryColumns = [
                {
              data : "id",
              name : "id"
            },
            {
                data: 'association_id',
                name: 'association_id',

            },
            {
                data: 'title',
                name: 'title',

            },
            {
                data: 'description',
                name: 'description',

            },{
                data: "created_at",
                name : "created_at"
            },
            {
                data: "start_date",
                name : "start_date"
            }
            ,{
                data: "end_date",
                name : "end_date"
            },{
                data: "owners_number",
                name : "owners_number"
            },{
                data: "audience_number",
                name : "audience_number"
            },{
                data: "unVoted",
                name : "unVoted"
            },
            {
                data: "status",
                name : "status"
            }
            // ,
            // {
            //     data: 'action',
            //     name: 'action',
            //     orderable: false,
            //     searchable: false
            // },
            ];
            showVoteDataTable(null, '{{ route('votes.index') }}', summaryColumns, 0, 3, association_id=null);


            // ===============================
            // 📌 doube functions for votes
            // ===============================
            async function showVoteDataTable(showRoute, routeOfShow, columns, orderByColumn = 0, showCol = 3,
                association_id = null) {
                let table = $('#voteDataTable').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: {
                        url: routeOfShow,
                        data: function(d) {
                            if (association_id) d.association_id = association_id;
                        }
                    },
                    columns: columns,
                    order: [
                        [orderByColumn ? orderByColumn : 0, "DESC"]
                    ],
                    createdRow: function(row, data) {
                        $(row).attr('data-id', data.id).addClass('clickable-row');
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
                });

                if (showRoute) {
                    $('#voteDataTable tbody').on('click', `tr td:nth-child(${showCol})`, function(e) {
                        if ($(e.target).is('input, button, a, .delete-checkbox, .editBtn, .statusBtn'))
                            return;
                        let id = $(this).closest('tr').data('id');
                        if (id) window.location.href = showRoute.replace(':id', id);
                    });
                }
            }
        });
    </script>






















    <script>
        const months = {!! json_encode($months, JSON_UNESCAPED_UNICODE) !!};

        const assocData = {!! json_encode($associationData, JSON_UNESCAPED_UNICODE) !!};
        const assocCtx = document.getElementById('myChart').getContext('2d');

        const assocChart = new Chart(assocCtx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: '{{ trns('associations') }}',
                    data: assocData,
                    borderWidth: 1,
                    borderColor: '#00193A',
                    backgroundColor: '#00193A',
                    tension: 0.4,
                    pointBackgroundColor: '#00F3CA',
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                // إضافة دعم RTL
                locale: 'ar',
                scales: {
                    x: {
                        // عكس ترتيب التسميات لتبدأ من اليمين
                        reverse: true,
                        // تخصيص النص ليكون RTL
                        ticks: {
                            textDirection: 'rtl'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        // وضع المحور Y على اليمين
                        position: 'right'
                    }
                },
                // إعدادات إضافية للـ RTL
                plugins: {
                    legend: {
                        // محاذاة الأسطورة إلى اليمين
                        align: 'end',
                        rtl: true,
                        textDirection: 'rtl'
                    },
                    tooltip: {
                        // اتجاه النص في التلميحات
                        rtl: true,
                        textDirection: 'rtl'
                    }
                }
            }
        });


        document.getElementById('associations_year').addEventListener('change', e => {
            const url = "{{ route('associations.byYear', ':year') }}".replace(':year', e.target.value);
            fetch(url).then(r => r.ok ? r.json() : Promise.reject())
                .then(resp => {
                    if (Array.isArray(resp.data) && resp.data.length === 12) {
                        assocChart.data.datasets[0].data = resp.data;
                        assocChart.update();
                    } else {
                        toastr.warning("{{ trns('no_data') }}");
                    }
                })
                .catch(() => toastr.error("{{ trns('something_went_wrong') }}"));
        });


        {{-- real states --}}

        const realStateData = {!! json_encode($realStateData, JSON_UNESCAPED_UNICODE) !!};
        const realCtx = document.getElementById('myChart1').getContext('2d');

        const realChart = new Chart(realCtx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: '{{ trns('realStates') }}',
                    data: realStateData,
                    borderWidth: 1,
                    backgroundColor: '#00193A',
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                // إضافة دعم RTL
                locale: 'ar',
                scales: {
                    x: {
                        // عكس ترتيب الأعمدة لتبدأ من اليمين
                        reverse: true,
                        // تخصيص النص ليكون RTL
                        ticks: {
                            textDirection: 'rtl'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        // وضع المحور Y على اليمين
                        position: 'right'
                    }
                },
                // إعدادات إضافية للـ RTL
                plugins: {
                    legend: {
                        // محاذاة الأسطورة إلى اليمين
                        align: 'end',
                        rtl: true,
                        textDirection: 'rtl'
                    },
                    tooltip: {
                        // اتجاه النص في التلميحات
                        rtl: true,
                        textDirection: 'rtl'
                    }
                }
            }
        });


        document.getElementById('realState_year').addEventListener('change', e => {
            const url = "{{ route('realState.byYear', ':year') }}".replace(':year', e.target.value);
            fetch(url).then(r => r.ok ? r.json() : Promise.reject())
                .then(resp => {
                    if (Array.isArray(resp.data) && resp.data.length === 12) {
                        realChart.data.datasets[0].data = resp.data;
                        realChart.update();
                    } else {
                        toastr.warning("{{ trns('no_data') }}");
                    }
                })
                .catch(() => toastr.error("{{ trns('something_went_wrong') }}"));
        });



        {{-- units  --}}

        const unitsData = {!! json_encode($unitsDate, JSON_UNESCAPED_UNICODE) !!};

        const unitsCtx = document.getElementById('myChart2').getContext('2d');
        const unitsChart = new Chart(unitsCtx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: '{{ trns('units_real_state') }}',
                    data: unitsData,
                    borderWidth: 1,
                    borderColor: '#00193A',
                    backgroundColor: 'rgba(128, 140, 157, 0.4)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#00F3CA',
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                // إضافة دعم RTL
                locale: 'ar',
                indexAxis: 'x',
                scales: {
                    x: {
                        // عكس ترتيب التسميات لتبدأ من اليمين
                        reverse: true,
                        // تخصيص النص ليكون RTL
                        ticks: {
                            textDirection: 'rtl'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        // وضع المحور Y على اليمين
                        position: 'right'
                    }
                },
                // إعدادات إضافية للـ RTL
                plugins: {
                    legend: {
                        // محاذاة الأسطورة إلى اليمين
                        align: 'end',
                        rtl: true,
                        textDirection: 'rtl'
                    },
                    tooltip: {
                        // اتجاه النص في التلميحات
                        rtl: true,
                        textDirection: 'rtl'
                    }
                }
            }
        });


        document.getElementById('units_year').addEventListener('change', e => {
            const url = "{{ route('units.byYear', ':year') }}".replace(':year', e.target.value);

            fetch(url)
                .then(r => r.ok ? r.json() : Promise.reject())
                .then(resp => {
                    if (Array.isArray(resp.data) && resp.data.length === 12) {
                        unitsChart.data.datasets[0].data = resp.data;
                        unitsChart.update();
                    } else {
                        toastr.warning("{{ trns('no_data') }}");
                    }
                })
                .catch(() => toastr.error("{{ trns('something_went_wrong') }}"));
        });









        {{-- the associations modals  --}}


        $(document).on('click', '.add_association', function() {
            const loader = '<div class="text-center p-5"><div class="spinner-border"></div></div>';
            const title = $(this).data('title');
            $('#example-Modal3').text(title);
            $('#modal-body').html(loader);
            $('#editOrCreate').modal('show');
            $('#modal-footer').html(`
                <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two"

                            data-bs-dismiss="modal">{{ trns('close') }}</button>
                    <button type="submit" class="btn btn-one me-2"

                            id="addButton">{{ trns('create') }}</button>
                </div>
            `);

            setTimeout(() => {
                $('#modal-body').load('{{ route('associations.create') }}');
            }, 250);
        });


        $(document).on('click', '#addButton', function(e) {
            console.log("test");
            e.preventDefault();

            var form = $('#addForm')[0];
            var formData = new FormData(form);
            var url = $('#addForm').attr('action');
            console.log(url)

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


                    if (data.status === 200) {
                        $('#editOrCreate').modal('hide').on('hidden.bs.modal', function() {
                            $('#modal-body').html('');
                        });

                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('created_successfully') }}</span>',
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
                    }

                    $('#addButton').html(`{{ trns('add') }}`).attr('disabled', false);
                    $('#editOrCreate').modal('hide');
                },
                error: function(data) {
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
                    $('#addButton').html(`{{ trns('add') }}`).attr('disabled', false);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });


        {{-- the realstate modals  --}}


        $(document).on('click', '.add_realState', function() {
            const loader = '<div class="text-center p-5"><div class="spinner-border"></div></div>';
            const title = $(this).data('title');
            $('#example-Modal3').text(title);
            $('#modal-body').html(loader);
            $('#editOrCreate').modal('show');
            $('#modal-footer').html(`
                <div class="w-100 d-flex">
                    <button type="button" class="btn btn-two"

                            data-bs-dismiss="modal">{{ trns('close') }}</button>
                    <button type="submit" class="btn btn-one me-2"

                            id="addButton">{{ trns('create') }}</button>
                </div>
            `);

            setTimeout(() => {
                $('#modal-body').load('{{ route('real_states.create') }}');
            }, 250);
        });


        {{-- $(document).on('click', '#addButton', function (e) {
            console.log("test");
            e.preventDefault();

            var form = $('#addForm')[0];
            var formData = new FormData(form);
            var url = $('#addForm').attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function () {
                    $('#addButton').html('<span class="spinner-border spinner-border-sm mr-2"></span> <span style="margin-left: 4px;">{{ trns('loading...') }}</span>')
                        .attr('disabled', true);
                },
                success: function (data) {
                    if (data.status == 200) {
                        toastr.success('{{ trns('added_successfully') }}');
                        if (data.redirect_to) {
                            setTimeout(function () {
                                window.location.href = data.redirect_to;
                            }, 2000);
                        } else {
                            $('#editOrCreate').modal('hide');
                            $('#dataTable').DataTable().ajax.reload();
                        }
                    } else if (data.status == 405) {
                        toastr.error(data.mymessage);
                    } else {
                        toastr.error('{{ trns('something_went_wrong') }}');
                    }
                    $('#addButton').html(`{{ trns('add') }}`).attr('disabled', false);
                },
                error: function (data) {
                    if (data.status === 500) {
                        toastr.error('');
                    } else if (data.status === 422) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function (key, value) {
                                    toastr.error(value, '{{ trns('error') }}');
                                });
                            }
                        });
                    } else {
                        toastr.error('{{ trns('something_went_wrong') }}');
                    }
                    $('#addButton').html(`{{ trns('add') }}`).attr('disabled', false);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }); --}}
    </script>



    {{-- the datatable show  --}}
    <script>
        $(document).ready(function() {

            $('#associations_table').DataTable({
                processing: true,
                serverSide: true,

                ajax: `{{ route('associations.index') }}`,
                columns: [{
                        data: null,
                        name: 'order',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            var total = meta.settings.fnRecordsDisplay();
                            return total - meta.row;
                        }
                    }, {
                        data: 'name',
                        name: 'name',
                        render: function(data, type, row) {
                            var showUrl = '{{ route('associations.show', 0) }}'.replace('/0', '/' +
                                row.id);
                            return `<a href="${showUrl}">${data}</a>`;
                        }
                    },
                    {
                        data: 'number',
                        render: function(data, type, row) {
                            return `
                                            <button
                                                style="cursor:pointer;border:none;background-color:transparent;"
                                                class="copy-btn" title="Copy" data-copy="${data}">
                                                    <i class="fa-regular fa-copy"></i>
                                                </button>
                                                <span class="copy-text">${data}</span>
                                            `;
                        }
                    },

                    {
                        data: 'real_stat_count',
                        name: 'real_stat_count'
                    },

                    {
                        data: 'approval_date',
                        name: 'approval_date'
                    }, {
                        data: 'establish_date',
                        name: 'establish_date'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    }, {
                        data: 'unified_number',
                        name: 'unified_number'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                searching: false,
                lengthChange: false,
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json",
                },
                drawCallback: function(settings) {
                    if (typeof afterAssociationsTableLoad === 'function') {
                        afterAssociationsTableLoad();
                    }
                }
            });
        });
    </script>



    <script>
        $(document).ready(function() {

            $('#real_state_datatable').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, 'asc']
                ],
                ajax: `{{ route('real_states.index') }}`,
                columns: [{
                        data: null,
                        name: 'order',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            var total = meta.settings.fnRecordsDisplay();
                            return total - meta.row;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                        render: function(data, type, row) {
                            var showUrl = '{{ route('real_states.show', 0) }}'.replace('/0', '/' +
                                row.id);
                            return `<a href="${showUrl}">${data}</a>`;
                        }
                    },
                    {
                        data: 'unitNumber',
                        name: 'unitNumber'
                    },



                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                searching: false,
                lengthChange: false,
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json",
                },
            });
        });





        {{-- units datatable  --}}
        $(document).ready(function() {

            $('#units_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{ route('units.index') }}`,
                columns: [{
                        data: 'user_id',
                        name: 'user_id'
                    },
                    {
                        data: 'unit_code',
                        name: 'unit_code',
                        render: function(data, type, row) {
                            var showUrl = '{{ route('units.show', 0) }}'.replace('/0', '/' + row
                                .id);
                            return `<a href="${showUrl}">${data}</a>`;
                        }
                    },
                    {
                        data: 'real_state_number',
                        name: 'real_state_number'
                    },
                    {
                        data: 'unit_number',
                        name: 'unit_number'
                    },
                    {
                        data: 'floor_count',
                        name: 'floor_count'
                    },
                    {
                        data: 'assocation_name',
                        name: 'assocation_name'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                searching: false,
                lengthChange: false,
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json",
                },
            });
        });
    </script>

    @include('admin/layouts/NewmyAjaxHelper')


    {{-- the edit for scripts  --}}
    <script>
        @php
            $editButtons = [['route' => route('associations.edit', ':id'), 'class' => 'association_show_edit'], ['route' => route('real_states.edit', ':id'), 'class' => 'real_state_show_edit'], ['route' => route('units.edit', ':id'), 'class' => 'unit_show_edit']];
        @endphp

        @foreach ($editButtons as $btn)
            showEditModalWithButton('{{ $btn['route'] }}', '{{ $btn['class'] }}');
        @endforeach

        editScript();




        {{--  the status js --}}
        {{-- status for associations --}}
        $(document).on('click', '.toggleAsociationsStatusBtn', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let currentStatus = parseInt($(this).data('status'));
            let newStatus = currentStatus === 1 ? 0 : 1;

            $.ajax({
                type: 'POST',
                url: '{{ route('associations.updateColumnSelected') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'ids': [id],
                    'status': newStatus
                },
                success: function(data) {
                    if (data.status === 200) {
                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('status_changed_successfully') }}</span>',
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
                        $('#associations_table').DataTable().ajax.reload(null, false);
                    } else {
                        toastr.error("{{ trns('something_went_wrong') }}");
                    }
                },
                error: function() {
                    toastr.error("{{ trns('something_went_wrong') }}");
                }
            });
        });


        {{-- status for realstate --}}
        $(document).on('click', '.toggleRealStatesStatusBtn', function(e) {
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
                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('status_changed_successfully') }}</span>',
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
                        $('#real_state_datatable').DataTable().ajax.reload(null, false);
                    } else {
                        toastr.error("{{ trns('something_went_wrong') }}");
                    }
                },
                error: function() {
                    toastr.error("{{ trns('something_went_wrong') }}");
                }
            });
        });


        {{-- status of units  --}}
        $(document).on('click', '.toggleUnitsStatusBtn', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let currentStatus = parseInt($(this).data('status'));
            let newStatus = currentStatus === 1 ? 0 : 1;

            $.ajax({
                type: 'POST',
                url: '{{ route('units.updateColumnSelected') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'ids': [id],
                    'status': newStatus
                },
                success: function(data) {
                    if (data.status === 200) {
                        Swal.fire({
                            title: '<span style="margin-bottom: 50px; display: block;">{{ trns('status_changed_successfully') }}</span>',
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
                        $('#units_datatable').DataTable().ajax.reload(null, false);
                    } else {
                        toastr.error("{{ trns('something_went_wrong') }}");
                    }
                },
                error: function() {
                    toastr.error("{{ trns('something_went_wrong') }}");
                }
            });
        });













        function showEditUsers(routeTemplate) { // Make sure parameter is properly received
            $(document).on('click', '.editOwners', function() {
                let id = $(this).data('id');
                console.log(id)

                // Check if ID exists
                if (!id) {
                    console.error('No ID found for this element');
                    return;
                }

                // Replace the placeholder with the actual ID
                let url = routeTemplate.replace(':id', id);
                console.log(url)

                // Show loading state
                $('#editOwners .modal-content').html(`
            <div class="modal-body text-center py-4">
                <i class="fas fa-spinner fa-spin fa-3x"></i>
            </div>
        `);

                $('#editOwners').modal('show');

                $.get(url)
                    .done(function(data) {
                        $('#editOwners .modal-content').html(data);
                    })
                    .fail(function(xhr) {
                        let errorMsg = xhr.responseJSON?.message || 'Failed to load content';
                        $('#editOwners .modal-content').html(`
                    <div class="modal-body">
                        <div class="alert alert-danger">${errorMsg}</div>
                    </div>
                `);
                    });
            });
        }


        $(document).on('click', '.show-owners-btn', function() {
            // Get the JSON string and parse it
            const ownersJson = $(this).attr('data-owners');

            try {
                const ownersData = JSON.parse(ownersJson);
                const modalBody = $('#show_owners_body');

                console.log(ownersJson);

                // Clear previous content
                modalBody.empty();

                if (ownersData && ownersData.length > 0) {
                    ownersData.forEach(owner => {
                        modalBody.append(`
                    <tr>
                        <td>${owner.name}</td>
                        <td>${owner.percentage}%</td>
                    </tr>
                `);
                    });
                } else {
                    modalBody.html(
                        '<tr><td colspan="2" class="text-center text-muted">لم يتم العثور علي أي مالك</td></tr>'
                    );
                }
            } catch (e) {
                console.error('Error parsing owners data:', e);
                $('#show_owners_body').html(
                    '<tr><td colspan="2" class="text-center text-danger">Error loading data</td></tr>');
            }
        });


        $(document).ready(function() {
            // Make sure the route is properly generated in Blade
            showEditUsers('{{ route('units.editOwners', ':id') }}');
        });
    </script>
@endsection
