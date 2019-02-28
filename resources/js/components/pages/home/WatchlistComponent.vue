<template>
  <div>
    <v-toolbar flat color="white">
      <v-toolbar-title>Watchlist</v-toolbar-title>
      <v-divider
        class="mx-2"
        inset
        vertical
      ></v-divider>
      <v-select
        :items="watchlists"
        item-value="id"
        item-text="name"
        label="Watchlists"
      ></v-select>
      <v-dialog v-model="dialog" max-width="500px">
        <v-btn slot="activator" color="primary" dark class="mb-2">Add</v-btn>
        <v-card>
          <v-card-title>
            <span class="headline">{{ formTitle }}</span>
          </v-card-title>

          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12 sm12>
                  <v-text-field
                    label="Watchlist Name"
                    v-model="editedItem.name"
                    outline
                  ></v-text-field>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" flat @click="close">Cancel</v-btn>
            <v-btn color="blue darken-1" flat @click="save">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-toolbar>
    <v-data-table
      :headers="watchlistHeaders"
      :items="watchlistContent"
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.code }}</td>
        <td class="text-xs-right">{{ props.item.stock?props.item.stock.close:'-' }}</td>
        <td class="text-xs-right">{{ props.item.stock?(props.item.stock.close - props.item.stock.open):'-' }}</td>
        <td class="justify-center layout px-0">
          <v-icon
            small
            @click="deleteItem(props.item)"
          >
            delete
          </v-icon>
        </td>
      </template>
      <template slot="no-data">
        <v-alert :value="true" color="error" icon="warning">
          Sorry, nothing to display here :(
        </v-alert>
      </template>
    </v-data-table>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        search: null,
        dialog: false,
        editedIndex: -1,
        editedItem: {
          name: ''
        },
        defaultItem: {
          name: ''
        },
        watchlists:[],
        watchlistHeaders: [
          {
            text: 'Code',
            align: 'left',
            sortable: false,
            value: 'code'
          },
          { text: 'Price (RM)', value: 'stock' },
          { text: 'Change', value: 'stock' },
          { text: '', value: '' },
        ],
        watchlistContent : [],
      }
    },
    methods: {
      deleteWatchlistItem(watchlistItemId,index){
        axios({
          url: '/api/watchlist-items/' + watchlistItemId,
          method: 'delete',
          // data: {
          //   '_method': 'DELETE',
          //   'watchlistItemId': watchlistItemId,
          // }
        })
        .then(response => {
          this.watchlistContent.splice(index, 1)
          console.log(response);
          // console.log(this.watchlistContent);
        })
        .catch(error => console.log(error.response));
      },

      getWatchlistItems(){
        axios({
          url: '/api/watchlist-items',
          method: 'get',
        })
        .then(response => {
          // console.log(response.data.data);
          this.watchlistContent = response.data.data;
          // console.log(this.watchlistContent);
        })
        .catch(error => console.log(error.response));
      },

      addWatchlist(name){
        axios({
          url: '/api/watchlists',
          method: 'post',
          data: {
            watchlist : name,
          },
        })
        .then(response => {
          console.log(response);
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
          this.watchlists = response.data.data;
        })
        .catch(error => console.log(error.response));
      },

      close () {
        this.dialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        }, 300)
      },

      save () {
        if (this.editedIndex > -1) {

        } else {
          this.watchlists.push(this.editedItem.name);
          this.addWatchlist(this.editedItem.name);
        }
        this.close()
      },

      deleteItem (item) {
        const index = this.watchlistContent.indexOf(item)
        confirm('Are you sure you want to delete this item?') && this.deleteWatchlistItem(item.id,index)
        
      },
      
    },
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Watchlist' : 'Edit Watchlist'
      }
    },
    created () {
      this.getWatchlistItems();
      this.getWatchlists();
    },
  }
</script>