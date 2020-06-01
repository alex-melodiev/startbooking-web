<template>
  <div class="page__container booking">
    <header class="header">
      <button @click.prevent="$router.go(-1)" class="header__back" type="button" role="button">
        <SvgIcon className="icon icon--arrow" name="arrow-left" />
      </button>
      <SBStats />
      <SBBreadcrumbs v-if="crumbs" :crumbs="crumbs" />
    </header>

    <SBLoading v-if="isLoading" />
    <template v-else-if="deal">
      <div class="row booking__row">
      <div class="col col-12 col-lg-8">
        <h1 class="page__title page__title--medium">{{ $t('Бронирование') }}</h1>
        <section class="booking__section">
          <SBAnnouncement type="secondary" icon="tagkey" iconClass="icon icon--tagkey">
            <b>Вероятно это жилье будет забронировано.</b> Тенденции путешествий<br />
            в Узбекистане подсказывают, что одна из ночей вашей поездки скоро будет забронирована.
          </SBAnnouncement>
        </section>

        <section class="booking__section">
          <b class="booking__title" v-if="getDaysCount">{{ getDaysCount }} ночей в г. Ташкент</b>
          <div class="booking__durations">
            <div class="booking__duration">
<!--              <label class="booking__date" for="check_in">-->
<!--                12<br />-->
<!--                окт.-->
<!--              </label>-->
              <div class="booking__duration-container">
                <div class="booking__datepicker">
                  <DatePicker v-model="payload.check_in"
                              :placeholder="$t('Дата заезда')"
                              :confirm-text="$t('Подтвердить')"
                              input-class="input input--lg input"
                  />
                </div>
                <div v-if="checkInText" class="booking__time">{{ checkInText }}</div>
              </div>
              <div v-if="errors && errors.check_in" class="booking__duration-error">
                {{ errors.check_in[0] }}
              </div>
            </div>
            <div class="booking__duration">
<!--              <div class="booking__date">-->
<!--                24<br />-->
<!--                окт.-->
<!--              </div>-->
              <div class="booking__duration-container">
                <div class="booking__datepicker">
                  <DatePicker v-model="payload.check_out"
                              :placeholder="$t('Дата заезда')"
                              :confirm-text="$t('Подтвердить')"
                              input-class="input input--lg"
                  />
                </div>
                <div v-if="checkOutText" class="booking__time">{{ checkOutText }}</div>
              </div>
              <div v-if="errors && errors.check_out" class="booking__duration-error">
                {{ errors.check_out[0] }}
              </div>
            </div>
          </div>
        </section>

        <section class="booking__section">
          <b class="booking__title">{{ $t('Прибывающие') }}</b>
          <div class="booking__tag">
            <SvgIcon className="icon icon--people" name="people" />
            <span>2 взрослых</span>
          </div>
        </section>

        <section class="booking__section">
          <b class="booking__title">{{ $t('Рассчёт стоимости') }}</b>
          <div class="booking__cost" v-if="getAmount">
            <div class="booking__cost-body">
              <div class="booking__cost-row">

                <div v-if="getDaysCount" class="booking__cost-key">{{ deal.price }} $ x {{ getDaysCount }} ночи</div>
                <div class="booking__cost-value">{{ getAmount }} сум</div>
              </div>
