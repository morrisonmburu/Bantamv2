<template>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Pay Periods</h5>
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
                                <th>Name</th>
                                <th>Status</th>
                                <th>Starting_Date</th>
                                <th>Closed</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(period, index) in periods">
                                <td>{{ index + 1}} </td>
                                <td>{{period.Name}}</td>
                                <td><span class="label label-info" v-if="period.Current">Current</span> <span v-else></span></td>
                                <td>{{period.Starting_Date}}</td>
                                <td>{{period.Closed}}</td>
                                <td>
                                    <!--<button class="btn btn-sm btn-success" @click="submitApplication(application,'Review')" >Submit <i class="fa fa-send"></i> </button>-->
                                    <button @click="getPayslip(period.Starting_Date)"  class="btn btn-xs btn-success" >View Payslip <i class="fa fa-eye"></i> </button>
                                </td>
                            </tr>
                            <tr v-if="isEmptyObject(periods)">
                                <td colspan="8" class="text-center"><i class="text-muted">no periods found</i></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>



    export default {
        name: "payslip",
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
                loading : true,
                periods : {},
               formData : {
                   period : '',
                   link : '',

               },
            }
        },
        methods : {
            getPayslip : function (period) {
                this.formData.link = this.APIENDPOINTS.PAYSLIPCURRENTEMPLOYEE + '?period=' +  period
                window.open(this.formData.link, '_blank');
            },
            getPeriods : function () {
                var v = this
                axios.get(v.getApiPath(v.APIENDPOINTS.PAYPERIODS, ''))
                    .then(function (response) {
                        v.periods = response.data.data
                        v.loading = false
                        console.log('periods')
                        console.log(v.periods)
                    })
                    .catch(function(error){
                        v.loading = false
                        console.log(error)
                    })
            }
        },
        created(){
            this.getPeriods()
        }
    }
</script>

<style scoped>

</style>