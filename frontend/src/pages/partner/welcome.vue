<template>
  <div class="home home--gray">
    <div class="card card--hint">
      <header class="card__header">
        <b class="card__title">{{ $t('Внимание!') }}</b>
      </header>
      <div class="card__body">
        {{ $t("Во избежании проблем с настройкой и использованием аккаунтов, создавая партнёрский профиль, в дальнейшем вы сможете использовать его только для конкретных назначений") }}
      </div>
    </div>
    <div class="home__partner">
      <div class="home__text">
        <h1 class="home__title">{{ $t('Добро пожаловать!') }}</h1>
        <p v-html="$t('В этом экране вы можете добавить один или несколько объектов для последующей активации обьявлений')"></p>
        <router-link :to="{name: 'partner-deals-add'}" class="btn btn--secondary btn--shadowed btn--lg btn--rounded">{{ $t('Добавить объект') }}</router-link>
      </div>
      <div class="home__hint">

      </div>
    </div>
    <div class="home__helper">
      {{ $t('Start Booking 2019. Все права защищены') }}
    </div>
    <div class="home__illustration home__illustration--left-bottom">
      <img src="@/assets/img/illustration_partner_1.svg" alt="welcome" />
    </div>
    <div class="home__illustration home__illustration--right-bottom">
      <img src="@/assets/img/illustration_partner_2.svg" alt="welcome" />
    </div>
  </div>
</template>

<script>
  export default {
    name: "page-partner-welcome"
  }
</script>

<style scoped>

</style>
