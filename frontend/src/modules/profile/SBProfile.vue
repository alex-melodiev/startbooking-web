<template>
  <div class="card card--single">
    <portal to="profileHeader">
      <h1 class="page__title">{{ 'Профиль' }}</h1>
    </portal>
    <div v-if="profileData" class="profile__user">
      <figure class="profile__figure">
        <img v-if="profileData.profile_src" :src="profileData.profile_src" alt="" />
        <img v-else src="https://via.placeholder.com/256x256" alt="" />
        <label class="profile__select" for="avatar">
          <SvgIcon className="icon icon--camera" name="camera" />
        </label>
      </figure>
      <div v-if="profileData.first_name || profileData.last_name" class="profile__name">
        {{ profileData.first_name ? profileData.first_name : null }}
        {{ profileData.last_name ? profileData.last_name : null }}
      </div>
      <div class="profile__position">Предпочтительно мессенджеры</div>
      <input @change="onChangeAvatar" class="profile__file" id="avatar" type="file" name="avatar" ref="avatarField" />
    </div>
    <div v-if="profileData" class="profile__stats">
      <div class="profile__stat">
        <div class="profile__stat-value">{{ profileData.bookings_count }}</div>
        <div class="profile__stat-key">{{ $t('Посещений объектов') }}</div>
      </div>
      <div class="profile__stat">
        <div class="profile__stat-value">{{ profileData.reviews_count }}</div>
        <div class="profile__stat-key">{{ $t('Отзывов по объектам') }}</div>
      </div>
      <div class="profile__stat">
        <div class="profile__stat-value">
          <span>{{ profileData.avg_rating }}</span>
          <SvgIcon className="icon icon--star" name="star" />
        </div>
        <div class="profile__stat-key">{{ $t('Впечатление от отдыха') }}</div>
      </div>
    </div>
    <b class="profile__label profile__label--center">{{ $t('Настройки аккаунта') }}</b>
    <nav v-if="menu" class="profile__nav">
      <router-link v-for="(item, index) in menu" :to="{name: item.page}" :key="index">{{ $t(item.name) }}</router-link>
    </nav>
  </div>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex';
  import Modal from '../../models/profile';
  import localMixin from './localMixin';

  export default {
    name: "SBProfile",
    data() {
      return {
        menu: Modal.menu
      }
    },
    methods: {
      ...mapActions('profile', [
        'getProfile',
        'updateProfile'
      ]),
      onChangeAvatar(event) {
        const input = event.target;
        this.updateProfile(input.files[0]);
      }
    },
    computed: {
      ...mapGetters('profile', [
        'profileData'
      ])
    },
    mounted() {
      this.getProfile();
    },
    mixins: [localMixin]
  }
</script>

<style scoped>

</style>
