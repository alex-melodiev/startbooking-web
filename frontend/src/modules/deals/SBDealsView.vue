<template>
  <div class="page__container">
    <div v-if="isLoading" class="page__loading">
      <SBLoading />
    </div>
    <div v-else-if="deal" class="view">
      <header class="header">
        <button @click.prevent="$router.go(-1)" class="header__back" type="button" role="button">
          <SvgIcon className="icon icon--arrow" name="arrow-left" />
        </button>
        <div class="header__row">
          <div class="header__col header__col--grow">
            <SBStats :averageRating=deal.avg_rating
                     :overallRating="deal.overall_rating"
                     :reviewsCount="deal.reviews_count"
            />
            <h1 class="page__title">{{ deal.name }}</h1>
          </div>
          <div v-if="!isGuest" class="header__col header__col--auto">
            <button @click="toggleFavorite(deal.id)"
                    class="btn btn--lg btn--rounded"
                    :class="[isFavorite(deal.id) ? 'btn--mutted' : 'btn--outline-mutted']"
                    type="button"
                    role="button"
            >{{ isFavorite(deal.id) ? $t('В избранных') : $t('В избранное') }}</button>
          </div>
        </div>
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
      <section v-else-if="coverPhoto" class="view__media">
        <figure class="view__figure">
          <img :src="coverPhoto" :alt="deal.name" />
        </figure>
        <swiper v-if="deal.thumbnails" class="view__thumbs" :options="swiperOption">
          <swiper-slide v-for="(image, index) in deal.thumbnails" :key="index">
            <button @click="setCoverPhoto(image.origin)" class="view__thumb" type="button" role="button">
              <img :src="image" :alt="deal.name" />
            </button>
          </swiper-slide>
        </swiper>
      </section>

      <section class="view__row">
        <div class="view__col view__col--label">
          <div class="view__price" v-html="$t('цена от в сутки', {price: deal.price})"></div>
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
<!--          <router-link :to="{name: 'rooms-list', params: {id: $route.params.id} }" class="btn btn&#45;&#45;lg btn&#45;&#45;secondary btn&#45;&#45;rounded">-->
<!--            {{ $t('Выбрать номер') }}-->
<!--          </router-link>-->
          <router-link :to="{name: 'booking-view', params: {id: deal.id} }" class="btn btn--lg btn--ternary btn--rounded">
            {{ $t('Бронировать') }}
          </router-link>
        </div>
      </section>

      <section v-if="deal.description" class="view__row">
        <div class="view__col view__col--label">{{ $t('Описание отеля') }}:</div>
        <div class="view__col view__col--content" v-html="deal.description"></div>
      </section>

      <section class="view__row">
        <div class="view__col view__col--label">{{ $t('Условия проживания') }}:</div>
        <div class="view__col view__col--content">
          <div v-if="deal.check_in || deal.depature" class="row">
            <div v-if="deal.check_in" class="col col-auto">
              <div class="view__label">{{ $t('Заезд') }}:</div>
              <div class="btn btn--tag">{{ $t('c времени', {time: deal.check_in}) }}</div>
            </div>
            <div class="col col-auto">
              <div class="view__label">{{ $t('Выезд') }}:</div>
              <div class="btn btn--tag">{{ $t('до времени', {time: deal.depature}) }}</div>
            </div>
          </div>
          <!--<ul v-if="deal.amenities" class="view__ul">-->
            <!--<li v-for="amenity in deal.amenities" :key="amenity.id">{{ amenity.description }}</li>-->
          <!--</ul>-->
        </div>
      </section>

      <section class="view__row">
        <div class="view__col view__col--label">{{ $t('Платные услуги') }}:</div>
        <div class="view__col view__col--content">
          <div class="view__tags">
            <div v-for="amenity in deal.amenities" :key="amenity.id" class="view__tag btn btn--tag">{{ amenity.label }}</div>
          </div>
        </div>
      </section>

      <section class="view__row">
        <div class="view__col view__col--label">{{ $t('Отзывы гостей') }}:</div>
        <div class="view__col view__col--content">
          <SBComment :comments="deal.reviews" :id="deal.id" />
        </div>
      </section>
    </div>
  </div>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex';
  import i18n from "../../modules/i18n";
  import localMixin from './localMixin';
  import SBComment from "../comment/SBComment";
  import SBLoading from "../../components/blocks/SBLoading";
  // import {isNotEmpty} from "../../utils/helpers";

  export default {
    name: "SBDealsView",
    metaInfo: {
      title: '',
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    },
    data() {
      return {
        title: '',
        mode: 'default',
        swiperOption: {
          slidesPerView: 8,
          spaceBetween: 8
        },
        mainImage: null
      }
    },
    components: {SBLoading, SBComment},
    methods: {
      ...mapActions('deals', [
        'getDeal',
        'destroyDeal'
      ]),
      ...mapActions('favorite', [
        'toggleFavorite'
      ]),
      onChangeMode() {
        if(this.mode === 'default') {
          this.$set(this, 'mode', 'map');
        } else {
          this.$set(this, 'mode', 'default');
        }
      },
      setCoverPhoto(src) {
        this.$set(this, 'mainImage', src);
      }
    },
    computed: {
      ...mapGetters('deals', [
        'isLoading',
        'deal'
      ]),
      ...mapGetters('user', [
        'isGuest'
      ]),
      ...mapGetters('favorite', [
        'isFavorite'
      ]),
      coverPhoto() {
        let result = null;
        console.log(this.deal.cover)
        // if(isNotEmpty(this.mainImage)) {
        //   result = this.mainImage
        // } else if(isNotEmpty(this.deal.cover)) {
        //   result = this.deal.cover
        // }

        result = this.deal.cover;
        return result;
      }
    },
    destroyed() {
      this.destroyDeal();
    },
    mounted() {
      this.getDeal(this.$route.params.id);
    },
    mixins: [localMixin]
  }
</script>
