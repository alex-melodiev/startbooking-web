<template>
  <div class="register">
    <portal to="registerHeader">
      <SBBreadcrumbs :crumbs="crumbs" />
      <br />
      <div class="header__description">
        <p v-html="$t('При заполнении полей обратите внимание на поля помеченные символом “*”. Это поля для обязательного заполнения')"></p>
      </div>
    </portal>
    <form @submit.prevent="onSubmit" class="form" action="/register" method="POST" role="form">
      <div class="form__row">
        <div class="card card--default">
          <header class="card__header">
            <b class="card__title">{{ $t('Данные') }}</b>
          </header>
          <div class="card__body">
            <div class="row">
              <div class="form__col form__col--xs col col-12 col-md-6">
                <SBInput v-model="payload.first_name"
                         :label="$t('Ваше имя')"
                         name="first_name"
                         type="text"
                         inputClass="input--white"
                         :placeholder="$t('Имя')"
                         :errors="errors && errors.first_name ? errors.first_name : null"
                />
              </div>
              <div class="form__col form__col--sm col col-12 col-lg-6">
                <SBInput v-model="payload.last_name"
                         :label="$t('Фамилия')"
                         name="last_name"
                         type="text"
                         inputClass="input--white"
                         :placeholder="$t('Фамилия')"
                         :errors="errors && errors.last_name ? errors.last_name : null"
                />
              </div>
              <div class="form__col form__col--sm col col-12 col-lg-6">
                <SBInput v-model="payload.middle_name"
                         :label="$t('Отчество')"
                         name="middle_name"
                         type="text"
                         inputClass="input--white"
                         :placeholder="$t('Отчество')"
                         :errors="errors ? errors.middle_name : null"
                />
              </div>
              <div class="form__col form__col--sm col col-12 col-lg-6">
                <SBInput v-model="payload.date_of_birth"
                         :label="$t('Дата рождения (дд.мм.гг.)')"
                         name="date_of_birth"
                         type="date"
                         inputClass="input--white"
                         :placeholder="$t('Дата рождения (дд.мм.гг.)')"
                         :errors="errors && errors.middle_name ? errors.middle_name : null"
                />
              </div>
              <div class="form__col form__col--sm col col-12 col-lg-6">
                <SBSelect v-model="payload.gender"
                          :label="$t('Пол')"
                          name="gender"
                          :items="genders"
                          inputClass="input--white"
                          :placeholder="$t('Пол')"
                          :errors="errors && errors.gender ? errors.gender : null"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="form__row">
        <div class="card card--default">
          <header class="card__header">
            <b class="card__title">{{ $t('Локация') }}</b>
          </header>
          <div class="card__body">
            <div class="row">
              <div class="form__col form__col--sm col col-12 col-lg-6">
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
              <div class="form__col form__col--sm col col-12 col-lg-6">
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
            </div>
          </div>
        </div>
      </div>
      <div class="form__row">
        <div class="row">
          <div class="form__col col col-12 col-lg-6">
            <div class="card card--default">
              <header class="card__header">
                <b class="card__title">{{ $t('Контактные данные') }}</b>
              </header>
              <div class="card__body">
                <div class="form__row form__row--sm">
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
                <div class="form__row form__row--sm">
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
          <div class="form__col col col-12 col-lg-6">
            <div class="card card--default">
              <header class="card__header">
                <b class="card__title">{{ $t('Безопасность') }}</b>
              </header>
              <div class="card__body">
                <div class="form__row form__row--sm">
                  <SBInput v-model="payload.password"
                           :label="$t('Пароль')"
                           name="password"
                           type="password"
                           inputClass="input--white"
                           :placeholder="$t('Ваш пароль')"
                           :errors="errors && errors.password ? errors.password : null"
                  />
                </div>
                <div class="form__row form__row--sm">
                  <SBInput v-model="payload.password_confirmation"
                           :label="$t('Подтверждение пароля')"
                           name="password_confirmation"
                           type="password"
                           inputClass="input--white"
                           :placeholder="$t('Повторный ввод')"
                           :errors="errors && errors.password_confirmation ? errors.password_confirmation : null"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="page__more">
        <button class="btn btn--lg btn--secondary btn--rounded" type="submit" :disabled="isSubmitting">{{ $t('Дальше') }}</button>
      </div>
    </form>
  </div>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex';
  import localMixin from './localMixin';
  import SBInput from "../../components/fields/SBInput";
  import SBSelect from "../../components/fields/SBSelect";
  import {isEmpty} from "../../utils/helpers";
  import SBPhone from "../../components/fields/SBPhone";

  export default {
    name: "SBRegister",
    components: {SBPhone, SBSelect, SBInput},
    data() {
      return {
        crumbs: [
          { name: this.$t('Регистация'), to: {name: 'register-step-1'} },
          { name: this.$t('Шаг 1') }
        ],
        payload: {},
        genders: [
          {label: 'Мужской', value: 'male'},
          {label: 'Женский', value: 'female'},
        ],
        countries: null,
        cities: [],
        callbacks: []
      }
    },
    methods: {
      ...mapActions('register', [
        'register'
      ]),
      onSubmit() {
        this.register(this.payload);
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
      ...mapGetters('register', [
        'errors',
        'isSubmitting'
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
    mixins: [localMixin],
    mounted() {
      this.getCountries();
    }
  }
</script>
