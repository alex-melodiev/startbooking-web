import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import i18n from "./modules/i18n";
import VueMeta from "vue-meta";
import vClickOutside from 'v-click-outside';
import GrayLayout from './layouts/GrayLayout';
import WhiteLayout from './layouts/WhiteLayout';
import SBBreadcrumbs from './components/blocks/SBBreadcrumbs';
import SBStats from './components/blocks/SBStats';
import SvgIcon from './components/ui/SvgIcon';
import VueAwesomeSwiper from 'vue-awesome-swiper';
import * as VueGoogleMaps from 'vue2-google-maps';
import 'swiper/dist/css/swiper.css'
import { isMobileOnly, isTablet } from 'mobile-device-detect';
import PortalVue from 'portal-vue'
import Toasted from 'vue-toasted';
import api from "./plugins/api";
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/ru';


Vue.use(api);
Vue.use(VueGoogleMaps, {
  load: {
    key: process.env.VUE_APP_GOOGLE_MAP_KEY,
    libraries: 'places',
    installComponents: true
  }
});

Vue.use(VueMeta, {
  refreshOnceOnNavigation: true
});
Vue.use(vClickOutside);
Vue.use(VueAwesomeSwiper);
Vue.use(PortalVue);
Vue.use(Toasted);

Vue.component('GrayLayout', GrayLayout);
Vue.component('WhiteLayout', WhiteLayout);
Vue.component('SBBreadcrumbs', SBBreadcrumbs);
Vue.component('SBStats', SBStats);
Vue.component('SvgIcon', SvgIcon);
Vue.component('DatePicker', DatePicker);

Vue.prototype.$isMobile = isMobileOnly;
Vue.prototype.$isTablet = isTablet;

Vue.config.productionTip = false;

new Vue({
  i18n,
  router,
  store,
  render: h => h(App)
}).$mount("#app");
