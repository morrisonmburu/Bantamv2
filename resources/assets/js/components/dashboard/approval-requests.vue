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
                        <div class="row">
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
                                    <th>Employee No.</th>
                                    <th>Document No.</th>
                                    <th>Date Created</th>
                                    <th>Date Sent</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>E84354</td>
                                    <td>DOC272</td>
                                    <td>02/07/2018</td>
                                    <td>02/07/2018</td>
                                    <td>02/07/2018</td>
                                    <td><span class="label label-danger">Rejected</span></td>
                                    <td>
                                        <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#approveRequest">Process</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>E84354</td>
                                    <td>DOC272</td>
                                    <td>02/07/2018</td>
                                    <td>02/07/2018</td>
                                    <td>02/07/2018</td>
                                    <td><span class="label label-info">Pending</span></td>
                                    <td>
                                        <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#approveRequest">Process</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>E84354</td>
                                    <td>DOC272</td>
                                    <td>02/07/2018</td>
                                    <td>02/07/2018</td>
                                    <td>02/07/2018</td>
                                    <td><span class="label label-info">Pending</span></td>
                                    <td>
                                        <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#approveRequest">Process</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>E84354</td>
                                    <td>DOC272</td>
                                    <td>02/07/2018</td>
                                    <td>02/07/2018</td>
                                    <td>02/07/2018</td>
                                    <td><span class="label label-primary">Approved</span></td>
                                    <td>
                                        <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#approveRequest">Process</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>E84354</td>
                                    <td>DOC272</td>
                                    <td>02/07/2018</td>
                                    <td>02/07/2018</td>
                                    <td>02/07/2018</td>
                                    <td><span class="label label-info">Pending</span></td>
                                    <td>
                                        <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#approveRequest">Process</button>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <!-- ==== Modal for leave application approval:: Added by Mayaka == -->
            <div class="modal inmodal" id="approveRequest" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content animated bounceInRight">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h5 class="modal-title">Approval processing</h5>
                        </div>
                        <div class="modal-body">
                            <div class="ibox-content inspinia-timeline">
                                <div class="timeline-item">
                                    <div class="row">
                                        <div class="col-xs-12 content no-top-border">
                                            <p class="m-b-xs"><strong>Employee Details</strong></p>
                                            <p><strong>Name:</strong> John Doe</p>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <p><strong>Title:</strong> Tech Nerd</p>
                                                </div>
                                                <div class="col-xs-6">
                                                    <p><strong>Department:</strong> IT</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="row">
                                        <div class="col-xs-12 content">
                                            <p class="m-b-xs"><strong>Leave Details</strong></p>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <p><strong>Type:</strong> Annual leave</p>
                                                    <p><strong>Start Date:</strong> 03/20/2018</p>
                                                    <p><strong>Days:</strong> 30 days</p>
                                                </div>
                                                <div class="col-xs-6">
                                                    <p><strong>End Date:</strong> 03/20/2018</p>
                                                    <p><strong>Return Date:</strong> 05/20/2018</p>
                                                    <p><strong>Balance:</strong> 2 days</p>
                                                </div>
                                            </div>
                                        </div>
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
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group"><label>Number of days</label> <input type="number" placeholder="Number of days" class="form-control"></div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group"><label>End Date</label>
                                                <div class="input-group date" data-provide="datepicker">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group"><label>Return Date</label>
                                                <div class="input-group date" data-provide="datepicker">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="form-group"><label>Comments</label>
                                                <textarea class="form-control" rows="2" id="comment"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-xs btn-white" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-xs btn-success">Approve</button>
                            <button type="button" class="btn btn-xs btn-danger">Reject</button>
                            <button type="button" class="btn btn-xs btn-warning">Escalate</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of New leave application approval modal -->
        </div>
    </div>
</template>

<script>
    export default {
        name: "approval-requests",
        props : [
            'currentUser',
            'currentUserData',
            'swapComponent'
        ],

    }
</script>

<style scoped>

</style>