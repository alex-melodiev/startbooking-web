<template>
  <div class="announcement" :class="[type ? 'announcement--' + type : null]">
    <div v-if="icon" class="announcement__icon">
      <SvgIcon :className="iconClass ? iconClass : null" :name="icon" />
    </div>
    <div class="announcement__body">
      <slot />
    </div>
  </div>
</template>

<script>
  export default {
    name: "SBAnnouncement",
    props: {
      type: {
        type: String,
        required: false,
        default: () => 'secondary'
      },
      icon: {
        type: String,
        required: false
      },
      iconClass: {
        type: String,
        required: false
      }
    }
  }
</script>

<style scoped>

</style>
