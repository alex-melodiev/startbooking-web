<template>
  <GrayLayout>
    <div class="page__container edit">
      <header class="header">
        <portal-target name="partnerDealsAddHeader"></portal-target>
      </header>
      <div class="row">
        <div class="col col-12 col-lg-3 row__col">
          <portal-target class="edit__label" name="partnerDealsAddStep"></portal-target>
        </div>
        <div class="col col-12 col-lg-9 row__col">
          <router-view></router-view>
        </div>
      </div>
    </div>
  </GrayLayout>
</template>

<script>
  export default {
    name: "page-partner-deals-add",
    beforeMount() {
      if(this.$route.name === 'partner-deals-add') {
        this.$router.replace({name: 'partner-deals-add-step-1'});
      }
    }
  }
</script>

<style scoped>

</style>
