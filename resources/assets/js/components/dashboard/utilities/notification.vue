<template>
    <li class="dropdown">
        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" @click="ReadNotifications">
            <i class="fa fa-bell"></i> <span class="label label-primary"  v-show="notify">{{notification.length}}</span>
        </a>
        <ul class="dropdown-menu dropdown-messages" v-show="notification.length !== 0">
            <li v-for="(notice, index) in notification">
                <div class="dropdown-messages-box">
                    <a href="" class="pull-left">
                        <i class="fa fa-envelope fa-fw "></i>
                    </a>
                    <div class="media-body">
                        <small class="pull-right"><timeago :since="notice.created_at"></timeago></small>
                        <strong>{{notice.data.title}}</strong><br>
                        {{notice.data.message}}
                        <small class="text-muted"></small>
                    </div>
                </div>
                <div class="divider" v-show="notification.length !== 1 && notification.length === (index + 1)"></div>
            </li>
        </ul>
    </li>












</template>

<script>
    import VueTimeago from 'vue-timeago'
    Vue.use(VueTimeago, {
        name: 'timeago', // component name, `timeago` by default
        locale: 'en-US',
        locales: {
            // you will need json-loader in webpack 1
            'en-US': require('vue-timeago/locales/en-US.json')
        }
    })
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
            'validateField'
        ],
        data : function () {
            return{
                notification : {},
                timer  : '',
                notify : false,
                noticeIcons : {
                    ApprovalRequest : '',
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
