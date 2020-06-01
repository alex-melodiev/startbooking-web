<template>
    <div>
        <SBEntitiesView/>
    </div>
</template>

<script>
    import i18n from "../../../modules/i18n";
    import SBEntitiesView from "../../../modules/entities/SBEntitiesView";
    export default {
        name: "page-entities",
        components: {SBEntitiesView},
        metaInfo: {
            title: i18n.t('Мои объекты'),
            htmlAttrs: {
                lang: i18n.locale,
                amp: true
            }
        }
    }
</script>