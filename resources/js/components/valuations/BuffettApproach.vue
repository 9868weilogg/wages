<template>
  <v-card>
    <v-card-title primary-title>
      <div>
        <h3 class="headline mb-0">Buffett Approach</h3>
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
          { text: '', value: 'b1' }
        ],
        desserts: [
          {
            a1: 'Business Sexines',
            b1: 159
          },
          {
            a1: 'Supplier No.',
            b1: 159
          },
          {
            a1: 'Customer Choices',
            b1: 159
          },
          {
            a1: 'Entry Barrier',
            b1: 159
          },
          {
            a1: 'Substitute',
            b1: 159
          },
          {
            a1: 'Competition No.',
            b1: 159
          },
          {
            a1: 'Competitiveness',
            b1: 159
          },
          {
            a1: 'FPE < 25',
            b1: 159
          },
          {
            a1: 'Gearing < 1.5',
            b1: 159
          },
          {
            a1: 'GP Cashflow > 0.88',
            b1: 159
          },
          {
            a1: 'Good Will',
            b1: 159
          },
          {
            a1: 'Customer Loyalty',
            b1: 159
          },
        ]
      }
    }
  }
</script>