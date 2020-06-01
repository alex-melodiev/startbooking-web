<template>
  <SBProfileAbout />
</template>

<script>
  import i18n from "../../../modules/i18n";
  import SBProfileAbout from "../../../modules/profile/SBProfileAbout";

  export default {
    name: "page-user-profile-about",
    components: {SBProfileAbout},
    metaInfo: {
      title: i18n.t('Личная информация'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    }
  }
</script>
