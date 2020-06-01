<template>
    <div class="page__content contacts">
        <!--<div v-if="isLoading" class="page__loading">-->
            <!--<SBLoading />-->
        <!--</div>-->
        <header class="header">
            <div class="page__container">
                <h1 class="page__title">{{ $t('Мои объекты') }}</h1>
                <p class="page__description">{{ $t('Здесь хранятся все ваши объекты, которые вы зарегистрировали в нашем сервисе. Вы можете включать или выключать, а так же редактировать ваши текущие объявление')}}</p>
            </div>
        </header>
        <div class="page__container">
            <div v-for="(items, name) in entities" :key="name" class="row">
                <div class="col col-2" v-if="name == ''">Не определено</div>
                <div class="col col-2" v-else>{{ name }}</div>
                <div class="col col-10 row">
                    <div class="card card--entity"  v-for="item in items" :key="item.id">

                        <div class="row">
                            <div class="row__col col col-6">
                                <div class="card__title">{{ item.name }}</div>
                                <div class="card__media">
                                    <figure v-if="item.cover" class="card__figure">
                                        <img :src="item.cover" alt="HYATT Regency Tashkent" />
                                    </figure>
                                    <div class="card__thumbs">
                                        <div :key="index" v-for="(item, index) in item.thumbnails">
                                            <img :src="item" alt="HYATT Regency Tashkent" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row__col col col-6">

                            </div>
                        </div>
                        <button class="card__footer card__footer--button" @click="switchState(item.id)">
                            {{ $t('Активно') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    // import SBLoading from "../../components/blocks/SBLoading";
    import i18n from "../../modules/i18n";
    import localMixin from './localMixin';

    export default {
        name: 'entitites-view',
        // components: {SBLoading},
        metaInfo: {
            htmlAttrs: {
                lang: i18n.locale,
                amp: true
            }
        },
        methods: {
            ...mapActions('entities', [
                'entitiesInit'
            ]),
            switchState(id){
                const formData = new FormData();

                // app.seen = !app.seen;
                // app.button.text = app.seen ? 'Hide' : 'Show';

                formData.append('id', id);
                
                this.$api.switchEntityState(formData, (response) => {
                    const { status, data } = response;
                    if(status === 200) {
                       console.log(data);
                    }
                }, (response) => {
                    const { data } = response;
                    const { message } = data;
                    this._vm.$toasted.show(message, {
                        position: 'bottom-center',
                        type: 'error',
                        duration: 2000
                    });
                });
            }
        },
        computed: {
            ...mapGetters('entities', [
                'entities',
                'errors',
            ])
        },
        mounted() {
            this.entitiesInit(this.$route.query);
        },
        mixins: [localMixin]
    }
</script>