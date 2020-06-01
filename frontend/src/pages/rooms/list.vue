<template>
  <GrayLayout>
    <SBRooms />
  </GrayLayout>
</template>

<script>
  import i18n from "../../modules/i18n";
  import SBRooms from "../../modules/rooms/SBRooms";

  export default {
    name: "page-rooms-list",
    metaInfo: {
      title: i18n.t('Выбор номера'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    },
    components: {SBRooms}
  }
</script>
