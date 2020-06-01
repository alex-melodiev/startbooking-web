<template>
  <router-view />
</template>

<script>
  import i18n from "../../modules/i18n";

  export default {
    name: "page-deals",
    metaInfo: {
      title: i18n.t('Предложения'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    }
  }
</script>
