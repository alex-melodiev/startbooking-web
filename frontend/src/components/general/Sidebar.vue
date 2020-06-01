<template>
  <aside class="sidebar">
    <div class="sidebar__logo">
      <router-link :to="{name: 'home'}" :title="site.name" role="button">
        <img src="@/assets/img/logo_mini.svg" :alt="site.name" />
      </router-link>
    </div>
    <button @click="toggleDrawer" class="sidebar__toggle">
      <span></span>
    </button>
    <div v-if="locales" class="sidebar__locales">
      <div v-for="locale in locales"
           class="sidebar__locale"
           :key="locale.code"
      >
        <router-link @click.native="onChangeLocale"
                     :to="displayUrl(locale.code)"
                     :title="locale.name"
        >{{ locale.code}}</router-link>


      </div>
    </div>
  </aside>
</template>

<script>
  import { mapActions } from 'vuex';
  import {Locales} from "../../modules/i18n";
  import {isNotEmpty} from "../../utils/helpers";

  export default {
    name: "Sidebar",
    data() {
      return {
        site: {
          name: process.env.VUE_APP_TITLE
        },
        isOpened: false,
        locales: Locales
      }
    },
    methods: {
      ...mapActions('drawer', {
        toggleDrawer: 'toggle'
      }),
      onChangeLocale(e) {
        e.preventDefault();
        window.location.href = e.target.href;
      },
      displayUrl(code) {
        const currentPath = this.$route.fullPath;
        const currentLang = this.$route.params.lang;
        let pureUrl = `${code}/${currentPath}`;
        if(isNotEmpty(currentLang)) {
          pureUrl = currentPath.replace(currentLang, code);
        }
        return pureUrl;
      }
    }
  }
</script>

<style scoped>

</style>
