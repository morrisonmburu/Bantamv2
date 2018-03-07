<li>
    <a href="#" v-on:click="currentView ='dashboard'"><i class="fa fa-tachometer"></i> <span class="nav-label">Dashboard</span></a>
</li>
<li>
    <a href="#" v-on:click="currentView ='profile'"><i class="fa fa-user-circle"></i> <span class="nav-label">Profile</span></a>
</li>
{{--Dropdown side nav Link--}}
@include('layouts.dashboard.side_nav_components.dropdown_link')

<li>
    <a href=""><i class="fa fa-file"></i> <span class="nav-label">Payslips</span></a>
</li>
