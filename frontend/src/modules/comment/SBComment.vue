<template>
  <div class="comment">
    <header v-if="isGuest" class="comment__header">
      <b class="comment__title">{{ $t('Зарегистрируйтесь чтобы вступить в обсуждение') }}</b>
      <p>{{ $t('Добавьте свой отзыв о инвестидее, войдя в систему или зарегистрировавшись.') }}</p>
      <div class="comment__auth">
        <router-link :to="{name: 'register'}" class="comment__btn btn btn--sm btn--primary btn--rounded">{{ $t('Зарегистрироваться по электронной почте') }}</router-link>
        <span>{{ $t('или') }}</span>
        <button class="btn btn--icon btn--sm btn--facebook">
          <SvgIcon className="btn__icon icon icon--facebook" name="facebook" />
        </button>
        <button class="btn btn--icon btn--sm btn--google">
          <SvgIcon className="btn__icon icon icon--google" name="google" />
        </button>
      </div>
    </header>
    <form v-else @submit.prevent="onSubmit" action="/comments" class="comment__form" role="form">
      <div class="comment__item">
        <figure class="comment__figure">
          <img :src="userInfo.profile_src" :alt="userInfo.first_name + ' ' + userInfo.last_name" />
        </figure>
        <div class="comment__row">
          <div class="comment__content">
            <SBTextarea v-model="payload.message"
                        name="message"
                        inputClass="input--white"
                        :placeholder="$t('Напишите ваше мнение')"
                        :errors="errors ? errors.message : null"
            />
            <br />
            <div class="row">
              <div class="col col-6 col-lg-4">
                <SBSelect v-model="payload.rating"
                          :label="$t('Ваша оценка') + ':'"
                          name="stars"
                          :items="stars"
                          inputClass="input--white"
                          icon="star"
                          :placeholder="$t('Выбрать')"
                          :errors="errors ? errors.rating : null"
                />
              </div>
              <div class="col col-6 col-lg-4 col--end">
                <button class="btn btn--primary" type="submit" role="button">{{ $t('Отправить') }}</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
    <div v-if="comments && comments.length"  class="comment__body">
      <div class="comment__list">
        <div v-for="comment in comments" class="comment__item" :key="comment.id">
          <figure v-if="comment.user" class="comment__figure">
            <img :src="comment.user.profile_src" :alt="comment.user.first_name +  ' ' + comment.user.last_name" />
          </figure>
          <div class="comment__row">
            <div class="comment__content">
              <div v-if="comment.user" class="comment__heading">
                <span class="comment__date">{{ timeSince(comment.created_at) }}</span>
                <b v-if="comment.user.first_name" class="comment__author">{{ comment.user.first_name +  ' ' + comment.user.last_name }}</b>
                <b v-else class="comment__author">{{ $t('Неопознанная панда') }}</b>
              </div>
              <div class="comment__description" v-html="comment.message"></div>
            </div>
            <div v-if="comment.rating" class="comment__rating">
              <SvgIcon className="icon icon--star" name="star" />
              <span>{{ comment.rating }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
<!--    <footer class="comment__footer">-->
<!--      <button class="comment__action comment__action&#45;&#45;primary" type="button" role="button">-->
<!--        <span>{{ $t('Смотреть другие комментарии') }}</span>-->
<!--        <SvgIcon className="icon icon&#45;&#45;arrow icon&#45;&#45;bottom" name="arrow-left" />-->
<!--      </button>-->
<!--    </footer>-->
  </div>
</template>

<script>
  import { mapGetters } from 'vuex';
  import localMixin from './localMixin';
  import TimeAgo from 'javascript-time-ago';
  import ru from 'javascript-time-ago/locale/ru';
  import SBTextarea from "../../components/fields/SBTextarea";
  import SBSelect from "../../components/fields/SBSelect";
  import {isNotEmpty} from "../../utils/helpers";
  TimeAgo.addLocale(ru);

  export default {
    name: "SBComment",
    components: {SBSelect, SBTextarea},
    props: {
      comments: {
        type: Array,
        required: false
      },
      id: {
        type: [String, Number],
        required: true
      }
    },
    data() {
      return {
        payload: {
          message: null,
          rating: '',
        },
        errors: null,
        stars: [
          {value: 1, label: 1},
          {value: 2, label: 2},
          {value: 3, label: 3},
          {value: 4, label: 4},
          {value: 5, label: 5},
          {value: 6, label: 6},
          {value: 7, label: 7},
          {value: 8, label: 8},
          {value: 9, label: 9},
          {value: 10, label: 10},
        ],
      }
    },
    methods: {
      timeSince(date) {
        const commentDate = new Date(date);
        const timeAgo = new TimeAgo('ru-RU');
        return timeAgo.format(commentDate);
      },
      async onSubmit() {
        this.$set(this, 'errors', null);
        await this.$api.addCommentToDeal({id: this.id, payload: this.payload}, (response) => {
          const { data, status } = response;
          if(status === 200) {
            const { succes } = data;
            this.$toasted.show(succes, {
              position: 'bottom-center',
              type: 'success',
              duration: 2000
            });
            this.$set(this, 'payload', {});
          }
        }, (catchErrors) => {
          const { data } = catchErrors;
          const { errors } = data;
          if(isNotEmpty(errors)) {
            this.$set(this, 'errors', errors);
          }
          this.$toasted.show(this.$t('Ощибка при отправке отзыва'), {
            position: 'bottom-center',
            type: 'error',
            duration: 2000
          });
        });
      }
    },
    computed: {
      ...mapGetters('user', [
        'isGuest',
        'accessToken',
        'userInfo'
      ])
    },
    mixins: [localMixin]
  }
</script>
