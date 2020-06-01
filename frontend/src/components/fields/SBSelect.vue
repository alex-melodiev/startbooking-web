<template>
  <div class="field">
    <label v-if="label"
           :for="name ? 'field-' + name : null"
           class="form__label"
    >{{ label }}</label>
    <div class="field__container">
      <select v-model="selfValue"
              :id="name ? 'field-' + name : null"
              class="input"
              :class="[inputClass ? inputClass : null, icon ? 'input--iconed' : null]"
              :name="name ? name : null"
              :value="value ? value : null"
              :disabled="disabled"
      >
        <option v-if="placeholder" value="">{{ placeholder }}</option>
        <option v-for="(item, index) in items"
                :value="item.value"
                :selected="value === item.value"
                :key="index"
        >{{ item.label }}</option>
      </select>
      <label v-if="icon" :for="name ? 'field-' + name : null" class="field__icon">
        <SvgIcon
            :className="iconClass ? iconClass + ' ' + 'icon icon--' + icon : 'icon icon--' + icon"
            :name="icon"
        />
      </label>
    </div>
    <SBErrors v-if="errors" :errors="errors" />
  </div>
</template>

<script>
  import SBErrors from "./SBErrors";
  export default {
    name: "SBSelect",
    components: {SBErrors},
    props: {
      value: {
        type: [String, Number],
        required: false,
        default: () => ''
      },
      name: {
        type: String,
        required: false
      },
      items: {
        type: Array,
        required: false,
        default: () => []
      },
      label: {
        type: String,
        required: false
      },
      placeholder: {
        type: String,
        required: false
      },
      icon: {
        type: String,
        required: false
      },
      iconClass: {
        type: String,
        required: false
      },
      inputClass: {
        type: String,
        required: false
      },
      errors: {
        required: false
      },
      disabled: {
        type: [String, Number, Boolean],
        required: false
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
