<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Open Applications</h5>
                        <div class="ibox-tools">
                            <button v-show="!loading" type="button"  class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal">
                                Make Application <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="ibox-content">
                        <!--<div class="row" >-->
                            <!--<div class="col-sm-4 col-sm-push-8">-->
                                <!--<div class="input-group"><input type="text" placeholder="Applicant Name" v-model="searchTerm" class="input-sm form-control">-->
                                    <!--<span class="input-group-btn">-->
                                        <!--<button type="button" class="btn btn-sm btn-primary"> <i class="fa fa-search"></i></button>-->
                                    <!--</span>-->
                                <!--</div>-->
                            <!--</div>-->
                        <!--</div>-->
                        <div v-if="loading" class="spiner-example">
                            <div class="sk-spinner sk-spinner-wave">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                            </div>
                        </div>
                        <div v-else  class="table-responsive">
                            <table class="table table-hover animated fadeIn">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <!--<th>Application Code</th>-->
                                    <th>Application Date</th>
                                    <th>Days Applied</th>
                                    <th>Leave Code</th>
                                    <th>Leave Period</th>
                                    <th>Start Date</th>
                                    <th>Return Date</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(application, index) in applications" @dblclick="applicationDetails(application.id)" class="hovertable"  style="cursor: pointer" :class="application.id === selected ? 'success' : ''">
                                    <td data-toggle="tooltip" data-placement="top" title="double click to view details">{{ meta.from + index}} </td>
                                    <!--<td>{{application.Application_Code}}</td>-->
                                    <td data-toggle="tooltip" data-placement="top" title="double click to view details">{{application.Application_Date}}</td>
                                    <td data-toggle="tooltip" data-placement="top" title="double click to view details">{{application.Days_Applied}}</td>
                                    <td data-toggle="tooltip" data-placement="top" title="double click to view details">{{application.Leave_Code}}</td>
                                    <td data-toggle="tooltip" data-placement="top" title="double click to view details">{{application.Leave_Period}}</td>
                                    <td data-toggle="tooltip" data-placement="top" title="double click to view details">{{application.Start_Date}}</td>
                                    <td data-toggle="tooltip" data-placement="top" title="double click to view details">{{application.Return_Date}}</td>
                                    <td><span class="label  " :class="application.Status === 'New' ? New : application.Status === 'Review' ? Review : Canceled" >{{application.Status}}</span></td>
                                    <td>
                                        <!--<button class="btn btn-sm btn-success" @click="submitApplication(application,'Review')" >Submit <i class="fa fa-send"></i> </button>-->
                                        <button v-if="application.Status === 'Review'" class="btn btn-xs btn-danger cancelButton" @click="deleteApplication(application)" >Cancel &nbsp <i class="fa fa-close"></i> </button>
                                        <button v-else disabled class="btn btn-xs btn-default cancelButton">Cancel <span v-if="sending" class="loading bullet"></span> <i v-else class="fa fa-close"></i> </button>
                                    </td>
                                </tr>
                                <tr v-if="isEmptyObject(applications)">
                                    <td colspan="8" class="text-center"><i class="text-muted">no applications found</i></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>

                        <div class="row text-right" >

                            <div class="btn-group" role="group" aria-label="...">
                                <!--<button type="button" class="btn btn-default" @click="paginate(paginateLinks.first)" tabindex="0" :disabled="paginateLinks.first  === null"><< First</button>-->
                                <!--<button type="button" class="btn btn-default" @click="paginate(paginateLinks.prev)" tabindex="0" :disabled="paginateLinks.prev === null">< Previous</button>-->

                                <button v-for="n in meta.last_page" type="button" class="btn btn-default" @click="paginate(meta.path + '?page=' + n)" tabindex="0">{{n}}</button>


                                <!--<button type="button" class="btn btn-default" @click="paginate(paginateLinks.next)" tabindex="0" :disabled="paginateLinks.next === null">Next ></button>-->
                                <!--<button type="button" class="btn btn-default" @click="paginate(paginateLinks.last)" tabindex="0" :disabled="paginateLinks.last === null">Last >></button>-->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
