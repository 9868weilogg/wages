
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
import { mapGetters, mapMutations } from 'vuex';

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
      intrinsicFairValue: [],
      intrinsicValue: [],
      fairValue: [],
      selectedStock: {},
      buffettApproach: [
        {
          key: 'Business Sexines',
          value: '-',
          shortKey: '',
          watchlist_item_id: '',
        },
        {
          key: 'Supplier No.',
          value: '-',
          shortKey: '',
          watchlist_item_id: '',
        },
        {
          key: 'Customer Choices',
          value: '-',
          shortKey: '',
          watchlist_item_id: '',
        },
        {
          key: 'Entry Barrier',
          value: '-',
          shortKey: '',
          watchlist_item_id: '',
        },
        {
          key: 'Substitute',
          value: '-',
          shortKey: '',
          watchlist_item_id: '',
        },
        {
          key: 'Competition No.',
          value: '-',
          shortKey: '',
          watchlist_item_id: '',
        },
        {
          key: 'Competitiveness',
          value: '-',
          shortKey: '',
          watchlist_item_id: '',
        },
        {
          key: 'FPE < 25',
          value: '-',
          shortKey: '',
          watchlist_item_id: '',
        },
        {
          key: 'Gearing < 1.5',
          value: '-',
          shortKey: '',
          watchlist_item_id: '',
        },
        {
          key: 'GP Cashflow > 0.88',
          value: '-',
          shortKey: '',
          watchlist_item_id: '',
        },
        {
          key: 'Good Will',
          value: '-',
          shortKey: '',
          watchlist_item_id: '',
        },
        {
          key: 'Customer Loyalty',
          value: '-',
          shortKey: '',
          watchlist_item_id: '',
        },
      ],
      fisherApproach: [
        {
          key: 'Future Grow',
          value: '-',
          shortKey: '',
          watchlist_item_id: '',
        },
        {
          key: 'Competitiveness',
          value: '-',
          shortKey: '',
          watchlist_item_id: '',
        },
        {
          key: 'Net Margin > 15%',
          value: '-',
          shortKey: '',
          watchlist_item_id: '',
        },
        {
          key: 'GP Cashflow > 0.88',
          value: '-',
          shortKey: '',
          watchlist_item_id: '',
        },
        {
          key: 'Marginal Cost (R&D Important)',
          value: '-',
          shortKey: '',
          watchlist_item_id: '',
        },
        {
          key: 'Leadership',
          value: '-',
          shortKey: '',
          watchlist_item_id: '',
        },
        {
          key: 'Talent',
          value: '-',
          shortKey: '',
          watchlist_item_id: '',
        },
        
      ],

    },
    getters: {
      getStockIntrinsicFairValue: (state) => (code) => {
        return state.intrinsicFairValue.filter(value => value.code === code)
      },
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
      checkIfWatchlistItem(state, watchlistItem) {
        const createGisRank = (watchlistItem) => {
          axios({
            url: '/api/gis-ranks',
            method: 'post',
            data: {
              'watchlist_item_id' : watchlistItem.id,
              'code' : watchlistItem.code,
            }
          })
          .then(response => {
            // console.log(response);
          })
          .catch(error => console.log(error.response));
        }

        const insertGisRankMark = (response) => {
          axios({
            url: '/api/gis-ranks/' + response.data.id,
            method: 'get',
          })
          .then(response => {
            // console.log(response.data);
            let gisRank = response.data
            store.state.buffettApproach = [
              {
                key: 'Business Sexines',
                value: gisRank.ba1,
                shortKey: 'ba1',
                watchlist_item_id: gisRank.watchlist_item_id,
              },
              {
                key: 'Supplier No.',
                value: gisRank.ba1_1,
                shortKey: 'ba1_1',
                watchlist_item_id: gisRank.watchlist_item_id,
              },
              {
                key: 'Customer Choices',
                value: gisRank.ba1_2,
                shortKey: 'ba1_2',
                watchlist_item_id: gisRank.watchlist_item_id,
              },
              {
                key: 'Entry Barrier',
                value: gisRank.ba1_3,
                shortKey: 'ba1_3',
                watchlist_item_id: gisRank.watchlist_item_id,
              },
              {
                key: 'Substitute',
                shortKey: 'ba1_4',
                value: gisRank.ba1_4,
                watchlist_item_id: gisRank.watchlist_item_id,
              },
              {
                key: 'Competition No.',
                value: gisRank.ba1_5,
                shortKey: 'ba1_5',
                watchlist_item_id: gisRank.watchlist_item_id,
              },
              {
                key: 'Competitiveness',
                value: gisRank.ba2,
                shortKey: 'ba2',
                watchlist_item_id: gisRank.watchlist_item_id,
              },
              {
                key: 'FPE < 25',
                value: gisRank.ba3,
                shortKey: 'ba3',
                watchlist_item_id: gisRank.watchlist_item_id,
              },
              {
                key: 'Gearing < 1.5',
                value: gisRank.ba4,
                shortKey: 'ba4',
                watchlist_item_id: gisRank.watchlist_item_id,
              },
              {
                key: 'GP Cashflow > 0.88',
                value: gisRank.ba5,
                shortKey: 'ba5',
                watchlist_item_id: gisRank.watchlist_item_id,
              },
              {
                key: 'Good Will',
                value: gisRank.ba6,
                shortKey: 'ba6',
                watchlist_item_id: gisRank.watchlist_item_id,
              },
              {
                key: 'Customer Loyalty',
                value: gisRank.ba7,
                shortKey: 'ba7',
                watchlist_item_id: gisRank.watchlist_item_id,
              },
            ]

            store.state.fisherApproach = [
              {
                key: 'Future Grow',
                value: gisRank.fa1,
                shortKey: 'fa1',
                watchlist_item_id: gisRank.watchlist_item_id,
              },
              {
                key: 'Competitiveness',
                value: gisRank.fa2,
                shortKey: 'fa2',
                watchlist_item_id: gisRank.watchlist_item_id,
              },
              {
                key: 'Net Margin > 15%',
                value: gisRank.fa3,
                shortKey: 'fa3',
                watchlist_item_id: gisRank.watchlist_item_id,
              },
              {
                key: 'GP Cashflow > 0.88',
                value: gisRank.fa4,
                shortKey: 'fa4',
                watchlist_item_id: gisRank.watchlist_item_id,
              },
              {
                key: 'Marginal Cost (R&D Important)',
                value: gisRank.fa5,
                shortKey: 'fa5',
                watchlist_item_id: gisRank.watchlist_item_id,
              },
              {
                key: 'Leadership',
                value: gisRank.fa6,
                shortKey: 'fa6',
                watchlist_item_id: gisRank.watchlist_item_id,
              },
              {
                key: 'Talent',
                value: gisRank.fa7,
                shortKey: 'fa7',
                watchlist_item_id: gisRank.watchlist_item_id,
              },
            ]
          })
          .catch(error => console.log(error.response));
        }

        axios({
          url: '/api/gis-ranks',
          method: 'get',
          params: {
            'watchlist_item_id' : watchlistItem.id,
            'get' : "checkIfExist",
          }
        })
        .then(response => {
          // console.log(response);
          if(response.data == false) {
            createGisRank(watchlistItem)
          } else {
            // console.log(response.data)
            insertGisRankMark(response) 
          }
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
      'checkIfWatchlistItem',
    ]),
    computed: mapGetters([
      'getStockIntrinsicFairValue',
    ]),
});

