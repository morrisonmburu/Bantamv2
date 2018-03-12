<template>
    <div class="dropdown profile-element ani">

        <span v-if="userDetails.profilePicture.length !== 0" class="animated fadeInDown">
            <img alt="image" class="img-circle" :src="userDetails.profilePicture " width="100"/>
        </span>

        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
              <span class="clear">
                  <span class="block m-t-xs">
                      <strong class="font-bold">{{userDetails.fullName}}</strong>
                 </span>
                 <span class="text-muted text-xs block">
                     {{currentUserData.Title == null ? 'My Account' : currentUserData.Title}}
                     <b class="caret"></b>
                 </span>
              </span>
        </a>

        <ul class="dropdown-menu animated fadeInRight m-t-xs">
            <li><a href="#" @click="swapComponent('profile')">Profile</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Messages</a></li>
        </ul>
    </div>

</template>

<script>
    export default {
        name: "side-nav-header",
        props : [
            'currentUser',
            'currentUserData',
            'swapComponent',
            'getApiPath',
            'APIENDPOINTS',
            'userDetails'
        ],
        data : function () {
            return {

            }
        },
        methods : {

        },
        created () {

        }

    }
</script>

<style scoped>

</style>