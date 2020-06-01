<template>
  <div class="page__container payment">
    <header class="header">
      <button @click.prevent="$router.go(-1)" class="header__back" type="button" role="button">
        <SvgIcon className="icon icon--arrow" name="arrow-left" />
      </button>
      <SBStats />
      <SBBreadcrumbs :crumbs="crumbs" />
    </header>

    <h1 class="page__title page__title--medium">{{ $t('Оплата') }}</h1>
    <div class="row payment__row">
      <div class="col col-12 col-lg-8 payment__col">
        <form class="card card--form payment__grow" action="/payment" method="POST" role="form">
          <b class="payment__title">{{ $t('Перевод средств') }}</b>
          <div class="row">
            <div class="form__col col col-6 col-lg-5">
              <SBRadio v-model="payload.method"
                       use="bank"
                       :label="$t('Банковской картой')"
                       name="method"
              />
            </div>
            <div class="form__col col col-6 col-lg-5">
              <SBRadio v-model="payload.method"
                       use="other"
                       :label="$t('Другой способ')"
                       name="method"
              />
            </div>
          </div>
          <div class="row">
            <div class="form__col col col-12 col-lg-5">
              <SBInput v-model="payload.card.number"
                       :label="$t('Номер карты')"
                       name="number"
                       type="text"
                       placeholder="XXXX XXXX XXXX XXXX"
                       mask="#### #### #### ####"
                       icon="credit"
              />
            </div>
            <div class="form__col col col-12 col-lg-3">
              <SBInput v-model="payload.card.expire"
                       :label="$t('Срок действия')"
                       name="expire"
                       type="text"
                       inputClass="input--short input--centered"
                       :placeholder="$t('ММ / ГГ')"
                       mask="##/##"
              />
            </div>
            <div class="form__col col col-12 col-lg-4 col--middle">
              <SBCheckbox v-model="payload.card.save"
                          use="other"
                          :label="$t('Сохранить новую карту')"
                          name="save"
              />
            </div>
            <div class="form__col col col-12 col-lg-5">
              <SBInput v-model="payload.card.holder"
                       :label="$t('Держатель карты')"
                       name="holder"
                       type="text"
                       :placeholder="$t('Имя Фамилия')"
                       icon="user"
              />
            </div>
            <div class="form__col col col-12 col-lg-3">
              <SBInput v-model="payload.card.cvc"
                       :label="$t('CVC')"
                       name="cvc"
                       type="text"
                       inputClass="input--short input--centered"
                       placeholder="XXX"
                       mask="###"
              />
            </div>
            <div class="form__col col col-12 col-lg-4">
              <SBInput v-model="payload.card.name"
                       :label="$t('Назовите новую карту')"
                       name="name"
                       type="text"
                       :placeholder="$t('Например Альфа-Онлайн')"
              />
            </div>
          </div>
          <input class="btn btn--lg btn--ternary" type="submit" :value="$t('Бронировать')" />
        </form>
      </div>
      <div class="col col-12 col-lg-4 payment__col">
        <div class="card card--invoice">
          <header class="card__header card__header--row card__header--center card__header--between">
            <b class="card__title">{{ $t('К оплате сейчас') }}:</b>
            <SBHint content="info text">
              <SvgIcon className="icon icon--info" name="info" />
            </SBHint>
          </header>
          <div class="card__body">
            <div class="card__total">247.5 $</div>
          </div>
        </div>
        <div class="card card--text payment__grow">
          <header class="card__header">
            <b class="card__title">Бесплатная отмена брони до 20 октября</b>
          </header>
          <div class="card__body">
            <p>При отмене брони на объект не позднее чем за 7 дней вы получите возврат в размере полной суммы предоплаты</p>
          </div>
        </div>
      </div>
    </div>
    <b class="payment__title">{{ $t('Мои карты') }}:</b>
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
      <div class="billing">
        <button class="card card--add" type="button" role="button">
          <SvgIcon className="icon icon--add-circle" name="add-circle" />
        </button>
      </div>
    </div>
  </div>
</template>

<script>
  import localMixin from './localMixin';
  import SBRadio from "../../components/fields/SBRadio";
  import SBCheckbox from "../../components/fields/SBCheckbox";
  import SBInput from "../../components/fields/SBInput";
  import SBHint from "../../components/fields/SBHint";

  export default {
    name: "SBPayment",
    data() {
      return {
        payload: {
          method: 'bank',
          card: {
            number: null,
            expire: null,
            holder: null,
            cvc: null,
            save: false,
            name: null
          }
        },
        crumbs: [
          {name: 'HYATT Regency Tashkent', to: { name: 'deals-view', params: { id: 123 }} },
          {name: 'Двухместный люкс', to: { name: 'rooms-view', params: { id: 234 }} },
          {name: this.$t('Бронирование'), to: { name: 'booking-view', params: { id: 234 }} },
          {name: this.$t('Оплата')}
        ]
      }
    },
    components: {
      SBHint,
      SBInput,
      SBRadio,
      SBCheckbox
    },
    mixins: [localMixin]
  }
</script>

<style scoped>

</style>
