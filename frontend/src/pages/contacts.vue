<template>
  <div class="page__content contacts">
    <header class="header">
      <div class="page__container">
        <h1 class="page__title">{{ $t('Контакты') }}</h1>
      </div>
    </header>
    <div class="page__container">
      <div class="row">
        <div class="col col-12 col-md-6 col-lg-4 contacts__col">
          <b class="contacts__label">{{ $t('Номер телефона') }}</b>
          <div class="contacts__info">
            <a :href="'tel:'+site.phone">{{ site.phone }}</a>
          </div>
        </div>
        <div class="col col-12 col-md-6 col-lg-4 contacts__col">
          <b class="contacts__label">{{ $t('Электронная почта') }}</b>
          <div class="contacts__info">
            <a :href="'mailto:'+site.phone">{{ site.email }}</a>
          </div>
        </div>
        <div class="col col-12 col-md-6 col-lg-4 contacts__col">
          <b class="contacts__label">{{ $t('Социальные сети') }}</b>
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
        <div class="col col-12 col-md-6 col-lg-4 contacts__col">
          <b class="contacts__label">{{ $t('Адрес') }}</b>
          <div class="contacts__info">
            {{ site.address_1 }},<br />
            {{ site.address_2 }},<br />
            {{ site.address_3 }},<br />
            {{ site.address_4 }}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col col-12 col-lg-8">
          <div class="contacts__map">
            <GmapMap
                :center="{lat:41.3053604, lng:69.270975}"
                :zoom="12"
                :zoomControl="false"
                :scaleControl="false"
                style="height: 348px"
            >
              <GmapMarker :position="{lat:41.3053604, lng:69.270975}"
                          title="Hello World!"
                          @click="center={lat:41.3053604, lng:69.270975}"
              />
            </GmapMap>
            <div class="contacts__illustration">
              <img src="@/assets/img/illustration_contacts.svg" alt="contatcs" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import i18n from "../modules/i18n";
  import Model from "../models/home";

  export default {
    name: "contacts",
    metaInfo: {
      title: i18n.t('Контакты'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    },
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
        networks: Model.networks
      }
    }
  };
</script>
