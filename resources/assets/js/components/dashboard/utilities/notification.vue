<template>
    <li class="dropdown">
        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
            <i class="fa fa-bell"></i> <span class="label label-primary"  v-show="notification.length !== 0">{{notification.length}}</span>
        </a>
        <ul class="dropdown-menu dropdown-alerts">
            <li v-for="(notice, index) in notification">
                <a href="mailbox.html">
                    <div>
                        <i class="fa fa-envelope fa-fw"></i> {{notice.data.message}}
                        <span class="pull-right text-muted small">
                           <timeago :since="notice.created_at"></timeago>
                        </span>
                    </div>
                </a>
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
            'userDetails'
        ],
        data : function () {
            return{
                notification : {},
                time  : Date.now()

            }
        },
        methods : {
            getNotifications : function () {
                var v = this
                axios.get(v.getApiPath(v.APIENDPOINTS.NOTIFICATIONS, v.currentUser.id))
                    .then(function (response) {
                        v.notification = response.data.data
                        console.log('notification')
                        console.log( v.notification)
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
            }
        },
        created() {

        },
        mounted() {
            setTimeout(() =>  this.getNotifications(), 2000);

        }
    }
</script>

<style scoped>

</style>
