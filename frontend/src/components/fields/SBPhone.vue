<template>
  <div class="field">
    <label v-if="label"
           :for="name ? 'field-' + name : null"
           class="form__label"
    >{{ label }}</label>
    <div class="field__container">
      <input v-model="selfValue"
             @input="onInput"
             :id="name ? 'field-' + name : null"
             class="input"
             :class="[inputClass ? inputClass : null, country ? 'input--phone' : null]"
             :name="name ? name : null"
             type="tel"
             :placeholder="placeholder"
             :disabled="disabled"
             min="0"
             step="1"
      />
      <label v-if="country" :for="name ? 'field-' + name : null" class="field__phone">
        <span v-if="country.calling_code">+{{ country.calling_code }}</span>
        <img :src="country.flag" :alt="country.code">
      </label>
    </div>
    <SBErrors v-if="errors" :errors="errors" />
  </div>
</template>

<script>
  import SBErrors from "./SBErrors";
  import {isNotEmpty} from "../../utils/helpers";

  export default {
    name: "SBPhone",
    components: {SBErrors},
    props: {
      value: {
        type: [String, Number],
        required: false
      },
      name: {
        type: String,
        required: false
      },
      label: {
        type: String,
        required: false
      },
      placeholder: {
        type: String,
        required: false
      },
      country: {
        required: true
      },
      inputClass: {
        type: String,
        required: false
      },
      errors: {
        type: Array,
        required: false
      },
      disabled: {
        type: [String, Number, Boolean],
        required: false
      }
    },
    methods: {
      onInput(e) {
        e.target.value = e.target.value.replace(/[^\d]+/g,'');
      }
    },
    computed: {
      selfValue: {
        get() {
          if(isNotEmpty(this.value)) {
            return this.value.replace('+', '').replace(this.country.calling_code, '');
          } else {
            return this.value;
          }
        },
        set(value) {
          if(value) {
            this.$emit('input', `+${this.country.calling_code}${value.replace(/[^\d]+/g,'')}`);
          } else {
            this.$emit('input', value);
          }
        }
      }
    }
  }
</script>
