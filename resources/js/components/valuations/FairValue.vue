<template>
  <v-card>
    <v-card-title primary-title>
      <div>
        <h3 class="headline mb-0">Fair Value</h3>
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
            a1: '52 week price',
            b1: 159
          },
          {
            a1: 'Current Price',
            b1: 159
          },
          {
            a1: 'Fair Value',
            b1: 159
          }
        ]
      }
    }
  }
</script>