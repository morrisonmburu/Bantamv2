<li>
    <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Leave Management</span> <span class="fa arrow"></span></a>
    {{--<a href="#"><i class="fa fa-globe"></i> <span class="nav-label">Miscellaneous</span><span class="label label-info pull-right">NEW</span></a>--}}
    <ul class="nav nav-second-level collapse">
        <li><a href="#"  @click="swapComponent('open-applications')">Leave Application</a></li>
        <li><a href="#" @click="swapComponent('leave-allocations')">Leave Allocations</a></li>
        {{--<li><a href="#"  @click="swapComponent('pending-applications')">Pending</a></li>--}}
        <li><a href="#"  @click="swapComponent('leave-history')">Leave History</a></li>
        <li><a href="#" class="disabled-link" {{--@click="swapComponent('leave-planner')"--}}>Leave Planner</a></li>
        <li><a href="#" class="disabled-link" {{--@click="swapComponent('department-planner')"--}}>Department Planner</a></li>
        <li><a href="#" class="disabled-link" {{--@click="swapComponent('statistics')"--}}>Statistics</a></li>
    </ul>
</li>
