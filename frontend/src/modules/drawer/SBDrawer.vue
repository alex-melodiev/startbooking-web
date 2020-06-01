<template>
  <div class="drawer"
       v-click-outside="onClickOutside"
       :class="[isDrawerOpened ? 'drawer--opened' : 'drawer--closed']"
  >
    <button @click="toggleDrawer" class="drawer__toggle"></button>
    <header class="drawer__header">
      <div class="drawer__logo">
        <router-link @click.native="toggleDrawer" :to="{name: 'home'}" :title="site.name" role="button">
          <img src="@/assets/img/logo.svg" :alt="site.name" />
        </router-link>
      </div>
    </header>
    <nav class="drawer__nav">
      <ul class="drawer__list">
        <li v-for="(item, index) in menu" class="drawer__item" :key="item.page + ' -' + index">
          <router-link @click.native="toggleDrawer"
                       :to="{name: item.page}"
                       :class="'drawer__link--' + item.page"
                       class="drawer__link"
          >{{ $t(item.name) }}</router-link>
        </li>
      </ul>
    </nav>
    <footer class="drawer__footer">
      <template v-if="isGuest">
        <router-link @click.native="toggleDrawer"
                     :to="{name: 'auth-main'}"
                     class="btn btn--primary btn--shadowed btn--block"
                     :class="[$isMobile ? '' : 'btn--lg']"
                     role="button">
          {{ $t('Авторизация / Регистрация') }}
        </router-link>
      </template>
      <template v-else-if="userInfo">
        <div class="drawer__user">
          <router-link @click.native="toggleDrawer" :to="{name: 'user-profile'}" class="drawer__user-avatar">
            <img :src="userInfo.profile_src" :alt="userInfo.first_name + ' ' + userInfo.last_name" />
          </router-link>
          <div class="drawer__user-content">
            <div v-if="userInfo.first_name || userInfo.last_name" class="drawer__user-name">
              <router-link @click.native="toggleDrawer" :to="{name: 'user-profile'}">
                {{ userInfo.first_name + ' ' + userInfo.last_name }}
              </router-link>
            </div>
            <router-link @click.native="toggleDrawer"
                         :to="{name: 'logout'}"
                         class="drawer__user-logout"
                         role="button">
              <SvgIcon className="icon icon--logout" name="logout" />
              <span>{{ $t('Выход') }}</span>
            </router-link>
          </div>
        </div>
        <router-link @click.native="toggleDrawer" :to="{name: 'partner-welcome'}" role="button">
          {{ $t('Перейти на партнёрский профиль') }}
        </router-link>
      </template>
    </footer>
  </div>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex';
  import localMixin from './localMixin';

  export default {
    name: "SBDrawer",
    props: {
      menu: {
        type: Array,
        required: false
      }
    },
    data() {
      return {
        site: {
          name: process.env.VUE_APP_TITLE
        }
      }
    },
    methods: {
      ...mapActions('drawer', {
        toggleDrawer: 'toggle'
      }),
      onClickOutside(e) {
        if(this.isDrawerOpened && e.target.className !== 'sidebar__toggle') {
          this.toggleDrawer();
        }
      },
      keyDown(event) {
        if (event.key === 'Escape') {
          if(this.isDrawerOpened) {
            this.toggleDrawer();
          }
        }
      },
      bindEventListener: function () {
        window.addEventListener('keydown', this.keyDown);
      },
      unbindEventListener: function () {
        window.removeEventListener('keydown', this.keyDown);
      },
    },
    computed: {
      ...mapGetters('drawer', {
        isDrawerOpened: 'isOpened'
      }),
      ...mapGetters('user', [
        'isGuest',
        'userInfo'
      ])
    },
    mixins: [localMixin],
    mounted() {
      this.bindEventListener()
    }
  }
</script>

<style scoped>

</style>
