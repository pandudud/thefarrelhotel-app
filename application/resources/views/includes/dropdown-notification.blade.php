<!-- DOC: Apply "dropdown-dark" class after "dropdown-extended" to change the dropdown styte -->
<!-- DOC: Apply "dropdown-hoverable" class after below "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
<!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->
<li class="dropdown {{ session('dropdown-hoverable-option') == 'yes' ? 'dropdown-hoverable' : '' }} dropdown-extended {{ session('page-header-top-dropdown-style-option') == 'dark' ? 'dropdown-dark' : '' }} dropdown-notification" id="header_notification_bar">
    <a href="javascript:;" class="dropdown-toggle" {{ session('dropdown-hoverable-option') == 'yes' ? '' : 'data-toggle=dropdown data-hover=dropdown data-close-others=true' }}>
        <i class="icon-bell"></i>
        <span class="badge badge-default"> 7 </span>
    </a>
    <ul class="dropdown-menu">
        <li class="external">
            <h3>
                <span class="bold">12 pending</span> notifications</h3>
            <a href="page_user_profile_1.html">view all</a>
        </li>
        <li>
            <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                <li>
                    <a href="javascript:;">
                        <span class="time">just now</span>
                        <span class="details">
                            <span class="label label-sm label-icon label-success">
                                <i class="fa fa-plus"></i>
                            </span> New user registered. </span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <span class="time">3 mins</span>
                        <span class="details">
                            <span class="label label-sm label-icon label-danger">
                                <i class="fa fa-bolt"></i>
                            </span> Server #12 overloaded. </span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <span class="time">10 mins</span>
                        <span class="details">
                            <span class="label label-sm label-icon label-warning">
                                <i class="fa fa-bell-o"></i>
                            </span> Server #2 not responding. </span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <span class="time">14 hrs</span>
                        <span class="details">
                            <span class="label label-sm label-icon label-info">
                                <i class="fa fa-bullhorn"></i>
                            </span> Application error. </span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <span class="time">2 days</span>
                        <span class="details">
                            <span class="label label-sm label-icon label-danger">
                                <i class="fa fa-bolt"></i>
                            </span> Database overloaded 68%. </span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <span class="time">3 days</span>
                        <span class="details">
                            <span class="label label-sm label-icon label-danger">
                                <i class="fa fa-bolt"></i>
                            </span> A user IP blocked. </span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <span class="time">4 days</span>
                        <span class="details">
                            <span class="label label-sm label-icon label-warning">
                                <i class="fa fa-bell-o"></i>
                            </span> Storage Server #4 not responding dfdfdfd. </span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <span class="time">5 days</span>
                        <span class="details">
                            <span class="label label-sm label-icon label-info">
                                <i class="fa fa-bullhorn"></i>
                            </span> System Error. </span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <span class="time">9 days</span>
                        <span class="details">
                            <span class="label label-sm label-icon label-danger">
                                <i class="fa fa-bolt"></i>
                            </span> Storage server failed. </span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</li>