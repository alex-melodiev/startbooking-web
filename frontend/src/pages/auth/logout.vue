<template>
  <WhiteLayout>
    <div class="page__container">
      <h1 class="page__title">{{ $t('Выход') }}</h1>
      <SBLoading />
    </div>
  </WhiteLayout>
</template>

<script>
  import { mapActions } from 'vuex';
  import i18n from "../../modules/i18n";
  import SBLoading from "../../components/blocks/SBLoading";

  export default {
    name: "page-auth-logout",
    components: {SBLoading},
    metaInfo: {
      title: i18n.t('Выход'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    },
    methods: {
      ...mapActions('login', [
        'logout'
      ])
    },
    beforeMount() {
      this.logout();
    }
  }
</script>
