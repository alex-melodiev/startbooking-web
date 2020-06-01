<template>
  <div class="page__container">
    <header class="header">
      <button @click.prevent="$router.go(-1)" class="header__back" type="button" role="button">
        <SvgIcon className="icon icon--arrow" name="arrow-left" />
      </button>
      <SBStats />
      <SBBreadcrumbs :crumbs="crumbs" />
    </header>

    <div class="row">
      <div v-for="i in 9"  class="row__col col col-12 col-sm-6 col-lg-4" :key="`card-${i}`">
        <SBRoomsCard />
      </div>
    </div>
    <div class="page__more">
      <button class="btn btn--lg btn--secondary btn--rounded" type="button" role="button">{{ $t('Показать больще объявлений') }}</button>
    </div>
  </div>
</template>

<script>
  import localMixin from './localMixin';
  import SBRoomsCard from "./SBRoomsCard";

  export default {
    name: "SBRooms",
    data() {
      return {
        crumbs: [
          {name: 'HYATT Regency Tashkent', to: {name: 'deals-view', params: {id: this.$route.params.id}}},
          {name: this.$t('Выбор номера')}
        ]
      }
    },
    components: {SBRoomsCard},
    mixins: [localMixin]
  }
</script>

<style scoped>

</style>
