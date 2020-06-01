<template>
  <div v-if="items"
       class="radio radio--button"
       :class="[multirow ? 'radio--multirow' : null]"
  >
    <label v-for="item in items"
           @click.prevent="onClick(item.value)"
           class="radio__button btn"
           :class="[item.value === value ? 'btn--secondary' : 'btn--light']"
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
    name: "SBRadioButton",
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
      },
      multirow: {
        type: Boolean,
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
