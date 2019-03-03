<template>
  <v-card>
    <v-card-title primary-title>
      <div>
        <h3 class="headline mb-0">Fundamental Data</h3>
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
      :loading="$store.state.fundamentalLoading"
      :search="search"
      :headers="fDataHeaders"
      :items="$store.state.fDataContent"
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.fye }}</td>
        <td class="text-xs-right">{{ props.item.name }}</td>
        <td class="text-xs-right">{{ props.item.pe }}</td>
        <td class="text-xs-right">{{ props.item.dy }}</td>
        <td class="text-xs-right">{{ props.item.dps }}</td>
        <td class="text-xs-right">{{ props.item.eps }}</td>
        <td class="text-xs-right">{{ props.item.net_profit_gr }}</td>
        <!-- <td class="text-xs-right">{{ props.item.revenue }}</td> -->
        <td class="text-xs-right">{{ props.item.gp_cash }}</td>
        <td class="text-xs-right">{{ props.item.total_cash }}</td>
        <td class="text-xs-right">{{ props.item.short_term_loan }}</td>
        <td class="text-xs-right">{{ props.item.long_term_loan }}</td>
        <td class="text-xs-right">{{ props.item.gearing }}</td>
        <td class="text-xs-right">{{ props.item.fcf_share }}</td>
        <td class="text-xs-right">{{ props.item.gp_cash }}</td>
        <td class="text-xs-right">{{ props.item.net_margin }}</td>
        <td class="text-xs-right">{{ props.item.roe }}</td>
        <td class="text-xs-right">{{ props.item.roa }}</td>
        <td class="text-xs-right">{{ props.item.code }}</td>
        <!-- <td class="text-xs-right">{{ props.item.asset_turnover }}</td> -->
      </template>
    </v-data-table>
  </v-card>
</template>

<script>
  export default {
    data () {
      return {
        search: '',
        fDataHeaders: [
          {
            text: 'FYE',
            align: 'left',
            sortable: false,
            value: 'fye'
          },
          { text: 'Name', value: 'name' },
          { text: 'PE', value: 'pe' },
          { text: 'Dividend Yield', value: 'dy' },
          { text: 'DPS (sen)', value: 'dps' },
          { text: 'EPS (sen)', value: 'eps' },
          { text: 'Net Profit GR (%)', value: 'net_profit_gr' },
          // { text: 'Revenue', value: 'revenue' },
          { text: 'GP Cash', value: 'gp_cash' },
          { text: 'Total Cash (RM `000)', value: 'total_cash' },
          { text: 'Short Term Loan (RM `000)', value: 'short_term_loan' },
          { text: 'Long Term Loan (RM `000)', value: 'long_term_loan' },
          { text: 'Gearing', value: 'gearing' },
          { text: 'FCF/share (sen)', value: 'fcf_share' },
          { text: 'GP Cashflow', value: 'gp_cash' },
          { text: 'Net Margin (%)', value: 'net_margin' },
          { text: 'ROE', value: 'roe' },
          { text: 'ROA', value: 'roa' },
          { text: 'Stock', value: 'code' },
          // { text: 'Asset Turnover', value: 'asset_turnover' }
        ],
      }
    },
    methods: {
    }
  }
</script>