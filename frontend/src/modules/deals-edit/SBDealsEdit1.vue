<template>
  <div>
    <portal to="partnerDealsAddHeader">
      <SBBreadcrumbs :crumbs="crumbs" />
    </portal>
    <portal to="partnerDealsAddStep">
      {{ $t('Выбор типа объекта') }}
    </portal>

    <div v-if="states" class="edit__fields">
      <div v-if="states.types" class="row row--sm">
        <div v-for="(type, index) in states.types" class="col col-12 col-md-6 row__col row__col--sm" :key="type.value">
          <div class="card card--edit">
            <header class="card__header">
              <b class="card__title">{{ index + 1 }}. {{ type.label }}</b>
            </header>
            <div class="card__body">
              <p>{{ type.description }}</p>
              <SBSelect v-model="payload.property_type"
                        :label="$t('Тип')"
                        name="property_subtype"
                        :items="type.children"
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
      <router-link :to="{name: 'partner-deals-add-step-2'}" class="btn btn--secondary btn--shadowed btn--lg btn--rounded">
        {{ $t('Дальше') }}
      </router-link>
    </div>

  </div>
</template>

<script>
  import { mapState, mapActions, mapGetters } from 'vuex';
  import localMixin from './localMixin';
  import SBSelect from "../../components/fields/SBSelect";

  export default {
    name: "SBDealsEdit1",
    components: {SBSelect},
    data() {
      return {
        crumbs: [
          { name: this.$t('Добавить объект'), to: {name: 'partner-deals-add-step-1'} },
          { name: this.$t('Шаг 1') }
        ],
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
