<template>
  <div class="about">
    <h1>{{ $t('О нас') }}</h1>
  </div>
</template>

<script>
  import i18n from "../modules/i18n";
  export default {
    name: "about",
    metaInfo: {
      title: i18n.t('О нас'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    },
  };
</script>
