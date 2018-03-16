<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Open Applications</h5>
                        <div class="ibox-tools">
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
                                    <button v-if="calculateButton.loading" class="btn btn-block" data-style="expand-right" @click="calculate" v-bind:class="calculateButton.status"> <strong>{{ calculateButton.text }} <i :class="calculateButton.icon"></i> </strong></button>
                                    <div v-else class="sk-spinner sk-spinner-wave">
                                        <div class="sk-rect1"></div>
                                        <div class="sk-rect2"></div>
                                        <div class="sk-rect3"></div>
                                        <div class="sk-rect4"></div>
                                        <div class="sk-rect5"></div>
                                    </div>
                                    <span id="helpBlokError" class="help-block">{{calculateButton.errorMessage}}</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group" :class="states.end_date">
                                <label class="col-sm-4 control-label" >End Date</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-calendar"></i></span>
                                        <input type="text" disabled class="form-control" name="end_date" v-model="formData.end_date" id="end_date">
                                        <span class="help-block">{{error.end_date}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" :class="states.return_date">
                                <label class="col-sm-4 control-label">Return Date</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-calendar"></i></span>
                                        <input type="text" disabled class="form-control"   name="return_date" v-model="formData.return_date" id="return_date">
                                        <span class="help-block">{{error.return_date}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group"  :class="states.comment">
                                <label class="col-sm-4 control-label" >Comments</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" rows="2" id="comment" name="comment" v-model="formData.comment"></textarea>
                                    <span id="helpBlocNoSubmitting" class="help-block">{{error.comment}}</span>

                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button v-if="submitButton.loading" @click="submitLeaveApplication" class="btn "  :class="submitButton.status" >
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


    </div>
</template>

<script>
    export default {
        name: "posted-applications",
        props : [
            'currentUser',
            'currentUserData',
            'swapComponent'
        ],
    }
</script>

<style scoped>

</style>