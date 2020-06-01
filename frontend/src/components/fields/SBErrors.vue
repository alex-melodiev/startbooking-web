<template>
  <div v-if="errors" class="errors">
    <span v-for="(error, index) in errors" class="errors__item" :key="index">{{ error }}</span>
  </div>
</template>

<script>
  export default {
    name: "SBErrors",
    props: {
      errors: {
        type: Array,
        required: false
      }
    }
  }
</script>
