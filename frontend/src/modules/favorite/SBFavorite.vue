<template>
  <div v-if="items" class="row">
    <div v-for="item in items" class="row__col col col-12 col-sm-6 col-lg-4" :key="item.id">
      <SBFavoriteCard :item="item" />
    </div>
  </div>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex';
  import localMixin from './localMixin';
  import SBFavoriteCard from "./SBFavoriteCard";

  export default {
    name: "SBFavorite",
    components: {SBFavoriteCard},
    methods: {
      ...mapActions('favorite', [
        'getFavorites'
      ])
    },
    computed: {
      ...mapGetters('favorite', [
        'items'
      ])
    },
    mounted() {
      this.getFavorites();
    },
    mixins: [localMixin]
  }
</script>

<style scoped>

</style>
