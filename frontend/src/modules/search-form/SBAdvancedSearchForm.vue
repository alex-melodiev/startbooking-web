<template>
  <form v-if="filters"
        @submit.prevent="onSubmit"
        action="/deals/search"
        method="GET"
        class="card card--form form form--advanced"
        role="form"
  >
    <div v-if="filters.name" class="form__row">
      <div class="form__by form__by--row">
        <SBLookup @input="onDebounceInput('name', ...arguments)"
                  :value="payload.name"
                  :label="filters.name.label"
                  inputClass="input input--lg"
        />
        <button class="form__btn btn btn--lg btn--secondary btn--block" type="submit">
          <SvgIcon className="btn__icon icon icon--search" name="search" />
        </button>
      </div>
    </div>

    <div v-if="filters.soryby" class="form__row form__order">
      <div class="form__label form__label--dressedup">{{ filters.soryby.label }}</div>
      <SBRadioButtonGroup v-model="payload.soryby" :items="filters.soryby.items" name="soryby" />
    </div>

<!--    <div class="row">-->
<!--      <div class="col col-12 col-md-6 col-xl-3 form__col">-->
<!--        <div class="form__label">{{ $t('Количество звёзд (от/до)') }}:</div>-->
<!--        <div class="row row&#45;&#45;sm">-->
<!--          <div class="col col-6">-->
<!--            <SBSelect v-model="payload.stars_from"-->
<!--                      name="stars_from"-->
<!--                      :items="stars"-->
<!--                      inputClass="input&#45;&#45;white"-->
<!--                      icon="star"-->
<!--                      :placeholder="$t('От')"-->
<!--            />-->
<!--          </div>-->
<!--          <div class="col col-6">-->
<!--            <SBSelect v-model="payload.stars_to"-->
<!--                      name="stars_to"-->
<!--                      :items="stars"-->
<!--                      inputClass="input&#45;&#45;white"-->
<!--                      icon="star"-->
<!--                      :placeholder="$t('До')"-->
<!--            />-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--      <div class="col col-12 col-md-6 col-xl-3 form__col">-->
<!--        <div class="form__label">{{ $t('Оценка по отзывам (от/до)') }}:</div>-->
<!--        <div class="row row&#45;&#45;sm">-->
<!--          <div class="col col-6">-->
<!--            <SBSelect v-model="payload.avgRatingFrom"-->
<!--                      name="reviews_from"-->
<!--                      :items="reviews"-->
<!--                      inputClass="input&#45;&#45;white"-->
<!--                      icon="like"-->
<!--                      :placeholder="$t('От')"-->
<!--            />-->
<!--          </div>-->
<!--          <div class="col col-6">-->
<!--            <SBSelect v-model="payload.avgRatingTo"-->
<!--                      name="reviews_to"-->
<!--                      :items="reviews"-->
<!--                      inputClass="input&#45;&#45;white"-->
<!--                      icon="like"-->
<!--                      :placeholder="$t('До')"-->
<!--            />-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--      <div class="col col-12 col-md-6 col-xl-2 form__col">-->
<!--        <SBSelect v-model="payload.nutrition"-->
<!--                  :label="$t('Питание') + ':'"-->
<!--                  name="nutrition"-->
<!--                  :items="nutritions"-->
<!--                  inputClass="input&#45;&#45;white"-->
<!--                  :placeholder="$t('Выбрать')"-->
<!--        />-->
<!--      </div>-->
<!--      <div class="col col-12 col-md-6 col-xl-4 form__col">-->
<!--        <div class="form__label">-->
<!--          {{ $t('Беслатная отмена бронирования') }}-->
<!--          <SBHint :content="$t('Для того чтобы обезопасить себя на случай непредвиденных обстоятельств, которые приведут к отмене бронирования, советуем вам включить функцию бесплатной отмены бронирования. В этом случаи гостиница не будет взымать деньги за отмену брони.')">-->
<!--            <span class="hint__dot"></span>-->
<!--          </SBHint>-->
<!--        </div>-->
<!--        <div class="form__fields">-->
<!--          <SBRadioButton v-model="payload.cancel_reservation" :items="cancel_reservations" name="cancel_reservation" />-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->

    <div class="row">
      <div v-if="filters.ratingFrom" class="col col-12 col-md-6 col-xl-3 form__col">
        <SBSelect v-model="payload.ratingFrom"
                  :label="filters.ratingFrom.label"
                  name="ratingFrom"
                  :items="filters.ratingFrom.items"
                  inputClass="input--white"
                  icon="star"
                  :placeholder="$t('Выбрать')"
        />
      </div>
      <div v-if="filters.withRatings" class="col col-12 col-md-6 col-xl-3 form__col">
        <SBSelect v-model="payload.withRatings"
                  :label="filters.withRatings.label"
                  name="withRatings"
                  :items="filters.withRatings.items"
                  inputClass="input--white"
                  icon="like"
                  :placeholder="$t('Выбрать')"
        />
      </div>
      <div v-if="filters.nutrition" class="col col-12 col-md-6 col-xl-3 form__col">
        <SBSelect v-model="payload.nutrition"
                  :label="filters.nutrition.label"
                  name="nutrition"
                  :items="filters.nutrition.items"
                  inputClass="input--white"
                  :placeholder="$t('Выбрать')"
        />
      </div>
      <div v-if="filters.cancelation" class="col col-12 col-md-6 col-xl-3 form__col">
        <div class="form__label">
          {{ filters.cancelation.label }}
          <SBHint :content="$t('Для того чтобы обезопасить себя на случай непредвиденных обстоятельств, которые приведут к отмене бронирования, советуем вам включить функцию бесплатной отмены бронирования. В этом случаи гостиница не будет взымать деньги за отмену брони.')">
            <span class="hint__dot"></span>
          </SBHint>
        </div>
        <div class="form__fields">
          <SBRadioButton v-model="payload.cancelation" :items="filters.cancelation.items" name="cancelation" />
        </div>
      </div>
    </div>

    <div v-if="isAdvanced" class="form__advanced">
      <div class="row">
        <div v-if="filters.noCreditCard" class="col col-12 col-md-3 form__col">
          <SBSelect v-model="payload.noCreditCard"
                    :label="filters.noCreditCard.label"
                    name="noCreditCard"
                    :items="filters.noCreditCard.items"
                    inputClass="input--white"
                    :placeholder="$t('Выбрать')"
          />
        </div>
      </div>
      <div v-if="filters.сonvenience" class="form__row">
        <div class="form__label">{{ filters.сonvenience.label }}</div>
        <SBCheckboxButton v-model="payload.сonvenience" :items="filters.сonvenience.items" name="сonvenience" :multirow="true" />
      </div>
