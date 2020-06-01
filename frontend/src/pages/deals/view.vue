<template>
  <WhiteLayout>
    <SBDealsView />
  </WhiteLayout>
</template>

<script>
  import i18n from "../../modules/i18n";
  import SBDealsView from "../../modules/deals/SBDealsView";

  export default {
    name: "page-deals-view",
    metaInfo: {
      title: i18n.t('Детальная страница'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    },
    components: {SBDealsView},
  }
</script>
