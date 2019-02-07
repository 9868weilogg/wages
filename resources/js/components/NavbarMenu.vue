<template>
  <v-app>
    
  </v-app>
</template>

<script>
  export default {
    data () {
      return {
        drawer: null,
        items: [
          { title: 'User Account', icon: 'dashboard' },
          { title: 'Valuation', icon: 'question_answer' },
          { title: 'Performance', icon: 'question_answer' }
        ],
        mini: false,
        right: null
      }
    }
  }
</script>
