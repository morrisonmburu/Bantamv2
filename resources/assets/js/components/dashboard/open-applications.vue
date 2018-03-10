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
                                <h4 class="modal-title">New application</h4>
                            </div>
                            <div class="modal-body">
                                <form role="form">
                                    <div class="form-group"><label>Leave type</label>
                                        <select class="form-control col-x-12" name="leave_code" id="leave_code" v-model="formData.leave_code">
                                            <option v-for="leave in leaveTypes" v-bind:value="leave.Code">{{leave.Description}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group"><label>Start Date</label>
                                        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control" name="start_date" id="start_date"  v-model="formData.start_date">
                                        </div>
                                    </div>
                                    <div class="form-group"><label>Number of days</label>
                                        <input type="number" placeholder="Number of days" v-model="formData.no_of_days" class="form-control" name="no_of_days" id="no_of_days"></div>
                                    <div class="text-center">
                                        <button class="ladda-button btn btn-primary" data-style="expand-right" @click="calculate"> <strong>Calculate <i class="fa fa-calculator"></i> </strong></button>
                                    </div>
                                    <div class="form-group"><label>End Date</label>
                                        <div class="input-group date" data-provide="datepicker">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control" readonly name="end_date" v-model="formData.end_date" id="end_date">
                                        </div>
                                    </div>
                                    <div class="form-group"><label>Return Date</label>
                                        <div class="input-group date" data-provide="datepicker">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control" readonly name="return_date" v-model="formData.return_date" id="return_date">
                                        </div>
                                    </div>
                                    <div class="form-group"><label>Comments</label>
                                        <textarea class="form-control" rows="2" id="comment" name="comment" v-model="formData.comment"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                <button @click="submitLeaveApplication" class="btn btn-primary">Apply <i class="fa fa-check-circle-o"></i> </button>
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
        data : function(){
            return {
                APIENDPOINT : {
                    CALCULATE : 'api/leave_applications/calculate_leave_dates',
                    LEAVETYPES : 'api/leave_types',
                    LEAVEAPPLICATION : 'api/leave_applications '
                },
                formData: {
                    leave_code : '',
                    start_date : '',
                    no_of_days : '',
                    end_date : '',
                    return_date : '',
                    comment : '',
                },
                leaveTypes : {}
            }
        },
        methods : {
            calculate : function (e) {
                e.preventDefault();
                var v = this
                axios.post(
                    this.APIENDPOINT.CALCULATE,
                    this.formData,
                    {headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }})
                    .then(function (response) {
                        console.log('calculated data')
                        console.log(response.data)
                        v.formData.end_date = response.data.eDate
                        v.formData.return_date = response.data.rDate
                    })
            },
            submitLeaveApplication : function (e) {
                e.preventDefault();
                var v = this
                axios.post(
                    this.APIENDPOINT.LEAVEAPPLICATION,
                    this.formData,
                    {headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }}
                )
                    .then(function (response) {
                        console.log(response.data)
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
            },
            getLeaveTypes : function () {
                var v = this
                axios.get('api/leave_types')
                    .then(function (response) {
                        v.leaveTypes = response.data.data
                        console.log('leave types')
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
            },
        },
        created() {
            this.getLeaveTypes()
        }




    }
</script>

<style scoped>

</style>