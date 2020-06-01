<template>
  <GrayLayout>
    <div class="page__container">
      <header class="header">
        <h1 class="page__title">{{ $t('Избранное') }}</h1>
        <div class="header__description" v-html="$t('Здесь хранятся все актуальные и не актуальные объявления которые вы сохранили ранее')"></div>
      </header>
      <SBFavorite />
    </div>
  </GrayLayout>
</template>

<script>
  import i18n from "../../modules/i18n";
  import SBFavorite from "../../modules/favorite/SBFavorite";

  export default {
    name: "page-user-favorite",
    metaInfo: {
      title: i18n.t('Избранное'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    },
    components: {SBFavorite}
  }
</script>