<div>
    <!--<div class="row">-->
    <!--<div class="col-lg-12">-->
    <!--<div class="ibox ">-->
    <!--<div class="ibox-title">-->
    <!--<h5>Recent Activities</h5>-->
    <!--</div>-->
    <!--<div class="ibox-content">-->
    <!--<div class="activity-stream">-->
    <!--<div class="stream">-->
    <!--<div class="stream-badge">-->
    <!--<i class="fa fa-pencil"></i>-->
    <!--</div>-->
    <!--<div class="stream-panel">-->
    <!--<div class="stream-info">-->
    <!--<a href="#">-->
    <!--<img src="img/a5.jpg">-->
    <!--<span>Karen Miggel</span>-->
    <!--<span class="date">Today at 01:32:40 am</span>-->
    <!--</a>-->
    <!--</div>-->
    <!--Add new note to the <a href="#">Martex</a>  project.-->
    <!--</div>-->
    <!--</div>-->
    <!--<div class="stream">-->
    <!--<div class="stream-badge">-->
    <!--<i class="fa fa-commenting-o"></i>-->
    <!--</div>-->
    <!--<div class="stream-panel">-->
    <!--<div class="stream-info">-->
    <!--<a href="#">-->
    <!--<img src="img/a4.jpg">-->
    <!--<span>John Mikkens</span>-->
    <!--<span class="date">Yesterday at 10:00:20 am</span>-->
    <!--</a>-->
    <!--</div>-->
    <!--Commented on <a href="#">Ariana</a> profile.-->
    <!--</div>-->
    <!--</div>-->
    <!--<div class="stream">-->
    <!--<div class="stream-badge">-->
    <!--<i class="fa fa-circle"></i>-->
    <!--</div>-->
    <!--<div class="stream-panel">-->
    <!--<div class="stream-info">-->
    <!--<a href="#">-->
    <!--<img src="img/a2.jpg">-->
    <!--<img src="img/a3.jpg">-->
    <!--<img src="img/a4.jpg">-->
    <!--<span>Mike Johnson, Monica Smith and Karen Dortmund</span>-->
    <!--<span class="date">Yesterday at 02:13:20 am</span>-->
    <!--</a>-->
    <!--</div>-->
    <!--Changed status of third stage in the <a href="#">Vertex</a> project.-->
    <!--</div>-->
    <!--</div>-->
    <!--<div class="stream">-->
    <!--<div class="stream-badge">-->
    <!--<i class="fa fa-circle"></i>-->
    <!--</div>-->
    <!--<div class="stream-panel">-->
    <!--<div class="stream-info">-->
    <!--<a href="#">-->
    <!--<img src="img/a6.jpg">-->
    <!--<span>Jessica Smith</span>-->
    <!--<span class="date">Yesterday at 08:14:41 am</span>-->
    <!--</a>-->
    <!--</div>-->
    <!--Add new files to own file sharing place.-->
    <!--</div>-->
    <!--</div>-->
    <!--<div class="stream">-->
    <!--<div class="stream-badge">-->
    <!--<i class="fa fa-send bg-primary"></i>-->
    <!--</div>-->
    <!--<div class="stream-panel">-->
    <!--<div class="stream-info">-->
    <!--<a href="#">-->
    <!--<img src="img/a7.jpg">-->
    <!--<img src="img/a1.jpg">-->
    <!--<span>Martha Farter and Mike Rodgers</span>-->
    <!--<span class="date">Yesterday at 04:18:13 am</span>-->
    <!--</a>-->
    <!--</div>-->
    <!--Sent email to all users participating in new project.-->
    <!--</div>-->
    <!--</div>-->
    <!--<div class="stream">-->
    <!--<div class="stream-badge">-->
    <!--<i class="fa fa-tag bg-warning"></i>-->
    <!--</div>-->
    <!--<div class="stream-panel">-->
    <!--<div class="stream-info">-->
    <!--<a href="#">-->
    <!--<img src="img/a7.jpg">-->
    <!--<span>Mark Mickens</span>-->
    <!--<span class="date">Yesterday at 06:00:30 am</span>-->
    <!--</a>-->
    <!--</div>-->
    <!--Has been taged in the latest comments about the new project.-->
    <!--</div>-->
    <!--</div>-->
    <!--<div class="stream">-->
    <!--<div class="stream-badge">-->
    <!--<i class="fa fa-circle"></i>-->
    <!--</div>-->
    <!--<div class="stream-panel">-->
    <!--<div class="stream-info">-->
    <!--<a href="#">-->
    <!--<img src="img/a8.jpg">-->
    <!--<span>Mike Johnson</span>-->
    <!--<span class="date">Yesterday at 02:13:20 am</span>-->
    <!--</a>-->
    <!--</div>-->
    <!--Changed status of second stage in the latest project.-->
    <!--</div>-->
    <!--</div>-->
    <!--<div class="stream">-->
    <!--<div class="stream-badge">-->
    <!--<i class="fa fa-circle"></i>-->
    <!--</div>-->
    <!--<div class="stream-panel">-->
    <!--<div class="stream-info">-->
    <!--<a href="#">-->
    <!--<img src="img/a1.jpg">-->
    <!--<span>Jessica Smith</span>-->
    <!--<span class="date">Yesterday at 08:14:41 am</span>-->
    <!--</a>-->
    <!--</div>-->
    <!--Add new files to own file sharing place.-->
    <!--</div>-->
    <!--</div>-->
    <!--<div class="stream">-->
    <!--<div class="stream-badge">-->
    <!--<i class="fa fa-circle"></i>-->
    <!--</div>-->
    <!--<div class="stream-panel">-->
    <!--<div class="stream-info">-->
    <!--<a href="#">-->
    <!--<img src="img/a6.jpg">-->
    <!--<span>Jessica Smith</span>-->
    <!--<span class="date">Yesterday at 08:14:41 am</span>-->
    <!--</a>-->
    <!--</div>-->
    <!--Add new files to own file sharing place.-->
    <!--</div>-->
    <!--</div>-->
    <!--<div class="stream">-->
    <!--<div class="stream-badge">-->
    <!--<i class="fa fa-send"></i>-->
    <!--</div>-->
    <!--<div class="stream-panel">-->
    <!--<div class="stream-info">-->
    <!--<a href="#">-->
    <!--<img src="img/a7.jpg">-->
    <!--<span>Martha Farter</span>-->
    <!--<span class="date">Yesterday at 04:18:13 am</span>-->
    <!--</a>-->
    <!--</div>-->
    <!--Sent email to all users participating in new project.-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>-->
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
                                        <select  class="form-control col-sm-2" name="leave_code" id="leave_code2" v-model="leave_code">
                                            <option value="" disabled selected >Leave type</option>
                                            <option v-for="leave in leaveTypes" v-bind:value="leave.Code">{{leave.Description}}</option>
                                        </select>
                                        <span id="helpBlockLeaveCode" class="help-block">{{error.leave_code}}</span>
                                    </div>
                                </div>
                                <div class="form-group" :class="states.start_date">
                                    <label class="col-sm-4 control-label" >Start Date - End Date</label>
                                    <div class="col-sm-8">
                                        <datepicker confirm placeholder="Select start date and end date" :disabled-days="dateArray" format="yyyy-MM-dd"  v-model="dateRange" lang="en" range name="start_date" id="start_date"  input-class="form-control"></datepicker>
                                        <span id="helpBlockdate" class="help-block">{{error.start_date}}</span>
                                    </div>
                                </div>
                                <!--<div class="form-group" :class="states.end_date">-->
                                    <!--<label class="col-sm-4 control-label" >End Date</label>-->
                                    <!--<div class="col-sm-8">-->
                                        <!--<-->
                                        <!--<input type="text"  class="form-control" name="end_date" v-model="formData.end_date" id="end_date">-->
                                        <!--<span class="help-block">{{error.end_date}}</span>-->
                                    <!--</div>-->
                                <!--</div>-->
                                <div class="form-group text-center" v-if="!calculateButton.loading">
                                    <label  class="col-sm-4 control-label">&nbsp;</label>
                                    <div class="col-sm-8">
                                        <!--<button  class="btn btn-block" data-style="expand-right" @click="calculate" v-bind:class="calculateButton.status"> <strong>{{ calculateButton.text }} <i :class="calculateButton.icon"></i> </strong></button>-->
                                        <div  class="sk-spinner sk-spinner-wave">
                                            <div class="sk-rect1"></div>
                                            <div class="sk-rect2"></div>
                                            <div class="sk-rect3"></div>
                                            <div class="sk-rect4"></div>
                                            <div class="sk-rect5"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" v-show="calculateButton.errorMessage.length !== 0">
                                    <label class="col-sm-4 control-label"></label>
                                    <div class="col-sm-8">
                                        <div class="alert alert-danger text-centre col-sm-12">
                                            {{calculateButton.errorMessage}}
                                        </div>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group" :class="states.no_of_days">
                                    <label  class="col-sm-4 control-label">Number of days</label>
                                    <div class="col-sm-8">
                                        <input type="number"  disabled placeholder="Number of days" v-model="formData.no_of_days" class="form-control" name="no_of_days" id="no_of_days">
                                        <span id="helpBlocNoOfDays" class="help-block">{{error.no_of_days}}</span>
                                    </div>
                                </div>
                                <div class="form-group" :class="states.return_date">
                                    <label class="col-sm-4 control-label">Return Date</label>
                                    <div class="col-sm-8">
                                        <datepicker  disabled confirm format="yyyy-MM-dd"  v-model="formData.return_date" lang="en"  name="return_date" id="return_date"  input-class="form-control"></datepicker>
                                        <!--<div class="input-group">-->
                                            <!--<span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-calendar"></i></span>-->
                                            <!--<input type="text" disabled class="form-control"   name="return_date" v-model="formData.return_date" id="return_date">-->
                                        <!--</div>-->
                                        <span class="help-block">{{error.return_date}}</span>
                                    </div>
                                </div>
                                <div class="form-group" :class="states.handOverTo">
                                    <label class="col-sm-4 control-label">Hand over to</label>
                                    <div class="col-sm-8">
                                        <select class="form-control col-sm-2" name="leave_code" id="handOverTo" v-model="formData.handOverTo">
                                            <option value="" disabled selected >Employee name</option>
                                            <option v-for="(departmentEmployee, index) in departmentEmployees" v-if="departmentEmployee.id !== currentUserData.id" v-bind:value="departmentEmployee.No">{{getFullNames(departmentEmployee)}}</option>
                                        </select>
                                        <span id="helpBlockhandOverTo" class="help-block">{{error.handOverTo}}</span>
                                    </div>
                                </div>
                                <div class="form-group"  :class="states.comment">
                                    <label class="col-sm-4 control-label" >Comments</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" rows="2" id="comment" name="comment" v-model="formData.comment"></textarea>

                                    </div>
                                </div>
                                <div class="form-group" v-show="error.submitting.length !== 0">
                                    <label class="col-sm-4 control-label">&nbsp;</label>
                                    <div class="col-sm-8">
                                        <div  class="alert alert-danger text-centre">
                                            {{error.submitting}}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" @click="closeApplicationModal" >Close</button>
                            <!--<button v-if="saveButton.loading" @click="saveLeaveApplication"  class="btn "  :class="saveButton.status" >-->
                                <!--{{ saveButton.text }} <i :class="saveButton.icon"></i>-->
                            <!--</button>-->
                            <!--<button v-else class="btn "  :class="saveButton.status">-->
                                <!--Sending <span class="loading bullet"></span>-->
                            <!--</button>-->
                            <button type="submit" v-if="submitButton.loading"    @click="submitLeaveApplication"   class="btn "  :class="submitButton.status" >
                                {{ submitButton.text }} <i :class="submitButton.icon"></i>
                            </button>
                            <button v-else class="btn "  :class="submitButton.status" >
                                Sending <span class="loading bullet"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <!-- End of New leave application modal -->

        <!-- view approvers modal -->
        <div class="modal inmodal" id="approveersModal" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog modal-sm">
                <div class="modal-content animated fadeInDown">
                    <!--<div class="modal-header">-->
                        <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
                        <!--<h4 class="modal-title">Approval Details</h4>-->
                    <!--</div>-->
                    <div class="modal-body">

                        <div v-if="loadingDetails" class="sk-spinner sk-spinner-pulse"></div>
                        <table v-else class="table table-hover table-xs animated fadeIn">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Approver</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="appDetail in appDetails">
                                <td>{{appDetail.Sequence_No}}</td>
                                <td>{{appDetail.Approval_Details}}</td>
                                <td >
                                        <i
                                            :class="
                                              appDetail.Status === 'Approved' ? 'fa fa-check'
                                            : appDetail.Status === 'Created'  ? 'fa fa-circle'
                                            : appDetail.Status === 'Rejected' ? 'fa fa-circle'
                                            : appDetail.Status === 'Open'     ? 'fa fa-circle'
                                            : 'Unknown'"

                                            :title="
                                              appDetail.Status === 'Approved' ? 'Approved'
                                            : appDetail.Status === 'Created'  ? 'Pending'
                                            : appDetail.Status === 'Rejected' ? 'Rejected'
                                            : appDetail.Status === 'Open'     ? 'Open'
                                            : 'Unknown'"

                                            :style="
                                              appDetail.Status === 'Approved' ? 'color: #2ecc71'
                                            : appDetail.Status === 'Created'  ? 'color: #bdc3c7'
                                            : appDetail.Status === 'Rejected' ? 'color: #e74c3c'
                                            : appDetail.Status === 'Open'     ? 'color: #3498db'
                                            : 'color: #ecf0f1'">
                                        </i>
                                </td>
                            </tr>
                            <tr v-if="isEmptyObject(appDetails)">
                                <td colspan="8" class="text-center"><i class="text-muted">no processing details</i></td>
                            </tr>

                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // import Datepicker from 'vuejs-datepicker'

    import Datepicker from 'vue2-datepicker';
    import moment from 'moment';



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
            'validateField',
            'fullNames',
            'openModal',
            'notificationsData',
            'notificationEvents'
        ],
        data : function(){
            return {
                searchTerm : '',
                loadingDetails : true,
                showPagination : true,
                leave_code : '',
                calculateButtonText : 'Calculate',
                submittButtonText   : 'Submit Application',
                spinner : true,
                dateRange : [],
                submitAndNew : false,
                paginateLinks : {},
                formData: {
                    leave_code : '',
                    start_date : '',
                    no_of_days : '',
                    end_date : '',
                    return_date : '',
                    comment : '',
                    handOverTo : '',
                    status : ''
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
                disabledDates : {},
                dateArray : [],
                leaveTypes      : {},
                applications    : {},
                loading         : true,
                submitting      : true,
                calculateButton   : {
                    text    : 'Calculate',
                    icon    : 'fa fa-calculator',
                    status  : 'btn-primary',
                    loading : true,
                    errorMessage : ''
                },
                submitButton : {
                    text    : 'Submit',
                    icon    : 'fa fa-send', /*fa fa-send*/
                    status  : 'btn-primary',
                    loading : true,
                    errorMessage : ''
                },
                saveButton : {
                    text    : 'Submit + New',
                    icon    : '', /*fa fa-save*/
                    status  : 'btn-success',
                    loading : true,
                    errorMessage : ''
                },
                timer   : '',
                departmentEmployees : {},
                openAppModal : false,
                paginateButtons : {
                    previous : '',
                    firts : '',
                    next : '',
                    last : '',
                },
                meta: '',
                New : 'label-info',
                Canceled : 'label-danger',
                Review : 'label-success',
                appDetails : { },
                selected : '',
                sending : false,

            }
        },
        methods : {
            setDisabledDates : function () {
                for (var i = 0; i <= this.disabledDates.length; i++)(
                    v.getDateRange(i.start_date, i.end_date)
                )
            },
            addDays : function(days) {
            var dat = new Date(this.valueOf())
            dat.setDate(dat.getDate() + days);
            return dat;
        },
            getDateRange : function (startDate, stopDate) {
                var currentDate = startDate

                while(currentDate <= stopDate){
                    this.dateArray.push(currentDate)
                    currentDate = currentDate.addDays(1)
                }
            },
            getDisabledDays : function () {
                var v = this
                axios.get(v.getApiPath(v.APIENDPOINTS.DISABLEDDAYS,''))
                    .then(function (response) {
                       v.dateArray = response.data
                        console.log('disabled days')
                        console.log(v.dateArray)
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
            },
            paginate : function (link) {

                // alert(link)

                var v = this
                v.loading = true
                if(link !== null){
                    axios.get(link)
                        .then(function (response) {
                            v.applications = response.data.data
                            v.meta = response.data.meta
                            v.loading = false
                        })
                        .catch(function (error) {
                            v.loading = false
                            console.log(error)
                        })
                }
            },
            applicationDetails : function (application) {
                var v = this
                v.loadingDetails = true
                v.appDetails = {}
                $('#approveersModal').modal('toggle')
                axios.get(v.getApiPath(v.APIENDPOINTS.APPLICATIONDETAILS, application))
                    .then(function (response) {
                        v.appDetails = response.data.data
                        v.loadingDetails = false
                        console.log('application Details')
                        console.log(v.appDetails)
                    })
            },
            getFullNames : function (departmentEmployee) {
                return this.fullNames(departmentEmployee.First_Name , departmentEmployee.Middle_Name, departmentEmployee.Last_Name)
            },
            setDates : function () {
                this.formData.start_date   =  this.dateFix(this.dateRange[0])
                this.formData.end_date     =  this.dateFix(this.dateRange[1])

                //old date fix
                // this.formData.start_date   =  (this.dateRange[0]).toISOString().slice(0,10)
                // this.formData.end_date     =  (this.dateRange[1]).toISOString().slice(0,10)

                this.calculate()
            },
            dateFix : function (date){
                let d = new Date(Date.UTC(date.getFullYear(), date.getMonth(), date.getDate(), date.getHours(), date.getMinutes(), date.getSeconds()));
                return moment(d).format("YYYY-MM-DD")
            },
            getLeaveApplications : function(){
                var v = this
                axios.get(v.getApiPath(v.APIENDPOINTS.CURRENT_EMPLOYEE_LEAVE_APPLICATIONS, v.currentUserData.id))
                    .then(function (response) {
                        v.applications = response.data.data
                        v.paginateLinks = response.data.links
                        v.meta = response.data.meta

                        console.log(v.applications)
                        v.loading = false

                        if(v.openAppModal){
                            setTimeout($('#myModal').modal('toggle'), 5000)
                            v.openAppModal = false
                        }

                    })
                    .catch(function (errro) {
                        console.log(errro)
                    })
            },
            formartDate : function (date) {
                return date.toISOString().slice(0,10)
            },
            calculate : function () {
                this.clearFieldsErrors()
                if (this.formData.leave_code.length === 0 || this.formData.start_date.length === 0 ){

                    if(this.formData.leave_code.length === 0){
                        this.states.leave_code = 'has-warning'
                        this.error.leave_code = 'Leave Code is required'
                    }

                    if(this.formData.start_date.length === 0){
                       // this.states.start_date = 'has-warning'
                       // this.error.start_date = 'date is required'
                    }

                }else {

                    // Formats date from yyyy-MM-ddThh-mm-ssZ to yyyy-MM-dd
                   // this.formData.start_date = this.formartDate(this.formData.start_date)
                    this.getCalculatedDates()
                }

            },
            closeApplicationModal : function () {
                $('#myModal').modal('hide')
                this.formData = {}
                this.dateRange = []
            },
            getCalculatedDates : function () {
                this.calculateButton.loading = false
                var v = this
               // v.formData.start_date = new Date(v.formData.start_date )
                axios.post(
                    this.APIENDPOINTS.CALCULATE,
                    this.formData,
                    {headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }})
                    .then(function (response) {
                        v.formData.no_of_days = response.data.lDays
                        v.formData.return_date = response.data.rDate
                        v.calculateButton.loading  = true
                    })
                    .catch(function (error) {
                        v.calculateButton.loading = true
                        v.calculateButton.status = 'btn btn-warning'
                        v.calculateButton.text = 'please try again '
                        v.calculateButton.icon = 'fa fa-warning'
                        v.calculateButton.errorMessage = error.response.data.message
                        console.log(error)

                    })
            },
            saveLeaveApplication : function (e) {
                e.preventDefault();
                if(this.validateLeaveApplication()) {
                    this.formData.status = 'Review'
                    this.saveButton.loading = false
                    this.submitAndNew = true
                    this.sendLeaveApplication()
                }

            },
            submitLeaveApplication : function (e) {
                e.preventDefault();
                if(this.validateLeaveApplication()) {
                    this.formData.status = 'Review'
                    this.submitButton.loading = false
                    this.submitAndNew = false
                    this.sendLeaveApplication()
                }
            },
            validateLeaveApplication : function () {
                this.clearFieldsErrors()
                if (this.formData.end_date.length === 0 || this.formData.return_date.length === 0 || this.formData.leave_code.length === 0 || this.formData.start_date.length === 0 || this.formData.no_of_days.length === 0 || this.formData.handOverTo.length === 0 || this.dateRange.length === 0){

                    if(this.dateRange.length === 0){
                        this.states.start_date = 'has-warning'
                        this.error.start_date = 'date is required'
                    }
                    if(this.formData.end_date.length === 0){
                        this.error.end_date = 'End Date is Required'
                    }
                    if(this.formData.return_date.length === 0){
                        this.error.return_date = 'Return Date is Required'
                        this.states.return_date = 'has-warning'
                    }
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
                    if(this.formData.handOverTo.length === 0){
                        this.states.handOverTo = 'has-warning'
                        this.error.handOverTo = 'Employee name is required'
                    }

                }else {

                    return true
                }
            },
            sendLeaveApplication : function () {
                let v = this
                //for testing only
                // v.formData.return_date = v.formData.return_date.toISOString().slice(0,10)
                axios.post(
                    this.APIENDPOINTS.LEAVEAPPLICATION,
                    this.formData,
                    {headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }}
                )
                    .then(function (response) {
                        v.submitButton.loading  = true
                        v.saveButton.loading  = true
                        v.getLeaveApplications()

                        if (v.submitAndNew ){
                            $('#myModal').modal('hide')
                            v.clearFieldsErrors()
                            v.formData = {}
                            setTimeout($('#myModal').modal('show'), 1000)
                            v.dateRange = []

                        }else {
                            $('#myModal').modal('hide')
                            v.formData = {}
                            v.dateRange = []
                        }
                        v.error.submitting = ''

                    })
                    .catch(function (error) {
                        v.submitButton.loading  = true
                        v.saveButton.loading  = true
                        v.error.submitting = error.response.data.message
                        console.log(error.response)
                    })
            },
            getLeaveTypes : function () {
                var v = this
                axios.get(v.getApiPath(v.APIENDPOINTS.CURRENT_EMPLOYEE_LEAVE_TYPES, ''))
                    .then(function (response) {
                        v.leaveTypes = response.data.data

                    })
                    .catch(function (error) {
                        console.log(error)
                    })
            },
            getDepartmentEmployees : function () {
                let v = this
                var apiPath = v.getApiPath(v.APIENDPOINTS.ALLEMPLOYEES, '') + '?status=' + (v.currentUserData.Department == null ? '' : v.currentUserData.Department)
                axios.get(apiPath)
                    .then(function (response) {
                        v.departmentEmployees = response.data.data
                        console.log('handed over to employees')
                        console.log(v.departmentEmployees)
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
            },
            clearFieldsErrors : function () {
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
            submitApplication : function (application, status) {
                var v = this


                var apiPath = v.getApiPath(v.APIENDPOINTS.CHANGEAPPLICATIONSTATUS, application.id) + 'status'
                alert(apiPath)
                v.formData.status = status
                axios.post(
                    apiPath,
                    v.formData,
                    {headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }}
                )
                    .then(function (response) {
                        v.getLeaveApplications()
                    })
                    .catch(function (error) {
                        v.getLeaveApplications()
                        console.log(error.response.message)
                    })
            },
            deleteApplication : function (application) {

                var v = this
                v.sending = true
                axios.post(
                    v.getApiPath(v.APIENDPOINTS.CANCELAPPLICATION, application.id),
                    { "Status": "Canceled" },
                    {headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }}
                )
                    .then(function (response) {
                        v.getLeaveApplications()
                        v.sending = false
                    })
                    .catch(function (error) {
                        v.getLeaveApplications()
                        console.log(error.response.message)
                    })
            }
        },
        created() {
            this.getLeaveApplications()
            this.getLeaveTypes()
            this.getDepartmentEmployees()
            this.getDisabledDays()

            //check for applications after every five minutes
            this.timer = setInterval(this.getLeaveApplications, 300000)

        },
        computed : {
            filteredItems () {
                return this.requests.filter(request =>{
                    return this.fullNames(request.Employee_Details.First_Name, request.Employee_Details.Middle_Name, request.Employee_Details.Last_Name).toLowerCase().indexOf(this.searchTerm.toLowerCase()) > -1
                })
            }
        },
        watch : {
            dateRange : function (newVal, OldVal) {
                this.setDates()
            },
            leave_code : function (newVal, OldVa) {
                this.formData.leave_code = this.leave_code
                this.calculate();
        ``}

        },
        mounted(){
            if(this.openModal){
                this.openAppModal = true
            }
            if (this.notificationsData.component === 'open-applications'){
                this.selected = this.notificationsData.data
            }
        },
    }
</script>

<style scoped>

</style>