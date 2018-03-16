<li>
    <a href="#" @click="swapComponent('dashboard')"><i class="fa fa-tachometer"></i> <span class="nav-label">Dashboard</span></a>
</li>
<li>
    <a href="#" @click="swapComponent('profile')"><i class="fa fa-user-circle"></i> <span class="nav-label">Profile</span></a>
</li>

<li  v-show="currentUserData.is_approver">
    <a href="#"  @click="swapComponent('approval-request')"><i class="fa fa-list"></i> <span class="nav-label">Approval Requests </span></a>
</li>

{{--Dropdown side nav Link--}}
@include('layouts.dashboard.side_nav_components.dropdown_link')

<li>
    <a href="#" @click="swapComponent('payslip')"><i class="fa fa-money"></i> <span class="nav-label">Payslips</span></a>
</li>

<li>
    <a href="#" @click="swapComponent('faq')"><i class="fa fa-question-circle"></i> <span class="nav-label">FAQ</span></a>
</li>

