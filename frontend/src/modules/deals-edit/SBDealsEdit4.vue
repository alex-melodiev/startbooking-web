<template>
  <div>
    <portal to="partnerDealsAddHeader">
      <SBBreadcrumbs :crumbs="crumbs" />
    </portal>
    <portal to="partnerDealsAddStep">
      {{ $t('Порядок проживания') }}
    </portal>

    <div class="page__more">
      <router-link :to="{name: 'partner-deals-add-step-5'}" class="btn btn--secondary btn--shadowed btn--lg btn--rounded">
        {{ $t('Дальше') }}
      </router-link>
    </div>
  </div>
</template>

<script>
  import localMixin from './localMixin';
  export default {
    name: "SBDealsEdit4",
    data() {
      return {
        crumbs: [
          { name: this.$t('Добавить объект'), to: {name: 'partner-deals-add-step-1'} },
          { name: this.$t('Шаг 4') }
        ],
      }
    },
    mixins: [localMixin]
  }
</script>

<style scoped>

</style>
