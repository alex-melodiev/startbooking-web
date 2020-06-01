<template>
  <GrayLayout>
    <div class="page__container">
      <header class="header">
        <portal-target name="registerHeader"></portal-target>
      </header>
      <router-view />
    </div>
  </GrayLayout>
</template>

<script>
  export default {
    name: "page-auth-register",
    beforeMount() {
      this.$router.replace({name: 'register-step-1'});
    }
  }
</script>
