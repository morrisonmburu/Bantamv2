<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">

            {{--Nav header with profile picture--}}
            @include('layouts.dashboard.side_nav_components.side_nav_header')

            {{--side link--}}
            @include('layouts.dashboard.side_nav_components.side_link')

            {{--landing link--}}
            {{--@include('layouts.dashboard.side_nav_components.landing_link')--}}

            {{--special link--}}
            {{--@include('layouts.dashboard.side_nav_components.special_link')--}}

        </ul>

    </div>
</nav>