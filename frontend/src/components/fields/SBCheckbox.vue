<template>
  <label v-if="use"
         @click.prevent="onClick"
         class="checkbox checkbox--default"
         :class="[use === value ? 'checkbox--active' : null, theme ? 'checkbox--' + theme : null]"
  >
    <input class="checkbox__input" type="checkbox" :value="use" :name="name ? name : null" />
    <span v-if="label" class="checkbox__label">{{ label }}</span>
  </label>
</template>

<script>
  export default {
    name: "SBCheckbox",
    props: {
      value: {
        type: [String, Number, Boolean],
        required: false
      },
      use: {
        type: [String, Number, Boolean],
        required: true
      },
      label: {
        type: String,
        required: true
      },
      theme: {
        type: String,
        required: false,
        default: () => 'primary'
      },
      name: {
        type: String,
        required: false
      }
    },
    methods: {
      onClick() {
        if(this.value === this.use) {
          this.$emit('input', null);
        } else {
          this.$emit('input', this.use);
        }
      }
    }
  }
</script>
