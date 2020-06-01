<template>
  <router-view />
</template>

<script>
  import user from './modules/user/store'

  export default {
    created() {
      const store = this.$store;
      const name = 'user';
      if (!(store && store.state && store.state[name])) {
        store.registerModule(name, user);
      }
    }
  }
</script>

<style lang="scss">
  @import "./assets/scss/main";
</style>
