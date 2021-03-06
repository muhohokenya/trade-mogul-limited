/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import VueSweetalert2 from 'vue-sweetalert2';

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';
import Notifications from 'vue-notification'


window.Vue = require('vue').default;
// window.base_url = "http://localhost/trade_mogul/public/api/"
window.base_url = "http://solutech.covid-19.co.ke/api/"


Vue.use(VueSweetalert2);
Vue.use(Notifications);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('depots', require('./components/Depots/Depots').default);
Vue.component('vehicles', require('./components/Vehicles/Vehicles').default);
Vue.component('orders', require('./components/Orders/Orders').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
});

