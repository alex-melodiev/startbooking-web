<template>
  <div>
    <portal to="partnerDealsAddHeader">
      <SBBreadcrumbs :crumbs="crumbs" />
    </portal>
    <portal to="partnerDealsAddStep">
      {{ $t('Основная информация') }}
    </portal>

    <form v-if="states" @submit.prevent="onSubmit" action="/partner/add" class="edit__form" method="POST" role="form">
      <div class="card card--edit">
        <header class="card__header">
          <b class="card__title">1. {{ $t('Назовите свой объект') }}</b>
        </header>
        <div class="card__body">
          <p>Наименование должно быть не слишком длинным для быстрого считывания пользователем</p>
          <SBInput v-model="payload.name"
                   :label="$t('Название')"
                   name="name"
                   type="text"
                   inputClass="input--white"
                   :placeholder="$t('Название объекта')"
                   :errors="errors && errors.name ? errors.name : null"
          />
        </div>
      </div>
      <div class="card card--edit">
        <header class="card__header">
          <b class="card__title">2. {{ $t('Добавьте фотографии своего объекта') }}</b>
        </header>
        <div class="card__body">
          <p>Чем больше фотографий в объявлении, тем больше шансов что человек полностью ознакомиться с будущем местом заселения</p>
          <SBImageUploader name="images" v-model="payload.images" />
        </div>
      </div>
      <div class="card card--edit">
        <header class="card__header">
          <b class="card__title">3. {{ $t('Количество звёзд') }}</b>
        </header>
        <div class="card__body">
          <SBStarsSelect v-model="payload.stars" name="stars" size="xl" :centered="true" />
        </div>
      </div>
      <div class="card card--edit">
        <header class="card__header">
          <b class="card__title">4. {{ $t('Описание') }}</b>
        </header>
        <div class="card__body">
          <p>Придумайте завлекающий текст с информацией о вашем объекте, чтобы соискатели моги получить больше информации о нём</p>
          <SBTextarea v-model="payload.description"
                      name="description"
                      inputClass="input--white"
                      :placeholder="$t('Ваш текст')"
                      :errors="errors ? errors.description : null"
          />
        </div>
      </div>
      <div class="row row--sm">
        <div class="col col-12 col-lg-6">
          <div class="card card--edit">
            <header class="card__header">
              <b class="card__title">5. {{ $t('Локация') }}</b>
            </header>
            <div class="card__body">
              <div class="edit__field">
                <SBSelect v-model="payload.country"
                          @input="getCities"
                          :label="$t('Страна')"
                          name="country"
                          :items="countriesItems"
                          inputClass="input--white"
                          :placeholder="$t('Выбрать')"
                          :disabled="!countriesItems"
                          :errors="errors && errors.country ? errors.country : null"
                />
              </div>
              <div class="edit__field">
                <SBSelect v-model="payload.city"
                          :label="$t('Город')"
                          name="city"
                          :items="citiesItems"
                          inputClass="input--white"
                          :placeholder="$t('Выбрать')"
                          :disabled="!citiesItems"
                          :errors="errors && errors.city ? errors.city : null"
                />
              </div>
              <div class="edit__field">
                <SBInput v-model="payload.address"
                         :label="$t('Улица и номер дома')"
                         name="address"
                         type="text"
                         inputClass="input--white"
                         :placeholder="$t('Например, улица Абая, 1д')"
                         :errors="errors && errors.address ? errors.address : null"
                />
              </div>
              <div class="edit__field">
                <SBInput v-model="payload.reference_point"
                         :label="$t('Ориентир')"
                         name="reference_point"
                         type="text"
                         inputClass="input--white"
                         :placeholder="$t('Например, музей им. Амира Темура')"
                         :errors="errors && errors.reference_point ? errors.reference_point : null"
                />
              </div>
              <div class="edit__field">
                <SBInput v-model="payload.postcode"
                         :label="$t('Почтовый индекс')"
                         name="postcode"
                         type="text"
                         inputClass="input--white"
                         :placeholder="$t('Например, 100085')"
                         :errors="errors && errors.postcode ? errors.postcode : null"
                />
              </div>
            </div>
          </div>
        </div>
        <div class="col col-12 col-lg-6">
          <div class="card card--edit">
            <header class="card__header">
              <b class="card__title">6. {{ $t('Контактные данные') }}</b>
            </header>
            <div class="card__body">
              <div class="edit__field">
                <SBInput v-model="payload.owner"
                         :label="$t('Владелец')"
                         name="owner"
                         type="text"
                         inputClass="input--white"
                         :placeholder="$t('Имя Фамилия')"
                         :errors="errors && errors.owner ? errors.owner : null"
                />
              </div>
              <div class="edit__field">
                <SBPhone v-model="payload.phone"
                         :label="$t('Номер телефона')"
                         name="phone"
                         type="text"
                         inputClass="input--white"
                         :placeholder="selectedCountry ? $t('Например 8907998555') : $t('Выберите страну')"
                         :errors="errors && errors.phone ? errors.phone : null"
                         :disabled="!selectedCountry"
                         :country="selectedCountry ? selectedCountry : null"
                />
              </div>
              <div class="edit__field">
                <SBInput v-model="payload.email"
                         :label="$t('Электронная почта')"
                         name="email"
                         type="email"
                         inputClass="input--white"
                         :placeholder="$t('Например start@booking.com')"
                         :errors="errors && errors.email ? errors.email : null"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="page__more">
        <router-link :to="{name: 'partner-deals-add-step-3'}" class="btn btn--secondary btn--shadowed btn--lg btn--rounded">
          {{ $t('Дальше') }}
        </router-link>
      </div>
    </form>
  </div>
