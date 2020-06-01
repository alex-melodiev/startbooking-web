<template>
  <div>
    <portal to="partnerDealsAddHeader">
      <SBBreadcrumbs :crumbs="crumbs" />
    </portal>
    <portal to="partnerDealsAddStep">
      {{ $t('Параметры номера') }}
    </portal>
  </div>
</template>

<script>
  import localMixin from './localMixin';
  export default {
    name: "SBDealsEdit6",
    data() {
      return {
        crumbs: [
          { name: this.$t('Добавить объект'), to: {name: 'partner-deals-add-step-1'} },
          { name: this.$t('Шаг 6') }
        ],
      }
    },
    mixins: [localMixin]
  }
</script>

<style scoped>

</style>
