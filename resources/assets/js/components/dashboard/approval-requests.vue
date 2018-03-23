<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Approval Requests</h5>
                        <div class="ibox-tools">
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
                        <div v-if="loading" class="spiner-example">
                            <div class="sk-spinner sk-spinner-wave">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                            </div>
                        </div>
                    <div v-else>
                        <div class="row" >
                            <div class="col-sm-5 m-b-xs"><select class="input-sm form-control input-s-sm inline">
                                <option value="0">All</option>
                                <option value="1">Date</option>
                                <option value="2">Department</option>
                                <option value="3">Employee</option>
                            </select>
                            </div>
                            <div class="col-sm-4 m-b-xs">
                                <div data-toggle="buttons" class="btn-group">
                                    <label class="btn btn-sm btn-white"> <input type="radio" id="option1" name="options"> Today </label>
                                    <label class="btn btn-sm btn-white active"> <input type="radio" id="option2" name="options"> This Week </label>
                                    <label class="btn btn-sm btn-white"> <input type="radio" id="option3" name="options"> This Month </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group"><input type="text" placeholder="Search" class="input-sm form-control"> <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary"> Go!</button> </span></div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Applicant</th>
                                    <th>Date Sent</th>
                                    <!--<th>Document No</th>-->
                                    <th>Document Owner</th>
                                    <th>Document Type</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(request, index) in requests" :class="request.id === selected ? 'active' : ''">
                                    <td>{{index + 1}} {{request.id === selected ? runModal(request): ''}}</td>
                                    <td>{{fullNames(request.Employee_Details.First_Name, request.Employee_Details.Middle_Name, request.Employee_Details.Last_Name)}}</td>
                                    <td>{{request.Date_Time_Sent_for_Approval}}</td>
                                    <!--<td>{{request.Document_No}}</td>-->
                                    <td>{{request.Document_Owner}}</td>
                                    <td>{{request.Document_Type}}</td>
                                    <td>{{request.Status}}</td>
                                    <td>{{request.Due_Date}}</td>
                                    <td> <!--data-toggle="modal" data-target="#approveRequest"-->
                                        <button class="btn btn-success"  @click="runModal(request)">Process <i class="fa fa-external-link-square" ></i></button>
                                    </td>
                                </tr>
                                <tr v-if="requests.length === 0">
                                    <td  class="text-center text-muted" colspan="9"><i>No Approval Requests</i></td>
                                </tr>

                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="row text-right" >
                        <ul class="pagination" v-show="showPagination">
                            <li class="paginate_button previous "  :class="paginateButtons.firts">
                                <a @click="paginate(paginateLinks.first)" tabindex="0"><< First</a>
                            </li>
                            <li class="paginate_button" :class="paginateButtons.previous">
                                <a @click="paginate(paginateLinks.prev)" tabindex="0">< Previous</a>
                            </li>
                            <li class="paginate_button " :class="paginateButtons.next">
                                <a  @click="paginate(paginateLinks.next)" tabindex="0">Next ></a>
                            </li>
                            <li  class="paginate_button next" :class="paginateButtons.last">
                                <a @click="paginate(paginateLinks.last)" tabindex="0">Last >></a>
                            </li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!--approval modal here -->
        <!-- ==== Modal for leave application approval:: Added by Mayaka == -->
        <div class="modal inmodal" id="approveRequest" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content animated fadeInDown">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h5 class="modal-title">Approval processing</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-hover table-condensed">
                                    <thead>
                                    <th><h3>Employee Details</h3></th>
                                    <th></th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td>{{modalData.applicant.EmployeeName}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Title:</strong></td>
                                            <td>{{modalData.applicant.EmployeeName}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Department:</strong></td>
                                            <td>{{modalData.applicant.department}}</td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-hover">
                                    <thead>
                                    <th><h3>Leave Details</h3></th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><strong>Type:</strong></td>
                                        <td>{{modalData.leave.type}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Start Date:</strong></td>
                                        <td>{{modalData.leave.start_date}} </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Days:</strong></td>
                                        <td>{{modalData.leave.days}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>End Date:</strong></td>
                                        <td>{{modalData.leave.end_date}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Return Date:</strong></td>
                                        <td>{{modalData.leave.return_date}}</td>
                                    </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right ">
                               <a href="#" class="m-xs btn btn-white btn-xs"  @click="resetApplication" v-bind:class="reset.status"> <strong>{{ reset.text }} <i :class="reset.icon"></i> </strong></a>
                            </div>

                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group" :class="states.start_date">
                                    <label>Start Date</label>
                                    <datepicker confirm placeholder="Select start date " format="yyyy-MM-dd"  v-model="modalData.application.start_date" lang="en"  name="start_date" id="start_date"  input-class="form-control"></datepicker>
                                    <span id="helpBlockdate" class="help-block">{{error.start_date}}</span>
                                </div>
                            </div>

                            <div class="col-xs-6">
                                <div class="form-group" :class="states.end_date">
                                    <label>End Date</label>
                                    <datepicker confirm placeholder="Select start date " format="yyyy-MM-dd"  v-model="modalData.application.end_date" lang="en"  name="start_date" id="start_date"  input-class="form-control"></datepicker>
                                    <span id="helpBlockdate2" class="help-block">{{error.end_date}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>Number of days</label>
                                    <input type="number" placeholder="Number of days" readonly class="form-control" v-model="modalData.application.no_of_days">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>Return Date</label>
                                    <datepicker confirm disabled placeholder="Select start date " format="yyyy-MM-dd"  v-model="modalData.application.return_date" lang="en"  name="retun_date" id="retun_date"  input-class="form-control"></datepicker>
                                    <span id="helpBlockdate3" class="help-block">{{error.return_date}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right ">
                                <a href="#" v-if="calculateButton.loading" class="btn btn-primary" > <span class="loading bullet"></span></a>
                                <a href="#" v-else class="btn btn-primary "  @click="calculate(modalData.applicant.id)" v-bind:class="calculateButton.status"> <strong>{{ calculateButton.text }} <i :class="calculateButton.icon"></i> </strong></a>
                            </div>
                            <div class="form-group" v-show="calculateError.length !== 0">
                                <div class="alert alert-danger text-centre col-sm-12">
                                    {{calculateError}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group"><label>Comments</label>
                                    <textarea diabled class="form-control" rows="2" id="comment" v-model="modalData.application.comment"></textarea>
                                </div>
                            </div>
                            <div class="form-group" v-show="approvalError.length !== 0">
                                <div class="alert alert-danger text-centre col-sm-12">
                                    {{approvalError}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-white" data-dismiss="modal">Close</button>
                        <button v-if="approveButton.loading" type="button" class="btn  btn-success" @click="approveEntry(modalData.id)">Approve</button>
                        <button v-else type="button" class="btn  btn-success"><span class="loading bullet"></span></button>
                        <button v-if="rejectButton.loading" type="button" class="btn  btn-danger" @click="rejectEntry(modalData.id)" >Reject</button>
                        <button v-else type="button" class="btn  btn-danger"  ><span class="loading bullet"></span></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of New leave application approval modal -->
    </div>
</template>

<script>

    import Datepicker from 'vue2-datepicker';

    export default {
        name: "approval-requests",
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
            'validateField',
            'notificationsData',
            'notificationEvents',
            'fullNames'
        ],
        data : function () {
            return{
                requests : {},
                backup : {},
                paginateLinks : {},
                loading : true,
                approveButton : {
                    loading : true
                },
                rejectButton : {
                    loading : true
                },
                showPagination : false,
                paginateButtons : {
                    previous : '',
                    firts : '',
                    next : '',
                    last : '',
                },
                modalData : {
                    id : '',
                    application : {
                        leave_code : '',
                        start_date : '',
                        no_of_days : '',
                        end_date : '',
                        return_date : '',
                        comment : ''
                     },
                    leave : {
                         type : '',
                         start_date : '',
                         days : '',
                         end_date : '',
                         return_date : '',
                     },
                    applicant : {
                        EmployeeName : '',
                        title : '',
                        department : '',
                        id : ''
                    }
                },
                selected : '',
                calculateError : '',
                approvalError : '',
                calculateButton   : {
                    text    : 'Calculate',
                    icon    : 'fa fa-calculator',
                    status  : 'btn-primary',
                    loading : false,
                    errorMessage : ''
                },
                reset   : {
                    text    : 'Reset',
                    icon    : 'fa fa-refresh',
                    status  : '',
                    loading : false,
                    errorMessage : ''
                },
                states : {
                    leave_code : '',
                    start_date : '',
                    no_of_days : '',
                    end_date : '',
                    return_date : '',
                    comment : '',
                    handOverTo : ''
                },
                error : {
                    leave_code : '',
                    start_date : '',
                    no_of_days : '',
                    end_date : '',
                    return_date : '',
                    comment : '',
                    submitting : '',
                    handOverTo : ''
                },
                shortcuts: [
                    {
                        text: 'Today',
                        start: new Date(),
                        end: new Date()
                    }
                ],
                formSubmit: {
                    Approved_Start_Date : '',
                    Approved_End_Date : '',
                    comment : '',
                    status : ''
                },

            }
        },
        methods : {
            runModal: function (data) {
                // store the data incase you need to reset when calculating
                this.backup = data

                console.log(data)
                this.modalData.id = data.id
                this.modalData.application.start_date = data.Application_Details.Start_Date
                this.modalData.application.no_of_days = data.Application_Details.Days_Applied
                this.modalData.application.end_date = data.Application_Details.End_Date
                this.modalData.application.return_date = data.Application_Details.Return_Date

                this.modalData.leave.type = data.Application_Details.Leave_Code
                this.modalData.leave.start_date = data.Application_Details.Start_Date
                this.modalData.leave.days = data.Application_Details.Days_Applied
                this.modalData.leave.end_date = data.Application_Details.End_Date
                this.modalData.leave.return_date = data.Application_Details.Return_Date

                this.modalData.applicant.EmployeeName = this.fullNames(data.Employee_Details.First_Name, data.Employee_Details.Middle_Name, data.Employee_Details.Last_Name)
                this.modalData.applicant.title = data.Employee_Details.Title
                this.modalData.applicant.department = data.Employee_Details.Department
                this.modalData.applicant.id = data.Employee_Details.id

                $('#approveRequest').modal('show')
            },
            setEntryData : function (status) {
                this.formSubmit.Approved_Start_Date     = this.modalData.application.start_date
                this.formSubmit.Approved_End_Date       = this.modalData.application.end_date
                this.formSubmit.comment                 = this.modalData.application.comment
                this.formSubmit.status                  = status
            },
            approveEntry: function (id) {
                this.clearFieldsErrors()
                var v = this
                v.setEntryData('Approved')
                v.approveButton.loading = false
                axios.post(
                    v.getApiPath(v.APIENDPOINTS.APPROVEENTRY, id),
                    v.formSubmit,
                    {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    }
                )
                    .then(function (response) {
                        v.selected = ''
                        v.getOpenRequests()
                        v.approveButton.loading = true
                        $('#approveRequest').modal('hide')

                    })
                    .catch(function (error) {
                        v.getOpenRequests()
                        v.approveButton.loading = true
                        v.approvalError = error.response.data.message

                    })
            },
            rejectEntry: function (id) {
                this.clearFieldsErrors()
                var v = this
                v.setEntryData('Rejected')
                v.rejectButton.loading = false
                axios.post(
                    v.getApiPath(v.APIENDPOINTS.REJECTENTRY, id),
                    v.formSubmit,
                    {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    }
                )
                    .then(function (response) {
                        v.selected = ''
                        v.getOpenRequests()
                        v.rejectButton.loading = true
                        $('#approveRequest').modal('hide')
                    })
                    .catch(function (error) {
                        v.getOpenRequests()
                        v.rejectButton.loading = true
                        v.approvalError = error.response.data.message
                    })
            },
            getOpenRequests: function () {
                let v = this

                axios.get(v.getApiPath(v.APIENDPOINTS.OPENAPPROVALREQUESTS, ''))
                    .then(function (response) {
                        v.requests = response.data.data
                        v.paginateLinks = response.data.links

                        if (v.paginateLinks.prev === null && v.paginateLinks.next === null) {
                            v.showPagination = false
                        } else {
                            v.showPagination = true
                        }

                        console.log('approval requests')
                        console.log(response.data.data)
                        v.loading = false
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
            },
            paginate: function (link) {
                var v = this
                v.loading = true
                if (link !== null) {
                    axios.get(link)
                        .then(function (response) {
                            v.requests = response.data.data
                            v.loading = false
                        })
                        .catch(function (error) {
                            v.loading = false
                            console.log(error)
                        })
                }
            },
            resetApplication : function () {
                this.modalData.application.start_date           = this.backup.Application_Details.Start_Date
                this.modalData.application.no_of_days           = this.backup.Application_Details.Days_Applied
                this.modalData.application.end_date             = this.backup.Application_Details.End_Date
                this.modalData.application.return_date          = this.backup.Application_Details.Return_Date
            },
            calculate : function (id) {

                this.clearFieldsErrors()
                if (this.modalData.application.start_date.length === 0 || this.modalData.application.end_date.length === 0){

                    if(this.modalData.application.start_date.length === 0){
                        this.states.start_date = 'has-warning'
                        this.error.start_date = 'start date is required'
                    }
                    if(this.modalData.application.end_date.length === 0){
                        this.states.end_date = 'has-warning'
                        this.error.end_date = 'end date is required'
                    }
                }else {
                    //calculator requires leave code
                    this.modalData.application.leave_code = this.modalData.leave.type
                    this.getCalculatedDates(id)
                }
            },
            getCalculatedDates : function (id) {
                this.calculateButton.loading = true
                var v = this
                alert(id)
                v.url = v.getApiPath(v.APIENDPOINTS.APPROVERLEAVECALCULATION, id )
                axios.post(
                    v.url,
                    v.modalData.application,
                    {headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }})
                    .then(function (response) {
                        v.modalData.application.no_of_days = response.data.lDays
                        v.modalData.application.return_date = response.data.rDate
                        v.calculateButton.loading  = false
                    })
                    .catch(function (error) {
                        v.calculateButton.loading = false
                        v.calculateButton.status = 'btn btn-warning'
                        v.calculateButton.text = 'please try again '
                        v.calculateButton.icon = 'fa fa-warning'
                        v.calculateButton.errorMessage = error.response.data.message
                    })
            },
            clearFieldsErrors : function () {
                this.calculateError = ''
                this.approvalError = ''
                this.error.submitting = ''
                this.error.return_date = ''
                this.states.return_date = ''
                this.error.end_date = ''
                this.states.leave_code = ''
                this.error.leave_code = ''
                this.states.start_date = ''
                this.error.start_date = ''
                this.states.no_of_days = ''
                this.error.no_of_days = ''
                this.calculateButton.status = 'btn btn-primary'
                this.calculateButton.text = 'Calculate'
                this.calculateButton.icon = 'fa fa-calculator'
                this.calculateButton.errorMessage = ''
                this.states.handOverTo = ''
                this.error.handOverTo = ''
            },
        },
        created () {
            this.getOpenRequests()
        },
        mounted(){
            if (this.notificationsData.component === 'approval-request'){
               this.selected = this.notificationsData.data
            }
        },
        watch : {
            'modalData.application.start_date' : function (newVal, oldVal) {
                if(newVal.length !== 0 && newVal.length !== 10){
                    this.modalData.application.start_date = this.modalData.application.start_date.toISOString().slice(0,10)
                }
            },
            'modalData.application.end_date' : function (newVal, oldVal) {
                if(newVal.length !== 0 && newVal.length !== 10){
                    this.modalData.application.end_date = this.modalData.application.end_date.toISOString().slice(0,10)
                }
            }
        }
    }
</script>

<style scoped>

</style>