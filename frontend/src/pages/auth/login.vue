<template>
  <WhiteLayout>
    <SBLogin />
  </WhiteLayout>
</template>

<script>
  import i18n from "../../modules/i18n";
  import SBLogin from "../../modules/login/SBLogin";

  export default {
    name: "page-auth-login",
    metaInfo: {
      title: i18n.t('Авторизация'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    },
    components: {SBLogin}
  }
</script>
