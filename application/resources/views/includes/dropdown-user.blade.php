<!-- DOC: Apply "dropdown-dark" class after "dropdown-extended" to change the dropdown styte -->
<!-- DOC: Apply "dropdown-hoverable" class after below "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
<!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->
<li class="dropdown {{ session('dropdown-hoverable-option') == 'yes' ? 'dropdown-hoverable' : '' }} {{ session('page-header-top-dropdown-style-option') == 'dark' ? 'dropdown-dark' : '' }} dropdown-user">
    <a href="javascript:;" class="dropdown-toggle" {{ session('dropdown-hoverable-option') == 'yes' ? '' : 'data-toggle=dropdown data-hover=dropdown data-close-others=true' }}>
        <img alt="" class="img-circle" src="{{ Avatar::create($user->name)->toBase64() }}" />
        <span class="username username-hide-on-mobile"> {{ $user->name }} </span>
        <i class="fa fa-angle-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-default">
        <li style="margin-top: 10px;">
            <a href="{{ url('home/profile') }}">
                <i class="icon-user"></i> My Profile
            </a>
        </li>
        <li class="divider"> </li>
        <li>
            <a href="{{ url('home/lock') }}">
                <i class="icon-lock"></i> Lock Screen
            </a>
        </li>
        <li style="margin-bottom: 10px;">
            <a href="{{ url('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="icon-key"></i> Log Out
            </a>
            <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">{{ csrf_field() }} </form>
        </li>
    </ul>
</li>