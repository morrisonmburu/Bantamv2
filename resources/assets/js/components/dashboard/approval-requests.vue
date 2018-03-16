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
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Approver</th>
                                    <th>Date Sent</th>
                                    <th>Document No</th>
                                    <th>Document Owner</th>
                                    <th>Document Type</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(request, index) in requests">
                                    <td>{{index + 1}}</td>
                                    <td>{{request.Approval_Details}}</td>
                                    <td>{{request.Date_Time_Sent_for_Approval}}</td>
                                    <td>{{request.Document_No}}</td>
                                    <td>{{request.Document_Owner}}</td>
                                    <td>{{request.Document_Type}}</td>
                                    <td>{{request.Status}}</td>
                                    <td>{{request.Due_Date}}</td>
                                    <td>
                                        <button class="btn btn-success" data-toggle="modal" data-target="#approveRequest" @click="runModal(request)">Process <i class="fa fa-external-link-square" ></i></button>
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
            <div class="modal-dialog modal-lg">
                <div class="modal-content animated fadeInDown">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h5 class="modal-title">Approval processing</h5>
                    </div>
                    <div class="modal-body">

                        <div class="ibox-content inspinia-timeline">
                            <div class="row">
                                <div class="col-xs-12 content no-top-border">
                                    <div class="col-xs-6">
                                        <h3 class="m-b-xs"><strong>Employee Details</strong></h3>
                                        <p><strong>Name:</strong> {{modalData.applicant.EmployeeName}}</p>
                                        <p><strong>Title:</strong> {{modalData.applicant.title}}</p>
                                        <p><strong>Department:</strong> {{modalData.applicant.department}}</p>
                                    </div>

                                    <div class="col-xs-6">
                                        <h3 class="m-b-xs"><strong>Leave Details</strong></h3>
                                        <p><strong>Type:</strong> {{modalData.leave.type}}</p>
                                        <p><strong>Start Date:</strong> {{modalData.leave.start_date}}</p>
                                        <p><strong>Days:</strong>{{modalData.leave.days}}</p>
                                        <p><strong>End Date:</strong>{{modalData.leave.end_date}}</p>
                                        <p><strong>Return Date:</strong> {{modalData.leave.return_date}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 content">
                                    <p class=""><strong>Processing</strong></p>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group"><label>Start Date</label>
                                                <div class="input-group date" data-provide="datepicker">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input readonly type="text" class="form-control" v-model="modalData.application.start_date">
                                                </div>
                                            </div>
                                            <div class="form-group"><label>Number of days</label>
                                                <input type="number" placeholder="Number of days" readonly class="form-control" v-model="modalData.application.no_of_days">
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group"><label>End Date</label>
                                                <div class="input-group date" data-provide="datepicker">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input readonly type="text" class="form-control" v-model="modalData.application.end_date">
                                                </div>
                                            </div>
                                            <div class="form-group"><label>Return Date</label>
                                                <div class="input-group date" data-provide="datepicker">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input v-model="modalData.application.return_date" type="text" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="form-group"><label>Comments</label>
                                                <textarea diabled class="form-control" rows="2" id="comment" ></textarea>
                                            </div>
                                        </div>
                                    </div>
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
                        <button type="button" class="btn  btn-warning">Escalate</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of New leave application approval modal -->
    </div>
</template>

<script>

    export default {
        name: "approval-requests",
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
        data : function () {
            return{
                formData : {
                    status : ''
                },
                requests : {},
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
                        start_date : '',
                        no_of_days : '',
                        end_date : '',
                        return_date : '',
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
                        department : ''
                    }
                },

            }
        },
        methods : {
            runModal : function (data) {
                // this.modalData = data
                this.modalData.id = data.id
                this.modalData.application.start_date  = data.Application_Details.Start_Date
                this.modalData.application.no_of_days  = data.Application_Details.Days_Applied
                this.modalData.application.end_date  = data.Application_Details.End_Date
                this.modalData.application.return_date  = data.Application_Details.Return_Date

                this.modalData.leave.type  = data.Application_Details.Leave_Code
                this.modalData.leave.start_date  = data.Application_Details.Start_Date
                this.modalData.leave.days  = data.Application_Details.Days_Applied
                this.modalData.leave.end_date  = data.Application_Details.End_Date
                this.modalData.leave.return_date = data.Application_Details.Return_Date

                this.modalData.applicant.EmployeeName = data.Employee_Details.First_Name + ' ' + data.Employee_Details.Middle_Name + ' ' +data.Employee_Details.Last_Name + ' '
                this.modalData.applicant.title  = data.Employee_Details.Title
                this.modalData.applicant.department = data.Employee_Details.Department
                // $('#approveRequest').modal('show')
            },
            approveEntry : function (id) {
                var v = this
                v.approveButton.loading = false
                v.formData.status = 'Approved'
                axios.post(
                    v.getApiPath(v.APIENDPOINTS.APPROVEENTRY, id),
                    v.formData,
                    {headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }}
                )
                    .then(function (response) {
                        v.getOpenRequests()
                        v.approveButton.loading = true
                        $('#approveRequest').modal('hide')

                    })
                    .catch(function (error) {
                        v.approveButton.loading = true
                        $('#approveRequest').modal('hide')
                        console.log(error)
                    })
            },
            rejectEntry : function (id) {
                var v = this
                v.rejectButton.loading = false
                v.formData.status = 'Rejected'
                axios.post(
                    v.getApiPath(v.APIENDPOINTS.REJECTENTRY, id),
                    v.formData,
                    {headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }}
                )
                    .then(function (response) {
                        v.getOpenRequests()
                        v.rejectButton.loading = true
                        $('#approveRequest').modal('hide')
                    })
                    .catch(function (error) {
                        v.rejectButton.loading = true
                        $('#approveRequest').modal('hide')
                        console.log(error)
                    })
            },
            getOpenRequests : function() {
                let v = this

                axios.get(v.getApiPath(v.APIENDPOINTS.OPENAPPROVALREQUESTS, ''))
                    .then(function (response) {
                        v.requests = response.data.data
                        v.paginateLinks = response.data.links

                        if(v.paginateLinks.prev === null && v.paginateLinks.next === null){
                           v.showPagination = true
                        }else {
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
            paginate : function (link) {
                var v = this
                v.loading = true
                if(link !== null){
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
            }
        },
        created () {
            this.getOpenRequests()
        }

    }
</script>

<style scoped>

</style>