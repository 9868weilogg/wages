<template>
  <v-app>
    <v-content>
      <v-container fluid>
        <v-layout row wrap>
          <v-flex xs12 sm6 pa-4>
            <upload-card v-bind:card_detail="stock_upload"></upload-card>
          </v-flex>
          <v-flex xs12 sm6 pa-4>
            <upload-card v-bind:card_detail="sector_industry_upload"></upload-card>
          </v-flex>
          <v-flex xs12 sm6 pa-4>
            <upload-card v-bind:card_detail="fundamental_data_upload"></upload-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
  import UploadCard from './UploadCard.vue';

  export default {
    components: { 
      UploadCard
    },
    data () {
      return {
        stock_upload: {
          'title' : 'Stock Upload',
          'ref' : 'stockList',
          'type' : 'single',
          'document' : 'stockList'
        },
        sector_industry_upload : {
          'title' : 'Sector/Industry Code Upload',
          'ref' : 'sectorIndustryCode',
          'type' : 'single',
          'document' : 'sectorIndustryCode'
        },
        fundamental_data_upload : {
          'title' : 'Fundamental Data Upload',
          'ref' : 'fundamentalData',
          'type' : 'multiple',
          'document' : 'fundamentalData'
        },
      }
    },
  }
</script>
