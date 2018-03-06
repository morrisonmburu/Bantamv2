
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('side-nav-header', require('./components/dashboard/side-nav-header.vue'));

const app = new Vue({
    el: '#app',
    data: {
        fullNames   : 'Test Name',
        user : {}

    },
    computed: {
        initUser : function () {
            this.CurrentUser
            this.fetchUserData

        },



    },
    methods: {
        CurrentUser : function () {

        },
        fetchUserData : function () {
            var vm = this
            axios.get('api/users/1')
                .then(function (response) {

                })
        }
    },

});
