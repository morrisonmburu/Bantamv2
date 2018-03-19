<template>
    <div>
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
                                <!--<th>Application Code</th>-->
                                <th>Application Date</th>
                                <th>Days Applied</th>
                                <th>Leave Code</th>
                                <th>Leave Period</th>
                                <th>Start Date</th>
                                <th>Return Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(application, index) in applications" @click="showApprovers(application)" data-toggle="tooltip" data-placement="left" title="" data-original-title="Click to view approvers">
                                <td>{{ index + 1}} </td>
                                <!--<td>{{application.Application_Code}}</td>-->
                                <td>{{application.Application_Date}}</td>
                                <td>{{application.Days_Applied}}</td>
                                <td>{{application.Leave_Code}}</td>
                                <td>{{application.Leave_Period}}</td>
                                <td>{{application.Start_Date}}</td>
                                <td>{{application.Return_Date}}</td>
                                <td>{{application.Status}}</td>
                                <td>
                                    <!--<button class="btn btn-sm btn-success" @click="submitApplication(application,'Review')" >Submit <i class="fa fa-send"></i> </button>-->
                                    <button v-if="application.Status === 'Review'" class="btn btn-xs btn-danger" @click="deleteApplication(application)" >Cancel <i class="fa fa-close"></i> </button>
                                    <button v-else disabled class="btn btn-xs btn-default" @click="deleteApplication(application)" >Cancel <i class="fa fa-close"></i> </button>
                                </td>
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






















        <div class="ibox-content p-xl">

            <div class="row">
                <div class="form-group">
                    <DatePicker format="yyyy-MM-dd" :minimumView="'month'" :maximumView="'year'" :initialView="'month'" v-model="formData.period" name="period" id="period"  input-class="form-control"></DatePicker>
                    <!--<DatePicker  v-model="testdate"  type="date" format="yyyy-MM-dd"  lang="en"></DatePicker>-->
                </div>
                <div class="form-group" >
                    <button type="submit" @click="getPayslip">Generate payslip</button>
                </div>
                </div>
            </div>

        </div>
</template>

<script>
   import DatePicker from 'vuejs-datepicker';

   // import DatePicker from 'vue2-datepicker';



    export default {
        name: "payslip",
        components: {
            DatePicker
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
        data : function () {
            return{
               formData : {
                   period : '',
                   link : '',

               },
                testdate : '',
                time1: '',
                time2: '',
                shortcuts: [
                    {
                        text: 'Today',
                        start: new Date(),
                        end: new Date()
                    }
                ]
            }
        },
        methods : {
            getPayslip : function () {

                // console.log(this.testdate[0])
                this.testdate[0] = this.testdate[0].toISOString().slice(0,10)
                this.testdate[1] = this.testdate[1].toISOString().slice(0,10)

                console.log(this.testdate[0])
                console.log(this.testdate[1])

                // if (this.formData.period.length !== 0){
                //     this.formData.period = (this.formData.period).toISOString().slice(0,10)
                //     this.formData.link = this.APIENDPOINTS.PAYSLIPCURRENTEMPLOYEE + '?period=' +  this.formData.period
                //     window.open(this.formData.link, '_blank');
                // }else {
                //     alert('select period')
                // }
            }
        }
    }
</script>

<style scoped>

</style>