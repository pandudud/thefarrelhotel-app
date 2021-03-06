<!-- DOC: Apply "dropdown-dark" class after "dropdown-extended" to change the dropdown styte -->
<!-- DOC: Apply "dropdown-hoverable" class after below "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
<!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->
<li class="dropdown {{ session('dropdown-hoverable-option') == 'yes' ? 'dropdown-hoverable' : '' }} dropdown-extended {{ session('page-header-top-dropdown-style-option') == 'dark' ? 'dropdown-dark' : '' }} dropdown-inbox" id="header_inbox_bar">
    <a href="javascript:;" class="dropdown-toggle" {{ session('dropdown-hoverable-option') == 'yes' ? '' : 'data-toggle=dropdown data-hover=dropdown data-close-others=true' }}>
        <i class="icon-envelope-open"></i>
        <span class="badge badge-default"> 4 </span>
    </a>
    <ul class="dropdown-menu">
        <li class="external">
            <h3>You have
                <span class="bold">7 New</span> Messages</h3>
            <a href="app_inbox.html">view all</a>
        </li>
        <li>
            <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                <li>
                    <a href="#">
                        <span class="photo">
                            <img src="{{ assets('layouts/layout/img/avatar2.jpg') }}" class="img-circle" alt=""> </span>
                        <span class="subject">
                            <span class="from"> Lisa Wong </span>
                            <span class="time">Just Now </span>
                        </span>
                        <span class="message"> Vivamus sed auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo">
                            <img src="{{ assets('layouts/layout/img/avatar3.jpg') }}" class="img-circle" alt=""> </span>
                        <span class="subject">
                            <span class="from"> Richard Doe </span>
                            <span class="time">16 mins </span>
                        </span>
                        <span class="message"> Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo">
                            <img src="{{ assets('layouts/layout/img/avatar1.jpg') }}" class="img-circle" alt=""> </span>
                        <span class="subject">
                            <span class="from"> Bob Nilson </span>
                            <span class="time">2 hrs </span>
                        </span>
                        <span class="message"> Vivamus sed nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo">
                            <img src="{{ assets('layouts/layout/img/avatar2.jpg') }}" class="img-circle" alt=""> </span>
                        <span class="subject">
                            <span class="from"> Lisa Wong </span>
                            <span class="time">40 mins </span>
                        </span>
                        <span class="message"> Vivamus sed auctor 40% nibh congue nibh... </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo">
                            <img src="{{ assets('layouts/layout/img/avatar3.jpg') }}" class="img-circle" alt=""> </span>
                        <span class="subject">
                            <span class="from"> Richard Doe </span>
                            <span class="time">46 mins </span>
                        </span>
                        <span class="message"> Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</li>