<template>
  <nav class="breadcrumbs" aria-label="breadcrumbs__list" role="navigation">
    <ul class="breadcrumbs__list">
      <li v-for="(crumb, index) in crumbs" class="breadcrumbs__item" :key="index">
        <template v-if="crumb.to">
          <router-link :to="crumb.to" class="breadcrumbs__link">{{ crumb.name }}</router-link>
          <div class="breadcrumbs__icon">
            <SvgIcon className="icon icon--chevron icon--stroke" name="chevron-left" />
          </div>
        </template>
        <span v-else class="breadcrumbs__text">{{ crumb.name }}</span>
      </li>
    </ul>
  </nav>
</template>

<script>
  export default {
    name: "SBBreadcrumbs",
    props: {
      crumbs: {
        type: Array,
        required: true
      }
    }
  }
</script>

<style scoped>

</style>
