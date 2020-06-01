<template>
  <div class="field">
    <label v-if="label"
           :for="name ? 'field-' + name : null"
           class="form__label"
    >{{ label }}</label>
    <div class="field__container">
      <input v-if="mask"
             v-model="selfValue"
             :id="name ? 'field-' + name : null"
             class="input"
             :class="[inputClass ? inputClass : null, icon ? 'input--iconed' : null]"
             :name="name ? name : null"
             :type="type"
             v-mask="mask"
             :placeholder="placeholder"
      />
      <input v-else
             v-model="selfValue"
             :id="name ? 'field-' + name : null"
             class="input"
             :class="[inputClass ? inputClass : null, icon ? 'input--iconed' : null]"
             :name="name ? name : null"
             :type="type"
             :placeholder="placeholder"
      />
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
  import { mask } from 'vue-the-mask';
  import SBErrors from "./SBErrors";

  export default {
    name: "SBInput",
    components: {SBErrors},
    directives: {mask},
    props: {
      value: {
        type: [String, Number],
        required: false
      },
      type: {
        type: String,
        required: false,
        default: () => 'text'
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
        type: Array,
        required: false
      },
      mask: {
        type: [String, Array],
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
