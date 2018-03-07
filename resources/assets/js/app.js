
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

const app = new Vue({
    el: '#app',
    data: {
        currentComponent: 'dashboard'
    },
    methods : {
        swapComponent : function (component) {
           if (Vue.options.components[component]){
               this.currentComponent = component
           }else {
               alert(component + ' component not found');
           }
        }
    }
});
