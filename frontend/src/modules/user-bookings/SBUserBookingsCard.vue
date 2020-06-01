<template>
  <div v-if="item" class="row">
    <div class="col col-12 col-md-8 booking__col">
      <div class="card card--booking">
        <div class="row">
          <div class="col col-12 col-md-6 card__col">
            <div class="card__body">
              <b class="card__title">{{ item.name }}</b>
              <div class="card__label card__label--tagline">HYATT Regency Tashkent</div>
              <div class="card__media">
                <figure class="card__figure">
                  <img src="https://via.placeholder.com/688x280" alt="HYATT Regency Tashkent" />
                </figure>
                <div class="card__thumbs">
                  <img src="https://via.placeholder.com/150x120" alt="HYATT Regency Tashkent" />
                  <img src="https://via.placeholder.com/150x120" alt="HYATT Regency Tashkent" />
                  <img src="https://via.placeholder.com/150x120" alt="HYATT Regency Tashkent" />
                  <img src="https://via.placeholder.com/150x120" alt="HYATT Regency Tashkent" />
                </div>
              </div>
            </div>
            <footer class="card__footer">
              <div class="card__description">
<!--                Бесплатная отмена бронирования<br />-->
<!--                до 20 октября.-->
              </div>
            </footer>
          </div>
          <div class="col col-12 col-md-6 card__col">
            <div class="card__body">
              <div class="card__label card__label--tagline">{{ $t('Описание номера') }}</div>
              <div class="card__description">
                {{ item.property_description }}
              </div>
              <div class="card__tags">
                <span class="card__tag">
                  <SvgIcon className="btn__icon icon icon--people" name="people" />
                  <span>2 взрослых</span>
                </span>
              </div>
              <div class="btn btn--tag">{{ item.date_range }}</div>
            </div>
            <footer class="card__footer">
              <div class="card__actions">
<!--                <button class="card__action card__action&#45;&#45;primary" type="button" role="button">-->
<!--                  {{ $t('Скачать ваучер') }}-->
<!--                </button>-->
                <button class="card__action card__action--danger" type="button" role="button">
                  {{ $t('Отменить бронирование') }}
                </button>
                <SBHint content="info text">
                  <span class="card__action-icon card__action-icon--danger">
                    <SvgIcon className="icon icon--question" name="question" />
                  </span>
                </SBHint>
              </div>
            </footer>
          </div>
        </div>
      </div>
    </div>
    <div class="col col-12 col-md-4 booking__col">
      <div class="card card--booking">
        <header class="card__header">
          <b class="card__title">{{ $t('Рассчёт стоимости') }}</b>
        </header>
        <div class="card__body">
          <div class="card__cost">
            <div class="card__cost-body">
              <div class="card__cost-row">
                <div class="card__cost-key">{{ item.per_night }} {{ item.currency_code }} x {{ item.total_night }} ночи</div>
                <div class="card__cost-value">{{ item.total }} {{ item.currency_code }}</div>
              </div>
<!--              <div class="card__cost-row">-->
<!--                <div class="card__cost-key">10%ная скидка на неделю</div>-->
<!--                <div class="card__cost-value">-90 $</div>-->
<!--              </div>-->
<!--              <div class="card__cost-row">-->
<!--                <div class="card__cost-key">НДС 20%</div>-->
<!--                <div class="card__cost-value">180 $</div>-->
<!--              </div>-->
              <div class="card__cost-row card__cost-row--allotted">
                <div class="card__cost-key">Итого к оплате</div>
                <div class="card__cost-value">{{ item.total }} {{ item.currency_code }}</div>
              </div>
            </div>
            <footer class="card__cost-footer">
              <div class="card__cost-row card__cost-row--secondary">
                <div class="card__cost-key">Оплата в начале</div>
                <div class="card__cost-value">{{ item.total * 0.3 }} {{ item.currency_code }}</div>
              </div>
              <div class="card__cost-row">
                <div class="card__cost-key">К оплате {{ item.end_date }}</div>
                <div class="card__cost-value">{{ item.total * 0.7 }} {{ item.currency_code }}</div>
              </div>
            </footer>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import localMixin from './localMixin';
  import SBHint from "../../components/fields/SBHint";
  import {objectGet} from "../../utils/object";
  import {isNotEmpty} from "../../utils/helpers";

  export default {
    name: "SBUserBookingsCard",
    props: {
      item: {
        type: Object,
        required: true
      }
    },
    data() {
      return {
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
    components: {SBHint},
    computed: {
      startDate() {
        let result = null;
        const startDate = objectGet(this, 'item.start_date');
        if(isNotEmpty(startDate)) {
          const date = new Date(startDate);
          result = this.$tc('c числа', date.getMonth(), { day: date.getDate(), month: date.getMonth() });
        }
        return result;
      },
      endDate() {
        let result = null;
        const endDate = objectGet(this, 'item.end_date');
        if(isNotEmpty(endDate)) {
          const date = new Date(endDate);
          result = this.$tc('до числа', date.getMonth(), { day: date.getDate(), month: date.getMonth() });
        }
        return result;
      }
    },
    mixins: [localMixin]
  }
</script>

<style scoped>

</style>
