<template>
  <div v-if="item" class="card card--deal">
    <router-link :to="{ name: 'deals-view', params: { id: item.id }}" class="card__link" role="button">
      <header class="card__header">
        <b class="card__title">{{ item.name }}</b>
      </header>
      <div class="card__body">
        <div class="card__media">
          <figure v-if="item.cover" class="card__figure">
            <img :src="item.cover" alt="HYATT Regency Tashkent" />
          </figure>
          <div class="card__thumbs">
            <div :key="index" v-for="(item, index) in item.thumbnails">
              <img :src="item" alt="HYATT Regency Tashkent" />
            </div>
          </div>
        </div>
        <div class="card__stats">
          <div v-if="item.avg_rating" class="card__stat card__stat--ternary">
            <SvgIcon className="icon icon--star" name="star" />
            <div class="card__stat-value">{{ item.avg_rating }}</div>
          </div>
          <div v-if="item.overall_rating || item.reviews_count" class="card__stat card__stat--primary">
            <template v-if="item.overall_rating">
              <SvgIcon className="btn__icon icon icon--like" name="like" />
              <div class="card__stat-value">{{ item.overall_rating }}</div>
            </template>
            <div v-if="item.reviews_count" class="card__stat-text">
              {{ $tc('Количество оценток от гостей', item.reviews_count, {count: item.reviews_count}) }}
            </div>
          </div>
        </div>
        <template v-if="item.reference_point">
          <div class="card__label">{{ $t('Ориентир') }}:</div>
          <div class="card__description">{{ item.reference_point }}</div>
        </template>
      </div>
      <footer v-if="item.fee_starts_from" class="card__footer">
        <span class="card__price">{{ item.fee_starts_from }}$</span>
      </footer>
    </router-link>
    <footer class="card__footer">
      <button @click="deleteFromFavorite(item.id)" class="card__action card__action--danger" type="button" role="button">
        <SvgIcon className="btn__icon icon icon--trash" name="trash" />
        <span>{{ $t('Убрать с избранного') }}</span>
      </button>
    </footer>
  </div>
</template>

<script>
  import { mapActions } from 'vuex';
  import localMixin from './localMixin';

  export default {
    name: "SBFavoriteCard",
    props: {
      item: {
        type: Object,
        required: true
      }
    },
    methods: {
      ...mapActions('favorite', [
        'deleteFromFavorite'
      ]),
    },
    mixins: [localMixin]
  }
</script>

<style scoped>

</style>