<!--      <div class="form__row">-->
<!--        <div class="form__label form__label&#45;&#45;primary">{{ $t('Добавить свои варианты') }}</div>-->
<!--        <div v-for="(variant, index) in payload.variants" class="row row&#45;&#45;sm" :key="index">-->
<!--          <div class="form__col form__col&#45;&#45;xs col col-auto col-lg-3">-->
<!--            <input v-model="payload.variants[index]" type="text" name="variants[]" class="input input&#45;&#45;white" :placeholder="$t('Ваш вариант')" />-->
<!--          </div>-->
<!--          <div class="form__col form__col&#45;&#45;xs col col-auto col-lg-3">-->
<!--            <button @click.prevent="addCustomVariant" class="btn btn&#45;&#45;primary" type="button" role="button">-->
<!--              <span>{{ $t('Добавить') }}</span>-->
<!--            </button>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
    </div>
    <footer class="form__footer">
      <div class="form__actions">
        <button @click="toggleAdvance"
                class="form__action"
                :class="isAdvanced ? 'form__action--danger' : 'form__action--primary'"
                type="button"
                role="button"
        >
          <span>{{ $t('Все параметры') }}</span>
          <SvgIcon v-if="isAdvanced" className="icon icon--chevron icon--stroke icon--top" name="chevron-left" />
          <SvgIcon v-else className="icon icon--chevron icon--stroke icon--bottom" name="chevron-left" />
        </button>
        <button @click.prevent="onChangeMode"
                class="form__action form__action--primary"
                type="button"
                role="button"
        >
          <SvgIcon className="icon icon--binoculars" name="binoculars" />
          <span v-if="mode === 'map'">{{ $t('В обычный режим') }}</span>
          <span v-else>{{ $t('В режим карты') }}</span>
        </button>
        <button @click.prevent="onReset" class="form__action form__action--mutted" type="button" role="button">
          <span>{{ $t('Сбросить') }}</span>
          <SvgIcon className="icon icon--stroke icon--close" name="close" />
        </button>
      </div>
    </footer>
  </form>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex';
  import _ from 'lodash';
  import deals from '../deals/store';
  import SBLookup from "../../components/fields/SBLookup";
  import SBRadioButtonGroup from "../../components/fields/SBRadioButtonGroup";
  import SBRadioButton from "../../components/fields/SBRadioButton";
  import SBCheckboxButton from "../../components/fields/SBCheckboxButton";
  import SBHint from "../../components/fields/SBHint";
  import SBSelect from "../../components/fields/SBSelect";

  export default {
    name: "SBAdvancedSearchForm",
    props: {
      mode: {
        type: String,
        required: false,
        default: () => 'default'
      }
    },
    data() {
      return {
        isAdvanced: false,
        payload: {}
      }
    },
    watch: {
      computedPayload: {
        handler(oldVal, newVal) {
          const oldPayload = JSON.stringify(oldVal);
          const newPayload = JSON.stringify(newVal);
          if(oldPayload !== newPayload) {
            this.onSubmit();
          }
        },
        deep: true
      }
    },
    components: {
      SBSelect,
      SBCheckboxButton,
      SBHint,
      SBRadioButtonGroup,
      SBRadioButton,
      SBLookup
    },
    methods: {
      ...mapActions('deals', [
        'getDeals'
      ]),
      toggleAdvance() {
        this.$set(this, 'isAdvanced', !this.isAdvanced);
      },
      onSubmit() {
        this.getDeals(this.payload);
      },
      addCustomVariant() {
        this.payload.variants = [...this.payload.variants, ''];
      },
      onReset() {
        this.payload = {}
      },
      onChangeMode() {
        if(this.mode === 'default') {
          this.$emit('onChangeMode', 'map')
        } else {
          this.$emit('onChangeMode', 'default')
        }
      }
    },
    computed: {
      ...mapGetters('deals', [
        'filters'
      ]),
      computedPayload() {
        return _.cloneDeep(this.payload)
      }
    },
    created() {
      const store = this.$store;
      const name = 'deals';
      if (!(store && store.state && store.state[name])) {
        store.registerModule(name, deals);
      }

      this.onDebounceInput = _.debounce((field, value) => {
        this.$set(this.payload, field, value);
      }, 500);
    },
    mounted() {
      const payload = {...this.payload, ...this.$route.query};
      this.$set(this, 'payload', payload);
    }
  }
</script>
