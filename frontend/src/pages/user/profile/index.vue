<template>
  <GrayLayout>
    <div class="profile">
      <div class="page__container">
        <header class="header">
          <portal-target name="profileHeader"></portal-target>
        </header>
        <div class="row">
          <div class="col col-12 col-md-4">
            <SBProfile />
          </div>
          <div class="col col-12 col-md-8">
            <router-view />
          </div>
        </div>
      </div>
    </div>
  </GrayLayout>
</template>

<script>
  import i18n from "../../../modules/i18n";
  import SBProfile from "../../../modules/profile/SBProfile";

  export default {
    name: "page-user-profile",
    metaInfo: {
      title: i18n.t('Профиль'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    },
    components: {SBProfile}
  }
</script>

<style scoped>

</style>
