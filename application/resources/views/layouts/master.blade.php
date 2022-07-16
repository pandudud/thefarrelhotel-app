<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<html lang="en">

    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>{{ strip_tags(config('app.name')) }} | @yield('title') </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="{{ strip_tags(config('app.desc')) }}" name="description" />
        <meta content="{{ strip_tags(config('app.author')) }}" name="author" />
        <meta content="{{ csrf_token() }}" name="csrf-token">
        @include('includes.styles')
        <link rel="shortcut icon" href="favicon.ico" />
    </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white page-md {{ (session('sidebar-option') == 'fixed' ? 'page-sidebar-fixed' : '') }} {{ (session('sidebar-pos-option') == 'right' ? 'page-sidebar-reversed' : '') }} {{ (session('page-footer-option') == 'fixed' ? 'page-footer-fixed' : '') }}">
        <div class="page-wrapper">

            <!-- BEGIN HEADER -->
            @include('layouts.header')
            <!-- END HEADER -->

            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->

            <!-- BEGIN CONTAINER -->
            <div class="page-container">

                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar-wrapper">

                    <!-- BEGIN SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse {{ session('sidebar-option') == 'fixed' ? 'page-sidebar-fixed' : '' }}">

                        <!-- BEGIN SIDEBAR MENU -->
                        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                        <ul class="page-sidebar-menu page-header-fixed {{ session('sidebar-style-option') == 'default' ? '' : 'page-sidebar-menu-light' }}" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

                            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <li class="sidebar-toggler-wrapper hide">
                                <div class="sidebar-toggler">
                                    <span></span>
                                </div>
                            </li>
                            <!-- END SIDEBAR TOGGLER BUTTON -->

                            @each('layouts.menu', $menus, 'menu')

                        </ul>
                        <!-- END SIDEBAR MENU -->

                    </div>
                    <!-- END SIDEBAR -->

                </div>
                <!-- END SIDEBAR -->

                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">

                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">

                        <!-- BEGIN THEME PANEL -->
                        {{-- @include('includes.theme') --}}
                        <!-- END THEME PANEL -->

                        <!-- BEGIN CONTENT -->
                        @yield('content')
                        <!-- END CONTENT -->
                        
                        <!-- BEGIN BREAK -->
                        @if(session('page-footer-option') == 'fixed')
                        <div class="clearfix page-footer-option" style="margin-bottom: -15px;"></div>
                        @else
                        <div class="clearfix page-footer-option" style="margin-bottom: -25px;"></div>
                        @endif
                        <!-- END BREAK -->
                        
                    </div>
                    <!-- END CONTENT BODY -->

                </div>
                <!-- END CONTENT -->

                {{-- @include('includes.quick-sidebar') --}}

            </div>
            <!-- END CONTAINER -->

            <!-- BEGIN FOOTER -->
            @include('layouts.footer')
            <!-- END FOOTER -->

        </div>

        <!-- BEGIN SCRIPTS -->
        @include('includes.scripts')
        <!-- END SCRIPTS -->
    </body>

</html>