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

                        <div v-if="loading" class="spiner-example">
                            <div class="sk-spinner sk-spinner-wave">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                            </div>
                        </div>
                        <table v-else class="table table-striped animated fadeIn">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>leave code</th>
                                <th>Maturity Date</th>
                                <th>Balance</th>
                                <th>Accrued Days</th>
                                <th>Days Taken</th>
                                <th>Allocated Days</th>
                                <th>Leave Period</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(allocation, index) in allocations">
                                <td>{{index + 1 }}</td>
                                <td>{{allocation.Leave_Code}}</td>
                                <td>{{allocation.Maturity_Date}}</td>
                                <td>{{allocation.Balance}}</td>
                                <td>{{allocation.Accrued_Days}}</td>
                                <td>{{allocation.Taken}}</td>
                                <td>{{allocation.Allocated_Days}}</td>
                                <td>{{allocation.Leave_Period}}</td>
                            </tr>
                            <tr v-if="isEmptyObject(allocations)">
                                <td colspan="8" class="text-center"><i class="text-muted">no allocations found</i></td>
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
            'currentEmployeeLeaveAllocations',
            'APIENDPOINTS',
            'getApiPath',
            'isEmptyObject'
        ],
        data : function(){
            return {
                allocations     : {},
                loading         : true
            }
        },
        methods : {

            getLeaveAllocations : function(){
                var v = this

                axios.get(v.getApiPath(v.APIENDPOINTS.CURRENT_EMPLOYEE_LEAVE_ALLOCATIONS, v.currentUserData.id))
                    .then(function (response) {
                        v.allocations = response.data.data
                        v.loading = false
                        console.log('Leave allocations')
                        console.log(v.allocations)
                    })
                    .catch(function (errro) {
                        console.log(errro)
                    })
            }
        },
        created : function () {
                this.getLeaveAllocations()
        },
        watch : {

        }

    }
</script>

<style scoped>

</style>