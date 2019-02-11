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
              <v-card-title primary-title>
                <div>
                  <h3 class="headline mb-0">Search</h3>
                </div>
              </v-card-title>

              <v-data-table
                :headers="headers"
                :items="desserts"
                class="elevation-1"
              >
                <template slot="items" slot-scope="props">
                  <td>{{ props.item.name }}</td>
                  <td class="text-xs-right">{{ props.item.calories }}</td>
                  <td class="text-xs-right">{{ props.item.fat }}</td>
                  <td class="text-xs-right">{{ props.item.carbs }}</td>
                  <td class="text-xs-right">{{ props.item.protein }}</td>
                  <td class="text-xs-right">{{ props.item.iron }}</td>
                </template>
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
        
      }
    }
  }
</script>
