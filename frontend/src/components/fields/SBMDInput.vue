<template>
  <label class="mdinput">
    <span v-if="label"
          class="mdinput__label"
          :class="[value || focused ? 'mdinput__label--active' : null]"
    >{{ label }}</span>
    <input v-model="selfValue"
           @focus="onFocus"
           @blur="onBlur"
           @keyup.enter="onEnter"
           :name="name ? name : null"
           type="text"
           class="mdinput__control"
           ref="mdinput"
    />
    <SvgIcon className="icon icon--chevron icon--right" name="chevron-left" />
  </label>
</template>

<script>
  export default {
    name: "SBMDInput",
    props: {
      value: {
        type: [String, Number],
        required: false
      },
      label: {
        type: String,
        required: false
      },
      name: {
        type: String,
        required: false
      }
    },
    data() {
      return {
        focused: false
      }
    },
    methods: {
      onEnter(e) {
        e.preventDefault();
        this.$emit('enter', e.target.value);
      },
      onFocus() {
        this.$set(this, 'focused', true);
      },
      onBlur() {
        this.$set(this, 'focused', false);
      }
    },
    computed: {
      selfValue: {
        get() {
          return this.value;
        },
        set(value) {
          this.$emit('input', value);
        }
      }
    }
  }
</script>
