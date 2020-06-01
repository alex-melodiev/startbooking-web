<template>
  <div class="card card--deal">
    <router-link :to="{ name: 'deals-view', params: { id: item.id }}" class="card__link" role="button">
      <header class="card__header">
        <b class="card__title">{{ item.name }}</b>
<!--        <div class="card__label card__label&#45;&#45;tagline">HYATT Regency Tashkent</div>-->
      </header>
      <div class="card__body">
        <div class="card__media">
          <figure v-if="item.cover_photo" class="card__figure">
            <img :src="item.cover_photo" alt="HYATT Regency Tashkent" />
          </figure>
          <div v-if="item.images" class="card__thumbs">
            <img v-for="(image, index) in item.images" :src="image.small" :alt="item.name" :key="index" />
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
        <template v-if="item.description">
          <div class="card__label">{{ $t('Описание номера') }}:</div>
          <div class="card__description">{{ item.description }}</div>
        </template>
        <div class="card__label">{{ $t('Стоимость проживания') }}:</div>
        <span class="card__price">{{ item.fee_starts_from }}$</span> {{ $t('в сутки') }}
      </div>
    </router-link>
    <footer class="card__footer">
      <router-link :to="{name: 'deals-view', params: {id: item.id} }" class="card__action card__action--primary" role="button">
        <span>{{ $t('Читать полностью') }}</span>
      </router-link>
    </footer>
  </div>
</template>

<script>
  import localMixin from './localMixin';
  export default {
    name: "SBBookingCard",
    props: {
      item: {
        type: Object,
        required: true
      }
    },
    mixins: [localMixin]
  }
</script>

<style scoped>

</style>
