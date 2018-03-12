<template>
<div>
    <div class="row m-b-lg m-t-lg">
        <div class="col-md-6">
            <div class="profile-image">
                <img :src="userDetails.profilePicture " class="img-circle circle-border m-b-md" alt="Profile Picture">
            </div>
            <div class="profile-info">
                <div class="">
                    <div>
                        <h1 class="no-margins" >
                            {{userDetails.fullName}}
                        </h1>
                        <h4>{{currentUserData.Job_Title}}</h4>
                        <small>
                            Bio:
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <table class="table table-condensed">
                <tbody>
                <tr>
                    <td>
                        <strong>Title</strong>
                    </td>
                    <td>
                       {{currentUserData.Title}}
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Department</strong>
                    </td>
                    <td>
                        {{currentUserData.Department}}
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Date of Join</strong>
                    </td>
                    <td>
                        {{currentUserData.Employment_Date}}
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Date of Birth</strong>
                    </td>
                    <td>
                        {{currentUserData.Birth_Date}}
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Name of Manager</strong>
                    </td>
                    <td>
                        {{currentUserData.Company_E_Mail}}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="row m-b-lg">
                <div class="col-lg-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1">Personal info</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2">Contacts info</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-3">Bank Details</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>ID Number</th>
                                            <th>{{currentUserData.National_ID}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>NSSF</td>
                                            <td>{{currentUserData.NSSF_No}}</td>
                                        </tr>
                                        <tr>
                                            <td>NHIF</td>
                                            <td>{{currentUserData.NHIF_No}}</td>
                                        </tr>
                                        <tr>
                                            <td>Passport</td>
                                            <td>{{currentUserData.Passport_No}}</td>
                                        </tr>
                                        <tr>
                                            <td>Helb</td>
                                            <td>{{currentUserData.HELB_NO}}</td>
                                        </tr>
                                        <tr>
                                            <td>Pin Number</td>
                                            <td>{{currentUserData.Passport_No}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <tbody>
                                        <tr>
                                            <td>Phone 1</td>
                                            <td>{{currentUserData.Phone_No}}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone 2</td>
                                            <td>{{currentUserData.Mobile_Phone_No}}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{currentUserData.E_Mail}}</td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td>{{currentUserData.Address}}</td>
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
                                            <td>Bank Name</td>
                                            <td> </td>
                                        </tr>
                                        <tr>
                                            <td>Branch</td>
                                            <td> </td>
                                        </tr>
                                        <tr>
                                            <td>Account No.</td>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>

            <!--Approvers-->
            <div class="row">
                <div class="col-lg-6">
                    <div class="contact-box center-version">
                        <a href="profile.html">
                            <img alt="image" class="img-circle" src="img/a2.jpg">
                            <h3 class="m-b-xs"><strong>John Smith</strong></h3>
                            <div class="font-bold">Manager</div>
                            <address class="m-t-xs">
                                johnsmith@email.com<br>
                                <abbr title="Phone">P:</abbr>  {{currentUserData.Phone_No}} &nbsp; {{ currentUserData.Phone_No}}
                            </address>
                        </a>
                        <div class="contact-box-footer">
                            <div class="m-t-xs btn-group">
                                <a class="btn btn-xs btn-white"><i class="fa fa-phone"></i> Call </a>
                                <a class="btn btn-xs btn-white"><i class="fa fa-envelope"></i> Email</a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-box center-version">
                        <a href="profile.html">
                            <img alt="image" class="img-circle" src="img/a2.jpg">
                            <h3 class="m-b-xs"><strong>John Smith</strong></h3>
                            <div class="font-bold">Manager</div>
                            <address class="m-t-xs">
                                johnsmith@email.com<br>
                                <abbr title="Phone">P:</abbr> {{currentUserData.Phone_No}}
                            </address>
                        </a>
                        <div class="contact-box-footer">
                            <div class="m-t-xs btn-group">
                                <a class="btn btn-xs btn-white"><i class="fa fa-phone"></i> Call </a>
                                <a class="btn btn-xs btn-white"><i class="fa fa-envelope"></i> Email</a>
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
            'swapComponent',
            'userDetails'
        ],
        data : function () {
            return {

            }
        },
        methods : {

        },
        created : function () {

        }
    }
</script>

<style scoped>

</style>