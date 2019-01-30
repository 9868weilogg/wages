
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'
import Vuetify from 'vuetify'
// index.js or main.js
import 'vuetify/dist/vuetify.min.css' // Ensure you are using css-loader
import 'font-awesome/css/font-awesome.min.css' // Ensure you are using css-loader

Vue.use(Vuetify)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.component('app-component', require('./components/AppComponent.vue').default);
Vue.component('valuation-component', require('./components/valuations/ValuationComponent.vue').default);
Vue.component('watchlist-component', require('./components/valuations/WatchlistComponent.vue').default);
Vue.component('fundamental-data', require('./components/valuations/FundamentalData.vue').default);
Vue.component('intrinsic-value', require('./components/valuations/IntrinsicValue.vue').default);
Vue.component('fair-value', require('./components/valuations/FairValue.vue').default);
Vue.component('buffett-approach', require('./components/valuations/BuffettApproach.vue').default);
Vue.component('fisher-approach', require('./components/valuations/FisherApproach.vue').default);
Vue.component('fundamental-analysis', require('./components/valuations/FundamentalAnalysis.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
