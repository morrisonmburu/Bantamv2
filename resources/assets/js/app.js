
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
Vue.component('search-results', require('./components/dashboard/search-results'));

const app = new Vue({
    el: '#app',
    data: {
        currentComponent: 'dashboard',
        currentUser      : {},
        currentUserData  : {},
        APIENDPOINTS     : {
            CURRENTUSER            : 'api/users/current',                   // Current logged in user
            CURRENTEMPLOYEE        : 'api/users@employee',                 // employee details
            SEARCH                 : 'https://yesno.wtf/api'
        },
        searchResults : '',
        searchTerm : ''
    },
    methods : {
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
        getData : function () {
            var v = this
            axios.get(this.getApiPath(v.APIENDPOINTS.CURRENTUSER,''))
                .then(function (response) {
                    v.currentUser = response.data.data

                    if (Object.keys(v.currentUser).length !== 0 ){
                        axios.get(v.getApiPath(v.APIENDPOINTS.CURRENTEMPLOYEE,v.currentUser.id))
                            .then(function (response) {
                                v.currentUserData = response.data.data
                            })
                            .catch(function (error) {
                                console.log(error)
                            })
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
