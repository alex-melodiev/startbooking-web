<template>
  <WhiteLayout>
    <SBBooking />
  </WhiteLayout>
</template>

<script>
  import i18n from "../../modules/i18n";
  import SBBooking from "../../modules/booking/SBBooking";

  export default {
    name: "page-booking-view",
    metaInfo: {
      title: i18n.t('Бронирование'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    },
    components: {SBBooking}
  }
</script>
