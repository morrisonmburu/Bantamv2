<div class="wrapper wrapper-content">
    <keep-alive>
            <component :is="currentComponent"
                       class="animated fadeInRight"
                       :current-user="currentUser"
                       :current-user-data="currentUserData"
                       :swap-component="swapComponent"
                       :search-results="searchResults"
                       :search-term="searchTerm"
                       :prof-pic="profPic"
            ></component>
    </keep-alive>
</div>

