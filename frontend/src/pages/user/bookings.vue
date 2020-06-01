<template>
  <GrayLayout>
    <div class="page__container booking">
      <header class="header">
        <h1 class="page__title">{{ $t('Мои брони') }}</h1>
        <div class="header__description" v-html="$t('Здесь список всехваших забронированны объектов, включающий в себя актуальную информацию по оплате и срокам')"></div>
      </header>
      <SBUserBookings />
    </div>
  </GrayLayout>
</template>

<script>
  import i18n from "../../modules/i18n";
  import SBUserBookings from "../../modules/user-bookings/SBUserBookings";

  export default {
    name: "page-user-bookings",
    metaInfo: {
      title: i18n.t('Мои брони'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    },
    components: {SBUserBookings}
  }
</script>
