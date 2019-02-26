<template>
  <div>
    <v-toolbar flat color="white">
      <v-toolbar-title>Search</v-toolbar-title>
      <v-divider
        class="mx-2"
        inset
        vertical
      ></v-divider>
      <v-text-field
        v-model="search"
        append-icon="search"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
      <v-dialog v-model="dialog" max-width="500px">
        <v-card>
          <v-card-title>
            <span class="headline">{{ formTitle }}</span>
          </v-card-title>

          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12 sm12>
                  <v-select
                    v-model="editedItem.watchlistId"
                    :items="watchlists"
                    item-value="id"
                    item-text="name"
                    label="Watchlists"
                  ></v-select>
                  <v-text-field
                    v-model="editedItem.stockCode"
                    label="Stock Code"
                    single-line
                    hide-details
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
      :headers="headers"
      :items="stocks"
      :search="search"
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.code }}</td>
        <td>{{ props.item.short_name }}</td>
        <td>
          <v-icon
            small
            @click="addItem(props.item)"
          >
            add
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
        dialog: false,
        editedIndex: -1,
        editedItem: {
          stockCode: '',
          watchlistId: ''
        },
        defaultItem: {
          stockCode: '',
          watchlistId: ''
        },
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
        stocks: [],
        watchlists:[],
      }
    },
    methods: {

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

      getStocks(){
        axios({
          url: '/api/stocks',
          method: 'get',
        })
        .then(response => {
          // console.log(response.data.data);
          this.stocks = response.data.data;
        })
        .catch(error => console.log(error.response));
      },

      addWatchlistItem(){
        axios({
          url: '/api/watchlist-items',
          method: 'post',
          data: {
            'stockCode' : this.editedItem.stockCode,
            'watchlistId' : this.editedItem.watchlistId,
          }
        })
        .then(response => {
          // console.log(response);
        })
        .catch(error => console.log(error.response));
      },

      addItem (item) {
        this.editedItem.stockCode = Object.assign({}, item).code;
        this.dialog = true
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
          this.addWatchlistItem(this.editedItem);
        }
        this.close()
      },
      
    },
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Watchlist' : 'Edit Watchlist'
      }
    },
    created () {
      this.getWatchlists();
      this.getStocks();
    },
  }
</script>