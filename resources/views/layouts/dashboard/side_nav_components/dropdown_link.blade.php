<li>
    <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Leave Management</span> <span class="fa arrow"></span></a>
    {{--<a href="#"><i class="fa fa-globe"></i> <span class="nav-label">Miscellaneous</span><span class="label label-info pull-right">NEW</span></a>--}}
    <ul class="nav nav-second-level collapse">
        <li><a href="#" @click="swapComponent('leave-allocations')">Leave Allocations</a></li>
        <li><a href="#"  @click="swapComponent('open-applications')">Open</a></li>
        <li><a href="#"  @click="swapComponent('pending-applications')">Pending</a></li>
        <li><a href="#"  @click="swapComponent('posted-applications')">Posted</a></li>
        <li><a href="#"  @click="swapComponent('approval-request')">Approval Requests <span class="badge badge-danger">6</span></a></li>
        <li><a href="#"  @click="swapComponent('leave-planner')">Leave Planner</a></li>
        <li><a href="#"  @click="swapComponent('statistics')">Statistics</a></li>
        <li><a href="#"  @click="swapComponent('department-planner')">Department Planner</a></li>
    </ul>
</li>
