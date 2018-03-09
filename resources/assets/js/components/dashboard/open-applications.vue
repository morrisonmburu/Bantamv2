<template>
    <div>
        <div class="row">
            <div class="col-lg-8">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Open Applications</h5>
                        <div class="ibox-tools">
                            <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModal">
                                New
                            </button>
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Leave Type</th>
                                <th>Application Date</th>
                                <th>Number of Days</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>Maternity</td>
                                <td>02/08/2018</td>
                                <td>15</td>
                                <td>Open</td>
                                <td><button class="btn btn-sm bt-default">view</button></td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Sick</td>
                                <td>02/08/2018</td>
                                <td>15</td>
                                <td>Open</td>
                                <td><button class="btn btn-sm bt-default">view</button></td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Educational</td>
                                <td>02/08/2018</td>
                                <td>15</td>
                                <td>Open</td>
                                <td><button class="btn btn-sm bt-default">view</button></td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Study</td>
                                <td>02/08/2018</td>
                                <td>15</td>
                                <td>Open</td>
                                <td><button class="btn btn-sm bt-default">view</button></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Recent Activities</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="activity-stream">
                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-pencil"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <img src="img/a5.jpg">
                                            <span>Karen Miggel</span>
                                            <span class="date">Today at 01:32:40 am</span>
                                        </a>
                                    </div>
                                    Add new note to the <a href="#">Martex</a>  project.
                                </div>
                            </div>
                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-commenting-o"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <img src="img/a4.jpg">
                                            <span>John Mikkens</span>
                                            <span class="date">Yesterday at 10:00:20 am</span>
                                        </a>
                                    </div>
                                    Commented on <a href="#">Ariana</a> profile.
                                </div>
                            </div>
                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-circle"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <img src="img/a2.jpg">
                                            <img src="img/a3.jpg">
                                            <img src="img/a4.jpg">
                                            <span>Mike Johnson, Monica Smith and Karen Dortmund</span>
                                            <span class="date">Yesterday at 02:13:20 am</span>
                                        </a>
                                    </div>
                                    Changed status of third stage in the <a href="#">Vertex</a> project.
                                </div>
                            </div>
                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-circle"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <img src="img/a6.jpg">
                                            <span>Jessica Smith</span>
                                            <span class="date">Yesterday at 08:14:41 am</span>
                                        </a>
                                    </div>
                                    Add new files to own file sharing place.
                                </div>
                            </div>
                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-send bg-primary"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <img src="img/a7.jpg">
                                            <img src="img/a1.jpg">
                                            <span>Martha Farter and Mike Rodgers</span>
                                            <span class="date">Yesterday at 04:18:13 am</span>
                                        </a>
                                    </div>
                                    Sent email to all users participating in new project.
                                </div>
                            </div>
                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-tag bg-warning"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <img src="img/a7.jpg">
                                            <span>Mark Mickens</span>
                                            <span class="date">Yesterday at 06:00:30 am</span>
                                        </a>
                                    </div>
                                    Has been taged in the latest comments about the new project.
                                </div>
                            </div>
                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-circle"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <img src="img/a8.jpg">
                                            <span>Mike Johnson</span>
                                            <span class="date">Yesterday at 02:13:20 am</span>
                                        </a>
                                    </div>
                                    Changed status of second stage in the latest project.
                                </div>
                            </div>
                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-circle"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <img src="img/a1.jpg">
                                            <span>Jessica Smith</span>
                                            <span class="date">Yesterday at 08:14:41 am</span>
                                        </a>
                                    </div>
                                    Add new files to own file sharing place.
                                </div>
                            </div>
                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-circle"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <img src="img/a6.jpg">
                                            <span>Jessica Smith</span>
                                            <span class="date">Yesterday at 08:14:41 am</span>
                                        </a>
                                    </div>
                                    Add new files to own file sharing place.
                                </div>
                            </div>
                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-send"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <img src="img/a7.jpg">
                                            <span>Martha Farter</span>
                                            <span class="date">Yesterday at 04:18:13 am</span>
                                        </a>
                                    </div>
                                    Sent email to all users participating in new project.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ==== Modal for new leave application:: Added by Mayaka == -->
                <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content animated bounceInRight">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <i class="fa fa-th-large modal-icon"></i>
                                <h4 class="modal-title">New leave application</h4>
                            </div>
                            <div class="modal-body">
                                <form role="form">
                                    <div class="form-group"><label>Start Date</label>
                                        <div class="input-group date" data-provide="datepicker">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group"><label>Number of days</label> <input type="number" placeholder="Number of days" class="form-control"></div>
                                    <div class="text-center">
                                        <button class="ladda-button btn btn-primary" data-style="expand-right" type="submit"><strong>Calculate <i class="fa fa-calculator"></i> </strong></button>
                                    </div>
                                    <div class="form-group"><label>End Date</label>
                                        <div class="input-group date" data-provide="datepicker">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group"><label>Return Date</label>
                                        <div class="input-group date" data-provide="datepicker">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Apply <i class="fa fa-check-circle-o"></i> </button>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- End of New leave application modal -->
        </div>
    </div>

</template>

<script>
    export default {
        name: "open-applications",
        props : [
            'currentUser',
            'currentUserData',
            'swapComponent'
        ],
    }
</script>

<style scoped>

</style>