<template>
  <div class="home">
    <div class="home__helper">
      <router-link :to="{name: 'partner-deals-add'}"
                   class="btn btn--primary btn--shadowed"
                   :class="[$isMobile ? '' : 'btn--lg']"
                   role="button"
      >
        {{ $t('Зарегистрировать свой объект') }}
        <SvgIcon className="btn__icon icon icon--arrow icon--right" name="arrow-left" />
      </router-link>
    </div>
    <div class="home__form">
      <div class="page__container">
        <SBBasicSearchForm />
      </div>
    </div>
    <div class="home__cover" :style="{backgroundImage: 'url('+background[0]+')'}"></div>
  </div>
</template>

<script>
  import i18n from "../modules/i18n";
  import SBBasicSearchForm from "../modules/search-form/SBBasicSearchForm";

  export default {
    name: "home",
    metaInfo: {
      title: i18n.t('Добро пожаловать!'),
      titleTemplate: '%s - ' + process.env.VUE_APP_TITLE,
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    },
    data() {
      return {
        background: [
          require('@/assets/img/cover_1.jpg')
        ]
      }
    },
    components: {SBBasicSearchForm}
  };
</script>
