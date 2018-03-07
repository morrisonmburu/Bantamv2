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
                                        <button disabled class="btn btn-xs btn-success">Approve</button>
                                        <button disabled class="btn btn-xs btn-danger">Reject</button>
                                        <button disabled class="btn btn-xs btn-warning">Escalate</button>
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
                                        <button class="btn btn-xs btn-success">Approve</button>
                                        <button class="btn btn-xs btn-danger">Reject</button>
                                        <button class="btn btn-xs btn-warning">Escalate</button>
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
                                        <button class="btn btn-xs btn-success">Approve</button>
                                        <button class="btn btn-xs btn-danger">Reject</button>
                                        <button class="btn btn-xs btn-warning">Escalate</button>
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
                                        <button disabled class="btn btn-xs btn-success">Approve</button>
                                        <button disabled class="btn btn-xs btn-danger">Reject</button>
                                        <button disabled  class="btn btn-xs btn-warning">Escalate</button>
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
                                        <button class="btn btn-xs btn-success">Approve</button>
                                        <button class="btn btn-xs btn-danger">Reject</button>
                                        <button class="btn btn-xs btn-warning">Escalate</button>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "approval-requests"
    }
</script>

<style scoped>

</style>