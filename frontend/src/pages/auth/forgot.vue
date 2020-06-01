<template>
  <WhiteLayout>
    <div>forgot password</div>
  </WhiteLayout>
</template>

<script>
  import i18n from "../../modules/i18n";

  export default {
    name: "page-auth-forgot",
    metaInfo: {
      title: i18n.t('Восстановление пароля'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    }
  }
</script>

<style scoped>

</style>
