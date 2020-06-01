<template>
  <div>
    <div v-if="isLoading" class="page__loading">
      <SBLoading />
    </div>
    <div v-else-if="deals && deals.length" class="row">
      <div v-for="item in deals" class="row__col col col-12 col-sm-6 col-lg-4" :key="item.id">
        <SBDealsCard :item="item" />
      </div>
    </div>
    <div v-else class="page__noresult">
      {{ $t('По вашему запросу ничего не найдено') }}
    </div>
    <div v-if="deals && deals.length" class="page__more">
      <button class="btn btn--lg btn--secondary btn--rounded" type="button" role="button">{{ $t('Показать больще объявлений') }}</button>
    </div>
  </div>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex';
  import localMixin from './localMixin';
  import SBLoading from "../../components/blocks/SBLoading";
  import SBDealsCard from "./SBDealsCard";

  export default {
    name: "SBDealsList",
    components: {SBLoading, SBDealsCard},
    methods: {
      ...mapActions('deals', [
        'dealsInit'
      ])
    },
    computed: {
      ...mapGetters('deals', [
        'isLoading',
        'deals',
        'errors',
      ])
    },
    mounted() {
      this.dealsInit(this.$route.query);
    },
    mixins: [localMixin]
  }
</script>
