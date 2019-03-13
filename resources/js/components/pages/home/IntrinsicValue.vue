<template>
  <v-card>
    <v-card-title primary-title>
      <div>
        <h3 class="headline mb-0">Intrinsic Value</h3>
      </div>
    </v-card-title>

    <v-data-table
      :headers="headers"
      :items="this.$store.state.intrinsicValue"
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.key }}</td>
        <td class="text-xs-right">{{ props.item.value }}</td>
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
            value: 'key'
          },
          { text: '', value: 'value' }
        ],
      }
    }
  }
</script>