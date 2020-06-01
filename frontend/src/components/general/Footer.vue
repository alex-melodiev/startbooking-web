<template>
  <footer class="footer">
    <div class="page__container footer__container">
      <b class="footer__title">{{ $t('С нами удобнее!') }}</b>

      <div class="footer__row row">
        <div class="col col-12 col-lg-4">
          <div class="footer__info">
            <p v-html="$t('Подпишитесь на рассылку и получайте новости от name первыми', {name: site.name})"></p>
          </div>
          <form class="footer__subscription" action="/subscribe">
            <SBMDInput v-model="subscribe" :label="$t('Ваш e-mail')" />
          </form>
        </div>
        <div class="col col-12 col-lg-4">
          <div class="footer__info">
            <b class="footer__label">{{ $t('Горячая линия') }}</b>
            <a :href="'tel:'+site.phone">{{ site.phone }}</a>
          </div>
          <div class="footer__info">
            <b class="footer__label">{{ $t('Почта') }}</b>
            <a :href="'mailto:'+site.phone">{{ site.email }}</a>
          </div>
        </div>
        <div class="col col-12 col-lg-4">
          <div class="footer__info">
            <b class="footer__label">{{ $t('Офис компании') }}</b>
            {{ site.address_1 }},<br />
            {{ site.address_2 }},<br />
            {{ site.address_3 }},<br />
            {{ site.address_4 }}
          </div>
        </div>
      </div>

      <div class="footer__row row">
        <div class="col col-12 col-lg-4">
          <div class="footer__oses">
            <div class="footer__os">
            <a :href="url.android" target="_blank">
              <picture>
                <source srcset="@/assets/img/button_play_market@2x.png">
                <img src="@/assets/img/button_play_market.png" alt="Play market" />
              </picture>
            </a>
          </div>
            <div class="footer__os">
              <a :href="url.ios" target="_blank">
                <picture>
                  <source srcset="@/assets/img/button_app_store@2x.png">
                  <img src="@/assets/img/button_app_store.png" alt="App store" />
                </picture>
              </a>
            </div>
          </div>
        </div>
        <div class="col col-12 col-lg-4">
          <nav class="footer__nav">
            <ul>
              <li v-for="item in menu" :key="item.page">
                <router-link :to="{name: item.page}">{{ $t(item.name) }}</router-link>
              </li>
            </ul>
          </nav>
        </div>
        <div class="col col-12 col-lg-4">
          <nav class="networks">
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

      <div class="footer__caption">
        <div class="row">
          <div class="col col-12 col-lg-auto">© {{ new Date().getFullYear() }},  {{ site.name }}™</div>
          <div class="col col-12 col-lg-auto">Art Direction <strong>Anvar Rizaev</strong></div>
          <div class="col col-12 col-lg-auto">
            <router-link :to="{name: 'home'}">{{ $t('Соглашение о конфиденциальности') }}</router-link>
          </div>
        </div>
      </div>
      <div class="footer__illustration">
        <img src="@/assets/img/illustration_footer.svg" alt="footer" />
      </div>
    </div>
  </footer>
</template>

<script>
  import Model from "../../models/home";
  import SBMDInput from "../fields/SBMDInput";

  export default {
    name: "Footer",
    data() {
      return {
        subscribe: null,
        site: {
          name: process.env.VUE_APP_TITLE,
          phone: process.env.VUE_APP_PHONE,
          email: process.env.VUE_APP_EMAIL,
          address_1: process.env.VUE_APP_ADDRESS_1,
          address_2: process.env.VUE_APP_ADDRESS_2,
          address_3: process.env.VUE_APP_ADDRESS_3,
          address_4: process.env.VUE_APP_ADDRESS_4
        },
        url: {
          android: process.env.VUE_APP_URL_ANDROID,
          ios: process.env.VUE_APP_URL_IOS
        },
        menu: Model.menu,
        networks: Model.networks
      }
    },
    components: {SBMDInput},
  }
</script>

<style scoped>

</style>
