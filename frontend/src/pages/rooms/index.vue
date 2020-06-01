<template>
  <router-view />
</template>

<script>
  import i18n from "../../modules/i18n";

  export default {
    name: "page-rooms",
    metaInfo: {
      title: i18n.t('Выбор номера'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    }
  }
</script>
