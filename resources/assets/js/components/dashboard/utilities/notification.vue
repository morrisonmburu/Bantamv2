<template>
    <li class="dropdown">
        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
            <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
        </a>
        <ul class="dropdown-menu dropdown-alerts">
            <li>
                <a href="mailbox.html">
                    <div>
                        <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                        <span class="pull-right text-muted small">
                           <timeago :since="time"></timeago>
                        </span>
                    </div>
                </a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="profile.html">
                    <div>
                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                        <span class="pull-right text-muted small">12 minutes ago</span>
                    </div>
                </a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="grid_options.html">
                    <div>
                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                        <span class="pull-right text-muted small">4 minutes ago</span>
                    </div>
                </a>
            </li>
            <li class="divider"></li>
            <li>
                <div class="text-center link-block">
                    <a href="notifications.html">
                        <strong>See All Alerts</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
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
            setTimeout(() =>  this.getNotifications(), 1500);

        }
    }
</script>

<style scoped>

</style>