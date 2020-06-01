<template>
  <WhiteLayout>
    <div class="auth">
      <div class="page__container">
        <div class="auth__illustration">
          <img src="@/assets/img/illustration_auth.svg" alt="auth" />
        </div>
        <div class="auth__container">
          <h1 class="auth__title">{{ $t('Добро пожаловать!') }}</h1>
          <div class="auth__text">
            <p>{{ $t('Наконец-то ты добрался до своего личного кабинета. Осталось только войти в него или зарегистрировать аккаунт ;)') }}</p>
          </div>
          <router-link :to="{name: 'login'}" class="btn btn--lg btn--secondary btn--rounded btn--block auth__btn">{{ $t('Войти в аккаунт') }}</router-link>
          <router-link :to="{name: 'register-step-1'}" class="btn btn--lg btn--light btn--rounded btn--block auth__btn">{{ $t('Создать новый аккаунт') }}</router-link>
        </div>
      </div>
    </div>
  </WhiteLayout>
</template>

<script>
  import i18n from "../../modules/i18n";

  export default {
    name: "page-auth-main",
    metaInfo: {
      title: i18n.t('Авторизация / Регистрация'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    }
  }
</script>
