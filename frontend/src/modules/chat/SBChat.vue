<template>
  <div class="page__content page__content--white chat">
    <header class="header">
      <div class="page__container">
        <h1 class="page__title">{{ $t('Поддержка') }}</h1>
      </div>
    </header>
    <div class="chat__window">
      <div class="chat__dialog" ref="window">
        <div v-for="(dialog, key) in dialogs" :key="key">
          <div class="chat__message chat__message--date">{{ key }}</div>
          <!--<div v-for="(message, index) in dialog"-->
               <!--class="chat__message"-->
               <!--:class="[message.account_id !== userInfo.id ? 'chat__message&#45;&#45;companion' : 'chat__message&#45;&#45;user']"-->
               <!--:key="index"-->
          <!--&gt;-->
            <!--<div class="chat__message-container">-->
              <!--<figure v-if="message.account_id !== userInfo.id" class="chat__message-avatar">-->
                <!--<img :src="message.avatar" :alt="message.sender" />-->
              <!--</figure>-->
              <!--<div class="chat__message-body">-->
                <!--<div class="chat__message-author">{{ message.sender }}</div>-->
                <!--<div class="chat__message-text" v-html="message.message"></div>-->
              <!--</div>-->
            <!--</div>-->
          <!--</div>-->
        </div>
      </div>
      <div class="chat__entry">
        <form @submit.prevent="onSubmit"
              @keydown.ctrl.enter.prevent="onSubmit"
              class="chat__form"
              action="/"
        >
          <textarea v-model="payload.message"
                    @input="onInput"
                    class="chat__input input input--lg"
                    name="message"
                    cols="10"
                    rows="1"
                    :style="{height: areaHeight + 'px'}"
                    :placeholder="$t('Сообщение...')"
                    :disabled="isSubmitting"
          ></textarea>
          <button class="chat__send" type="submit" role="button" :disabled="isSubmitting">
            <SvgIcon className="icon icon--arrow-left icon--top" name="arrow-left" />
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapActions, mapGetters, mapState } from 'vuex';
  import localMixin from './localMixin';
  import {isNotEmpty} from "../../utils/helpers";
  const areaHeight = 51;


  /**
   * https://github.com/laravel/echo
   * Real time
   */
  import Echo from 'laravel-echo';


  /**
   * Socket.io Client
   * @type {Object}
   */
  window.io = require('socket.io-client');



  /**
   * Socket.io configuration
   */
  window.Echo = new Echo({
      broadcaster: 'socket.io',
      host: process.env.VUE_APP_SERVER_URI + ':6001'
  });

  export default {
    name: "SBChat",
    data() {
      return {
        areaHeight
      }
    },
    methods: {
      ...mapActions('chat', [
        'init',
        'onSubmit'
      ]),
      onInput(e) {
        if(e.target.value) {
          this.areaHeight = (e.target.scrollHeight + 2);
        } else {
          this.$set(this, 'areaHeight', areaHeight);
        }
      },
      scrollWindow() {
        if(isNotEmpty(this.$refs.window)) {
          this.$refs.window.scrollTop = this.$refs.window.scrollHeight;
        }
      }
    },
    computed: {
      ...mapState('chat', [
        'payload'
      ]),
      ...mapGetters('chat', [
        'dialogs',
        'isSubmitting'
      ]),
      ...mapGetters('user', [
        'userInfo'
      ])
    },
    updated() {
      this.scrollWindow();
    },
    mounted() {
      this.init();
      this.scrollWindow();

      window.Echo.channel('chat')
        .listen('Message', ({message}) => {
            console.log(message);
        });
      window.addEventListener('resize', this.scrollWindow);
    },
    mixins: [localMixin],
  }
</script>
