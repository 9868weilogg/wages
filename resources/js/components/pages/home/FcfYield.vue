<template>
  <v-card>
    <v-card-title primary-title>
      <div>
        <h3 class="headline mb-0">Free Cash Flow Yield</h3>
      </div>
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="search"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
      <v-spacer></v-spacer>
      <v-btn color="primary" dark @click="expand = !expand">
        {{ expand ? 'Show' : 'Hide' }} FCF 
      </v-btn>
    </v-card-title>

    <v-data-table
      :loading="$store.state.fcfYieldLoading"
      :search="search"
      :headers="expand ? fcfYieldHeadersAll : fcfYieldHeaders"
      :items="this.$store.state.fcfYieldContent"
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <tr @click="getIntrinsicFairValue(props.item)">
          <td>{{ props.item.name }}</td>
          <td class="text-xs-right">{{ props.item.close }}</td>
          <td class="text-xs-right">{{ props.item.low52week }}</td>
          <td class="text-xs-right">{{ props.item.high52week }}</td>
          <td class="text-xs-right" :style="{backgroundColor: (props.item.close < props.item.buy_price ? '#b6f9f7' : 'transparent' ) }">{{ props.item.buy_price.toFixed(3) }}</td>
          <td v-show="expand" class="text-xs-right" :style="{backgroundColor: (props.item.y2018 > 5 ? '#8ee3c7' : 'transparent' ) }">{{ props.item.y2018 }}</td>
          <td v-show="expand" class="text-xs-right" :style="{backgroundColor: (props.item.y2017 > 5 ? '#8ee3c7' : 'transparent' ) }">{{ props.item.y2017 }}</td>
          <td v-show="expand" class="text-xs-right" :style="{backgroundColor: (props.item.y2016 > 5 ? '#8ee3c7' : 'transparent' ) }">{{ props.item.y2016 }}</td>
          <td v-show="expand" class="text-xs-right" :style="{backgroundColor: (props.item.y2015 > 5 ? '#8ee3c7' : 'transparent' ) }">{{ props.item.y2015 }}</td>
          <td v-show="expand" class="text-xs-right" :style="{backgroundColor: (props.item.y2014 > 5 ? '#8ee3c7' : 'transparent' ) }">{{ props.item.y2014 }}</td>
          <td v-show="expand" class="text-xs-right" :style="{backgroundColor: (props.item.y2013 > 5 ? '#8ee3c7' : 'transparent' ) }">{{ props.item.y2013 }}</td>
          <td v-show="expand" class="text-xs-right" :style="{backgroundColor: (props.item.y2012 > 5 ? '#8ee3c7' : 'transparent' ) }">{{ props.item.y2012 }}</td>
          <td v-show="expand" class="text-xs-right" :style="{backgroundColor: (props.item.y2011 > 5 ? '#8ee3c7' : 'transparent' ) }">{{ props.item.y2011 }}</td>
          <td v-show="expand" class="text-xs-right" :style="{backgroundColor: (props.item.y2010 > 5 ? '#8ee3c7' : 'transparent' ) }">{{ props.item.y2010 }}</td>
          <td v-show="expand" class="text-xs-right" :style="{backgroundColor: (props.item.y2009 > 5 ? '#8ee3c7' : 'transparent' ) }">{{ props.item.y2009 }}</td>
          <td v-show="expand" class="text-xs-right" :style="{backgroundColor: (props.item.y2008 > 5 ? '#8ee3c7' : 'transparent' ) }">{{ props.item.y2008 }}</td>
          <td class="text-xs-right">{{ props.item.pe.toFixed(3) }}</td>
          <td class="text-xs-right" :style="{backgroundColor: (props.item.roe > 15 ? '#6decac' : 'transparent' ) }">{{ props.item.roe.toFixed(3) }}</td>
          <td class="text-xs-right" :style="{backgroundColor: (props.item.net_profit_gr > 15 ? '#6495ed' : 'transparent' ) }">{{ props.item.net_profit_gr.toFixed(3) }}</td>
          <td class="text-xs-right" :style="{backgroundColor: (props.item.dy > 6 ? '#6decac' : props.item.dy > 4 ? '#FFFF00' : 'transparent' ) }">{{ props.item.dy.toFixed(3) }}</td>
        </tr>
      </template>
    </v-data-table>
  </v-card>
</template>

<script>
  export default {
    data () {
      return {
        expand: false,
        search: '',
        fcfYieldHeadersAll: [
          {
            text: 'Stock Name',
            align: 'left',
            sortable: false,
            value: 'name',
          },
          { text: 'Price (RM)', value: 'close' },
          { text: '52 Week Low (RM)', value: 'low52week' },
          { text: '52 Week High (RM)', value: 'high52week' },
          { text: 'Buy Price (RM)', value: 'buy_price' },
          { text: '2018', value: 'y2018' },
          { text: '2017', value: 'y2017' },
          { text: '2016', value: 'y2016' },
          { text: '2015', value: 'y2015' },
          { text: '2014', value: 'y2014' },
          { text: '2013', value: 'y2013' },
          { text: '2012', value: 'y2012' },
          { text: '2011', value: 'y2011' },
          { text: '2010', value: 'y2010' },
          { text: '2009', value: 'y2009' },
          { text: '2008', value: 'y2008' },
          { text: 'PE', value: 'pe' },
          { text: 'ROE', value: 'roe' },
          { text: 'Net Profit GR (%)', value: 'net_profit_gr' },
          { text: 'Dividend Yield (%)', value: 'dy' },
        ],
        fcfYieldHeaders: [
          {
            text: 'Stock Name',
            align: 'left',
            sortable: false,
            value: 'name',
          },
          { text: 'Price (RM)', value: 'close' },
          { text: '52 Week Low (RM)', value: 'low52week' },
          { text: '52 Week High (RM)', value: 'high52week' },
          { text: 'Buy Price (RM)', value: 'buy_price' },
          { text: 'PE', value: 'pe' },
          { text: 'ROE', value: 'roe' },
          { text: 'Net Profit GR (%)', value: 'net_profit_gr' },
          { text: 'Dividend Yield (%)', value: 'dy' },
        ],
      }
    },
    created () {
    }, 
    methods: {
      getIntrinsicFairValue(item) {
        this.$store.state.intrinsicValue = this.$store.getters.getStockIntrinsicFairValue(item.code).filter(value => value.type === "intrinsic")
        this.$store.state.fairValue = this.$store.getters.getStockIntrinsicFairValue(item.code).filter(value => value.type === "fair")
      }
      
    }
  }
</script>