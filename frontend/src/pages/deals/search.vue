<template>
  <GrayLayout>
    <div class="page__container">
      <header class="header">
        <div class="page__container">
          <div class="header__row">
            <div class="header__col header__col--title">
              <button @click.prevent="$router.go(-1)" class="header__back" type="button" role="button">
                <SvgIcon className="icon icon--arrow" name="arrow-left" />
              </button>
              <h1 class="page__title">{{ $t('Предложения') }}</h1>
            </div>
            <div class="header__col">
              <div class="header__caption">{{ $t('Вы ищете') }}</div>
              <div class="header__description">
                Отели в городе <strong>Ташкентская область.</strong><br />
                Прживание 3-го до 5го декабря для 1 взрослого
              </div>
            </div>
          </div>
        </div>
      </header>
      <SBAdvancedSearchForm @onChangeMode="onChangeMode" :mode="mode" />
      <SBDealsMap v-if="mode === 'map'" />
      <SBDealsList v-else />
    </div>
  </GrayLayout>
</template>

<script>
  import i18n from "../../modules/i18n";
  import SBAdvancedSearchForm from "../../modules/search-form/SBAdvancedSearchForm";
  import SBDealsMap from "../../modules/deals/SBDealsMap";
  import SBDealsList from "../../modules/deals/SBDealsList";

  export default {
    name: "page-deals-search",
    metaInfo: {
      title: i18n.t('Предложения'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    },
    data() {
      return {
        mode: 'default'
      }
    },
    components: {
      SBDealsList,
      SBDealsMap,
      SBAdvancedSearchForm
    },
    methods: {
      onChangeMode(mode) {
        this.$set(this, 'mode', mode);
      }
    }
  }
</script>
