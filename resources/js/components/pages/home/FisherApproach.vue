<template>
  <div>
    <v-card>
      <v-card-title primary-title>
        <div>
          <h3 class="headline mb-0">Fisher Approach</h3>
        </div>
      </v-card-title>

      <v-data-table
        :headers="headers"
        :items="ranks"
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
        ranks: [
          {
            key: 'Future Grow',
            value: 159
          },
          {
            key: 'Competitiveness',
            value: 159
          },
          {
            key: 'Net Margin > 15%',
            value: 159
          },
          {
            key: 'GP Cashflow > 0.88',
            value: 159
          },
          {
            key: 'Marginal Cost (R&D Important)',
            value: 159
          },
          {
            key: 'Leadership',
            value: 159
          },
          {
            key: 'Talent',
            value: 159
          },
          
        ]
      }
    },
    methods: {
      openDialog(item){
        this.dialog = true
        this.factor = item
      },
      save() {
        this.ranks.find(rank => rank.key == this.factor.key).value = this.mark
        this.dialog = false
        // axios({
        //   url: '/api/stock-prices',
        //   method: 'post',
        // })
        // .then(response => {
        //   // console.log(response);
        //   this.$store.state.eods = response.data.data;
        //   this.getFcfYield();
        //   // console.log(this.$store.state.eods);
        // })
        // .catch(error => console.log(error.response));
      },
    },
  }
</script>