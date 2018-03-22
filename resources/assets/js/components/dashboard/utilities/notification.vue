<template>
    <li class="dropdown">
        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" @click="ReadNotifications">
            <i class="fa fa-bell"></i> <span class="label label-primary"  v-show="notify">{{notification.length}}</span>
        </a>

        <div class="project-list  dropdown-menu" style="min-width: 360px">
            <table class="table table-hover table-borderless">
                <tbody>
                <tr v-for="(notice, index) in notification" style="cursor: pointer" @click="notificationClick(notice.data.details, notice.data.model)">
                    <td class="project-status">
                          <i class="m-l-md" style="font-size : 24px"
                            :class="notice.data.type === 'success' ? 'fa fa-check-circle'
                            :notice.data.type === 'danger' ? 'fa fa-exclamation-circle'
                            :notice.data.type === 'info' ? 'fa fa-info-circle'
                            :'fa fa-question-circle'"

                            :style="notice.data.type === 'success' ? 'color : #2ecc71'
                            :notice.data.type === 'danger' ? 'color : #e74c3c'
                            :notice.data.type === 'info' ? 'color : #bdc3c7'
                            :'color : #ecf0f1'"
                            >
                            </i>
                    </td>
                    <td class="project-title">
                        <h5 v-if="notice.data.title">{{notice.data.title}}</h5>
                        <small>{{notice.data.message}}</small>
                    </td>
                    <td class="project-completion">
                        <small><timeago :since="notice.created_at"></timeago></small>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

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
