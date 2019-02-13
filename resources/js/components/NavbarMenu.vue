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
          { title: 'User Account', icon: 'dashboard', href: '/users' },
          { title: 'Valuation', icon: 'money', href: '/valuations' },
          { title: 'Performance', icon: 'trending_up', href: '/performances' },
          { title: 'Admin', icon: 'settings', href: '/admins' }
        ],
        mini: false,
        right: null
      }
    }
  }
</script>
