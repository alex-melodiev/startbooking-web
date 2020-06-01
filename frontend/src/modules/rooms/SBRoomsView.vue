<template>
  <div class="page__container view">
    <header class="header">
      <button @click.prevent="$router.go(-1)" class="header__back" type="button" role="button">
        <SvgIcon className="icon icon--arrow" name="arrow-left" />
      </button>
      <SBStats />
      <SBBreadcrumbs :crumbs="crumbs" />
    </header>

    <section v-if="mode === 'map'" class="view__map">
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
              style="height: 400px"
          >
            <GmapMarker :position="{lat:41.3053604, lng:69.270975}"
                        title="Hello World!"
                        @click="center={lat:41.3053604, lng:69.270975}"
            />
          </GmapMap>
        </div>
      </div>
    </section>
    <section v-else class="view__media">
      <figure class="view__figure">
        <img src="https://via.placeholder.com/1138x520" alt="HYATT Regency Tashkent" />
      </figure>
      <swiper class="view__thumbs" :options="swiperOption">
        <swiper-slide v-for="thumb in 12" :key="thumb">
          <img src="https://via.placeholder.com/136x75/f1f1f1" alt="HYATT Regency Tashkent" />
        </swiper-slide>
      </swiper>
    </section>

    <section class="view__row">
      <div class="view__col view__col--label">
        <div class="view__price">
          от <span>75$</span> в сутки
        </div>
      </div>
      <div class="view__col view__col--content">
        <div class="view__label">{{ $t('Ориентир') }}:</div>
        <div class="view__heading">
          <div class="view__address">2 км от Чарвакское водохранилище</div>
          <button @click="onChangeMode"
                  class="view__action view__action--primary"
                  type="button"
                  role="button"
          >
            <SvgIcon className="icon icon--binoculars" name="binoculars" />
            <span v-if="mode === 'map'">{{ $t('В обычный режим') }}</span>
            <span v-else>{{ $t('В режим карты') }}</span>
          </button>
        </div>
      </div>
      <div class="view__col view__col--action">
        <router-link :to="{name: 'booking-view', params: {id: $route.params.id} }" class="btn btn--lg btn--ternary btn--rounded">
          {{ $t('Бронировать') }}
        </router-link>
      </div>
    </section>

    <section class="view__row">
      <div class="view__col view__col--label">{{ $t('Описание отеля') }}:</div>
      <div class="view__col view__col--content">
        <p>Роскошный отель Hyatt Regency Tashkent расположен в самом центре города Ташкент. К услугам гостей вращающийся ресторан, крытый бассейн и бесплатный Wi-Fi.</p>
        <p>Номера обставлены элегантной мебелью, а из окон открывается живописный вид. В некоторых номерах имеется гостиная зона с мини-баром и спутниковым телевидением.</p>
        <p>В спа- и фитнес-центре отеля Hyatt Regency есть современный тренажерный зал. Предоставляются спа-услуги, включая расслабляющий массаж.</p>
        <p>Станция метро Mustaqillik Maydoni находится в 12 минутах ходьбы. Расстояние от отеля Hyatt Regency Tashkent до международного аэропорта Ташкент составляет 7 км.</p>
        <p>Парам особенно нравится расположение — они оценили проживание в этом районе для поездки вдвоем на 9,2.</p>
        <p>Мы говорим на вашем языке!</p>
      </div>
    </section>

    <section class="view__row">
      <div class="view__col view__col--label">{{ $t('Условия проживания') }}:</div>
      <div class="view__col view__col--content">
        <div class="row">
          <div class="col col-auto">
            <div class="view__label">{{ $t('Заезд') }}:</div>
            <div class="btn btn--tag">с 12:00</div>
          </div>
          <div class="col col-auto">
            <div class="view__label">{{ $t('Выезд') }}:</div>
            <div class="btn btn--tag">с 22:00</div>
          </div>
        </div>
        <ul class="view__ul">
          <li>Бесплатный трансфер с Аэропорта</li>
          <li>Высокоскоростной интернет</li>
          <li>Завтрак включен в стоимость</li>
        </ul>
      </div>
    </section>

    <section class="view__row">
      <div class="view__col view__col--label">{{ $t('Платные услуги') }}:</div>
      <div class="view__col view__col--content">
        <div class="view__tags">
          <div class="view__tag btn btn--tag">Ресторан</div>
          <div class="view__tag btn btn--tag">Семейные номера</div>
          <div class="view__tag btn btn--tag">Доставка еды и напитков в номер</div>
          <div class="view__tag btn btn--tag">Бар</div>
          <div class="view__tag btn btn--tag">Оздаровительный центр</div>
          <div class="view__tag btn btn--tag">Пляж</div>
          <div class="view__tag btn btn--tag">Гидромассажная ванна</div>
          <div class="view__tag btn btn--tag">Станция зарядки электромобилей</div>
        </div>
      </div>
    </section>

    <section class="view__row">
      <div class="view__col view__col--label">{{ $t('Отзывы гостей') }}:</div>
      <div class="view__col view__col--content">
        <SBComment :comments="[]" :id="$route.params.id" />
      </div>
    </section>
  </div>
</template>

<script>
  import i18n from "../../modules/i18n";
  import localMixin from './localMixin';
  import SBComment from "../comment/SBComment";

  export default {
    name: "SBRoomsView",
    metaInfo: {
      title: 'Двухместный люкс',
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    },
    data() {
      return {
        mode: 'default',
        swiperOption: {
          slidesPerView: 8,
          spaceBetween: 8
        },
        crumbs: [
          {name: 'HYATT Regency Tashkent', to: {name: 'deals-view', params: {id: this.$route.params.id}}},
          {name: 'Двухместный люкс'}
        ]
      }
    },
    components: {SBComment},
    methods: {
      onChangeMode() {
        if(this.mode === 'default') {
          this.$set(this, 'mode', 'map');
        } else {
          this.$set(this, 'mode', 'default');
        }
      }
    },
    mixins: [localMixin]
  }
</script>

<style scoped>

</style>
