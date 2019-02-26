<template>
  <v-app>
    <v-content>
      <v-container fluid>
        <v-layout row wrap>
          <v-flex xs12 sm6 pa-4>
            <watchlist-component></watchlist-component>
          </v-flex>
          <v-flex xs12 sm6 pa-4>
            <search-stock></search-stock>
          </v-flex>
        </v-layout>
        <v-layout>
          <v-flex xs12 sm12 pa-4>
            <fundamental-data></fundamental-data>
          </v-flex>
        </v-layout>
        <v-layout>
          <v-flex xs12 sm12 pa-4>
            <fcf-yield></fcf-yield>
          </v-flex>
        </v-layout>
        <v-layout>
          <v-flex xs12 sm6 pa-4>
            <intrinsic-value></intrinsic-value>
          </v-flex>
          <v-flex xs12 sm6 pa-4>
            <fair-value></fair-value>
          </v-flex>
        </v-layout>
        <v-layout>
          <v-flex xs12 sm4 pa-3>
            <fundamental-analysis></fundamental-analysis>
          </v-flex>
          <v-flex xs12 sm4 pa-3>
            <buffett-approach></buffett-approach>
          </v-flex>
          <v-flex xs12 sm4 pa-3>
            <fisher-approach></fisher-approach>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
  import WatchlistComponent from './WatchlistComponent.vue'
  import FundamentalData from './FundamentalData.vue'
  import IntrinsicValue from './IntrinsicValue.vue'
  import FairValue from './FairValue.vue'
  import BuffettApproach from './BuffettApproach.vue'
  import FisherApproach from './FisherApproach.vue'
  import FundamentalAnalysis from './FundamentalAnalysis.vue'
  import FcfYield from './FcfYield.vue'
  import SearchStock from './SearchStock.vue'

  export default {
    components: { 
      WatchlistComponent, 
      FundamentalData, 
      IntrinsicValue, 
      FairValue,
      BuffettApproach,
      FisherApproach,
      FundamentalAnalysis,
      FcfYield,
      SearchStock,
    },
    data () {
      return {
        search: '',
        headers: [
          {
            text: 'Stock Code',
            align: 'left',
            sortable: false,
            value: 'code'
          },
          { text: 'Name', value: 'name' },
          { text: '', value: '' }
        ],
        stocks: [],
      }
    },
    created (){
      this.getStocks();
    },
    methods: {
      getStocks(){
        axios({
          url: '/api/stocks',
          method: 'get',
        })
        .then(response => {
          // console.log(response.data.data);
          this.stocks = response.data.data;
        })
        .catch(error => console.log(error.response));
      }
    }
  }
</script>
