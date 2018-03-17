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
                                <td colspan="8" class="text-center"><i class="text-muted">no historical applications found</i></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
</template>

<script>
    export default {
        name: "posted-applications",
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
            return {
                applications : {},
                loading : true,

            }
        },
        methods : {
            getLeaveApplications : function(){
                let v = this
                axios.get(v.getApiPath(v.APIENDPOINTS.HISTORICLEAVEAPPLICATIONS, v.currentUserData.id))
                    .then(function (response) {
                        v.applications = response.data.data
                        v.loading = false
                    })
                    .catch(function (errro) {
                        console.log(errro)
                        v.loading = false
                    })
            },
        },
        created() {
            this.getLeaveApplications()
        }
    }
</script>

<style scoped>

</style>