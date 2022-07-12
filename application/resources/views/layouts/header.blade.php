<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            {{-- <a href="index.html">
                <img src="{{ assets('layouts/layout/img/logo.png') }}" alt="logo" class="logo-default" />
            </a> --}}
            <div class="menu-toggler sidebar-toggler">
                <span></span>
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>
        <div class="top-title">
            {!! config('app.name') !!}
        </div>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">

                <!-- BEGIN NOTIFICATION DROPDOWN -->
                @include('includes.dropdown-notification')
                <!-- END NOTIFICATION DROPDOWN -->

                <!-- BEGIN INBOX DROPDOWN -->
                @include('includes.dropdown-inbox')
                <!-- END INBOX DROPDOWN -->

                <!-- BEGIN TASK DROPDOWN -->
                @include('includes.dropdown-task')
                <!-- END TASK DROPDOWN -->

                <!-- BEGIN USER LOGIN DROPDOWN -->
                @include('includes.dropdown-user')
                <!-- END USER LOGIN DROPDOWN -->

                <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                {{-- <li class="dropdown dropdown-quick-sidebar-toggler">
                    <a href="javascript:;" class="dropdown-toggle">
                        <i class="icon-logout"></i>
                    </a>
                </li> --}}
                <!-- END QUICK SIDEBAR TOGGLER -->

            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>