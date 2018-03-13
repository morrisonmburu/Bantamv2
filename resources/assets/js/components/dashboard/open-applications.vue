<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Open Applications</h5>
                        <div class="ibox-tools">
                            <button v-show="!loading" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal">
                                New
                            </button>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div v-if="loading" class="spiner-example">
                            <div class="sk-spinner sk-spinner-wave">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                            </div>
                        </div>

                        <table v-else class="table table-hover table-condensed animated fadeIn">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Application Code</th>
                                <th>Application Date</th>
                                <th>Days Applied</th>
                                <th>Leave Code</th>
                                <th>Leave Period</th>
                                <th>Start Date</th>
                                <th>Return Date</th>
                                <th>Status</th>
                                <!--<th>Action</th>-->
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(application, index) in applications">
                                <td>{{ index + 1}}</td>
                                <td>{{application.Application_Code}}</td>
                                <td>{{application.Application_Date}}</td>
                                <td>{{application.Days_Applied}}</td>
                                <td>{{application.Leave_Code}}</td>
                                <td>{{application.Leave_Period}}</td>
                                <td>{{application.Start_Date}}</td>
                                <td>{{application.Return_Date}}</td>
                                <td>{{application.Status}}</td>
                                <!--<td><button class="btn btn-sm bt-default" @click="showDetails(index, application)" >view</button></td>-->
                            </tr>
                            <tr v-if="isEmptyObject(applications)">
                                <td colspan="8" class="text-center"><i class="text-muted">no applications found</i></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
                <div class="col-lg-12">
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
            </div>

        <!-- ==== Modal for new leave application:: Added by Mayaka == -->
            <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" >
                <div class="modal-dialog">
                    <div class="modal-content animated fadeInDown">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">New application</h4>
                        </div>
                        <div class="modal-body" >
                            <form class="form-horizontal" role="form">
                                <div class="form-group" :class="states.leave_code">
                                    <label class="col-sm-4 control-label">Leave type</label>
                                    <div class="col-sm-8">
                                        <select class="form-control col-sm-2" name="leave_code" id="leave_code" v-model="formData.leave_code">
                                            <option v-for="leave in leaveTypes" v-bind:value="leave.Code">{{leave.Description}}</option>
                                        </select>
                                        <span id="helpBlockLeaveCode" class="help-block">{{error.leave_code}}</span>
                                    </div>
                                </div>
                                <div class="form-group" :class="states.start_date">
                                    <label class="col-sm-4 control-label" >Start Date</label>
                                    <div class="col-sm-8">
                                        <datepicker format="yyyy-MM-dd" v-model="formData.start_date" name="start_date" id="start_date"  input-class="form-control"></datepicker>
                                        <span id="helpBlockdate" class="help-block">{{error.start_date}}</span>
                                    </div>
                                </div>
                                <div class="form-group" :class="states.no_of_days">
                                    <label  class="col-sm-4 control-label">Number of days</label>
                                    <div class="col-sm-8">
                                         <input type="number" placeholder="Number of days" v-model="formData.no_of_days" class="form-control" name="no_of_days" id="no_of_days">
                                        <span id="helpBlocNoOfDays" class="help-block">{{error.no_of_days}}</span>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <label  class="col-sm-4 control-label">&nbsp;</label>
                                    <div class="col-sm-8">
                                        <button v-if="spinner" class="ladda-button btn btn-block" data-style="expand-right" @click="calculate" v-bind:class="[btnType]"> <strong>{{ calculateButtonText}} <i :class="[btnIcon ]"></i> </strong></button>
                                        <div v-else class="sk-spinner sk-spinner-wave">
                                            <div class="sk-rect1"></div>
                                            <div class="sk-rect2"></div>
                                            <div class="sk-rect3"></div>
                                            <div class="sk-rect4"></div>
                                            <div class="sk-rect5"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" >End Date</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-calendar"></i></span>
                                            <input type="text" disabled class="form-control" name="end_date" v-model="formData.end_date" id="end_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Return Date</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-calendar"></i></span>
                                            <input type="text" disabled class="form-control"   name="return_date" v-model="formData.return_date" id="return_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" >Comments</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" rows="2" id="comment" name="comment" v-model="formData.comment"></textarea>
                                    </div>
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
</template>

