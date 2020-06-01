<template>
  <div v-if="items" class="radio radio--button-group">
    <label v-for="item in items"
           @click.prevent="onClick(item.value)"
           class="radio__button"
           :class="[item.value === value ? 'radio__button--active' : null]"
           :key="item.value">
      <input :checked="item.value === value"
             class="radio__input"
             type="radio"
             :value="item.value"
             :name="name ? name : ''"
      />
      <span class="radio__label">{{ item.label }}</span>
    </label>
  </div>
</template>

<script>
  export default {
    name: "SBRadioButtonGroup",
    props: {
      value: {
        type: [String, Number, Boolean]
      },
      items: {
        type: Array,
        required: true
      },
      name: {
        type: String,
        required: false
      }
    },
    methods: {
      onClick(val) {
        this.$emit('input', val);
      }
    }
  }
</script>

<style scoped>

</style>
