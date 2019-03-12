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
      }
    },
    created() {
      this.getStocks();
      this.getWatchlists();
      this.getWatchlistItems();
      this.getFundamental();
      this.getEods();
    },
    methods: {
      getStocks(){
        axios({
          url: '/api/stocks',
          method: 'get',
        })
        .then(response => {
          // console.log(response.data.data);
          // this.stocks = response.data.data;
          this.$store.state.stocks = response.data.data;
          // console.log(this.$store.state.stocks);
          this.$store.state.searchLoading = false;
        })
        .catch(error => console.log(error.response));
      },
      getWatchlists(){
        axios({
          url: '/api/watchlists',
          method: 'get',
        })
        .then(response => {
          // console.log(response.data);
          this.$store.state.watchlists = response.data.data;
          this.$store.state.watchlistLoading = false;
        })
        .catch(error => console.log(error.response));
      },
      getWatchlistItems(){
        axios({
          url: '/api/watchlist-items',
          method: 'get',
          params: {
            'watchlist_id' : 1,
            'get' : "watchlist_item",
          }
        })
        .then(response => {
          // this.watchlistItems = response.data.data;
          this.$store.state.watchlistItems = response.data.data;
          // console.log(this.$store.state.watchlistItems);

        })
        .catch(error => console.log(error.response));
      },
      getFundamental(){
        axios({
          url: '/api/fundamentals',
          method: 'get',
          // data: _formData,
          // headers: {
          //   'Content-Type': 'multipart/form-data'
          // }
        })
        .then(response => {
          // console.log(response.data.data);
          this.$store.state.fDataContent = response.data.data;
          this.$store.state.fundamentalLoading = false;
        })
        .catch(error => console.log(error.response));
      },
      getEods() {
        axios({
          url: '/api/stock-prices',
          method: 'get',
        })
        .then(response => {
          // console.log(response);
          this.$store.state.eods = response.data.data;
          this.getFcfYield();
          // console.log(this.$store.state.eods);
        })
        .catch(error => console.log(error.response));
      },

      getFcfYield(){
        Array.prototype.groupBy = function(prop) {
          return this.reduce(function(groups, item) {
            const val = item[prop]
            groups[val] = groups[val] || []
            groups[val].push(item)
            return groups
          }, {})
        }

        let fundamentals = this.$store.state.fDataContent
        let stocks = this.$store.state.stocks
        let eods = this.$store.state.eods

        let fundamentals2017 = fundamentals.filter(year => year.fye == "2017")
        let fyes = Object.keys(fundamentals.groupBy('fye'))
        let fcfYield = []
        let key = ""
        
        const reducer = (accumulator, currentValue) => accumulator + currentValue;

        for (let i=0; i<fundamentals2017.length; i++ ){
          
          let fundamentalArray = {
            pe: [],
            roe: [],
            netProfitGR: [],
            dy: [],
          }

          let avgArray = {
            pe: 0,
            roe: 0,
            netProfitGR: 0,
            dy: 0,
          }

          let eodArray = {
            close: [],
            high52week: 0,
            low52week: 0,

          }

          let fcfYieldCalculation = {
            total10YrEps: 0,
            total10YrDps: 0,
            total10YrReturn: 0,
            estimatePrice: 0,
            intrinsicValue: 0,
            intrinsic_25_discount: 0,
            low52week_33_premium: 0,
            buy_price: 0,
            fcf: 0,
            marketCap: 0,
            enterpriceValue: 0,
            fcfy: 0,
          }

          let companyFundamentals = fundamentals.filter(fundamental => fundamental.code == fundamentals2017[i].code)

          companyFundamentals.forEach(function(currentValue){
            fundamentalArray.pe.push(parseFloat(currentValue['pe']))
            fundamentalArray.roe.push(parseFloat(currentValue['roe']))
            fundamentalArray.netProfitGR.push(parseFloat(currentValue['net_profit_gr']))
            fundamentalArray.dy.push(parseFloat(currentValue['dy']))
          })
          avgArray.pe = fundamentalArray.pe.reduce(reducer)/fundamentalArray.pe.length
          avgArray.roe = fundamentalArray.roe.reduce(reducer)/fundamentalArray.roe.length
          avgArray.netProfitGR = fundamentalArray.netProfitGR.reduce(reducer)/fundamentalArray.netProfitGR.length
          avgArray.dy = fundamentalArray.dy.reduce(reducer)/fundamentalArray.dy.length

          let companyEods = eods.filter(eod => eod.code == fundamentals2017[i].code)
          companyEods.forEach(function(currentValue){
            eodArray.close.push(parseFloat(currentValue['close']))
          })
          eodArray.high52week = Math.max.apply(Math,eodArray.close)
          eodArray.low52week = Math.min.apply(Math,eodArray.close)

          if(companyFundamentals[0].eps == 0) {
            fcfYieldCalculation.total10YrEps = companyFundamentals[1].eps / 100 * Math.pow(1.1,10)
          } else {
            fcfYieldCalculation.total10YrEps = companyFundamentals[0].eps / 100 * Math.pow(1.1,10)
          }
          fcfYieldCalculation.total10YrDps = fcfYieldCalculation.total10YrEps * avgArray.dy / 100
          fcfYieldCalculation.total10YrReturn = fcfYieldCalculation.total10YrEps + fcfYieldCalculation.total10YrDps
          fcfYieldCalculation.estimatePrice = fcfYieldCalculation.total10YrEps * avgArray.pe
          fcfYieldCalculation.intrinsicValue = fcfYieldCalculation.estimatePrice / Math.pow(1.1,10)
          fcfYieldCalculation.intrinsic_25_discount = fcfYieldCalculation.intrinsicValue * 0.75
          fcfYieldCalculation.low52week_33_premium = ((eodArray.high52week - eodArray.low52week) * 0.33) + eodArray.low52week
          fcfYieldCalculation.buy_price = Math.min(fcfYieldCalculation.intrinsic_25_discount, fcfYieldCalculation.low52week_33_premium)

          

          fcfYield.push({ 
            'name': stocks.find(stock => stock.code == fundamentals2017[i].code).name,
            'buy_price': fcfYieldCalculation.buy_price,
            'close': eodArray.close[0],
            'low52week': eodArray.low52week,
            'high52week': eodArray.high52week,
            'pe': avgArray.pe,
            'roe': avgArray.roe,
            'net_profit_gr': avgArray.netProfitGR,
            'dy': avgArray.dy,
            'code': fundamentals2017[i].code,
          })

          for(let j=0; j<fyes.length; j++) {
            let fundamentalByFye = companyFundamentals.filter(fundamental => fundamental.fye == fyes[j])
            key = "y" + fyes[j]

            if(fundamentalByFye[0].fcf_share != 0){
              fcfYieldCalculation.fcf = fundamentalByFye[0].fcf_share * fundamentalByFye[0].share_qty
              fcfYieldCalculation.marketCap = eodArray.close[0] * fundamentalByFye[0].share_qty
              fcfYieldCalculation.enterpriceValue = fcfYieldCalculation.marketCap + fundamentalByFye[0].short_term_loan + fundamentalByFye[0].long_term_loan - fundamentalByFye[0].total_cash
              fcfYield[i][key] = (fcfYieldCalculation.fcf / fcfYieldCalculation.enterpriceValue * 100).toFixed(2)
            } else if(fundamentalByFye[0].fcf_share == 0){
              fcfYield[i][key] = 0
            }
          }
        }

          // console.log(fcfYield)          
        this.$store.state.fcfYieldContent = fcfYield
        this.$store.state.fcfYieldLoading = false
      },
    }
  }
</script>
