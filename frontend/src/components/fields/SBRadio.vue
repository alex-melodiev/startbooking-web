<template>
  <label v-if="use"
         @click.prevent="onClick"
         class="radio radio--default"
         :class="[use === value ? 'radio--active' : null]"
  >
    <input class="radio__input" type="radio" :value="use" :name="name ? name : null" />
    <span v-if="label" class="radio__label">{{ label }}</span>
  </label>
</template>

<script>
  export default {
    name: "SBRadio",
    props: {
      value: {
        type: [String, Number, Boolean],
        required: false
      },
      use: {
        type: [String, Number, String],
        required: true
      },
      label: {
        type: String,
        required: true
      },
      name: {
        type: String,
        required: false
      }
    },
    methods: {
      onClick() {
        this.$emit('input', this.use);
      }
    }
  }
</script>
