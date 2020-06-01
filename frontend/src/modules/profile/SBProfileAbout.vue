<template>
  <div class="row profile__page profile__about">
    <portal to="profileHeader">
      <SBBreadcrumbs :crumbs="crumbs" />
    </portal>
    <div v-if="isProfileLoading" class="col col-12 col-lg-9 profile__content">
      <SBLoading />
    </div>
    <div v-else-if="profileData" class="col col-12 col-lg-9 profile__content">
      <div class="card card--default profile__col profile__col--grow">
        <header class="card__header">
          <b class="card__title">{{ $t('Настроить личные данные') }}</b>
        </header>
        <div class="card__body">
          <form @submit.prevent="updateProfile()" class="form" action="/profile" role="form">
            <div class="row">
              <div class="form__col form__col--sm col col-12 col-lg-6">
                <SBInput v-model="profileData.first_name"
                         :label="$t('Ваше имя')"
                         name="first_name"
                         type="text"
                         inputClass="input--white"
                         :errors="profileErrors ? profileErrors.first_name : null"
                         :placeholder="$t('Имя')"
                />
              </div>
              <div class="form__col form__col--sm col col-12 col-lg-6">
                <SBInput v-model="profileData.last_name"
                         :label="$t('Фамилия')"
                         name="last_name"
                         type="text"
                         inputClass="input--white"
                         :errors="profileErrors ? profileErrors.last_name : null"
                         :placeholder="$t('Фамилия')"
                />
              </div>
              <div class="form__col form__col--sm col col-12 col-lg-6">
                <SBInput v-model="profileData.middle_name"
                         :label="$t('Отчество')"
                         name="middle_name"
                         type="text"
                         inputClass="input--white"
                         :errors="profileErrors ? profileErrors.middle_name : null"
                         :placeholder="$t('Отчество')"
                />
              </div>
              <div class="form__col form__col--sm col col-12 col-lg-6">
                <SBInput v-model="profileData.date_of_birth"
                         :label="$t('Дата рождения (дд.мм.гг.)')"
                         name="date_of_birth"
                         type="date"
                         inputClass="input--white"
                         :errors="profileErrors ? profileErrors.date_of_birth : null"
                         :placeholder="$t('Фамилия')"
                />
              </div>
              <div class="form__col form__col--sm col col-12 col-lg-6">
                <SBSelect v-model="profileData.gender"
                          :label="$t('Пол')"
                          name="gender"
                          :items="genders"
                          inputClass="input--white"
                          :errors="profileErrors ? profileErrors.gender : null"
                          :placeholder="$t('Пол')"
                />
              </div>
            </div>
            <button class="btn btn--primary btn--block"
                    :disabled="profileIsSubmitting"
                    type="submit"
                    role="button"
            >{{ $t('Сохранить') }}</button>
          </form>
        </div>
      </div>
      <div class="card card--default profile__col">
        <header class="card__header">
          <b class="card__title">{{ $t('Локация') }}</b>
        </header>
        <div class="card__body">
          <form class="form" action="/profile">
            <div class="row">
              <div class="form__col form__col--sm col col-12 col-lg-6">
                <SBSelect v-model="profileData.country"
                          :label="$t('Страна')"
                          name="country"
                          :items="countries"
                          inputClass="input--white"
                          :placeholder="$t('Страна')"
                />
              </div>
              <div class="form__col form__col--sm col col-12 col-lg-6">
                <SBSelect v-model="profileData.city"
                          :label="$t('Город')"
                          name="city"
                          :items="cities"
                          inputClass="input--white"
                          :placeholder="$t('Город')"
                />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapActions, mapGetters, mapState } from 'vuex';
  import SBSelect from "../../components/fields/SBSelect";
  import SBInput from "../../components/fields/SBInput";
  import SBLoading from "../../components/blocks/SBLoading";

  export default {
    name: "SBProfileAbout",
    data() {
      return {
        crumbs: [
          { name: this.$t('Профиль'), to: {name: 'user-profile'} },
          { name: this.$t('Личная информация') }
        ],
        genders: [
          {name: 'Мужской', value: 'male'},
          {name: 'Женский', value: 'female'},
        ],
        countries: [
          {value: 'uz', name: 'Узбекистан'},
          {value: 'ru', name: 'Россия'},
          {value: 'us', name: 'США'}
        ],
        cities: [
          {value: 'tashkent', name: 'Ташкент'},
          {value: 'samarkand', name: 'Самарканд'}
        ]
      }
    },
    components: {SBLoading, SBSelect, SBInput},
    methods: {
      ...mapActions('profile', [
        'updateProfile'
      ])
    },
    computed: {
      ...mapState('profile', [
        'profileData'
      ]),
      ...mapGetters('profile', [
        'isProfileLoading',
        'profileIsSubmitting',
        'profileErrors'
      ])
    }
  }
</script>
