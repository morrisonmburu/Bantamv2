<template>
    <div class="dropdown profile-element">

        <span>
            <img alt="image" class="img-circle" src="img/profile_small.jpg" />
        </span>

        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
              <span class="clear">
                  <span class="block m-t-xs">
                      <strong class="font-bold">{{currentUserData.First_Name +' '+ currentUserData.Middle_Name +' '+ currentUserData.Last_Name}}</strong>
                 </span>
                 <span class="text-muted text-xs block">
                     Art Director
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
            'swapComponent'
        ],

    }
</script>

<style scoped>

</style>