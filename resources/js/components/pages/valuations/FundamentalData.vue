<template>
  <v-card>
    <v-card-title primary-title>
      <div>
        <h3 class="headline mb-0">Fundamental Data</h3>
      </div>
    </v-card-title>

    <v-data-table
      :headers="fDataHeaders"
      :items="fDataContent"
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.fye }}</td>
        <td class="text-xs-right">{{ props.item.stock }}</td>
        <td class="text-xs-right">{{ props.item.pe_bv }}</td>
        <td class="text-xs-right">{{ props.item.dividend }}</td>
        <td class="text-xs-right">{{ props.item.eps }}</td>
        <td class="text-xs-right">{{ props.item.net_profit_gr }}</td>
        <td class="text-xs-right">{{ props.item.revenue }}</td>
        <td class="text-xs-right">{{ props.item.cash }}</td>
        <td class="text-xs-right">{{ props.item.loan }}</td>
        <td class="text-xs-right">{{ props.item.gearing }}</td>
        <td class="text-xs-right">{{ props.item.fcf }}</td>
        <td class="text-xs-right">{{ props.item.gp_cash }}</td>
        <td class="text-xs-right">{{ props.item.net_margin }}</td>
        <td class="text-xs-right">{{ props.item.roe }}</td>
        <td class="text-xs-right">{{ props.item.roa }}</td>
        <td class="text-xs-right">{{ props.item.asset_turnover }}</td>
      </template>
    </v-data-table>
  </v-card>
</template>

<script>
  export default {
    data () {
      return {
        
        fDataHeaders: [
          {
            text: 'FYE',
            align: 'left',
            sortable: false,
            value: 'fye'
          },
          { text: 'Stock', value: 'stock' },
          { text: 'PE/ Book Value', value: 'pe_bv' },
          { text: 'Dividend', value: 'dividend' },
          { text: 'EPS', value: 'eps' },
          { text: 'Net Profit GR', value: 'net_profit_gr' },
          { text: 'Revenue', value: 'revenue' },
          { text: 'Cash', value: 'cash' },
          { text: 'Loan', value: 'loan' },
          { text: 'Gearing', value: 'gearing' },
          { text: 'FCF', value: 'fcf' },
          { text: 'GP Cashflow', value: 'gp_cash' },
          { text: 'Net Margin', value: 'net_margin' },
          { text: 'ROE', value: 'roe' },
          { text: 'ROA', value: 'roa' },
          { text: 'Asset Turnover', value: 'asset_turnover' }
        ],
        fDataContent: [
          {
            fye: '1',
            stock: 159,
            pe_bv: 159,
            dividend: 159,
            eps: 159,
            net_profit_gr: 159,
            revenue: 159,
            cash: 159,
            loan: 159,
            gearing: 159,
            fcf: 159,
            gp_cash: 159,
            net_margin: 159,
            roe: 159,
            roa: 159,
            asset_turnover: 159
          },
          {
            fye: '1',
            stock: 159,
            pe_bv: 159,
            dividend: 159,
            eps: 159,
            net_profit_gr: 159,
            revenue: 159,
            cash: 159,
            loan: 159,
            gearing: 159,
            fcf: 159,
            gp_cash: 159,
            net_margin: 159,
            roe: 159,
            roa: 159,
            asset_turnover: 159
          } 
        ]
      }
    }
  }
</script>