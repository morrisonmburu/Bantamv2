<template>
    <!--top row statistics-->
    <div>
        <div v-if="loading" class="row">
            <div class="col-sm-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Leave Summary</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="spiner-example">
                            <div class="sk-spinner sk-spinner-wave">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Leave summary bar graph</h5>
                    </div>
                    <div class="ibox-content">
                        <chartjs-bar :width="200" :height="80" :beginzero="false" :labels="labels" :datasets="datasets" :option="options"></chartjs-bar>
                        <!--<chartjs-bar :data="testDataset"></chartjs-bar>-->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-6">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Leave Taken Summary</h5>
                            </div>
                            <div class="ibox-content">
                                <chartjs-doughnut :labels="labels" :option="doughnutOptions" :data="doughnutData"></chartjs-doughnut>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Annual Leave Summary</h5>
                            </div>
                            <div class="ibox-content">
                                <chartjs-line></chartjs-line>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "content-wrapper",
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
            'notificationEvents',
            'pageLoading'
        ],
        data : function () {
          return {
              loading : true,
              LeaveAllocations : {},
              leaveTypes : {},
              labels : [],
              doughnutData : [],
              leaveStats : ['Taken','Accrued_Days', 'Balance', 'Allocated_Days'],
              datasets : [
                  {
                      label : "Days Taken",
                      backgroundColor: [
                          'rgb(255,99,132)',
                          'rgb(255,99,132)',
                          'rgb(255,99,132)',
                          'rgb(255,99,132)',
                          'rgb(255,99,132)',
                          'rgb(255,99,132)',
                      ],
                      borderColor: [

                      ],
                      borderWidth: 1,
                      data: []
                  },
                  {
                      label : "Accrued Days",
                      backgroundColor: [
                          'rgb(54,162,235)',
                          'rgb(54,162,235)',
                          'rgb(54,162,235)',
                          'rgb(54,162,235)',
                          'rgb(54,162,235)',
                          'rgb(54,162,235)',
                      ],
                      borderColor: [

                      ],
                      borderWidth: 1,
                      data: []
                  },
                  {
                      label : "Balance",
                      backgroundColor: [
                          'rgb(0,166,0)',
                          'rgb(0,166,0)',
                          'rgb(0,166,0)',
                          'rgb(0,166,0)',
                          'rgb(0,166,0)',
                          'rgb(0,166,0)'
                      ],
                      borderColor: [

                      ],
                      borderWidth: 1,
                      data: []
                  },
                  {
                      label : "Allocated Days",
                      backgroundColor: [
                          'rgb(255,206,86)',
                          'rgb(255,206,86)',
                          'rgb(255,206,86)',
                          'rgb(255,206,86)',
                          'rgb(255,206,86)',
                          'rgb(255,206,86)',
                      ],
                      borderColor: [
                      ],
                      borderWidth: 1,
                      data: []
                  },
              ],
              options : {
                  responsive : true,
                  maintainAspectRatio : true,
                  title: {
                      display: true,
                      position: 'bottom',
                      text: 'Custom Chart Title'
                  },
                  scales: {
                      xAxes: [{
                          // stacked: true,
                          gridLines: { display: false },
                      }],
                      yAxes: [{
                          // stacked: true
                      }]
                  }
              },
              doughnutOptions : {}

          }
        },
        methods : {
            getLeaveAllocations : function () {
                var v = this
                axios.get(v.getApiPath(v.APIENDPOINTS.CURRENT_EMPLOYEE_LEAVE_ALLOCATIONS, v.currentUserData.id))
                    .then(function (response) {
                        v.LeaveAllocations = response.data.data
                        console.log('leave allocation')
                        console.log(v.LeaveAllocations)
                        v.loading = false
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
            },
            getLeaveTypes : function () {
                var v = this
                axios.get(v.getApiPath(v.APIENDPOINTS.CURRENT_EMPLOYEE_LEAVE_TYPES, ''))
                    .then(function (response) {
                        v.leaveTypes = response.data.data
                        console.log('leave types')
                        console.log(v.leaveTypes)
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
            },
            initCharts : function (val) {
                //reset datasets labels
                //for each dataset push data for each leave type
                //pick first data set

                this.initChartLabels(val)

            for(let dataset in this.datasets){                                                      // loop through each data set
                    for(let label in this.labels){                                                  // loop through the set labels
                        for(let v in val){                                                          // loop through leave allocations
                            if (this.labels[label] === val[v].LTypes_Description){                  // if leave matches the label
                                this.datasets[dataset].data.push(val[v][this.leaveStats[dataset]])
                                // push data into dataset array
                                console.log(this.datasets[dataset])
                            }
                        }
                    }
                }
            },

            initDoughnutChart : function (val) {

                for(let label in this.labels){
                    this.doughnutData[label] = 0;
                    for(let v in val){
                        if (this.labels[label] === val[v].LTypes_Description){
                            this.doughnutData[label] = parseInt(val[v][this.leaveStats[2]]) + this.doughnutData[label]
                        }
                    }
                }
                },
            initChartLabels : function (val) {
                // reset the labels array
                this.labels = []
                for(let i in val){
                    // for(let code in this.leaveTypes)
                        // if (val[i].Code === code)
                    this.labels.push(val[i].LTypes_Description)
                }
            }
        },
        created(){
            // setTimeout(this.getLeaveAllocations , 5000)
            // if(this.pageReady){
            //     setTimeout(this.getLeaveAllocations , 10000)
            // }else {this.getLeaveAllocations}
            this.getLeaveTypes()
        },
        mounted(){

        },
        watch : {
            LeaveAllocations : function (newVal, oldVal) {
                this.initCharts(this.LeaveAllocations)
                this.initDoughnutChart(this.LeaveAllocations)
            },
            // leaveTypes : function (newVal, oldVal) {
            //     this.initChartLabels(this.leaveTypes)
            // },
            pageLoading : function (newVal, oldVal) {
                if(!newVal){
                    this.getLeaveAllocations()
                }
            }
        }
    }
</script>

<style scoped>

</style>