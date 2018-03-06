<template>
    <div class="dropdown profile-element">

        <span>
            <img alt="image" class="img-circle" src="img/profile_small.jpg" />
        </span>

        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
              <span class="clear">
                  <span class="block m-t-xs">
                      <strong class="font-bold">{{ fullNames }}</strong>
                 </span>
                 <span class="text-muted text-xs block">
                     Art Director
                     <b class="caret"></b>
                 </span>
              </span>
        </a>

        <ul class="dropdown-menu animated fadeInRight m-t-xs">
            <li><a href="profile.html">Profile</a></li>
            <li><a href="contacts.html">Contacts</a></li>
            <li><a href="mailbox.html">Mailbox</a></li>
            <li class="divider"></li>
            <li><a href="login.html">Logout</a></li>
        </ul>

    </div>


</template>

<script>
    export default {
        name: "side-nav-header"
    }
</script>

<style scoped>

</style>