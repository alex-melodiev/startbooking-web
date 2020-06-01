<template>
  <div>
    <portal to="partnerDealsAddHeader">
      <SBBreadcrumbs :crumbs="crumbs" />
    </portal>

    <portal to="partnerDealsAddStep">
      {{ $t('Удобства и услуги') }}
    </portal>

    <div v-if="states" class="edit__fields">
      <div v-if="states.attributes" class="row row--sm">
        <div v-for="(type, index) in states.attributes" class="col col-12 col-md-6 row__col row__col--sm" :key="type.value">
          <div class="card card--edit">
            <header class="card__header">
              <b class="card__title" :class="'type_' + index">{{ type.label }}</b>
            </header>
            <div class="card__body">
              <p>{{ type.description }}</p>
              <SBSelect v-model="payload['attributes']"
                        :label="$t('Тип')"
                        name="property_subtype"
                        :items="type.children"
                        inputClass="input--white"
                        :placeholder="$t('Выбрать')"
                        :errors="errors && errors.property_type ? errors.property_type : null"
              />
              <br>
              <SBSelect v-model="payload['attributes']['where']"
                        :label="$t('Где?')"
                        name="property_subtype"
                        :items="where"
                        inputClass="input--white"
                        :placeholder="$t('Выбрать')"
                        :errors="errors && errors.property_type ? errors.property_type : null"
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="page__more">
      <router-link :to="{name: 'partner-deals-add-step-4'}" class="btn btn--secondary btn--shadowed btn--lg btn--rounded">
        {{ $t('Дальше') }}
      </router-link>
    </div>
  </div>
</template>

<script>
  import localMixin from './localMixin';

  import { mapState, mapActions, mapGetters } from 'vuex';
  import SBSelect from "../../components/fields/SBSelect";


  export default {
    name: "SBDealsEdit3",
    components: {SBSelect},
    data() {
      return {
        crumbs: [
          { name: this.$t('Добавить объект'), to: {name: 'partner-deals-add-step-1'} },
          { name: this.$t('Шаг 3') }
        ],
        where: [
          {label: this.$t('Места общего пользования')},
          {label: this.$t('Здание отеля')}
        ]
      }
    },
    methods: {
        ...mapActions('dealsEdit', [
            'getStates'
        ])
    },
    computed: {
        ...mapState('dealsEdit', [
            'payload'
        ]),
        ...mapGetters('dealsEdit', [
            'states',
            'errors'
        ])
    },
    mounted() {
        this.getStates();
    },
    mixins: [localMixin]
  }
</script>

<style scoped>

</style>
