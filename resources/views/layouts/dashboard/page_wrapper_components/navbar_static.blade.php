<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">

        {{--nav bar header--}}
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

            {{--nav bar search--}}
            <form role="search" class="navbar-form-custom" action="search_results.html">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" v-model="searchTerm"  name="top-search" id="top-search">
                </div>
            </form>
        </div>

        {{--nav bar rigth links--}}
        <ul class="nav navbar-top-links navbar-right">
            {{--nav bar welcome message--}}
            <li>
                <span class="m-r-sm text-muted welcome-message">Welcome @{{ currentUserData.First_Name }}.</span>
            </li>

            {{--drop down and notifications--}}
            {{--<li class="dropdown">--}}
                {{--<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">--}}
                    {{--<i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>--}}
                {{--</a>--}}
                {{--<ul class="dropdown-menu dropdown-messages">--}}
                    {{--<li>--}}
                        {{--<div class="dropdown-messages-box">--}}
                            {{--<a href="profile.html" class="pull-left">--}}
                                {{--<img alt="image" class="img-circle" src="img/a7.jpg">--}}
                            {{--</a>--}}
                            {{--<div class="media-body">--}}
                                {{--<small class="pull-right">46h ago</small>--}}
                                {{--<strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>--}}
                                {{--<small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<div class="dropdown-messages-box">--}}
                            {{--<a href="profile.html" class="pull-left">--}}
                                {{--<img alt="image" class="img-circle" src="img/a4.jpg">--}}
                            {{--</a>--}}
                            {{--<div class="media-body ">--}}
                                {{--<small class="pull-right text-navy">5h ago</small>--}}
                                {{--<strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>--}}
                                {{--<small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<div class="dropdown-messages-box">--}}
                            {{--<a href="profile.html" class="pull-left">--}}
                                {{--<img alt="image" class="img-circle" src="img/profile.jpg">--}}
                            {{--</a>--}}
                            {{--<div class="media-body ">--}}
                                {{--<small class="pull-right">23h ago</small>--}}
                                {{--<strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>--}}
                                {{--<small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<div class="text-center link-block">--}}
                            {{--<a href="mailbox.html">--}}
                                {{--<i class="fa fa-envelope"></i> <strong>Read All Messages</strong>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}

            <notification
                    :current-user="currentUser"
                    :current-user-data="currentUserData"
                    :swap-component="swapComponent"
                    :user-details="userDetails"
                    :a-p-i-e-n-d-p-o-i-n-t-s="APIENDPOINTS"
                    :get-api-path="getApiPath"
                    :is-empty-object="isEmptyObject"
                    :validate-field="validateField"
                    :notification-events="notificationEvents"
            ></notification>

            {{--Log out link--}}
            <li>
                <a  href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    Log out <i class="fa fa-sign-out"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
</div>