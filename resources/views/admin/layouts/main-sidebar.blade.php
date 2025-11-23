<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app sidebar-mini">
        <div class="side-header">
            <a class="header-brand1" href="#">
                <img src="{{ getFile($setting->where('key', 'logo')->first()->value) }}"
                    class="header-brand-img desktop-logo" alt="logo">
                <img src="{{ getFile($setting->where('key', 'fav_icon')->first()->value) }}"
                    class="header-brand-img mobile-logo" alt="logo">
            </a>
        </div>
    </div>


    <ul class="side-menu" style="padding-top: 20px;">
        <!-- <li>
            <h3>{{ trns('elements') }}</h3>
        </li> -->

        <!-- Dashboard -->
        <li class="">
            <a class="side-menu__item side-menu__item1 {{ routeActive('adminHome', 'active') }}"
                href="{{ route('adminHome') }}">
                <!-- <i class="fe fe-grid side-menu__icon m-2"></i> -->
                <svg width="20" height="20" viewBox="0 0 24 24" fill=""
                    xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_264_31499)">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M13.2281 2.68701C12.877 2.4139 12.4449 2.26562 12.0001 2.26562C11.5553 2.26562 11.1232 2.4139 10.7721 2.68701L2.3881 9.20701C1.6361 9.79401 2.0501 10.999 3.0031 10.999H4.0951L4.9151 19.198C4.96445 19.6915 5.19541 20.1491 5.56314 20.4819C5.93087 20.8147 6.40914 20.999 6.9051 20.999H17.0951C17.5911 20.999 18.0693 20.8147 18.4371 20.4819C18.8048 20.1491 19.0358 19.6915 19.0851 19.198L19.9051 10.999H20.9971C21.9491 10.999 22.3651 9.79401 21.6121 9.20801L13.2281 2.68701ZM5.9961 9.90901C5.9828 9.77618 5.94324 9.64731 5.87972 9.52989C5.81621 9.41248 5.73 9.30884 5.6261 9.22501L12.0001 4.26601L18.3741 9.22401C18.2702 9.30784 18.184 9.41148 18.1205 9.5289C18.057 9.64631 18.0174 9.77518 18.0041 9.90801L17.0951 18.999H6.9051L5.9961 9.90901ZM10.5001 12.999C10.5001 12.6012 10.6581 12.2197 10.9394 11.9384C11.2207 11.657 11.6023 11.499 12.0001 11.499C12.3979 11.499 12.7795 11.657 13.0608 11.9384C13.3421 12.2197 13.5001 12.6012 13.5001 12.999C13.5001 13.3968 13.3421 13.7784 13.0608 14.0597C12.7795 14.341 12.3979 14.499 12.0001 14.499C11.6023 14.499 11.2207 14.341 10.9394 14.0597C10.6581 13.7784 10.5001 13.3968 10.5001 12.999ZM12.0001 9.49901C11.0718 9.49901 10.1816 9.86776 9.52523 10.5241C8.86885 11.1805 8.5001 12.0708 8.5001 12.999C8.5001 13.9273 8.86885 14.8175 9.52523 15.4739C10.1816 16.1303 11.0718 16.499 12.0001 16.499C12.9284 16.499 13.8186 16.1303 14.475 15.4739C15.1314 14.8175 15.5001 13.9273 15.5001 12.999C15.5001 12.0708 15.1314 11.1805 14.475 10.5241C13.8186 9.86776 12.9284 9.49901 12.0001 9.49901Z"
                            fill="#00193A" />
                    </g>
                    <defs>
                        <clipPath id="clip0_264_31499">
                            <rect width="24" height="24" fill="white" />
                        </clipPath>
                    </defs>
                </svg>

                <span class="side-menu__label">{{ trns('home') }}</span>
            </a>
        </li>

        @can('read_user')
            <!-- Users Management -->
            <li class="slide {{ arrRouteActive(['users.*']) }}">
                <a class="side-menu__item side-menu__item1 {{ arrRouteActive(['users.*'], 'active') }}" data-toggle="slide"
                    href="#">
                    <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_264_31505)">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.58576 15C10.1162 15.0001 10.6248 15.2109 10.9998 15.586L11.9998 16.586L12.9998 15.586C13.3747 15.2109 13.8834 15.0001 14.4138 15H18.4378C19.1067 15.0001 19.7564 15.2237 20.2836 15.6354C20.8109 16.047 21.1854 16.6231 21.3478 17.272L21.9698 19.758C22.0042 19.8862 22.0127 20.02 21.9948 20.1516C21.977 20.2831 21.9331 20.4098 21.8658 20.5243C21.7985 20.6387 21.709 20.7386 21.6027 20.8181C21.4964 20.8975 21.3753 20.9551 21.2465 20.9873C21.1177 21.0195 20.9837 21.0257 20.8525 21.0056C20.7213 20.9855 20.5953 20.9395 20.4821 20.8702C20.3688 20.8009 20.2705 20.7098 20.1929 20.6021C20.1152 20.4944 20.0597 20.3723 20.0298 20.243L19.4088 17.758C19.3548 17.5416 19.23 17.3494 19.0542 17.212C18.8785 17.0747 18.6618 17.0001 18.4388 17H14.4138L13.4138 18C13.0387 18.3749 12.5301 18.5856 11.9998 18.5856C11.4694 18.5856 10.9608 18.3749 10.5858 18L9.58576 17H5.56176C5.3387 17.0001 5.12206 17.0747 4.9463 17.212C4.77054 17.3494 4.64574 17.5416 4.59176 17.758L3.96976 20.243C3.93977 20.3723 3.88433 20.4944 3.80667 20.6021C3.72901 20.7098 3.63069 20.8009 3.51743 20.8702C3.40418 20.9395 3.27826 20.9855 3.14703 21.0056C3.01579 21.0257 2.88187 21.0195 2.75307 20.9873C2.62427 20.9551 2.50317 20.8975 2.39684 20.8181C2.2905 20.7386 2.20106 20.6387 2.13373 20.5243C2.06641 20.4098 2.02254 20.2831 2.00469 20.1516C1.98684 20.02 1.99536 19.8862 2.02976 19.758L2.65076 17.272C2.81309 16.6231 3.18763 16.047 3.71488 15.6354C4.24214 15.2237 4.89184 15.0001 5.56076 15H9.58576ZM11.9998 2C12.7838 2 13.6608 2.19 14.3798 2.391C16.0428 2.854 16.9998 4.41 16.9998 5.997V10.003C16.9998 11.591 16.0428 13.146 14.3798 13.609C13.6608 13.809 12.7838 14 11.9998 14C11.2158 14 10.3388 13.81 9.61976 13.609C7.95676 13.146 6.99976 11.591 6.99976 10.003V5.997C6.99976 4.41 7.95676 2.854 9.61976 2.391C10.3388 2.191 11.2158 2 11.9998 2ZM11.9998 4C11.4908 4 10.8228 4.132 10.1568 4.318C9.48876 4.504 8.99976 5.165 8.99976 5.997V10.003C8.99976 10.835 9.48876 11.496 10.1568 11.683C10.8228 11.868 11.4908 12 11.9998 12C12.5088 12 13.1768 11.868 13.8428 11.682C14.5108 11.496 14.9998 10.835 14.9998 10.003V5.997C14.9998 5.165 14.5108 4.504 13.8428 4.317C13.1768 4.133 12.5098 4 11.9998 4Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_264_31505">
                                <rect width="24" height="24" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    <span class="side-menu__label">{{ trns('users_management') }}</span>
                    <i class="angle fa fa-angle-down"></i>
                </a>

                <ul class="slide-menu">
                    @can('create_user')
                        <li class="{{ routeActive('users.singlePageCreate', 'active') }}">
                            <a class="slide-item text-white" href="{{ route('users.singlePageCreate') }}">
                                <i class="fa fa-user m-3 text-white"></i>
                                {{ trns('create_new_owner') }}
                            </a>
                        </li>
                    @endcan
                    <li class="{{ routeActive('users.index', 'active') }}">
                        <a class="slide-item text-white" href="{{ route('users.index') }}">
                            <i class="fa fa-user m-3 text-white"></i>
                            {{ trns('all_owners') }}
                        </a>
                    </li>
                </ul>

            </li>
        @endcan

        @can('read_admin')
            <!-- Admins Management -->
            <li class="slide {{ arrRouteActive(['admins.*']) }}">
                <a class="side-menu__item side-menu__item1 {{ arrRouteActive(['admins.*'], 'active') }}"
                    data-toggle="slide" href="#">
                    <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_264_31505)">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.58576 15C10.1162 15.0001 10.6248 15.2109 10.9998 15.586L11.9998 16.586L12.9998 15.586C13.3747 15.2109 13.8834 15.0001 14.4138 15H18.4378C19.1067 15.0001 19.7564 15.2237 20.2836 15.6354C20.8109 16.047 21.1854 16.6231 21.3478 17.272L21.9698 19.758C22.0042 19.8862 22.0127 20.02 21.9948 20.1516C21.977 20.2831 21.9331 20.4098 21.8658 20.5243C21.7985 20.6387 21.709 20.7386 21.6027 20.8181C21.4964 20.8975 21.3753 20.9551 21.2465 20.9873C21.1177 21.0195 20.9837 21.0257 20.8525 21.0056C20.7213 20.9855 20.5953 20.9395 20.4821 20.8702C20.3688 20.8009 20.2705 20.7098 20.1929 20.6021C20.1152 20.4944 20.0597 20.3723 20.0298 20.243L19.4088 17.758C19.3548 17.5416 19.23 17.3494 19.0542 17.212C18.8785 17.0747 18.6618 17.0001 18.4388 17H14.4138L13.4138 18C13.0387 18.3749 12.5301 18.5856 11.9998 18.5856C11.4694 18.5856 10.9608 18.3749 10.5858 18L9.58576 17H5.56176C5.3387 17.0001 5.12206 17.0747 4.9463 17.212C4.77054 17.3494 4.64574 17.5416 4.59176 17.758L3.96976 20.243C3.93977 20.3723 3.88433 20.4944 3.80667 20.6021C3.72901 20.7098 3.63069 20.8009 3.51743 20.8702C3.40418 20.9395 3.27826 20.9855 3.14703 21.0056C3.01579 21.0257 2.88187 21.0195 2.75307 20.9873C2.62427 20.9551 2.50317 20.8975 2.39684 20.8181C2.2905 20.7386 2.20106 20.6387 2.13373 20.5243C2.06641 20.4098 2.02254 20.2831 2.00469 20.1516C1.98684 20.02 1.99536 19.8862 2.02976 19.758L2.65076 17.272C2.81309 16.6231 3.18763 16.047 3.71488 15.6354C4.24214 15.2237 4.89184 15.0001 5.56076 15H9.58576ZM11.9998 2C12.7838 2 13.6608 2.19 14.3798 2.391C16.0428 2.854 16.9998 4.41 16.9998 5.997V10.003C16.9998 11.591 16.0428 13.146 14.3798 13.609C13.6608 13.809 12.7838 14 11.9998 14C11.2158 14 10.3388 13.81 9.61976 13.609C7.95676 13.146 6.99976 11.591 6.99976 10.003V5.997C6.99976 4.41 7.95676 2.854 9.61976 2.391C10.3388 2.191 11.2158 2 11.9998 2ZM11.9998 4C11.4908 4 10.8228 4.132 10.1568 4.318C9.48876 4.504 8.99976 5.165 8.99976 5.997V10.003C8.99976 10.835 9.48876 11.496 10.1568 11.683C10.8228 11.868 11.4908 12 11.9998 12C12.5088 12 13.1768 11.868 13.8428 11.682C14.5108 11.496 14.9998 10.835 14.9998 10.003V5.997C14.9998 5.165 14.5108 4.504 13.8428 4.317C13.1768 4.133 12.5098 4 11.9998 4Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_264_31505">
                                <rect width="24" height="24" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    <span class="side-menu__label"> {{ trns('admin_management') }}</span>
                    <i class="angle fa fa-angle-down"></i>
                </a>
                <ul class="slide-menu">


                    @can('create_admin')
                        <li class="{{ routeActive('admins.singlePageCreate', 'active') }}">
                            <a class="slide-item text-white" href="{{ route('admins.singlePageCreate') }}">
                                <i class="fa fa-user m-3"></i>
                                {{ trns('create_new_admin') }}
                            </a>
                        </li>
                    @endcan
                    <li class="{{ routeActive('admins.index', 'active') }}">
                        <a class="slide-item text-white" href="{{ route('admins.index') }}">
                            <i class="fa-solid fa-user-tie m-3 text-white"></i>
                            {{ trns('all_admins') }}
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

        @can('read_association')
            <!-- Associations Management -->
            <li class="slide {{ arrRouteActive(['associations.*']) }}">
                <a class="side-menu__item side-menu__item1 {{ arrRouteActive(['associations.*'], 'active') }}"
                    data-toggle="slide" href="#">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_264_31511)">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M10.753 2.19664C10.4792 2.10526 10.189 2.07422 9.90207 2.10564C9.61518 2.13705 9.33849 2.23018 9.091 2.37864L4.971 4.85064C4.67485 5.02833 4.42976 5.27969 4.25959 5.58023C4.08943 5.88078 4 6.22027 4 6.56564V19.9996H3C2.73478 19.9996 2.48043 20.105 2.29289 20.2925C2.10536 20.4801 2 20.7344 2 20.9996C2 21.2649 2.10536 21.5192 2.29289 21.7067C2.48043 21.8943 2.73478 21.9996 3 21.9996H21C21.2652 21.9996 21.5196 21.8943 21.7071 21.7067C21.8946 21.5192 22 21.2649 22 20.9996C22 20.7344 21.8946 20.4801 21.7071 20.2925C21.5196 20.105 21.2652 19.9996 21 19.9996H20V6.71964C19.9998 6.30017 19.8676 5.8914 19.6223 5.55115C19.377 5.21091 19.0309 4.9564 18.633 4.82364L10.753 2.19664ZM18 19.9996V6.71964L11 4.38764V19.9996H18ZM9 4.76564L6 6.56564V19.9996H9V4.76564Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_264_31511">
                                <rect width="24" height="24" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    <span class="side-menu__label">{{ trns('associations_management') }}</span>
                    <i class="angle fa fa-angle-down"></i>
                </a>
                <ul class="slide-menu">
                    @can('create_association')
                        <li class="{{ routeActive('associations.singlePageCreate', 'active') }}">
                            <a class="slide-item text-white" href="{{ route('associations.singlePageCreate') }}">
                                <i class="fa-solid fa-house m-3"></i>{{ trns('create_association') }}
                            </a>
                        </li>
                    @endcan
                    <li class="{{ routeActive('associations.index', 'active') }}">
                        <a class="slide-item text-white" href="{{ route('associations.index') }}">
                            <i class="fa-solid fa-user-tie m-3"></i>{{ trns('association_list') }}
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

        @can('read_real_state')
            <!-- Real Estate Management -->
            <li class="slide {{ arrRouteActive(['real_states.*', 'real_state.*']) }}">
                <a class="side-menu__item side-menu__item1 {{ arrRouteActive(['real_states.*', 'real_state.*'], 'active') }}"
                    data-toggle="slide" href="#">
                    <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_264_31517)">
                            <path
                                d="M12.9999 3C13.5044 2.99984 13.9904 3.19041 14.3604 3.5335C14.7304 3.87659 14.957 4.34684 14.9949 4.85L14.9999 5V9H17.9999C18.5044 8.99984 18.9904 9.19041 19.3604 9.5335C19.7304 9.87659 19.957 10.3468 19.9949 10.85L19.9999 11V19H20.9999C21.2547 19.0003 21.4999 19.0979 21.6852 19.2728C21.8706 19.4478 21.9821 19.687 21.997 19.9414C22.012 20.1958 21.9292 20.4464 21.7656 20.6418C21.602 20.8373 21.37 20.9629 21.1169 20.993L20.9999 21H2.99987C2.74499 20.9997 2.49984 20.9021 2.3145 20.7272C2.12916 20.5522 2.01763 20.313 2.0027 20.0586C1.98776 19.8042 2.07054 19.5536 2.23413 19.3582C2.39772 19.1627 2.62977 19.0371 2.88287 19.007L2.99987 19H3.99987V5C3.99971 4.49542 4.19027 4.00943 4.53337 3.63945C4.87646 3.26947 5.34671 3.04284 5.84987 3.005L5.99987 3H12.9999ZM17.9999 11H14.9999V19H17.9999V11ZM12.9999 5H5.99987V19H12.9999V5ZM10.9999 15V17H7.99987V15H10.9999ZM10.9999 11V13H7.99987V11H10.9999ZM10.9999 7V9H7.99987V7H10.9999Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_264_31517">
                                <rect width="24" height="24" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    <span class="side-menu__label">{{ trns('real_state_management') }}</span>
                    <i class="angle fa fa-angle-down"></i>
                </a>
                <ul class="slide-menu">

                    @can('create_real_state')
                        <li class="{{ routeActive('real_state.singleCreate', 'active') }}">
                            <a class="slide-item text-white" href="{{ route('real_state.singleCreate') }}">
                                <i class="fa-solid fa-house m-3"></i>{{ trns('create_real_state') }}
                            </a>
                        </li>
                    @endcan
                    <li class="{{ routeActive('real_states.index', 'active') }}">
                        <a class="slide-item text-white" href="{{ route('real_states.index') }}">
                            <i class="fa-solid fa-house m-3"></i>{{ trns('real_state_list') }}
                        </a>
                    </li>
                </ul>
            </li>
        @endcan
        <!-- Property Unit Management -->

        @can('read_unit')
            <li class="slide {{ arrRouteActive(['Establishment_Real_estateUnit.*', 'unit.*']) }}">
                <a class="side-menu__item side-menu__item1 {{ arrRouteActive(['Establishment_Real_estateUnit.*', 'unit.*'], 'active') }}"
                    data-toggle="slide" href="#">
                    <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_405_10714)">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M6.5 3C6.87288 3.00002 7.23239 3.13892 7.50842 3.38962C7.78445 3.64032 7.9572 3.98484 7.993 4.356L8 4.5V6H9V4.5C9.00002 4.12712 9.13892 3.76761 9.38962 3.49158C9.64032 3.21555 9.98484 3.0428 10.356 3.007L10.5 3H13.5C13.8729 3.00002 14.2324 3.13892 14.5084 3.38962C14.7844 3.64032 14.9572 3.98484 14.993 4.356L15 4.5V6H16V4.5C16 4.12712 16.1389 3.76761 16.3896 3.49158C16.6403 3.21555 16.9848 3.0428 17.356 3.007L17.5 3H20.5C20.8729 3.00002 21.2324 3.13892 21.5084 3.38962C21.7844 3.64032 21.9572 3.98484 21.993 4.356L22 4.5V19.5C22 19.8729 21.8611 20.2324 21.6104 20.5084C21.3597 20.7844 21.0152 20.9572 20.644 20.993L20.5 21H3.5C3.12712 21 2.76761 20.8611 2.49158 20.6104C2.21555 20.3597 2.0428 20.0152 2.007 19.644L2 19.5V4.5C2.00002 4.12712 2.13892 3.76761 2.38962 3.49158C2.64032 3.21555 2.98484 3.0428 3.356 3.007L3.5 3H6.5ZM20 16H17V19H20V16ZM15 16H9V19H15V16ZM7 16H4V19H7V16ZM20 12H13V14H20V12ZM11 12H4V14H11V12ZM6 5H4V10H20V5H18V6.5C18 6.89782 17.842 7.27936 17.5607 7.56066C17.2794 7.84196 16.8978 8 16.5 8H14.5C14.1022 8 13.7206 7.84196 13.4393 7.56066C13.158 7.27936 13 6.89782 13 6.5V5H11V6.5C11 6.89782 10.842 7.27936 10.5607 7.56066C10.2794 7.84196 9.89782 8 9.5 8H7.5C7.10218 8 6.72064 7.84196 6.43934 7.56066C6.15804 7.27936 6 6.89782 6 6.5V5Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_405_10714">
                                <rect width="24" height="24" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    <span class="side-menu__label">{{ trns('unit_management') }}</span>
                    <i class="angle fa fa-angle-down"></i>
                </a>
                <ul class="slide-menu">
                    @can('create_unit')
                        <li class="{{ routeActive('unit.singlePageCreate', 'active') }}">
                            <a class="slide-item text-white" href="{{ route('unit.singlePageCreate') }}">
                                <i class="fa-solid fa-house m-3"></i>{{ trns('create_unit') }}
                            </a>
                        </li>
                    @endcan
                    <li class="{{ routeActive('Establishment_Real_estateUnit.index', 'active') }}">
                        <a class="slide-item text-white" href="{{ route('Establishment_Real_estateUnit.index') }}">
                            <i class="fa-solid fa-house m-3"></i>{{ trns('unit_list') }}
                        </a>
                    </li>
                </ul>
            </li>
        @endcan
        {{-- @can("read_contract") --}}
        <li class="slide {{ arrRouteActive(['contracts.*', 'contracts.*']) }}">
            <a class="side-menu__item side-menu__item1 {{ arrRouteActive(['contracts.*', 'contracts.*'], 'active') }}"
                data-toggle="slide" href="#">
                <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path fill="white"
                        d="M6 2C5.44772 2 5 2.44772 5 3V21C5 21.5523 5.44772 22 6 22H18C18.5523 22 19 21.5523 19 21V8L13 2H6ZM13 3.5L18.5 9H13V3.5ZM7 4H12V9H18V20H7V4Z" />
                </svg>
                <span class="side-menu__label">{{ trns('contracts') }}</span>
                <i class="angle fa fa-angle-down"></i>
            </a>

            <ul class="slide-menu">
                <li class="{{ routeActive('contracts.singlePageCreate', 'active') }}">
                    <a class="slide-item text-white" href="{{ route('contracts.singlePageCreate') }}">
                        <i class="fa-solid fa-plus-circle m-3"></i>{{ trns('create_contracts') }}

                    </a>
                </li>
                <li class="{{ routeActive('contracts.index', 'active') }}">
                    <a class="slide-item text-white" href="{{ route('contracts.index') }}">
                        <i class="fa-solid fa-file-lines m-3"></i>{{ trns('contracts_list') }}
                    </a>
                </li>
            </ul>

        </li>
        {{-- @endcan --}}

        {{-- @can(['read_vote' , 'read_meeting']) --}}
        <li class="slide {{ arrRouteActive(['votes.*', 'meetings.*']) }}">
            <a class="side-menu__item side-menu__item1 {{ arrRouteActive(['votes.*', 'meetings.*'], 'active') }}"
                data-toggle="slide" href="#">
                <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path fill="white"
                        d="M19 3H5C4.44772 3 4 3.44772 4 4V20C4 20.5523 4.44772 21 5 21H19C19.5523 21 20 20.5523 20 20V4C20 3.44772 19.5523 3 19 3ZM6 5H18V7H6V5ZM6 9H18V11H6V9ZM6 13H13V15H6V13ZM6 17H11V19H6V17Z" />
                </svg>
                <span class="side-menu__label">{{ trns('Managing_meetings_and_decisions') }}</span>
                <i class="angle fa fa-angle-down"></i>
            </a>
            <ul class="slide-menu">
                <li class="{{ routeActive('votes.singlePageCreate', 'active') }}">
                    <a class="slide-item text-white" href="{{ route('votes.singlePageCreate') }}">
                        <i class="fa-solid fa-plus-circle m-3"></i>{{ trns('create_vote') }}
                    </a>
                </li>
                <li class="{{ routeActive('votes.index', 'active') }}">
                    <a class="slide-item text-white" href="{{ route('votes.index') }}">
                        <i class="fa-solid fa-list-check m-3"></i>{{ trns('votes_list') }}
                    </a>
                </li>

                <li class="{{ routeActive('meetings.singlePageCreate', 'active') }}">
                    <a class="slide-item text-white" href="{{ route('meetings.singlePageCreate') }}">
                        <i class="fa-solid fa-calendar-plus m-3"></i>{{ trns('create_meeting') }}
                    </a>
                </li>
                <li class="{{ routeActive('meetings.index', 'active') }}">
                    <a class="slide-item text-white" href="{{ route('meetings.index') }}">
                        <i class="fa-solid fa-calendar-days m-3"></i>{{ trns('meetings_list') }}
                    </a>
                </li>
            </ul>
        </li>
        {{-- @endcan --}}


        {{-- @can("read_courtCase") --}}
        <li class="slide {{ arrRouteActive(['court_case.*']) }}">
            <a class="side-menu__item side-menu__item1 {{ arrRouteActive(['court_case.*'], 'active') }}"
                data-toggle="slide" href="#">
                <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path fill="white"
                        d="M18 2H6C5.44772 2 5 2.44772 5 3V21C5 21.5523 5.44772 22 6 22H18C18.5523 22 19 21.5523 19 21V3C19 2.44772 18.5523 2 18 2ZM7 4H17V6H7V4ZM7 8H17V10H7V8ZM7 12H14V14H7V12ZM7 16H12V18H7V16ZM15 12V7L19 11L15 12Z" />
                </svg>
                <span class="side-menu__label">{{ trns('court_case') }}</span>
                <i class="angle fa fa-angle-down"></i>
            </a>

            <ul class="slide-menu">
                <li class="{{ routeActive('court_case.singlePageCreate', 'active') }}">
                    <a class="slide-item text-white" href="{{ route('court_case.singlePageCreate') }}">
                        <i class="fa-solid fa-plus-circle m-3"></i>{{ trns('create_court_case') }}
                    </a>
                </li>
                <li class="{{ routeActive('court_case.index', 'active') }}">
                    <a class="slide-item text-white" href="{{ route('court_case.index') }}">
                        <i class="fa-solid fa-list-check m-3"></i>{{ trns('court_case') }}
                    </a>
                </li>
            </ul>
        </li>
        {{-- @endcan --}}



        @can('read_setting')
            <!-- Settings -->
            <li style="margin-bottom: 200px;"
                class="slide {{ arrRouteActive(['settings.*', 'agenda.*', 'topics.*', 'locations.*', 'dates.*', 'terms.*', 'names.*', 'types.*', 'roles.*', 'activity_logs.*', 'association_models.*', 'legal_ownerships.*', 'parties.*']) }}">
                <a class="side-menu__item side-menu__item1 {{ arrRouteActive(['settings.*', 'roles.*', 'agenda.*', 'activity_logs.*', 'association_models.*', 'legal_ownerships.*'], 'active') }}"
                    data-toggle="slide" href="#">
                    <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_264_31529)">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M14.41 2.29123C15.3786 2.53112 16.3057 2.91543 17.16 3.43123C17.3313 3.53459 17.4676 3.68694 17.5514 3.86859C17.6352 4.05025 17.6625 4.25286 17.63 4.45023C17.517 5.13923 17.689 5.66623 18.01 5.98823C18.332 6.31023 18.86 6.48123 19.548 6.36823C19.7455 6.33545 19.9483 6.36272 20.1302 6.44652C20.312 6.53032 20.4646 6.66678 20.568 6.83823C21.0838 7.69253 21.4681 8.61958 21.708 9.58823C21.7563 9.78257 21.7451 9.98693 21.6759 10.1748C21.6067 10.3628 21.4827 10.5256 21.32 10.6422C20.752 11.0492 20.5 11.5422 20.5 11.9982C20.5 12.4542 20.752 12.9482 21.32 13.3552C21.4826 13.4718 21.6064 13.6345 21.6756 13.8222C21.7448 14.0099 21.7561 14.214 21.708 14.4082C21.4681 15.3769 21.0838 16.3039 20.568 17.1582C20.4646 17.3297 20.312 17.4661 20.1302 17.5499C19.9483 17.6337 19.7455 17.661 19.548 17.6282C18.859 17.5152 18.333 17.6872 18.011 18.0082C17.689 18.3302 17.517 18.8582 17.631 19.5462C17.6638 19.7438 17.6365 19.9466 17.5527 20.1284C17.4689 20.3103 17.3324 20.4628 17.161 20.5662C16.3061 21.0822 15.3783 21.4665 14.409 21.7062C14.2148 21.7543 14.0106 21.743 13.8229 21.6739C13.6352 21.6047 13.4725 21.4808 13.356 21.3182C12.95 20.7502 12.456 20.4982 12 20.4982C11.545 20.4982 11.05 20.7502 10.644 21.3182C10.5274 21.4808 10.3647 21.6047 10.177 21.6739C9.98932 21.743 9.78517 21.7543 9.59098 21.7062C8.62163 21.4665 7.6939 21.0822 6.83898 20.5662C6.66752 20.4628 6.53106 20.3103 6.44726 20.1284C6.36347 19.9466 6.33619 19.7438 6.36898 19.5462C6.48298 18.8582 6.31198 18.3312 5.98898 18.0092C5.66798 17.6872 5.14098 17.5152 4.45198 17.6292C4.2546 17.6618 4.05199 17.6344 3.87034 17.5506C3.68868 17.4669 3.53633 17.3305 3.43298 17.1592C2.917 16.3043 2.53269 15.3766 2.29298 14.4072C2.2449 14.213 2.25618 14.0089 2.32534 13.8212C2.39451 13.6335 2.51839 13.4708 2.68098 13.3542C3.24798 12.9482 3.50098 12.4542 3.50098 11.9982C3.50098 11.5432 3.24798 11.0482 2.68098 10.6422C2.51839 10.5257 2.39451 10.363 2.32534 10.1753C2.25618 9.98757 2.2449 9.78342 2.29298 9.58923C2.53277 8.62022 2.91708 7.69283 3.43298 6.83823C3.53633 6.66696 3.68868 6.53061 3.87034 6.44683C4.05199 6.36304 4.2546 6.33566 4.45198 6.36823C5.14098 6.48123 5.66798 6.31023 5.98998 5.98823C6.31198 5.66623 6.48298 5.13823 6.36998 4.45023C6.33741 4.25286 6.36478 4.05025 6.44857 3.86859C6.53236 3.68694 6.6687 3.53459 6.83998 3.43123C7.69427 2.91544 8.62131 2.53114 9.58998 2.29123C9.78431 2.24294 9.98867 2.25411 10.1766 2.32328C10.3645 2.39246 10.5273 2.51646 10.644 2.67923C11.051 3.24623 11.544 3.49923 12 3.49923C12.456 3.49923 12.95 3.24623 13.357 2.67923C13.4735 2.51665 13.6362 2.39277 13.8239 2.3236C14.0116 2.25443 14.2158 2.24316 14.41 2.29123ZM14.512 4.40123C13.855 5.05823 12.992 5.49823 12 5.49823C11.008 5.49823 10.145 5.05923 9.48798 4.40023C9.11604 4.5233 8.75372 4.67371 8.40398 4.85023C8.40498 5.78023 8.10498 6.70023 7.40398 7.40223C6.70298 8.10323 5.78198 8.40323 4.85198 8.40223C4.67598 8.75023 4.52598 9.11223 4.40198 9.48623C5.06098 10.1432 5.49998 11.0062 5.49998 11.9982C5.49998 12.9902 5.06098 13.8532 4.40198 14.5102C4.52598 14.8842 4.67698 15.2472 4.85198 15.5952C5.78198 15.5932 6.70198 15.8932 7.40398 16.5952C8.10498 17.2952 8.40498 18.2162 8.40398 19.1462C8.75098 19.3222 9.11398 19.4722 9.48798 19.5962C10.145 18.9372 11.008 18.4982 12 18.4982C12.992 18.4982 13.855 18.9382 14.512 19.5962C14.8843 19.4732 15.2469 19.3228 15.597 19.1462C15.595 18.2162 15.895 17.2962 16.597 16.5942C17.297 15.8932 18.218 15.5942 19.148 15.5942C19.324 15.2472 19.474 14.8842 19.598 14.5102C18.939 13.8532 18.5 12.9902 18.5 11.9982C18.5 11.0062 18.94 10.1432 19.598 9.48623C19.4749 9.11429 19.3245 8.75197 19.148 8.40223C18.218 8.40323 17.298 8.10323 16.596 7.40223C15.895 6.70123 15.596 5.78023 15.596 4.85023C15.2462 4.67371 14.8839 4.5243 14.512 4.40123ZM12 7.99823C13.0608 7.99823 14.0783 8.41966 14.8284 9.16981C15.5785 9.91995 16 10.9374 16 11.9982C16 13.0591 15.5785 14.0765 14.8284 14.8267C14.0783 15.5768 13.0608 15.9982 12 15.9982C10.9391 15.9982 9.92169 15.5768 9.17155 14.8267C8.4214 14.0765 7.99998 13.0591 7.99998 11.9982C7.99998 10.9374 8.4214 9.91995 9.17155 9.16981C9.92169 8.41966 10.9391 7.99823 12 7.99823ZM12 9.99823C11.4695 9.99823 10.9608 10.2089 10.5858 10.584C10.2107 10.9591 9.99998 11.4678 9.99998 11.9982C9.99998 12.5287 10.2107 13.0374 10.5858 13.4124C10.9608 13.7875 11.4695 13.9982 12 13.9982C12.5304 13.9982 13.0391 13.7875 13.4142 13.4124C13.7893 13.0374 14 12.5287 14 11.9982C14 11.4678 13.7893 10.9591 13.4142 10.584C13.0391 10.2089 12.5304 9.99823 12 9.99823Z"
                                fill="white" />
                        </g>
                        <defs>
                            <clipPath id="clip0_264_31529">
                                <rect width="24" height="24" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    <span class="side-menu__label">{{ trns('settings') }}</span>
                    <i class="angle fa fa-angle-down"></i>
                </a>
                <ul class="slide-menu">
                    <li class="{{ routeActive('settings.index', 'active') }}">
                        <a class="slide-item text-white" href="{{ route('settings.index') }}">
                            <i class="fa-solid fa-screwdriver-wrench m-3"></i>{{ trns('general settings') }}
                        </a>
                    </li>
                    {{-- 
                    <li class="{{ routeActive('terms.index', 'active') }}">
                        <a class="slide-item text-white" href="{{ route('terms.index') }}">
                            <i class="fa-solid fa-handshake m-3"></i>{{ trns('terms') }}
                        </a>
                    </li> --}}
                    <li class="{{ routeActive('roles.index', 'active') }}">
                        <a class="slide-item text-white" href="{{ route('roles.index') }}">
                            <i class="fa-solid fa-universal-access m-3"></i>{{ trns('role and permission') }}
                        </a>
                    </li>
                    @can('read_activity_log')
                        <li class="{{ routeActive('activity_logs.index', 'active') }}">
                            <a class="slide-item text-white" href="{{ route('activity_logs.index') }}">
                                <i class="fa-solid fa-file-waveform m-3"></i>{{ trns('activity log') }}
                            </a>
                        </li>
                    @endcan
                    @can('read_association_model')
                        <li class="{{ routeActive('association_models.index', 'active') }}">
                            <a class="slide-item text-white" href="{{ route('association_models.index') }}">
                                <i class="fa-solid fa-diagram-project m-3"></i>{{ trns('association_model') }}
                            </a>
                        </li>
                    @endcan
                    @can('read_legal_ownership')
                        <li class="{{ routeActive('legal_ownerships.index', 'active') }}">
                            <a class="slide-item text-white" href="{{ route('legal_ownerships.index') }}">
                                <i class="fa-solid fa-scale-balanced m-3"></i>{{ trns('legal_ownerships') }}
                            </a>
                        </li>
                    @endcan

                    <!-- meeting setting  -->
                    {{-- @can('read_meeting') --}}
                    <span class="side-menu__label">{{ trns('meeting_settings') }}</span>
                    <ul class="slide-menu">
                        <li class="{{ request()->routeIs('topics.*') ? 'active' : '' }}">
                            <a class="slide-item text-white" href="{{ route('topics.index') }}">
                                <i class="fa-solid fa-users m-3"></i>{{ trns('topics_settings') }}
                            </a>
                        </li>
                    </ul>
                    {{-- @endcan --}}


                    {{-- @can('read_courtCase') --}}
                    <span class="side-menu__label">{{ trns('case_setting') }}</span>
                    <ul class="slide-menu">
                        <li class="{{ request()->routeIs('case_type.*') ? 'active' : '' }}">
                            <a class="slide-item text-white" href="{{ route('case_type.index') }}">
                                <i class="fa-solid fa-users m-3"></i>{{ trns('case_type') }}
                            </a>
                        </li>
                    </ul>
                    <ul class="slide-menu">
                        <li class="{{ request()->routeIs('Judiciaty_type.*') ? 'active' : '' }}">
                            <a class="slide-item text-white" href="{{ route('Judiciaty_type.index') }}">
                                <i class="fa-solid fa-users m-3"></i>{{ trns('Judiciaty_type') }}
                            </a>
                        </li>
                    </ul>
                    <ul class="slide-menu">
                        <li class="{{ request()->routeIs('case_update_type.*') ? 'active' : '' }}">
                            <a class="slide-item text-white" href="{{ route('case_update_type.index') }}">
                                <i class="fa-solid fa-users m-3"></i>{{ trns('case_update_type') }}
                            </a>
                        </li>
                    </ul>
                    {{-- @endcan --}}


                    {{--                    contract setting --}}
                    {{-- @can('read_contract') --}}
                    <span class="side-menu__label">{{ trns('contract_settings') }}</span>
                    <ul class="slide-menu">
                        <li class="{{ request()->routeIs('parties.*') ? 'active' : '' }}">
                            <a class="slide-item text-white" href="{{ route('parties.index') }}">
                                <i class="fa-solid fa-users m-3"></i>{{ trns('parties_settings') }}
                            </a>
                        </li>
                    </ul>
                    <ul class="slide-menu">
                        <li class="{{ request()->routeIs('types.*') ? 'active' : '' }}">
                            <a class="slide-item text-white" href="{{ route('types.index') }}">
                                <i class="fa-solid fa-shapes m-3"></i>{{ trns('types_settings') }}
                            </a>
                        </li>
                    </ul>
                    <ul class="slide-menu">
                        <li class="{{ request()->routeIs('names.*') ? 'active' : '' }}">
                            <a class="slide-item text-white" href="{{ route('names.index') }}">
                                <i class="fa-solid fa-id-card m-3"></i>{{ trns('names_settings') }}
                            </a>
                        </li>
                    </ul>
                    {{-- <ul class="slide-menu">
                        <li class="{{request()->routeIs('terms.*') ? 'active' : '' }}">
                            <a class="slide-item text-white" href="{{ route('terms.index') }}">
                                <i class="fa-solid fa-file-contract m-3"></i>{{ trns('terms_settings') }}
                            </a>
                        </li>
                    </ul> --}}
                    <ul class="slide-menu">
                        <li class="{{ request()->routeIs('locations.*') ? 'active' : '' }}">
                            <a class="slide-item text-white" href="{{ route('locations.index') }}">
                                <i class="fa-solid fa-map-marker-alt m-3"></i>{{ trns('locations_settings') }}
                            </a>
                        </li>
                    </ul>
                    {{-- @endcan --}}


                </ul>
            </li>
        @endcan

        <!-- Logout -->
        <li style="margin-top: -200px;" class="{{ routeActive('admin.logout', 'active') }}">
            <a class="side-menu__item side-menu__item1 text-danger" style="height: 42px;"
                href="{{ route('admin.logout') }}">
                <i class="fe fe-log-out text-danger side-menu__icon"></i>
                <span class="side-menu__label">{{ trns('logout') }}</span>
            </a>
        </li>
    </ul>
</aside>
