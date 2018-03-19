<div class="wrapper wrapper-content">
    <keep-alive>
            <component :is="currentComponent"
                       class="animated fadeInRight"
                       :current-user="currentUser"
                       :current-user-data="currentUserData"
                       :swap-component="swapComponent"
                       :search-results="searchResults"
                       :search-term="searchTerm"
                       :user-details="userDetails"
                       :a-p-i-e-n-d-p-o-i-n-t-s="APIENDPOINTS"
                       :get-api-path="getApiPath"
                       :is-empty-object="isEmptyObject"
                       :validate-field="'validateField'"
                       :full-names="fullNames"
            ></component>
    </keep-alive>
</div>

