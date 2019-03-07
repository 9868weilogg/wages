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
      <v-btn color="primary" dark>
      <!-- <v-btn color="primary" dark @click="getFundamental"> -->
        Load 
      </v-btn>
      <v-btn color="primary" dark @click="expand = !expand">
        {{ expand ? 'Show' : 'Hide' }} FCF 
      </v-btn>
    </v-card-title>

    <v-data-table
      :loading="$store.state.fcfYieldLoading"
      :search="search"
      :headers="expand ? fcfYieldHeadersAll : fcfYieldHeaders"
      :items="$store.state.fcfYieldContent"
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.name }}</td>
        <td class="text-xs-right">{{ props.item.close }}</td>
        <td class="text-xs-right">{{ props.item.low52week }}</td>
        <td class="text-xs-right">{{ props.item.high52week }}</td>
        <td class="text-xs-right" :style="{backgroundColor: (props.item.close < props.item.buy_price ? '#b6f9f7' : 'transparent' ) }">{{ props.item.buy_price }}</td>
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
        <td class="text-xs-right">{{ props.item.pe }}</td>
        <td class="text-xs-right" :style="{backgroundColor: (props.item.roe > 15 ? '#6decac' : 'transparent' ) }">{{ props.item.roe }}</td>
        <td class="text-xs-right" :style="{backgroundColor: (props.item.net_profit_gr > 15 ? '#6495ed' : 'transparent' ) }">{{ props.item.net_profit_gr }}</td>
        <td class="text-xs-right" :style="{backgroundColor: (props.item.dy > 6 ? '#6decac' : props.item.dy > 4 ? '#FFFF00' : 'transparent' ) }">{{ props.item.dy }}</td>
      </template>
    </v-data-table>
  </v-card>
</template>

<script>
  export default {
    data () {
      return {
        expand: false,
        loading: false,
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
        fcfYieldContent: [],
      }
    },
    created () {
    }, 
    methods: {
      // getFundamentalAvg(fundamentals, fundamentals2017, currentValue, fundamentalArray, avgArray, reducer) {
      //   let companyFundamentals = fundamentals.filter(fundamental => fundamental.code == fundamentals2017[i].code)
      //   companyFundamentals.forEach(function(currentValue){
      //     fundamentalArray.pe.push(parseFloat(currentValue['pe']))
      //     fundamentalArray.roe.push(parseFloat(currentValue['roe']))
      //     fundamentalArray.netProfitGR.push(parseFloat(currentValue['net_profit_gr']))
      //     fundamentalArray.dy.push(parseFloat(currentValue['dy']))
      //   })
      //   avgArray.pe = fundamentalArray.pe.reduce(reducer)/fundamentalArray.pe.length
      //   avgArray.roe = fundamentalArray.roe.reduce(reducer)/fundamentalArray.roe.length
      //   avgArray.netProfitGR = fundamentalArray.netProfitGR.reduce(reducer)/fundamentalArray.netProfitGR.length
      //   avgArray.dy = fundamentalArray.dy.reduce(reducer)/fundamentalArray.dy.length
      // },

      // get52HighLow(eods, currentValue, eodArray) {
      //   let companyEods = eods.filter(eod => eod.code == fundamentals2017[i].code)
      //   companyEods.forEach(function(currentValue){
      //     eodArray.close.push(parseFloat(currentValue['close']))
      //     // eodArray.createdDates.push(Date(currentValue['created_at']))
          
      //   })
      //   eodArray.high52week = Math.max.apply(Math,eodArray.close)
      //   eodArray.low52week = Math.min.apply(Math,eodArray.close)
      // },
      
      // calculateFcfYield(companyFundamentals, fcfYieldCalculation, avgArray, eodArray) {
      //   if(companyFundamentals[0].eps == 0) {
      //     fcfYieldCalculation.total10YrEps = companyFundamentals[1].eps / 100 * Math.pow(1.1,10)
      //   } else {
      //     fcfYieldCalculation.total10YrEps = companyFundamentals[0].eps / 100 * Math.pow(1.1,10)
      //   }
      //   fcfYieldCalculation.total10YrDps = fcfYieldCalculation.total10YrEps * avgArray.dy / 100
      //   fcfYieldCalculation.total10YrReturn = fcfYieldCalculation.total10YrEps + fcfYieldCalculation.total10YrDps
      //   fcfYieldCalculation.estimatePrice = fcfYieldCalculation.total10YrEps * avgArray.pe
      //   fcfYieldCalculation.intrinsicValue = fcfYieldCalculation.estimatePrice / Math.pow(1.1,10)
      //   fcfYieldCalculation.intrinsic_25_discount = fcfYieldCalculation.intrinsicValue * 0.75
      //   fcfYieldCalculation.low52week_33_premium = ((eodArray.high52week - eodArray.low52week) * 0.33) + eodArray.low52week
      //   fcfYieldCalculation.buy_price = Math.min(fcfYieldCalculation.intrinsic_25_discount, fcfYieldCalculation.low52week_33_premium)
      // },

      // defineObjects (){
      //   let fundamentalArray = {
      //     pe: [],
      //     roe: [],
      //     netProfitGR: [],
      //     dy: [],
      //   }

      //   let avgArray = {
      //     pe: 0,
      //     roe: 0,
      //     netProfitGR: 0,
      //     dy: 0,
      //   }

      //   let eodArray = {
      //     close: [],
      //     high52week: 0,
      //     low52week: 0,

      //   }

      //   let fcfYieldCalculation = {
      //     total10YrEps: 0,
      //     total10YrDps: 0,
      //     total10YrReturn: 0,
      //     estimatePrice: 0,
      //     intrinsicValue: 0,
      //     intrinsic_25_discount: 0,
      //     low52week_33_premium: 0,
      //     buy_price: 0,
      //   }
      // },

      // getFundamental(){
      //   let fundamentals = this.$store.state.fDataContent
      //   let stocks = this.$store.state.stocks
      //   let eods = this.$store.state.eods

      //   let fundamentals2017 = fundamentals.filter(year => year.fye == "2017")
      //   let fcfYield = []
        
      //   const reducer = (accumulator, currentValue) => accumulator + currentValue;

      //   for (var i=0; i<fundamentals2017.length; i++ ){

      //     this.defineObjects()
      //     this.getFundamentalAvg(fundamentals, fundamentals2017, currentValue, fundamentalArray, avgArray, reducer)
      //     this.get52HighLow(eods, currentValue, eodArray)
      //     this.calculateFcfYield(companyFundamentals, fcfYieldCalculation, avgArray, eodArray)

      //     fcfYield.push({ 
      //       'name': stocks.find(stock => stock.code == fundamentals2017[i].code).name,
      //       'buy_price': fcfYieldCalculation.buy_price,
      //       'close': eodArray.close[0],
      //       'low52week': eodArray.low52week,
      //       'high52week': eodArray.high52week,
      //       'pe': avgArray.pe,
      //       'roe': avgArray.roe,
      //       'net_profit_gr': avgArray.netProfitGR,
      //       'dy': avgArray.dy,
      //       'code': fundamentals2017[i].code,
      //     })
      //   }

      //     console.log(fcfYield)          
      //   this.$store.state.fcfYieldContent = fcfYield
      // }
      
    }
  }
</script>