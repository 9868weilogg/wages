
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'
import Vuetify from 'vuetify'
import Vuex from 'vuex'

// index.js or main.js
import 'vuetify/dist/vuetify.min.css' // Ensure you are using css-loader
import 'font-awesome/css/font-awesome.min.css' // Ensure you are using css-loader
import { mapState, mapMutations } from 'vuex';

Vue.use(Vuetify)
Vue.use(Vuex)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.component('home-page', require('./components/pages/home/HomePage.vue').default);
Vue.component('valuation-page', require('./components/pages/valuations/ValuationPage.vue').default);
Vue.component('admin-page', require('./components/pages/admins/AdminPage.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 const store = new Vuex.Store({
    state: {
      // table loading
      searchLoading: true,
      watchlistLoading: true,
      fundamentalLoading: true,
      fcfYieldLoading: true,

      // table data
      stocks: [],
      watchlistItems: [],
      watchlists: [],
      fDataContent: [],
      eods: [],
      fcfYieldContent: [],

    },
    mutations: {
      addWatchlistItem(state, editedItem) {
        axios({
          url: '/api/watchlist-items',
          method: 'post',
          data: {
            'stockCode' : editedItem.stockCode,
            'watchlistId' : editedItem.watchlistId,
          }
        })
        .then(response => {
          // console.log(response);
          store.commit('getWatchlistItems')

        })
        .catch(error => console.log(error.response));
      },
      getWatchlistItems(state){
        axios({
          url: '/api/watchlist-items',
          method: 'get',
          params: {
            'watchlist_id' : 1,
            'get' : "watchlist_item",
          }
        })
        .then(response => {
          state.watchlistItems = response.data.data;
          // console.log(state.watchlistItems);

        })
        .catch(error => console.log(error.response));
      },
    },

});


const app = new Vue({
    el: '#app',
    store,
    methods: mapMutations([
      'addWatchlistItem',
      'getWatchlistItems',
    ])
});

