<template>
  <div v-if="items"
       class="checkbox checkbox--button"
       :class="[multirow ? 'checkbox--multirow' : null]"
  >
    <label v-for="item in items"
           @click.prevent="onClick(item.value)"
           class="checkbox__button btn"
           :class="[value && value.indexOf(item.value) > - 1 ? 'btn--secondary' : 'btn--light', $isMobile ? 'btn--sm' : null]"
           :key="item.value">
      <input :checked="value && value.indexOf(item.value) > - 1"
             class="checkbox__input"
             type="checkbox"
             :value="item.value"
             :name="name ? name : ''"
      />
      <span class="checkbox__label">{{ item.label }}</span>
    </label>
  </div>
</template>

<script>
  import {isNotEmpty} from "../../utils/helpers";

  export default {
    name: "SBCheckboxButton",
    props: {
      value: {
        type: Array
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
        let value = [];
        if(isNotEmpty(this.value)) {
          value = [...[], ...this.value];
        }
        const idx = value.indexOf(val);
        let result = [];
        if(idx > -1) {
          result = [...value.slice(0, idx), ...value.slice(idx + 1)];
        } else {
          result = [...value, val];
        }
        this.$emit('input', result);
      }
    }
  }
</script>
