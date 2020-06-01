<template>
  <div class="login">
    <div class="page__container">
      <form @submit.prevent="onSubmit" class="login__container" action="/login">
        <div class="card card--login">
          <header class="card__header">
            <b class="card__title">{{ $t('Вход в аккаунт') }}</b>
          </header>
          <div class="card__body">
            <div class="card__description">
              <p>{{ $t('Введите адрес своей почты или номер телефона и пароль, чтобы войти') }}</p>
            </div>
            <div class="login__field">
              <SBInput v-model="payload.email"
                       name="email"
                       type="email"
                       inputClass="input input--lg input--centered"
                       :placeholder="$t('Электронная почта/номер телефона')"
                       :errors="errors && errors.email ? errors.email : null"
              />
            </div>
            <div class="login__field">
              <SBInput v-model="payload.password"
                       name="password"
                       type="password"
                       inputClass="input input--lg input--centered"
                       :placeholder="$t('Пароль')"
                       :errors="errors && errors.password ? errors.password : null"
              />
            </div>
          </div>
          <div class="login__illustration">
            <img src="@/assets/img/illustration_login.svg" alt="login" />
          </div>
        </div>
        <div class="login__action">
          <SBCheckbox v-model="payload.remember_me"
                      :use="true"
                      :label="$t('Запомнить меня')"
                      theme="secondary"
                      name="remember_me"
          />
          <router-link :to="{name: 'forgot'}">{{ $t('Забыли пароль?') }}</router-link>
        </div>

        <button class="btn btn--lg btn--secondary btn--rounded btn--block login__btn" type="submit" role="button" :disabled="isSubmitting">{{ $t('Войти') }}</button>
        <router-link :to="{name: 'register'}" class="btn btn--lg btn--light btn--rounded btn--block login__btn">{{ $t('У меня нету аккаунта') }}</router-link>
      </form>
    </div>
  </div>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex';
  import localMixin from './localMixin';
  import SBCheckbox from "../../components/fields/SBCheckbox";
  import SBInput from "../../components/fields/SBInput";

  export default {
    name: "SBLogin",
    components: {SBInput, SBCheckbox},
    data() {
      return {
        payload: {
          email: null,
          password: null,
          remember_me: true
        }
      }
    },
    methods: {
      ...mapActions('login', [
        'login'
      ]),
      onSubmit() {
        this.login(this.payload);
      }
    },
    computed: {
      ...mapGetters('login', [
        'errors',
        'isSubmitting'
      ])
    },
    mixins: [localMixin]
  }
</script>

<style scoped>

</style>
