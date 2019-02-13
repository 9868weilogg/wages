<template>
  <v-card>
    <v-card-title primary-title>
      <div>
        <h3 class="headline mb-0">Intrinsic Value</h3>
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
            a1: '5-yr Average',
            b1: 159
          },
          {
            a1: 'Projected 5-yr accumulate earning and dividend',
            b1: 159
          },
          {
            a1: 'Estimate Price',
            b1: 159
          },
          {
            a1: 'Current Intrinsic Value',
            b1: 159
          },
          
        ]
      }
    }
  }
</script>