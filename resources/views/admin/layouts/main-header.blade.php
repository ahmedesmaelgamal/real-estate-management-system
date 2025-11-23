<style>
    .header.app-header .dropdown-menu.dropdown-menu-left {
        top: 25px !important;
    }

    .d-flex {
        border-bottom: 0 !important;
    }

    /* إضافة styles للـ dropdown الجديد */
    .custom-dropdown .dropdown-menu {
        min-width: 200px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border: 1px solid #e0e0e0;
    }

    .custom-dropdown .dropdown-item {
        padding: 10px 16px;
        font-size: 14px;
        color: #333;
        transition: all 0.2s ease;
    }

    .custom-dropdown .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #007bff;
    }

    .custom-dropdown .dropdown-item i {
        margin-right: 8px;
        width: 16px;
    }
</style>
<!--APP-MAIN-HEADER-->
<div class="app-header header">

    <div class="container-fluid">
        <div class="d-flex" style="border-bottom: 0;">
            <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-toggle="sidebar" href="#">
                <svg style="stroke:none;" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24"
                    width="24">
                    <path style="stroke:none !important;" d="M0 0h24v24H0V0z" fill="none" />
                    <path style="stroke:none !important;" d="M21 11.01L3 11v2h18zM3 16h12v2H3zM21 6H3v2.01L21 8z" />
                </svg>
            </a><!-- sidebar-toggle-->
            <div class="header-search d-none d-md-flex">
            </div>
            <div class="d-flex {{ lang() == 'ar' ? 'mr-auto' : 'ml-auto' }} header-left-icons header-search-icon"
                style="float: left;">
                <button class="navbar-toggler navresponsive-toggler d-md-none" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"
                        class="navbar-toggler-icon">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                    </svg>
                </button>
                <!-- إضافة الـ Custom Dropdown هنا -->
                <div class="dropdown custom-dropdown d-none d-lg-flex">
                    <a class="nav-link icon nav-link-bg" href="#" data-bs-toggle="dropdown" aria-expanded="false"
                        style="border: 1px solid #e0e0e0; border-radius: 6px; padding: 0px 5px; font-size: 13px; min-height: 28px;">
                        <i class="fe fe-plus" style="font-size: 16px; margin-right: 4px;color:#242e4c !important;"></i>
                        {{ trns('fast_action') }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-{{ lang() == 'ar' ? 'left' : 'right' }}">
                        @can('read_user')
                            <a href="#" class="dropdown-item create_user_access text-black"
                                data-title="{{ trns('add_new_owner') }}">
                                <span class="ms-2">
                                    <svg width="20" height="20" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_264_31505)">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9.58576 15C10.1162 15.0001 10.6248 15.2109 10.9998 15.586L11.9998 16.586L12.9998 15.586C13.3747 15.2109 13.8834 15.0001 14.4138 15H18.4378C19.1067 15.0001 19.7564 15.2237 20.2836 15.6354C20.8109 16.047 21.1854 16.6231 21.3478 17.272L21.9698 19.758C22.0042 19.8862 22.0127 20.02 21.9948 20.1516C21.977 20.2831 21.9331 20.4098 21.8658 20.5243C21.7985 20.6387 21.709 20.7386 21.6027 20.8181C21.4964 20.8975 21.3753 20.9551 21.2465 20.9873C21.1177 21.0195 20.9837 21.0257 20.8525 21.0056C20.7213 20.9855 20.5953 20.9395 20.4821 20.8702C20.3688 20.8009 20.2705 20.7098 20.1929 20.6021C20.1152 20.4944 20.0597 20.3723 20.0298 20.243L19.4088 17.758C19.3548 17.5416 19.23 17.3494 19.0542 17.212C18.8785 17.0747 18.6618 17.0001 18.4388 17H14.4138L13.4138 18C13.0387 18.3749 12.5301 18.5856 11.9998 18.5856C11.4694 18.5856 10.9608 18.3749 10.5858 18L9.58576 17H5.56176C5.3387 17.0001 5.12206 17.0747 4.9463 17.212C4.77054 17.3494 4.64574 17.5416 4.59176 17.758L3.96976 20.243C3.93977 20.3723 3.88433 20.4944 3.80667 20.6021C3.72901 20.7098 3.63069 20.8009 3.51743 20.8702C3.40418 20.9395 3.27826 20.9855 3.14703 21.0056C3.01579 21.0257 2.88187 21.0195 2.75307 20.9873C2.62427 20.9551 2.50317 20.8975 2.39684 20.8181C2.2905 20.7386 2.20106 20.6387 2.13373 20.5243C2.06641 20.4098 2.02254 20.2831 2.00469 20.1516C1.98684 20.02 1.99536 19.8862 2.02976 19.758L2.65076 17.272C2.81309 16.6231 3.18763 16.047 3.71488 15.6354C4.24214 15.2237 4.89184 15.0001 5.56076 15H9.58576ZM11.9998 2C12.7838 2 13.6608 2.19 14.3798 2.391C16.0428 2.854 16.9998 4.41 16.9998 5.997V10.003C16.9998 11.591 16.0428 13.146 14.3798 13.609C13.6608 13.809 12.7838 14 11.9998 14C11.2158 14 10.3388 13.81 9.61976 13.609C7.95676 13.146 6.99976 11.591 6.99976 10.003V5.997C6.99976 4.41 7.95676 2.854 9.61976 2.391C10.3388 2.191 11.2158 2 11.9998 2ZM11.9998 4C11.4908 4 10.8228 4.132 10.1568 4.318C9.48876 4.504 8.99976 5.165 8.99976 5.997V10.003C8.99976 10.835 9.48876 11.496 10.1568 11.683C10.8228 11.868 11.4908 12 11.9998 12C12.5088 12 13.1768 11.868 13.8428 11.682C14.5108 11.496 14.9998 10.835 14.9998 10.003V5.997C14.9998 5.165 14.5108 4.504 13.8428 4.317C13.1768 4.133 12.5098 4 11.9998 4Z"
                                                fill="black" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_264_31505">
                                                <rect width="24" height="24" fill="black" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </span>
                                {{ trns('add_new_owner') }}
                            </a>
                        @endcan
                        @can('read_admin')
                            <a href="#" class="dropdown-item create_admin_access text-black"
                                data-title="{{ trns('add new admin') }}">
                                <span class="ms-2">
                                    <svg width="20" height="20" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_264_31505)">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9.58576 15C10.1162 15.0001 10.6248 15.2109 10.9998 15.586L11.9998 16.586L12.9998 15.586C13.3747 15.2109 13.8834 15.0001 14.4138 15H18.4378C19.1067 15.0001 19.7564 15.2237 20.2836 15.6354C20.8109 16.047 21.1854 16.6231 21.3478 17.272L21.9698 19.758C22.0042 19.8862 22.0127 20.02 21.9948 20.1516C21.977 20.2831 21.9331 20.4098 21.8658 20.5243C21.7985 20.6387 21.709 20.7386 21.6027 20.8181C21.4964 20.8975 21.3753 20.9551 21.2465 20.9873C21.1177 21.0195 20.9837 21.0257 20.8525 21.0056C20.7213 20.9855 20.5953 20.9395 20.4821 20.8702C20.3688 20.8009 20.2705 20.7098 20.1929 20.6021C20.1152 20.4944 20.0597 20.3723 20.0298 20.243L19.4088 17.758C19.3548 17.5416 19.23 17.3494 19.0542 17.212C18.8785 17.0747 18.6618 17.0001 18.4388 17H14.4138L13.4138 18C13.0387 18.3749 12.5301 18.5856 11.9998 18.5856C11.4694 18.5856 10.9608 18.3749 10.5858 18L9.58576 17H5.56176C5.3387 17.0001 5.12206 17.0747 4.9463 17.212C4.77054 17.3494 4.64574 17.5416 4.59176 17.758L3.96976 20.243C3.93977 20.3723 3.88433 20.4944 3.80667 20.6021C3.72901 20.7098 3.63069 20.8009 3.51743 20.8702C3.40418 20.9395 3.27826 20.9855 3.14703 21.0056C3.01579 21.0257 2.88187 21.0195 2.75307 20.9873C2.62427 20.9551 2.50317 20.8975 2.39684 20.8181C2.2905 20.7386 2.20106 20.6387 2.13373 20.5243C2.06641 20.4098 2.02254 20.2831 2.00469 20.1516C1.98684 20.02 1.99536 19.8862 2.02976 19.758L2.65076 17.272C2.81309 16.6231 3.18763 16.047 3.71488 15.6354C4.24214 15.2237 4.89184 15.0001 5.56076 15H9.58576ZM11.9998 2C12.7838 2 13.6608 2.19 14.3798 2.391C16.0428 2.854 16.9998 4.41 16.9998 5.997V10.003C16.9998 11.591 16.0428 13.146 14.3798 13.609C13.6608 13.809 12.7838 14 11.9998 14C11.2158 14 10.3388 13.81 9.61976 13.609C7.95676 13.146 6.99976 11.591 6.99976 10.003V5.997C6.99976 4.41 7.95676 2.854 9.61976 2.391C10.3388 2.191 11.2158 2 11.9998 2ZM11.9998 4C11.4908 4 10.8228 4.132 10.1568 4.318C9.48876 4.504 8.99976 5.165 8.99976 5.997V10.003C8.99976 10.835 9.48876 11.496 10.1568 11.683C10.8228 11.868 11.4908 12 11.9998 12C12.5088 12 13.1768 11.868 13.8428 11.682C14.5108 11.496 14.9998 10.835 14.9998 10.003V5.997C14.9998 5.165 14.5108 4.504 13.8428 4.317C13.1768 4.133 12.5098 4 11.9998 4Z"
                                                fill="black" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_264_31505">
                                                <rect width="24" height="24" fill="black" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </span>
                                {{ trns('add new admin') }}
                            </a>
                        @endcan


                        @can('create_association')
                            <a href="#" class="dropdown-item create_association_access text-black"
                                data-title="{{ trns('add new association') }}">
                                <span class="ms-2">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_264_31511)">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M10.753 2.19664C10.4792 2.10526 10.189 2.07422 9.90207 2.10564C9.61518 2.13705 9.33849 2.23018 9.091 2.37864L4.971 4.85064C4.67485 5.02833 4.42976 5.27969 4.25959 5.58023C4.08943 5.88078 4 6.22027 4 6.56564V19.9996H3C2.73478 19.9996 2.48043 20.105 2.29289 20.2925C2.10536 20.4801 2 20.7344 2 20.9996C2 21.2649 2.10536 21.5192 2.29289 21.7067C2.48043 21.8943 2.73478 21.9996 3 21.9996H21C21.2652 21.9996 21.5196 21.8943 21.7071 21.7067C21.8946 21.5192 22 21.2649 22 20.9996C22 20.7344 21.8946 20.4801 21.7071 20.2925C21.5196 20.105 21.2652 19.9996 21 19.9996H20V6.71964C19.9998 6.30017 19.8676 5.8914 19.6223 5.55115C19.377 5.21091 19.0309 4.9564 18.633 4.82364L10.753 2.19664ZM18 19.9996V6.71964L11 4.38764V19.9996H18ZM9 4.76564L6 6.56564V19.9996H9V4.76564Z"
                                                fill="black" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_264_31511">
                                                <rect width="24" height="24" fill="black" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </span>
                                {{ trns('add new association') }}
                            </a>
                        @endcan
                        @can('create_real_state')
                            <a href="#" class="dropdown-item create_real_state_access text-black"
                                data-title="{{ trns('add_real_state_account') }}">
                                <span class="ms-2">
                                    <svg width="20" height="20" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_264_31517)">
                                            <path
                                                d="M12.9999 3C13.5044 2.99984 13.9904 3.19041 14.3604 3.5335C14.7304 3.87659 14.957 4.34684 14.9949 4.85L14.9999 5V9H17.9999C18.5044 8.99984 18.9904 9.19041 19.3604 9.5335C19.7304 9.87659 19.957 10.3468 19.9949 10.85L19.9999 11V19H20.9999C21.2547 19.0003 21.4999 19.0979 21.6852 19.2728C21.8706 19.4478 21.9821 19.687 21.997 19.9414C22.012 20.1958 21.9292 20.4464 21.7656 20.6418C21.602 20.8373 21.37 20.9629 21.1169 20.993L20.9999 21H2.99987C2.74499 20.9997 2.49984 20.9021 2.3145 20.7272C2.12916 20.5522 2.01763 20.313 2.0027 20.0586C1.98776 19.8042 2.07054 19.5536 2.23413 19.3582C2.39772 19.1627 2.62977 19.0371 2.88287 19.007L2.99987 19H3.99987V5C3.99971 4.49542 4.19027 4.00943 4.53337 3.63945C4.87646 3.26947 5.34671 3.04284 5.84987 3.005L5.99987 3H12.9999ZM17.9999 11H14.9999V19H17.9999V11ZM12.9999 5H5.99987V19H12.9999V5ZM10.9999 15V17H7.99987V15H10.9999ZM10.9999 11V13H7.99987V11H10.9999ZM10.9999 7V9H7.99987V7H10.9999Z"
                                                fill="black" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_264_31517">
                                                <rect width="24" height="24" fill="black" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </span>
                                {{ trns('add new real_state') }}
                            </a>
                        @endcan
                        @can('create_unit')
                            <a href="#" class="dropdown-item create_unit_access text-black"
                                data-title="{{ trns('add_new_unit') }}">
                                <span class="ms-2">
                                    <svg width="20" height="20" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_405_10714)">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M6.5 3C6.87288 3.00002 7.23239 3.13892 7.50842 3.38962C7.78445 3.64032 7.9572 3.98484 7.993 4.356L8 4.5V6H9V4.5C9.00002 4.12712 9.13892 3.76761 9.38962 3.49158C9.64032 3.21555 9.98484 3.0428 10.356 3.007L10.5 3H13.5C13.8729 3.00002 14.2324 3.13892 14.5084 3.38962C14.7844 3.64032 14.9572 3.98484 14.993 4.356L15 4.5V6H16V4.5C16 4.12712 16.1389 3.76761 16.3896 3.49158C16.6403 3.21555 16.9848 3.0428 17.356 3.007L17.5 3H20.5C20.8729 3.00002 21.2324 3.13892 21.5084 3.38962C21.7844 3.64032 21.9572 3.98484 21.993 4.356L22 4.5V19.5C22 19.8729 21.8611 20.2324 21.6104 20.5084C21.3597 20.7844 21.0152 20.9572 20.644 20.993L20.5 21H3.5C3.12712 21 2.76761 20.8611 2.49158 20.6104C2.21555 20.3597 2.0428 20.0152 2.007 19.644L2 19.5V4.5C2.00002 4.12712 2.13892 3.76761 2.38962 3.49158C2.64032 3.21555 2.98484 3.0428 3.356 3.007L3.5 3H6.5ZM20 16H17V19H20V16ZM15 16H9V19H15V16ZM7 16H4V19H7V16ZM20 12H13V14H20V12ZM11 12H4V14H11V12ZM6 5H4V10H20V5H18V6.5C18 6.89782 17.842 7.27936 17.5607 7.56066C17.2794 7.84196 16.8978 8 16.5 8H14.5C14.1022 8 13.7206 7.84196 13.4393 7.56066C13.158 7.27936 13 6.89782 13 6.5V5H11V6.5C11 6.89782 10.842 7.27936 10.5607 7.56066C10.2794 7.84196 9.89782 8 9.5 8H7.5C7.10218 8 6.72064 7.84196 6.43934 7.56066C6.15804 7.27936 6 6.89782 6 6.5V5Z"
                                                fill="black" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_405_10714">
                                                <rect width="24" height="24" fill="black" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </span>
                                {{ trns('add new units') }}
                            </a>
                        @endcan

                        @can('create_association')
                            <a href="#" class="dropdown-item create_contract_access text-black"
                                data-title="{{ trns('add new contract') }}">
                                <span class="ms-2">
                                    <i class="fa-solid fa-file-contract" style="font-size: 20px; margin-right: 0;"></i>
                                </span>
                                {{ trns('add new contract') }}
                            </a>
                        @endcan

                        @can('create_association')
                            <a href="#" class="dropdown-item create_votes_access text-black"
                                data-title="{{ trns('add new vote') }}">
                                <span class="ms-2">
                                    <i class="fa-solid fa-plus-circle" style="font-size: 20px; margin-right: 0;"></i>
                                </span>
                                {{ trns('add new vote') }}
                            </a>
                        @endcan

                        @can('create_association')
                            <a href="#" class="dropdown-item create_meetings_access text-black"
                                data-title="{{ trns('add new meeting') }}">
                                <span class="ms-2">
                                    <i class="fa-solid fa-calendar-plus " style="font-size: 20px; margin-right: 0;"></i>
                                </span>
                                {{ trns('add new meeting') }}
                            </a>
                        @endcan

                        @can('create_association')
                            <a href="#" class="dropdown-item create_court_cases_access text-black"
                                data-title="{{ trns('add new court_case') }}">
                                <span class="ms-2">
                                    <i class="fa-solid fa-list-check " style="font-size: 20px; margin-right: 0;"></i>
                                </span>
                                {{ trns('add new court_case') }}
                            </a>
                        @endcan

                    </div>
                </div>

                <div class="dropdown d-none d-lg-flex">
                    <a class="nav-link icon nav-link-bg"
                        href="{{ route('change_language', lang() == 'ar' ? 'en' : 'ar') }}">
                        <img style="height: 24px;" src="{{ asset('assets/language.png') }}" alt="Building Icon"
                            class="img-fluid">
                    </a>
                </div>

                <div class="dropdown d-none d-lg-flex">
                    <a class="nav-link icon full-screen-link nav-link-bg">
                        <img style="height: 24px;" id="fullscreen-button3"
                            src="{{ asset('assets/full-screen.png') }}" alt="Building Icon"
                            class="img-fluid fullscreen-button">
                    </a>
                </div>

                <!-- باقي الكود كما هو... -->
                <div class="dropdown profile-1">
                    <a href="#" data-bs-toggle="dropdown"
                        class="nav-link pl-2 pr-2 mt-2 leading-none d-flex align-items-center">
                        <span>
                            <img src="{{ getFile(auth('admin')->user()->image, 'avatar.gif') }}" alt="profile-user"
                                class="avatar ml-xl-3 profile-user brround cover-image">
                        </span>
                        <span class="ml-2">{{ auth('admin')->user()->name }}</span>
                    </a>
                    <div
                        class="dropdown-menu dropdown-menu-{{ lang() == 'ar' ? 'left' : 'right' }} dropdown-menu-arrow">
                        <a class="dropdown-item" href="{{ route('myProfile') }}">
                            <i class="dropdown-icon mdi mdi-account-outline"></i> {{ trns('profile') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.logout') }}">
                            <i class="dropdown-icon mdi  mdi-logout-variant"></i>
                            {{ trns('logout') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    {{-- $(document).ready(function() {
        // التأكد من أن الـ dropdown يعمل بشكل صحيح
        $('.custom-dropdown .dropdown-toggle').on('click', function(e) {
            e.preventDefault();
            $(this).next('.dropdown-menu').toggle();
        });

        // إغلاق الـ dropdown عند النقر خارجه
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.custom-dropdown').length) {
                $('.custom-dropdown .dropdown-menu').hide();
            }
        });
    }); --}}







    {{-- teh create modals --}}
</script>
