<template>
<div>
    <div class="row m-b-lg m-t-lg">
        <div class="col-md-6">
            <div class="profile-image">
                <img src="img/a4.jpg" class="img-circle circle-border m-b-md" alt="profile">
            </div>
            <div class="profile-info">
                <div class="">
                    <div>
                        <h2 class="no-margins">
                            {{currentUserData.First_Name +' '+ currentUserData.Middle_Name +' '+ currentUserData.Last_Name}}
                        </h2>
                        <h4>&nbsp;&nbsp;&nbsp;{{currentUserData.Job_Title}}</h4>
                        <small>
                            Bio:
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <table class="table small m-b-xs">
                <tbody>
                <tr>
                    <td>
                        <strong>Company Email</strong> {{currentUserData.Company_E_Mail}}
                    </td>
                    <td>
                        <strong>Address</strong> {{currentUserData.Address}}
                    </td>

                </tr>
                <tr>
                    <td>
                        <strong>Initials</strong> {{currentUserData.Initials}}
                    </td>
                    <td>
                        <strong>Phone No.</strong> {{currentUserData.Mobile_Phone_No}}
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Status</strong> {{currentUserData.Status}}
                    </td>
                    <td>
                        <strong>Title</strong> {{currentUserData.Title}}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-3">
            <small>Sales in last 24h</small>
            <h2 class="no-margins">206 480</h2>
            <div id="sparkline1"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="row m-b-lg">
                <div class="col-lg-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1">Personal</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-3">Employment</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-4">Contacts</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Names</th>
                                            <th>{{currentUserData.First_Name +' '+ currentUserData.Middle_Name +' '+ currentUserData.Last_Name}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Initials</td>
                                            <td>{{currentUserData.Title}}</td>
                                        </tr>
                                        <tr>
                                            <td>DOB</td>
                                            <td>{{currentUserData.Birth_Date}}</td>
                                        </tr>
                                        <tr>
                                            <td>Gender</td>
                                            <td>{{currentUserData.Gender}}</td>
                                        </tr>
                                        <tr>
                                            <td>National ID</td>
                                            <td>{{currentUserData.National_ID}}</td>
                                        </tr>
                                        <tr>
                                            <td>Passport No</td>
                                            <td>{{currentUserData.Passport_No}}</td>
                                        </tr>
                                        <tr>
                                            <td>Pin No</td>
                                            <td>{{currentUserData.PIN_No}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="tab-3" class="tab-pane">
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <tbody>
                                        <tr>
                                            <td>Employment Date</td>
                                            <td>{{currentUserData.Employment_Date}}</td>
                                        </tr>
                                        <tr>
                                            <td>Employee No.</td>
                                            <td>{{currentUserData.No}}</td>
                                        </tr>
                                        <tr>
                                            <td>Job Title</td>
                                            <td>{{currentUserData.Job_Title}}</td>
                                        </tr>
                                        <tr>
                                            <td>Department</td>
                                            <td>{{currentUserData.Department}}e</td>
                                        </tr>
                                        <tr>
                                            <td>NSSF</td>
                                            <td>{{currentUserData.NSSF_No}}</td>
                                        </tr>
                                        <tr>
                                            <td>NHIF</td>
                                            <td>{{currentUserData.NHIF_No}}</td>
                                        </tr>
                                        <tr>
                                            <td>HELB NO</td>
                                            <td>{{currentUserData.HELB_NO}}</td>
                                        </tr>
                                        <tr>
                                            <td>Social Security No.</td>
                                            <td>{{currentUserData.Social_Security_No}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="tab-4" class="tab-pane">
                                <div class="panel-body">
                                    <div class="col-lg-12">
                                        <div class="contact-box">
                                            <a href="#">
                                                <div class="col-sm-3">
                                                    <div class="text-center">
                                                        <img alt="image" class="img-circle m-t-xs img-responsive" src="img/a6.jpg">
                                                        <div class="m-t-xs font-bold">{{currentUserData.Job_Title}}</div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-9">
                                                    <h3><strong>{{currentUserData.First_Name +' '+ currentUserData.Middle_Name +' '+ currentUserData.Last_Name}}</strong></h3>
                                                    <p><i class="fa fa-map-marker"></i> {{currentUserData.Address}}</p>
                                                    <address>
                                                        <strong>{{currentUserData.Job_Title}}</strong><br>
                                                        {{currentUserData.E_Mail}}<br>
                                                        {{currentUserData.Post_Code}}<br>
                                                        {{currentUserData.City}}<br>
                                                        <abbr title="Phone">P:</abbr> {{currentUserData.Phone_No}}
                                                    </address>
                                                </div>
                                                <div class="clearfix"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="contact-box center-version">

                        <a href="profile.html">

                            <img alt="image" class="img-circle" src="img/a2.jpg">


                            <h3 class="m-b-xs"><strong>John Smith</strong></h3>

                            <div class="font-bold">Graphics designer</div>
                            <address class="m-t-md">
                                <strong>Twitter, Inc.</strong><br>
                                795 Folsom Ave, Suite 600<br>
                                San Francisco, CA 94107<br>
                                <abbr title="Phone">P:</abbr> (123) 456-7890
                            </address>

                        </a>
                        <div class="contact-box-footer">
                            <div class="m-t-xs btn-group">
                                <a class="btn btn-xs btn-white"><i class="fa fa-phone"></i> Call </a>
                                <a class="btn btn-xs btn-white"><i class="fa fa-envelope"></i> Email</a>
                                <a class="btn btn-xs btn-white"><i class="fa fa-user-plus"></i> Follow</a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-box center-version">

                        <a href="profile.html">

                            <img alt="image" class="img-circle" src="img/a1.jpg">


                            <h3 class="m-b-xs"><strong>Alex Johnatan</strong></h3>

                            <div class="font-bold">CEO</div>
                            <address class="m-t-md">
                                <strong>Twitter, Inc.</strong><br>
                                795 Folsom Ave, Suite 600<br>
                                San Francisco, CA 94107<br>
                                <abbr title="Phone">P:</abbr> (123) 456-7890
                            </address>

                        </a>
                        <div class="contact-box-footer">
                            <div class="m-t-xs btn-group">
                                <a class="btn btn-xs btn-white"><i class="fa fa-phone"></i> Call </a>
                                <a class="btn btn-xs btn-white"><i class="fa fa-envelope"></i> Email</a>
                                <a class="btn btn-xs btn-white"><i class="fa fa-user-plus"></i> Follow</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 m-b-lg">
            <div id="vertical-timeline" class="vertical-container light-timeline no-margins">
                <div class="vertical-timeline-block">
                    <div class="vertical-timeline-icon navy-bg">
                        <i class="fa fa-briefcase"></i>
                    </div>

                    <div class="vertical-timeline-content">
                        <h2>Meeting</h2>
                        <p>Conference on the sales results for the previous year. Monica please examine sales trends in marketing and products. Below please find the current status of the sale.
                        </p>
                        <a href="#" class="btn btn-sm btn-primary"> More info</a>
                        <span class="vertical-date">
                            Today <br>
                            <small>Dec 24</small>
                        </span>
                    </div>
                </div>

                <div class="vertical-timeline-block">
                    <div class="vertical-timeline-icon blue-bg">
                        <i class="fa fa-file-text"></i>
                    </div>

                    <div class="vertical-timeline-content">
                        <h2>Send documents to Mike</h2>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>
                        <a href="#" class="btn btn-sm btn-success"> Download document </a>
                        <span class="vertical-date">
                            Today <br>
                            <small>Dec 24</small>
                        </span>
                    </div>
                </div>

                <div class="vertical-timeline-block">
                    <div class="vertical-timeline-icon lazur-bg">
                        <i class="fa fa-coffee"></i>
                    </div>

                    <div class="vertical-timeline-content">
                        <h2>Coffee Break</h2>
                        <p>Go to shop and find some products. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's. </p>
                        <a href="#" class="btn btn-sm btn-info">Read more</a>
                        <span class="vertical-date"> Yesterday <br><small>Dec 23</small></span>
                    </div>
                </div>

                <div class="vertical-timeline-block">
                    <div class="vertical-timeline-icon yellow-bg">
                        <i class="fa fa-phone"></i>
                    </div>

                    <div class="vertical-timeline-content">
                        <h2>Phone with Jeronimo</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum aut hic quasi placeat iure tempora laudantium ipsa ad debitis unde? Iste voluptatibus minus veritatis qui ut.</p>
                        <span class="vertical-date">Yesterday <br><small>Dec 23</small></span>
                    </div>
                </div>

                <div class="vertical-timeline-block">
                    <div class="vertical-timeline-icon navy-bg">
                        <i class="fa fa-comments"></i>
                    </div>

                    <div class="vertical-timeline-content">
                        <h2>Chat with Monica and Sandra</h2>
                        <p>Web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like). </p>
                        <span class="vertical-date">Yesterday <br><small>Dec 23</small></span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
</template>

<script>
    export default {
        name: "profile",
        props : [
            'currentUser',
            'currentUserData',
            'swapComponent'
        ],
    }
</script>

<style scoped>

</style>