<!--              <div class="booking__cost-row">-->
<!--                <div class="booking__cost-key">10%ная скидка на неделю</div>-->
<!--                <div class="booking__cost-value">-90 $</div>-->
<!--              </div>-->
              <div class="booking__cost-row">
                <div class="booking__cost-key">НДС 20%</div>
                <div class="booking__cost-value">{{ getNds }} сум</div>
              </div>
              <div class="booking__cost-row booking__cost-row--allotted">
                <div class="booking__cost-key">Итого к оплате</div>
                <div class="booking__cost-value">{{ getSubtotal }} сум</div>
              </div>
            </div>
            <footer class="booking__cost-footer">
              <div class="booking__cost-row booking__cost-row--allotted">
                <div class="booking__cost-key">К оплате сейчас</div>
                <div class="booking__cost-value">{{ getTotalNow }} сум</div>
              </div>
              <div class="booking__cost-row">
                <div class="booking__cost-key">К оплате {{ payload.check_out }}</div>
                <div class="booking__cost-value">{{ getTotalAfter }} сум</div>
              </div>
            </footer>
          </div>
        </section>
      </div>
      <div class="col col-12 col-lg-4">
        <div>
          <SBBookingCard v-if="item" :item="item" />
        </div>
      </div>
    </div>
      <div class="page__more">
      <router-link v-if="isGuest" :to="{name: 'login', query: {backto: $route.path} }" class="btn btn--lg btn--secondary btn--rounded" type="button" role="button">
        {{ $t('Авторизоваться') }}
      </router-link>
      <button v-else @click="onSubmit" class="btn btn--lg btn--secondary btn--rounded" :disabled="isSubmitting" type="button" role="button">
        {{ $t('Согласиться и бронировать') }}
      </button>
    </div>
    </template>
  </div>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex';
  import localMixin from './localMixin';
  import SBAnnouncement from "../../components/blocks/SBAnnouncement";
  import SBBookingCard from "./SBBookingCard";
  import SBLoading from "../../components/blocks/SBLoading";

  export default {
    name: "SBBooking",
    data() {
      return {
        payload: {
          property_id: this.$route.params.id,
          check_in: new Date(),
          check_out: new Date(new Date().getTime() + (24 * 60 * 60 * 1000)),
          days_count: this.getDaysCount,
          amount: this.getAmount,
          nds: this.getNds,
          subtotal: this.getSubtotal,
          total_now: this.getTotalNow,
          total_after: this.getTotalAfter

        },
        days: [
          this.$t('Sunday'),
          this.$t('Monday'),
          this.$t('Tuesday'),
          this.$t('Wednesday'),
          this.$t('Thursday'),
          this.$t('Friday'),
          this.$t('Saturday')
        ]
      }
    },
    components: {
      SBLoading,
      SBBookingCard,
      SBAnnouncement
    },
    methods: {
      ...mapActions('booking', [
        'getDeal',
        'bookProperty',
        'setDaysCount'
      ]),
      onSubmit() {
        //this.bookProperty(this.payload);
          let newPayload = JSON.parse(JSON.stringify(this.payload));
          newPayload.days_count = this.getDaysCount;
          newPayload.amount = this.getAmount;
          newPayload.nds = this.getNds;
          newPayload.subtotal = this.getSubtotal;
          newPayload.total_now = this.getTotalNow;
          newPayload.total_after = this.getTotalAfter;

          this.bookProperty(newPayload);

          //console.log(newPayload);
      }
    },
    computed: {
      ...mapGetters('booking', [
        'isLoading',
        'isSubmitting',
        'errors',
        'deal',
        'crumbs',
        'item',
        'getDaysCount',
        'getBookingDetails',
        'getAmount',
        'getNds',
        'getSubtotal',
        'getTotalNow',
        'getTotalAfter',
        'getTotal']),
      ...mapGetters('user', [
        'isGuest'
      ]),
      checkInText() {
        let result = null;
        if(this.payload.check_in) {
          this.setDaysCount({"data": this.payload, "price": this.deal.fee_starts_from});
          //this.payload.days_count = this.newGetDaysCount();
          const date = new Date(this.payload.check_in);
          const weekName = this.days[date.getDay()];
          const hours = date.getHours() < 10 ? '0' + date.getHours() : date.getHours();
          const minutes = date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes();
          const time = hours + ':' + minutes;
          result = this.$t('День прибытия', { day: weekName, time: time });
        }
        return result;
      },
      checkOutText() {
        let result = null;
        if(this.payload.check_out) {
          const date = new Date(this.payload.check_out);
          //console.log(this.deal.fee_starts_from);
          this.setDaysCount({"payload": this.payload, "price": this.deal.fee_starts_from});
          //this.payload.days_count = this.newGetDaysCount();
          const weekName = this.days[date.getDay()];
          const hours = date.getHours() < 10 ? '0' + date.getHours() : date.getHours();
          const minutes = date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes();
          const time = hours + ':' + minutes;
          result = this.$t('День выезда', { day: weekName, time: time });
        }
        return result;
      }
    },
    mounted() {
      this.getDeal(this.$route.params.id);
    },
    newGetDaysCount() {
        let result = null;
        if(this.payload.check_out) {
            const check_out = new Date(this.payload.check_out);
            const check_in = new Date(this.payload.check_in);
            result = Math.round((check_out-check_in)/(1000*60*60*24))
        }
        this.daysCount = result;
        return result;
    },
    mixins: [localMixin]
  }
</script>