</template>

<script>
  import { mapState, mapActions, mapGetters } from 'vuex';
  import localMixin from './localMixin';
  import SBInput from "../../components/fields/SBInput";
  import SBImageUploader from "../../components/fields/SBImageUploader";
  import SBStarsSelect from "../../components/fields/SBStarsSelect";
  import SBTextarea from "../../components/fields/SBTextarea";
  import SBSelect from "../../components/fields/SBSelect";
  import {isEmpty} from "../../utils/helpers";
  import SBPhone from "../../components/fields/SBPhone";

  export default {
    name: "SBDealsEdit2",
    components: {SBPhone, SBSelect, SBTextarea, SBStarsSelect, SBImageUploader, SBInput},
    data() {
      return {
        crumbs: [
          { name: this.$t('Добавить объект'), to: {name: 'partner-deals-add-step-1'} },
          { name: this.$t('Шаг 2') }
        ],
        countries: null,
        cities: [],
      }
    },
    methods: {
      ...mapActions('dealsEdit', [
        'getStates',
        'submitStore'
      ]),
      onSubmit() {
        this.submitStore();
      },
      getCountries() {
        this.$api.getCountries(null, (response) => {
          const { status, data } = response;
          if(status === 200) {
            this.$set(this, 'countries', data);
          }
        });
      },
      getCities(country) {
        this.$api.getCities({country}, (response) => {
          const { status, data } = response;
          if(status === 200) {
            this.$set(this, 'cities', data);
          }
        });
      }
    },
    computed: {
      ...mapState('dealsEdit', [
        'payload'
      ]),
      ...mapGetters('dealsEdit', [
          'states',
          'errors'
      ]),
      selectedCountry() {
        const { country } = this.payload;
        if(isEmpty(country)) return null;
        return this.countries.find((item) => item.name === country);
      },
      countriesItems() {
        if(isEmpty(this.countries)) return null;

        return this.countries.map((country) => {
          return {
            value: country.name,
            label: country.name
          }
        })
      },
      citiesItems() {
        if(isEmpty(this.cities)) return null;

        return this.cities.map((city) => {
          return {
            value: city.value,
            label: city.label
          }
        })
      }
    },
    mounted() {
      this.getStates();
      this.getCountries();
    },
    mixins: [localMixin]
  }
</script>
