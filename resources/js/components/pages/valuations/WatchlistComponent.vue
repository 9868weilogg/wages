<template>
  <v-card>
    <v-card-title primary-title>
      <div>
        <h3 class="headline mb-0">Watchlist</h3>
      </div>
    </v-card-title>

    <v-data-table
      :headers="watchlistHeaders"
      :items="watchlistContent"
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.name }}</td>
        <td class="text-xs-right">{{ props.item.price }}</td>
      </template>
    </v-data-table>
  </v-card>
</template>

<script>
  export default {
    data () {
      return {
        watchlistHeaders: [
          {
            text: 'Name',
            align: 'left',
            sortable: false,
            value: 'name'
          },
          { text: 'Price', value: 'price' }
        ],
        watchlistContent: [
          {
            name: 'Frozen Yogurt',
            price: 159
          },
          {
            name: 'Ice cream sandwich',
            price: 159
          },
          {
            name: 'Eclair',
            price: 159
          },
          {
            name: 'Cupcake',
            price: 159
          }
        ]
      }
    }
  }
</script>