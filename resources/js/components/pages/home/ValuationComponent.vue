<template>
  <v-app>
    <v-content>
      <v-container fluid>
        <v-layout row wrap>
          <v-flex xs12 sm6 pa-4>
            <watchlist-component></watchlist-component>
          </v-flex>
          <v-flex xs12 sm6 pa-4>
            <v-card>
              <v-card-title>
                <div>
                  <h3 class="headline mb-0">Search</h3>
                </div>
                <v-spacer></v-spacer>
                <v-text-field
                  v-model="search"
                  append-icon="search"
                  label="Search"
                  single-line
                  hide-details
                ></v-text-field>
              </v-card-title>
              <v-data-table
                :headers="headers"
                :items="stocks"
                :search="search"
              >
                <template slot="items" slot-scope="props">
                  <td>{{ props.item.code }}</td>
                  <td class="text-xs-right">{{ props.item.short_name }}</td>
                </template>
                <v-alert slot="no-results" :value="true" color="error" icon="warning">
                  Your search for "{{ search }}" found no results.
                </v-alert>
              </v-data-table>
            </v-card>
          </v-flex>
        </v-layout>
        <v-layout>
          <v-flex xs12 sm12 pa-4>
            <fundamental-data></fundamental-data>
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
        <intrinsic-fair-value></intrinsic-fair-value>
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

  export default {
    components: { 
      WatchlistComponent, 
      FundamentalData, 
      IntrinsicValue, 
      FairValue,
      BuffettApproach,
      FisherApproach,
      FundamentalAnalysis,
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
          { text: 'Name', value: 'name' }
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
          // data: _formData,
          // headers: {
          //   'Content-Type': 'multipart/form-data'
          // }
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
