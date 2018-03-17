<template>
    <div>
        <div class="ibox-content p-xl">

            <div class="row">
                <div class="form-group" >
                    <!--<datepicker format="yyyy-MM-dd" :minimumView="'month'" :maximumView="'year'" :initialView="'month'" v-model="formData.period" name="period" id="period"  input-class="form-control"></datepicker>-->
                    



                </div>
                <div class="form-group" >
                    <button type="submit" @click="getPayslip">Generate payslip</button>
                    </div>
                </div>
            </div>

        </div>
</template>

<script>
   // import Datepicker from 'vuejs-datepicker';

    import Datepicker from 'vuejs-datepicker';



    export default {
        name: "payslip",
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
            'validateField'
        ],
        data : function () {
            return{
               formData : {
                   period : '',
                   link : ''
               }
            }
        },
        methods : {
            getPayslip : function () {
                if (this.formData.period.length !== 0){
                    this.formData.period = (this.formData.period).toISOString().slice(0,10)
                    this.formData.link = this.APIENDPOINTS.PAYSLIPCURRENTEMPLOYEE + '?period=' +  this.formData.period
                    window.open(this.formData.link, '_blank');
                }else {
                    alert('select period')
                }
            }
        }
    }
</script>

<style scoped>

</style>