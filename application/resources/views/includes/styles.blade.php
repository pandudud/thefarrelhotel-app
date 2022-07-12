<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="{{ assets('global/plugins/font-google/font-google.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ assets('global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ assets('global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ assets('global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ assets('global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ assets('global/plugins/bootstrap-toastr/toastr.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ assets('global/plugins/sweetalert2/sweetalert2.css')}}" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL STYLES -->
@stack('styles')
<!-- END PAGE LEVEL STYLES -->

<!-- BEGIN THEME GLOBAL STYLES -->
<link href="{{ assets('global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
<link href="{{ assets('global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->

<!-- BEGIN THEME LAYOUT STYLES -->
<link href="{{ assets('layouts/layout/css/layout.css') }}" rel="stylesheet" type="text/css" />
@if(session('color-option') == 'blue')
<link href="{{ assets('layouts/layout/css/themes/blue.css')}}" rel="stylesheet" type="text/css" id="style_color" />
@elseif(session('color-option') == 'darkblue')
<link href="{{ assets('layouts/layout/css/themes/darkblue.css')}}" rel="stylesheet" type="text/css" id="style_color" />
@elseif(session('color-option') == 'grey')
<link href="{{ assets('layouts/layout/css/themes/grey.css')}}" rel="stylesheet" type="text/css" id="style_color" />
@elseif(session('color-option') == 'light')
<link href="{{ assets('layouts/layout/css/themes/light.css')}}" rel="stylesheet" type="text/css" id="style_color" />
@elseif(session('color-option') == 'light2')
<link href="{{ assets('layouts/layout/css/themes/light2.css')}}" rel="stylesheet" type="text/css" id="style_color" />
@else
<link href="{{ assets('layouts/layout/css/themes/default.css')}}" rel="stylesheet" type="text/css" id="style_color" />
@endif
<link href="{{ assets('layouts/layout/css/custom.css') }}" rel="stylesheet" type="text/css" />
<!-- END THEME LAYOUT STYLES -->