<template>
  <div class="card card--deal">
    <router-link :to="{ name: 'rooms-view', params: { id: 234 }}" class="card__link">
      <header class="card__header">
        <b class="card__title">Двухместный люкс</b>
        <div class="card__label card__label--tagline">HYATT Regency Tashkent</div>
      </header>
      <div class="card__body">
        <div class="card__media">
          <figure class="card__figure">
            <img src="https://via.placeholder.com/688x280" alt="HYATT Regency Tashkent" />
          </figure>
          <div class="card__thumbs">
            <img src="https://via.placeholder.com/150x120" alt="HYATT Regency Tashkent" />
            <img src="https://via.placeholder.com/150x120" alt="HYATT Regency Tashkent" />
            <img src="https://via.placeholder.com/150x120" alt="HYATT Regency Tashkent" />
            <img src="https://via.placeholder.com/150x120" alt="HYATT Regency Tashkent" />
          </div>
        </div>
        <div class="card__stats">
          <div class="card__stat card__stat--ternary">
            <SvgIcon className="icon icon--star" name="star" />
            <div class="card__stat-value">3.5</div>
          </div>
          <div class="card__stat card__stat--primary">
            <SvgIcon className="btn__icon icon icon--like" name="like" />
            <div class="card__stat-value">3.5</div>
            <div class="card__stat-text">6 оценок от гостей</div>
          </div>
        </div>
        <div class="card__label">{{ $t('Описание номера') }}:</div>
        <div class="card__description">Двухместный люкс на 3-ем этаже с отличным видом на центр города из балкона. В номере присутствует большая ...</div>
        <div class="card__label">{{ $t('Стоимость проживания') }}:</div>
        <span class="card__price">75$ в сутки</span>
      </div>
    </router-link>
    <footer class="card__footer">
      <router-link :to="{name: 'booking-view', params: {id: 234} }" class="card__action card__action--ternary" role="button">
        <SvgIcon className="icon icon--lock" name="lock" />
        <span>{{ $t('Бронировать') }}</span>
      </router-link>
    </footer>
  </div>
</template>

<script>
  import localMixin from './localMixin';
  export default {
    name: "SBRoomsCard",
    mixins: [localMixin]
  }
</script>

<style scoped>

</style>
