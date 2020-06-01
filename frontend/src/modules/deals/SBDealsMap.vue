<template>
  <div class="row">
    <div class="col col-12 col-lg-8">
      <div class="card card--map">
        <header class="card__header">
          <b class="card__title">{{ $t('Карта') }}</b>
        </header>
        <div class="card__body">
          <GmapMap
              :center="{lat:41.3053604, lng:69.270975}"
              :zoom="12"
              :zoomControl="false"
              :scaleControl="false"
              style="height: 600px"
          >
            <GmapMarker :position="{lat:41.3053604, lng:69.270975}"
                        title="Hello World!"
                        @click="center={lat:41.3053604, lng:69.270975}"
            />
          </GmapMap>
        </div>
      </div>
    </div>
    <div v-if="!isLoading && deals && deals.length" class="col col-12 col-lg-4">
      <div v-for="item in deals" class="row__col" :key="item.id">
        <SBDealsCard :item="item" />
      </div>
    </div>
  </div>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex';
  import localMixin from './localMixin';
  import SBDealsCard from "./SBDealsCard";

  export default {
    name: "SBDealsMap",
    components: {SBDealsCard},
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
