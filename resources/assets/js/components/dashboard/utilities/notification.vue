<template>
    <li class="dropdown">
        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" ><!--@click="ReadNotifications"-->
            <i class="fa fa-bell"></i> <span class="label label-primary"  v-show="notify">{{notification.length}}</span>
        </a>
        <ul class="dropdown-menu dropdown-messages" v-show="notification.length !== 0">
            <li v-for="(notice, index) in notification" @click="notificationClick(notice.data.details, notice.data.model)">
                <div class="dropdown-messages-box ">
                    <a href="#" class="pull-left">
                        <i
                         :class="notice.data.model === 'App\ApprovalEntry' ? 'fa fa-tasks'
                         :notice.data.model === 'App\EmployeeLeaveApplication' ? 'fa fa-file-alt'
                         :'fa fa-file'"

                         :style="notice.data.type === 'success' ? 'color : #2ecc71'
                        :notice.data.model === 'danger' ? 'color : #e74c3c'
                        :notice.data.model === 'info' ? 'color : #bdc3c7'
                        :'color : #ecf0f1'"
                        >

                        </i>
                    </a>
                    <div class="media-body" >
                        <small class="pull-right"><timeago :since="notice.created_at"></timeago></small>
                        <!--<strong v-if="notice.data.title">{{notice.data.title}}<br></strong>-->
                        {{notice.data.message}}
                        <!--<small class="text-muted"></small>-->
                    </div>
                </div>
                <div class="divider" v-show="notification.length !== 1 && notification.length === (index + 1)"></div>
            </li>
        </ul>
    </li>













</template>

<script>

    import  Bus from '../../eventBus.js';
    import VueTimeago from 'vue-timeago';



    Vue.use(VueTimeago, {
        name: 'timeago', // component name, `timeago` by default
        locale: 'en-US',
        locales: {
            // you will need json-loader in webpack 1
            'en-US': require('vue-timeago/locales/en-US.json')
        }
    });
    export default {
        name: "notification",
        props : [
            'currentUser',
            'currentUserData',
            'swapComponent',
            'APIENDPOINTS',
            'getApiPath',
            'isEmptyObject',
            'userDetails',
            'validateField',
            'notificationEvents'
        ],
        data : function () {
            return{
                notification : {},
                timer  : '',
                notify : false,
                noticeIcons : {
                    ApprovalRequest : '',
                 },
                noticeData : {
                    component : '',
                    data      : {}
                }

            }
        },
        methods : {
            getNotifications : function () {
                var v = this
                axios.get(v.getApiPath(v.APIENDPOINTS.NOTIFICATIONS, v.currentUser.id))
                    .then(function (response) {

                        // Update notification when notifications are available
                        if (response.data.data.length !==0){
                            v.notification = response.data.data
                            v.notify = true
                        }
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
            },

            ReadNotifications : function () {

                var v = this
                v.notify = false
                axios.get(v.getApiPath(v.APIENDPOINTS.READNOTIFICATIONS, ''))
                    .then(function (response) {
                       v.getNotifications()
                    })
                    .catch(function (error) {

                    })
            },
            notificationClick : function (details, model) {

                if(model === 'ApprovalEntry'){
                    this.noticeData.component = 'approval-request'
                    this.noticeData.data      = details.id
                }else if (model === 'EmployeeLeaveApplication'){
                    this.noticeData.component = 'open-applications'
                    this.noticeData.data      = details.id
                }
                this.notificationEvents(this.noticeData)

            }
        },
        created() {

        },
        mounted() {
            setTimeout(this.getNotifications , 3000)
            this.timer = setInterval(this.getNotifications, 20000)
        }
    }
</script>

<style scoped>

</style>
