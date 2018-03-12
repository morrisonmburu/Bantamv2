
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this applications
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('side-nav-header', require('./components/dashboard/side-nav-header.vue'));
Vue.component('dashboard', require('./components/dashboard/dashboard.vue'));
Vue.component('profile', require('./components/dashboard/profile.vue'));
Vue.component('open-applications', require('./components/dashboard/open-applications.vue'));
Vue.component('pending-applications', require('./components/dashboard/pending-application.vue'));
Vue.component('approval-request', require('./components/dashboard/approval-requests.vue'));
Vue.component('posted-applications', require('./components/dashboard/posted-applications.vue'));
Vue.component('leave-allocations', require('./components/dashboard/leave-allocations.vue'));
Vue.component('leave-planner', require('./components/dashboard/leave-planner'));
Vue.component('payslip', require('./components/dashboard/payslip'));
Vue.component('faq', require('./components/dashboard/faq'));
Vue.component('faq', require('./components/dashboard/faq'));
Vue.component('wave-loader', require('./components/dashboard/utilities/wave-loader'));


const app = new Vue({
    el: '#app',
    data: {
        currentComponent: 'dashboard',
        profPic : '',
        currentUser                         : {},
        currentUserData                     : {},
        userDetails   : {
            fullName        : '',
            profilePicture  : ''
        },
        currentEmployeeLeaveApplications    : {},
        currentEmployeeLeaveAllocations     : {},
        APIENDPOINTS     : {
            CURRENTUSER                             : 'api/users/current',                   // Current logged in user
            CURRENTEMPLOYEE                         : 'api/users@employee',                  // employee details
            CURRENT_EMPLOYEE_LEAVE_APPLICATIONS     : 'api/employees@leave_applications',    // current employee leave applications
            CURRENT_EMPLOYEE_LEAVE_ALLOCATIONS      : 'api/employees@leave_allocations',     // current employee leave allocations
            CURRENT_EMPLOYEE_LEAVE_TYPES            : 'api/employees@leave_types',           // current employee leave types
            SEARCH                                  : 'https://yesno.wtf/api',
            CALCULATE : 'api/leave_applications/calculate_leave_dates',
            LEAVETYPES : 'api/leave_types',
            LEAVEAPPLICATION : 'api/leave_applications ',
            PROFILEPICTURE : 'api/employees@picture',

        },
        searchResults : '',
        searchTerm : ''
    },
    methods : {
        isEmptyObject : function (object) {
            return (Object.keys(object).length === 0)
        },
        swapComponent: function (component) {
            if (Vue.options.components[component]) {
                this.currentComponent = component
            } else {
                alert(component + ' component not found');
            }
        },

        sanitizeHeaders: function (heading) {
            return heading.replace('-', ' ');
        },

        getApiPath: function (rawPath, data) {
            if (data.length == 0) {
                return rawPath.replace('@', '/')
            } else {
                return rawPath.replace('@', '/' + data + '/');
            }
        },

        setUserDetails : function () {
            this.userDetails.fullName = this.currentUserData.First_Name +' '+ this.currentUserData.Middle_Name +' '+ this.currentUserData.Last_Name
            this.userDetails.profilePicture = this.getApiPath(this.APIENDPOINTS.PROFILEPICTURE, this.currentUserData.id)
        },

        getData : function () {
            var v = this
            axios.get(this.getApiPath(v.APIENDPOINTS.CURRENTUSER,''))
                .then(function (response) {
                    v.currentUser = response.data.data
                    console.log(v.currentUser)

                    if (Object.keys(v.currentUser).length !== 0 ){
                        axios.get(v.getApiPath(v.APIENDPOINTS.CURRENTEMPLOYEE,v.currentUser.id))
                            .then(function (response) {
                                v.currentUserData = response.data.data
                                v.setUserDetails()
                                console.log(v.currentUserData)


                                if (Object.keys(v.currentUserData).length !== 0 ){

                                    // // Fetch current employee's Leave applications
                                    // axios.get(v.getApiPath(v.APIENDPOINTS.CURRENT_EMPLOYEE_LEAVE_APPLICATIONS,v.currentUserData.id))
                                    //     .then(function (response){
                                    //         v.currentEmployeeLeaveApplications = response.data.data
                                    //         console.log(v.currentEmployeeLeaveApplications)
                                    //     })
                                    //     .catch(function (error) {
                                    //         console.log("Error fetching leave applications data.");
                                    //         console.log(error);
                                    //     })

                                    // // Fetch current employee's leave allocations
                                    // axios.get(v.getApiPath(v.APIENDPOINTS.CURRENT_EMPLOYEE_LEAVE_ALLOCATIONS,v.currentUserData.id))
                                    //     .then(function (response){
                                    //         v.currentEmployeeLeaveAllocations = response.data.data
                                    //         console.log(v.currentEmployeeLeaveAllocations)
                                    //     })
                                    //     .catch(function (error) {
                                    //         console.log("Error fetching leave allocations data.");
                                    //         console.log(error);
                                    //     })

                                }else{
                                    console.log("Employee data is blank");
                                }
                            })
                            .catch(function (error) {
                                console.log("Error encountered while fetching current employee data.");
                                console.log(error);
                            })
                    }else{
                        console.log("There is no such user in the system");
                    }

                })
                .catch(function (error) {
                    console.log(error)
                })
        },
        
        search : _.debounce(
            function () {
                this.searchResults = 'Searching...'
                var v = this
                axios.get(v.APIENDPOINTS.SEARCH)
                    .then(function (response) {
                        v.searchResults = response.data
                    })
                    .catch(function (error) {
                        v.searchResults = 'Nothing Found'
                    })
            },
            500
        )

    },
    created : function () {
        this.getData()
    },
    watch : {
        searchTerm : function () {
            this.swapComponent('search-results')
            this.searchResults  = ' Typing..'
            this.search();
        }
    }

});
