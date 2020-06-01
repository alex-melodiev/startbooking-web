<template>
  <form @submit.prevent="onSubmit"
        action="/deals/search"
        method="GET"
        class="form form--basic"
        role="form"
  >
    <div class="form__by">
      <SBLookup v-model="payload.name"
                :label="$t('Название отеля / гостиницы')"
                inputClass="input input--lg input--transparent"
                name="name" />
      <SBListdown v-model="payload.apartment"
                  :items="apartments"
                  :label="$t('Тип апартаментов')"
                  name="apartment"
      />
      <SBRundown :label="$t('Дни пребывания')" className="hi">
        <div class="rundown__ranges">
          <div class="rundown__range">
            <span class="rundown__subtitle">{{ $t('Дата заезда') }}</span>
            <div class="rundown__set">
              <select v-model="payload.day_in" name="day_in" class="input input--white">
                <option value="">{{ $t('День') }}</option>
                <option v-for="day in days" value="" :key="day.value">{{ day.name }}</option>
              </select>
              <select v-model="payload.month_in" name="month_in" class="input input--white">
                <option value="">{{ $t('Месяц') }}</option>
                <option v-for="month in months" value="" :key="month.value">{{ month.name }}</option>
              </select>
            </div>
          </div>
          <div class="rundown__range">
            <span class="rundown__subtitle">{{ $t('Дата выезда') }}</span>
            <div class="rundown__set">
              <select v-model="payload.day_out" name="day_out" class="input input--white">
                <option value="">{{ $t('День') }}</option>
                <option v-for="day in days" value="" :key="day.value">{{ day.name }}</option>
              </select>
              <select v-model="payload.month_out" name="month_out" class="input input--white">
                <option value="">{{ $t('Месяц') }}</option>
                <option v-for="month in months" value="" :key="month.value">{{ month.name }}</option>
              </select>
            </div>
          </div>
        </div>
      </SBRundown>
      <SBRundown :label="$t('Количество гостей')">
        <div class="rundown__ranges">
          <div class="rundown__range">
            <span class="rundown__subtitle">{{ $t('Взрослые') }}</span>
            <div class="rundown__set">
              <input v-model="payload.adults" name="adults" type="number" class="input input--white" placeholder="0" />
              <select v-model="payload.citizen" name="citizen" class="input input--white">
                <option value="">{{ $t('Гражданство') }}</option>
                <option v-for="country in countries" :value="country.value" :key="country.value">{{ country.name }}</option>
              </select>
            </div>
          </div>
          <div class="rundown__range">
            <span class="rundown__subtitle">{{ $t('Дети') }}</span>
            <div class="rundown__set">
              <input v-model="payload.children" type="number" class="input input--white" placeholder="0" />
              <span class="rundown__hint">({{ $t('Дети до 12 лет') }})</span>
            </div>
          </div>
        </div>
      </SBRundown>
      <button class="form__btn btn btn--lg   btn--secondary btn--block" type="submit" role="button">
        <SvgIcon className="btn__icon icon" name="search" />
      </button>
    </div>
  </form>
</template>

<script>
  import localMixin from './localMixin';
  import SBRundown from "../../components/fields/SBRundown";
  import SBLookup from "../../components/fields/SBLookup";
  import SBListdown from "../../components/fields/SBListdown";

  export default {
    name: "SBBasicSearchForm",
    components: {SBListdown, SBLookup, SBRundown },
    data() {
      return {
        payload: {},
        apartments: [
          {value: 'hotel', name: 'Отели'},
          {value: 'guest_house', name: 'Гостевой дом'},
          {value: 'hostel', name: 'Хостелы'},
          {value: 'motel', name: 'Мотели'},
          {value: 'capsule_hotel', name: 'Капсульные отели'},
          {value: 'сountry_house', name: 'Дача'},
        ],
        days: [
          {value: 1, name: 1},
          {value: 2, name: 2},
          {value: 3, name: 3},
          {value: 4, name: 4},
          {value: 5, name: 5},
          {value: 6, name: 6},
          {value: 7, name: 7},
          {value: 8, name: 8},
          {value: 9, name: 9},
          {value: 10, name: 10},
          {value: 11, name: 11},
          {value: 12, name: 12},
        ],
        months: [
          {value: 1, name: 'Январь'},
          {value: 2, name: 'Февраль'},
          {value: 3, name: 'Март'},
          {value: 4, name: 'Апрель'},
          {value: 5, name: 'Май'},
          {value: 6, name: 'Июнь'},
          {value: 7, name: 'Июль'},
          {value: 8, name: 'Август'},
          {value: 9, name: 'Сентябрь'},
          {value: 10, name: 'Октябрь'},
          {value: 11, name: 'Ноябрь'},
          {value: 12, name: 'Декабрь'},
        ],
        countries: [
          {value: 'uz', name: 'Узбекистан'},
          {value: 'ru', name: 'Россия'},
          {value: 'us', name: 'США'}
        ]
      }
    },
    methods: {
      onSubmit() {
        this.$router.push({name: 'deals-search', query: this.payload})
      }
    },
    mounted() {},
    mixins: [localMixin]
  }
</script>

<style scoped>

</style>
