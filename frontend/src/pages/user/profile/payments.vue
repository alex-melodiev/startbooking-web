<template>
  <div class="profile__page profile__payments">
    <portal to="profileHeader">
      <SBBreadcrumbs :crumbs="crumbs" />
    </portal>
    <div class="profile__content">
      <div class="card card--default profile__col">
        <header class="card__header">
          <b class="card__title">{{ $t('Мои карты') }}</b>
        </header>
        <div class="card__body">
          <div class="billings">
            <div class="billing">
              <div class="card card--billing card--dark" style="background-color: #4F4F4F">
                <header class="card__header">
                  <b class="card__title">Kapitalbank</b>
                </header>
                <div class="card__body">
                  <div class="card__chip"></div>
                  <div class="card__number">
                    <span>XXXX</span>
                    <span>XXXX</span>
                    <span>XXXX</span>
                    <span>XXXX</span>
                  </div>
                </div>
                <footer class="card__footer">
                  <div class="card__details">
                    <div class="card__detail">
                      <div class="card__small">Card holder</div>
                      <div class="card__value">John Smith</div>
                    </div>
                    <div class="card__detail">
                      <div class="card__small">Expires</div>
                      <div class="card__value">03 / 25</div>
                    </div>
                    <div class="card__detail">
                      <div class="card__small">CVC</div>
                      <div class="card__value">XXX</div>
                    </div>
                  </div>
                </footer>
              </div>
            </div>
            <div class="billing">
              <div class="card card--billing card--dark" style="background-color: #1556E8">
                <header class="card__header">
                  <b class="card__title">Тинькофф Black</b>
                </header>
                <div class="card__body">
                  <div class="card__chip"></div>
                  <div class="card__number">
                    <span>XXXX</span>
                    <span>XXXX</span>
                    <span>XXXX</span>
                    <span>XXXX</span>
                  </div>
                </div>
                <footer class="card__footer">
                  <div class="card__details">
                    <div class="card__detail">
                      <div class="card__small">Card holder</div>
                      <div class="card__value">John Smith</div>
                    </div>
                    <div class="card__detail">
                      <div class="card__small">Expires</div>
                      <div class="card__value">03 / 25</div>
                    </div>
                    <div class="card__detail">
                      <div class="card__small">CVC</div>
                      <div class="card__value">XXX</div>
                    </div>
                  </div>
                </footer>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card card--default profile__col profile__col--grow">
        <header class="card__header">
          <b class="card__title">{{ $t('Добавить новую карту') }}</b>
        </header>
        <div class="card__body">
          <form class="form" action="/payment" method="POST" role="form">
            <div class="row">
              <div class="form__col form__col--sm col col-12 col-lg-5">
                <SBInput v-model="payload.number"
                         :label="$t('Номер карты')"
                         name="number"
                         type="text"
                         placeholder="XXXX XXXX XXXX XXXX"
                         mask="#### #### #### ####"
                         icon="credit"
                />
              </div>
              <div class="form__col form__col--sm col col-12 col-lg-auto">
                <SBInput v-model="payload.number"
                         :label="$t('Срок действия')"
                         name="expire"
                         type="text"
                         inputClass="input--short input--centered"
                         :placeholder="$t('ММ / ГГ')"
                         mask="##/##"
                />
              </div>
              <div class="form__col form__col--sm col col-12 col-lg-auto">
                <SBInput v-model="payload.name"
                         :label="$t('Назовите новую карту')"
                         name="name"
                         type="text"
                         :placeholder="$t('Например Альфа-Онлайн')"
                />
              </div>
              <div class="form__col form__col--sm col col-12 col-lg-5">
                <SBInput v-model="payload.holder"
                         :label="$t('Держатель карты')"
                         name="holder"
                         type="text"
                         :placeholder="$t('Имя Фамилия')"
                         icon="user"
                />
              </div>
              <div class="form__col form__col--sm col col-12 col-lg-auto">
                <SBInput v-model="payload.number"
                         :label="$t('CVC')"
                         name="cvc"
                         type="text"
                         inputClass="input--short input--centered"
                         placeholder="XXX"
                         mask="###"
                />
              </div>
              <div class="form__col form__col--sm col col-12 col-lg-4 col--end">
                <input class="btn btn--primary btn--block" type="submit" :value="$t('Сохранить карту')" />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import i18n from "../../../modules/i18n";
  import SBBreadcrumbs from "../../../components/blocks/SBBreadcrumbs";
  import SBInput from "../../../components/fields/SBInput";

  export default {
    name: "page-user-profile-payments",
    metaInfo: {
      title: i18n.t('Платежи и выплаты'),
      htmlAttrs: {
        lang: i18n.locale,
        amp: true
      }
    },
    data() {
      return {
        crumbs: [
          { name: this.$t('Профиль'), to: {name: 'user-profile'} },
          { name: this.$t('Платежи и выплаты') }
        ],
        payload: {
          number: null,
          expire: null,
          holder: null,
          cvc: null,
          save: false,
          name: null
        }
      }
    },
    components: {SBInput, SBBreadcrumbs}
  }
</script>

<style scoped>

</style>
