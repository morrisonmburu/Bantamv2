
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
Vue.component('leave-history', require('./components/dashboard/leave-history.vue'));
Vue.component('leave-allocations', require('./components/dashboard/leave-allocations.vue'));
Vue.component('leave-planner', require('./components/dashboard/leave-planner'));
Vue.component('payslip', require('./components/dashboard/payslip'));
Vue.component('faq', require('./components/dashboard/faq'));
Vue.component('faq', require('./components/dashboard/faq'));
Vue.component('wave-loader', require('./components/dashboard/utilities/wave-loader'));
Vue.component('notification', require('./components/dashboard/utilities/notification'));


const app = new Vue({
    el: '#app',
    data: {
        fromNotification : '',
        openModal : false,
        currentComponent: 'dashboard',
        profPic : '',
        currentUser                         : {},
        currentUserData                     : {},
        userDetails   : {
            fullName        : '',
            profilePicture  : '',
            id              : ''
        },
        currentEmployeeLeaveApplications    : {},
        currentEmployeeLeaveAllocations     : {},
        APIENDPOINTS     : {
            CURRENTUSER                             : 'api/users/current',                   // Current logged in user
            CURRENTEMPLOYEE                         : 'api/users@employee',                  // employee details
            ALLEMPLOYEES                            : 'api/employees',
            CURRENT_EMPLOYEE_LEAVE_APPLICATIONS     : 'api/employees/leave_applications?status[]=New&status[]=Review',    // current employee leave applications
            CURRENT_EMPLOYEE_LEAVE_ALLOCATIONS      : 'api/employees@leave_allocations',     // current employee leave allocations
            CURRENT_EMPLOYEE_LEAVE_TYPES            : 'api/employees/leave_types',           // current employee leave types
            SEARCH                                  : 'https://yesno.wtf/api',
            CALCULATE                               : 'api/leave_applications/calculate_leave_dates',
            LEAVETYPES                              : 'api/leave_types',
            LEAVEAPPLICATION                        : 'api/leave_applications',
            HISTORICLEAVEAPPLICATIONS               : 'api/employees/leave_applications?status[]=Approved&status[]=Rejected',
            PROFILEPICTURE                          : 'api/employees@picture',
            NOTIFICATIONS                           : 'api/users/notification/unread',
            READNOTIFICATIONS                       : 'api/users/notification/markasread',
            OPENAPPROVALREQUESTS                    : 'api/employees/approvals?status=Open',
            REJECCTEDAPPROVALREQUESTS               : 'api/employees/approvals?status=Rejected',
            REJECTEDMULTIPLEAPPROVALREQUESTS        : 'api/employees/approvals?status[]=Rejected&status[]=Canceled',
            CREATEDAPPROVALREQUESTS                 : 'api/employees/approvals?status=Created',
            APPROVEDAPPROVALREQUESTS                : 'api/employees/approvals?status=Approved',
            APPROVEENTRY                            : 'api/approvals@status',
            REJECTENTRY                             : 'api/approvals@status',
            APPROVERS                               : 'api/employees/approvers',
            PAYSLIPCURRENTEMPLOYEE                  : 'api/employees/payslip',
            CHANGEAPPLICATIONSTATUS                 : 'api/leave_applications@',
            PAYPERIODS                              : 'api/pay_periods',
            CANCELAPPLICATION                       : 'api/leave_applications@status',
            APPLICATIONDETAILS                      : 'api/leave_applications@approvals',
            DISABLEDDAYS                            : 'api/leave_applications/disabled_days'

            },
        searchResults : '',
        searchTerm : '',
        notificationsData : {}
    },
    methods : {
        isEmptyObject : function (object) {
            return (Object.keys(object).length === 0)
        },
        fullNames : function(nameOne, nameTwo, nameThree){
            nameOne     = nameOne === null ? '' : nameOne.trim()
            // nameTwo     = nameTwo === null? '' : nameTwo.trim()
            nameThree   = nameThree === null ? '' : nameThree.trim()
            return nameOne + /*' ' + nameTwo +*/ ' ' + nameThree
        },
        swapComponent: function (component) {

            if (component === 'new-leave'){
                this.openModal = true
                this.currentComponent = 'open-applications'
            }else if(component === 'approval-notice'){

            }else {
                this.openModal = false
                if (Vue.options.components[component]) {
                    this.currentComponent = component
                } else {
                    alert(component + ' component not found');
                }
            }
        },
        validateField : function (field) {
          return field.length !== 0
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

            this.userDetails.fullName =  this.fullNames(this.currentUserData.First_Name, this.currentUserData.Middle_Name, this.currentUserData.Last_Name)
            // this.userDetails.fullName = this.currentUserData.First_Name == null ? "": this.currentUserData.First_Name  +' '+ this.currentUserData.Middle_Name +' '+ this.currentUserData.Last_Name
            this.userDetails.profilePicture = this.getApiPath(this.APIENDPOINTS.PROFILEPICTURE, this.currentUserData.id)
            this.userDetails.id = this.currentUser.id
        },
        getData : function () {
            var v = this
            axios.get(this.getApiPath(v.APIENDPOINTS.CURRENTUSER,''))
                .then(function (response) {
                    v.currentUser = response.data.data

                    if (Object.keys(v.currentUser).length !== 0 ){
                        axios.get(v.getApiPath(v.APIENDPOINTS.CURRENTEMPLOYEE,v.currentUser.id))
                            .then(function (response) {
                                v.currentUserData = response.data.data

                                console.log(v.currentUserData)

                                v.setUserDetails()

                                if (Object.keys(v.currentUserData).length !== 0 ){
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
        ),

        notificationEvents : function (data) {
            // expects an object
            // data {
            //     component : '',
            //     id of entry : ''
            // }
            this.notificationsData = data
            this.swapComponent(data.component)
        },
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
