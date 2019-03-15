<template>
  <div>
    <v-card>
      <v-card-title primary-title>
        <div>
          <h3 class="headline mb-0">Buffett Approach</h3>
        </div>
      </v-card-title>

      <v-data-table
        :headers="headers"
        :items="$store.state.buffettApproach"
        class="elevation-1"
      >
        <template slot="items" slot-scope="props">
          <tr @click="openDialog(props.item)">
            <td>{{ props.item.key }}</td>
            <td class="text-xs-right">{{ props.item.value }}</td>
          </tr>
        </template>
      </v-data-table>
    </v-card>
    <v-dialog v-model="dialog" max-width="500px">
      <v-card>
        <v-card-title>
          <h1>{{ this.factor.key }}</h1>
        </v-card-title>
        <v-card-text>
          <v-select
            v-model="mark"
            :items="select"
            label="Evaluate Mark"
            item-value="text"
          ></v-select>
        </v-card-text>
        <v-card-actions>
          <v-btn color="primary" flat @click="dialog=false">Close</v-btn>
          <v-btn color="primary" flat @click="save">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        dialog: false,
        factor: {},
        select:['1','2','3','4','5'],
        mark: "",
        headers: [
          {
            text: '',
            align: 'left',
            sortable: false,
            value: 'key'
          },
          { text: '', value: 'value' }
        ],
      }
    },
    methods: {
      openDialog(item){
        this.dialog = true
        this.factor = item
      },
      save() {
        let key = this.factor.key
        this.$store.state.buffettApproach.find(rank => rank.key == key).value = this.mark
        this.dialog = false
        this.mark = ""

        axios({
          url: '/api/gis-ranks/' + this.factor.watchlist_item_id,
          method: 'post',
          data : { 
            _method: 'put',
            key: this.factor.shortKey,
            value: this.$store.state.buffettApproach.find(rank => rank.key == key).value,
          }
        })
        .then(response => {
          console.log(response);
        })
        .catch(error => console.log(error.response));
      },
    }
  }
</script>