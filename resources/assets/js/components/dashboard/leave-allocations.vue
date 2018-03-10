<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Leave Allocations</h5>
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
                        <ul id="example-1">
                            <li v-for="allocation in currentEmployeeLeaveAllocations">
                                {{ allocation.Employee_No}}
                            </li>
                        </ul>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>leave code</th>
                                <th>Maturity Date</th>
                                <th>Balance</th>
                                <th>Accrued Days</th>
                                <th>Days Taken</th>
                                <th>Days Applied</th>
                                <th>Days Approved</th>
                                <th>Days Approved_Taken</th>
                                <th>Allocated Days</th>
                                <th>Leave Period</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>L434</td>
                                <td>05/24/2018</td>
                                <td>5</td>
                                <td>2</td>
                                <td>7</td>
                                <td>3</td>
                                <td>3</td>
                                <td>3</td>
                                <td>21</td>
                                <td>2018</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>L434</td>
                                <td>05/24/2018</td>
                                <td>5</td>
                                <td>2</td>
                                <td>7</td>
                                <td>3</td>
                                <td>3</td>
                                <td>3</td>
                                <td>21</td>
                                <td>2018</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>L434</td>
                                <td>05/24/2018</td>
                                <td>5</td>
                                <td>2</td>
                                <td>7</td>
                                <td>3</td>
                                <td>3</td>
                                <td>3</td>
                                <td>21</td>
                                <td>2018</td>
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
    export default {
        name: "leave-allocations",
        props : [
            'currentUser',
            'currentUserData',
            'swapComponent',
            'currentEmployeeLeaveAllocations'
        ],
    }
</script>

<style scoped>

</style>