<script>
    import Datepicker from 'vuejs-datepicker'

    export default {
        name: "open-applications",
        components: {
            Datepicker
        },
        props : [
            'currentUser',
            'currentUserData',
            'swapComponent',
            'currentEmployeeLeaveAllocations',
            'APIENDPOINTS',
            'getApiPath',
            'isEmptyObject',
            'validateField'
        ],
        data : function(){
            return {
                calculateButtonText : 'Calculate',
                spinner : true,
                formData: {
                    leave_code : '',
                    start_date : '',
                    no_of_days : '',
                    end_date : '',
                    return_date : '',
                    comment : '',
                },
                states : {
                    leave_code : '',
                    start_date : '',
                    no_of_days : '',
                    end_date : '',
                    return_date : '',
                    comment : '',
                },
                error : {
                    leave_code : '',
                    start_date : '',
                    no_of_days : '',
                    end_date : '',
                    return_date : '',
                    comment : '',
                },
                leaveTypes      : {},
                applications    : {},
                loading         : true,
                shortcuts: [
                    {
                        text: 'Today',
                        start: new Date(),
                        end: new Date()
                    }
                ],
                btnType : 'btn-primary',
                btnIcon :  'fa fa-calculator',
                timer   : ''
            }
        },
        methods : {
            getLeaveApplications : function(){
                var v = this
                axios.get(v.getApiPath(v.APIENDPOINTS.CURRENT_EMPLOYEE_LEAVE_APPLICATIONS, v.currentUserData.id))
                    .then(function (response) {
                        v.applications = response.data.data
                        console.log('leave applications')
                        console.log(v.applications)
                        v.loading = false
                    })
                    .catch(function (errro) {
                        console.log(errro)
                    })
            },

            formartDate : function (date) {
                return date.toISOString().slice(0,10)
            },
            calculate : function (e) {
                e.preventDefault();

                this.states.leave_code = ''
                this.error.leave_code = ''
                this.states.start_date = ''
                this.error.start_date = ''
                this.states.no_of_days = ''
                this.error.no_of_days = ''

                if (this.formData.leave_code.length === 0 || this.formData.start_date.length === 0 || this.formData.no_of_days.length === 0){

                    if(this.formData.leave_code.length === 0){
                        this.states.leave_code = 'has-warning'
                        this.error.leave_code = 'Leave Code is required'
                    }
                    if(this.formData.start_date.length === 0){
                        this.states.start_date = 'has-warning'
                        this.error.start_date = 'start date is required'
                    }
                    if(this.formData.no_of_days.length === 0){
                        this.states.no_of_days = 'has-warning'
                        this.error.no_of_days = 'Number of days is required'
                    }

                }else {

                    // Formats date from yyyy-MM-ddThh-mm-ssZ to yyyy-MM-dd
                    this.formData.start_date = this.formartDate(this.formData.start_date)
                    this.getCalculatedDates()
                }

            },

            getCalculatedDates : function () {
                this.spinner = false
                var v = this
               // v.formData.start_date = new Date(v.formData.start_date )
                axios.post(
                    this.APIENDPOINTS.CALCULATE,
                    this.formData,
                    {headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }})
                    .then(function (response) {
                        v.formData.end_date = response.data.eDate
                        v.formData.return_date = response.data.rDate
                        v.spinner = true
                    })
                    .catch(function (error) {
                        v.spinner = true
                        v.btnType = 'btn-warning'
                        v.calculateButtonText = 'connection problem please try again '
                        v.btnIcon = 'fa fa-warning'
                        console.log(error)

                    })
            },
            submitLeaveApplication : function (e) {
                e.preventDefault();
                var v = this
                axios.post(
                    this.APIENDPOINTS.LEAVEAPPLICATION,
                    this.formData,
                    {headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }}
                )
                    .then(function (response) {
                        v.getLeaveApplications()
                        v.loading = true
                        $('#myModal').modal('hide')

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
            this.getLeaveApplications()
            this.getLeaveTypes()


            //check for applications after every five minutes
            this.timer = setInterval(this.getLeaveApplications, 300000)

        },
        watch : {

        },
        mounted(){

        },
    }

</script>

<style scoped>

</style>