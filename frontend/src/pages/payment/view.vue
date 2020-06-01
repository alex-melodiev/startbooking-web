<template>
  <WhiteLayout>
    <SBPayment />
  </WhiteLayout>
</template>

<script>
  import i18n from "../../modules/i18n";
  import SBPayment from "../../modules/payment/SBPayment";

  export default {
    name: "page-payment-view",
    metaInfo: {
      title: i18n.t('Оплата'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    },
    components: {SBPayment}
  }
</script>
