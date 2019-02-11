<template>
  <v-card>
    <v-card-title primary-title>
      <div>
        <h3 class="headline mb-0">Fundamental Analysis</h3>
      </div>
    </v-card-title>

    <v-data-table
      :headers="headers"
      :items="desserts"
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.a1 }}</td>
        <td class="text-xs-right">{{ props.item.b1 }}</td>
        <td class="text-xs-right">{{ props.item.c1 }}</td>
      </template>
    </v-data-table>
  </v-card>
</template>

<script>
  export default {
    data () {
      return {
        
        headers: [
          {
            text: '',
            align: 'left',
            sortable: false,
            value: 'a1'
          },
          { text: 'avg', value: 'b1' },
          { text: 'now', value: 'c1' }
        ],
        desserts: [
          {
            a1: 'ROE > 15%',
            b1: 159,
            c1: 159
          },
          {
            a1: 'EPS GR > 15%',
            b1: 159,
            c1: 159
          },
          {
            a1: 'Debt/Equity < 0.5',
            b1: 159,
            c1: 159
          },
          {
            a1: 'Net Margin > 15%',
            b1: 159,
            c1: 159
          },
          {
            a1: 'GP Cashflow > 0.88',
            b1: 159,
            c1: 159
          },
          {
            a1: 'Gearing < 1.5',
            b1: 159,
            c1: 159
          },
        ]
      }
    }
  }
</script>