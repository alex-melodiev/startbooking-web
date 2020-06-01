<template>
  <div class="profile__page profile__contacts">
    <portal to="profileHeader">
      <SBBreadcrumbs :crumbs="crumbs" />
    </portal>
    <div class="profile__content">
      <div class="row profile__stretch">
        <div class="col col-12 col-md-6 profile__content">
          <div class="card card--default profile__col">
            <header class="card__header">
              <b class="card__title">{{ $t('Контактные данные') }}</b>
            </header>
            <div class="card__body">
              <form action="/user/contacts" method="POST" role="form">
                <div class="form__row form__row--sm">
                  <SBInput v-model="payload.phone"
                           :label="$t('Номер телефона')"
                           name="phone"
                           type="text"
                           inputClass="input--white"
                           placeholder="8"
                  />
                </div>
                <div class="form__row form__row--sm">
                  <SBInput v-model="payload.phone_2"
                           :label="$t('Дополнительный номер телефона')"
                           name="phone_2"
                           type="text"
                           inputClass="input--white"
                           placeholder="8"
                  />
                </div>
                <div class="form__row form__row--sm">
                  <SBInput v-model="payload.email"
                           :label="$t('Электронная почта')"
                           name="email"
                           type="email"
                           inputClass="input--white"
                           :placeholder="$t('Например start@booking.com')"
                  />
                </div>
                <div class="form__row form__row--sm">
                  <SBSelect v-model="payload.callback"
                            :label="$t('Предпочтительный способ связи')"
                            name="callback"
                            :items="callbacks"
                            inputClass="input--white"
                            :placeholder="$t('Тип связи')"
                  />
                </div>
              </form>
            </div>
          </div>
          <div class="card card--default profile__col profile__col--grow">
            <header class="card__header">
              <b class="card__title">{{ $t('Социальные сети') }}</b>
            </header>
            <div class="card__body">
              <nav class="networks networks--center">
                <ul>
                  <li v-for="network in networks" :key="network.name">
                    <a :href="network.url"
                       :class="'network network--' + network.name"
                       :title="network.title"
                       target="_blank"
                    >
                      <SvgIcon :className="'icon icon--' + network.name" :name="network.name" />
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
        <div class="col col-12 col-md-6">
          <div class="card card--default card--stretch profile__col">
            <header class="card__header">
              <b class="card__title">{{ $t('Смена пароля') }}</b>
            </header>
            <div class="card__body">
              <form action="/user/password" method="POST" role="form">
                <div class="form__row form__row--sm">
                  <SBInput v-model="payload.old_password"
                           :label="$t('Текущий пароль')"
                           name="old_password"
                           type="text"
                           inputClass="input--white"
                           :placeholder="$t('Ваш пароль')"
                  />
                </div>
                <div class="form__row form__row--sm">
                  <SBInput v-model="payload.new_password"
                           :label="$t('Новый пароль')"
                           name="new_password"
                           type="text"
                           inputClass="input--white"
                           :placeholder="$t('Введите новый пароль')"
                  />
                </div>
                <div class="form__row form__row--sm">
                  <SBInput v-model="payload.confirm_password"
                           :label="$t('Подтверждение паролья')"
                           name="confirm_password"
                           type="email"
                           inputClass="input--white"
                           :placeholder="$t('Введите новый пароль повторно')"
                  />
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import i18n from "../../../modules/i18n";
  import SBInput from "../../../components/fields/SBInput";
  import SBSelect from "../../../components/fields/SBSelect";
  import Model from "../../../models/home";

  export default {
    name: "page-user-profile-contacts",
    components: {SBSelect, SBInput},
    metaInfo: {
      title: i18n.t('Контакты и пароли'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    },
    data() {
      return {
        crumbs: [
          { name: this.$t('Профиль'), to: {name: 'user-profile'} },
          { name: this.$t('Контакты и пароли') }
        ],
        payload: {
          callback: 'messengers'
        },
        networks: Model.networks,
        callbacks: [
          {name: 'Мессенджеры', value: 'messengers'},
          {name: 'Звонки', value: 'calls'},
          {name: 'СМС', value: 'sms'},
        ]
      }
    }
  }
</script>

<style scoped>

</style>
