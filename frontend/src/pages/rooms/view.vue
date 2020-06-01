<template>
  <WhiteLayout>
    <SBRoomsView />
  </WhiteLayout>
</template>

<script>
  import i18n from "../../modules/i18n";
  import SBRoomsView from "../../modules/rooms/SBRoomsView";

  export default {
    name: "page-rooms-view",
    metaInfo: {
      title: i18n.t('Детальная страница'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    },
    components: {SBRoomsView}
  }
</script>
