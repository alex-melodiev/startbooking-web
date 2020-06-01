<template>
  <SBChat />
</template>

<script>
  import i18n from "../modules/i18n";
  import SBChat from "../modules/chat/SBChat";

  export default {
    name: "support",
    components: {SBChat},
    metaInfo: {
      title: i18n.t('Поддержка'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    }
  };
</script>
