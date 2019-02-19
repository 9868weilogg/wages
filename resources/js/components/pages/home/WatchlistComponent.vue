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
        <td>{{ props.item.code }}</td>
        <td class="text-xs-right">RM {{ props.item.stock.close }}</td>
        <td class="text-xs-right">RM {{ props.item.stock.close - props.item.stock.open }}</td>
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
            text: 'Code',
            align: 'left',
            sortable: false,
            value: 'code'
          },
          { text: 'Price (RM)', value: 'stock' },
          { text: 'Change', value: 'stock' }
        ],
        watchlistContent : [],
        // watchlistContent: [
        //   {
        //     code: 'Frozen Yogurt',
        //     watchlist_id: 159
        //   },
        //   {
        //     code: 'Ice cream sandwich',
        //     watchlist_id: 159
        //   },
        //   {
        //     code: 'Eclair',
        //     watchlist_id: 159
        //   },
        //   {
        //     code: 'Cupcake',
        //     watchlist_id: 159
        //   }
        // ]
      }
    },
    methods: {
      getWatchlistItems(){
        axios({
          url: '/api/watchlist-items',
          method: 'get',
          // data: _formData,
          // headers: {
          //   'Content-Type': 'multipart/form-data'
          // }
        })
        .then(response => {
          console.log(response.data.data[0]);
          this.watchlistContent = response.data.data;
        })
        .catch(error => console.log(error.response));
      },
      
    },
    created () {
      this.getWatchlistItems();
    },
    // mounted () {
    //   this.getWatchlistItems();
    // },
  }
</script>