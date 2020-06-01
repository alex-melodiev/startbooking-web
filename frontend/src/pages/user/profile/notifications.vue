<template>
  <div class="profile__page profile__notification">
    <portal to="profileHeader">
      <SBBreadcrumbs :crumbs="crumbs" />
    </portal>
    <div class="profile__content">
      <div class="row profile__stretch">
        <div class="col col-12 col-md-6 profile__content">
          <div class="card card--default profile__col">
            <header class="card__header">
              <b class="card__title">{{ $t('Сообщения') }}</b>
            </header>
            <div class="card__body">
              <div class="card__description">
                <p>{{ $t('Получать сообщения от администрации о важных изменениях в сервисе') }}</p>
              </div>

              <div class="card__field">
                <SBCheckbox v-model="payload.message.email"
                            :use="true"
                            :label="$t('Электронные письма')"
                            theme="secondary"
                            name="email"
                />
              </div>
              <div class="card__field">
                <SBCheckbox v-model="payload.message.sms"
                            :use="true"
                            :label="$t('SMS-сообщения')"
                            theme="secondary"
                            name="sms"
                />
              </div>
            </div>
          </div>
          <div class="card card--default profile__col profile__col--grow">
            <header class="card__header">
              <b class="card__title">{{ $t('Советы и рекламные материалы') }}</b>
            </header>
            <div class="card__body">
              <div class="card__description">
                <p>{{ $t('Получать сообщения от администрации о важных изменениях в сервисе') }}</p>
              </div>

              <div class="card__field">
                <SBCheckbox v-model="payload.ads.email"
                            :use="true"
                            :label="$t('Электронные письма')"
                            theme="secondary"
                            name="email"
                />
              </div>
              <div class="card__field">
                <SBCheckbox v-model="payload.ads.sms"
                            :use="true"
                            :label="$t('SMS-сообщения')"
                            theme="secondary"
                            name="sms"
                />
              </div>
              <div class="card__field">
                <SBCheckbox v-model="payload.ads.calls"
                            :use="true"
                            :label="$t('Телефонные звонки')"
                            theme="secondary"
                            name="sms"
                />
              </div>
            </div>
          </div>
        </div>
        <div class="col col-12 col-md-6">
          <div class="card card--default card--stretch profile__col">
            <header class="card__header">
              <b class="card__title">{{ $t('Поддержка аккаунта') }}</b>
            </header>
            <div class="card__body">
              <div class="card__description">
                <p>Иногда нам нужно обращаться к вам по вопросам, связанным с вашим аккаунтом, поездками, юридическими особенностями, безопасностью и конфеденциальностью, а также отвечать на ваши вопросы о помощи. Ради вашей бещопасности отключить уведомления на электронную почту нельзя. Кроме того, при необзодимости мы можем связаться с вами по телефону или иным способом.</p>
              </div>

              <div class="card__field">
                <SBCheckbox v-model="payload.support.email"
                            :use="true"
                            :label="$t('Электронные письма')"
                            theme="secondary"
                            name="email"
                />
              </div>
              <div class="card__field">
                <SBCheckbox v-model="payload.support.sms"
                            :use="true"
                            :label="$t('SMS-сообщения')"
                            theme="secondary"
                            name="sms"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import i18n from "../../../modules/i18n";
  import SBCheckbox from "../../../components/fields/SBCheckbox";

  export default {
    name: "page-user-profile-notifications",
    components: {SBCheckbox},
    metaInfo: {
      title: i18n.t('Уведомления'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    },
    data() {
      return {
        crumbs: [
          { name: this.$t('Профиль'), to: {name: 'user-profile'} },
          { name: this.$t('Уведомления') }
        ],
        payload: {
          message: {
            email: true,
            sms: false
          },
          ads: {
            email: true,
            sms: false,
            calls: false
          },
          support: {
            email: true,
            sms: false
          }
        }
      }
    }
  }
</script>

<style scoped>

</style>
