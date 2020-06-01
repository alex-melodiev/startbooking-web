<template>
  <div class="field">
    <label v-if="label"
           :for="name ? 'field-' + name : null"
           class="form__label"
    >{{ label }}</label>
    <div class="field__container">
      <textarea v-model="selfValue"
                :id="name ? 'field-' + name : null"
                class="input"
                :rows="rows"
                :cols="cols"
                :class="[inputClass ? inputClass : null, icon ? 'input--iconed' : null]"
                :name="name ? name : null"
                :placeholder="placeholder"
      ></textarea>
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
    name: "SBTextarea",
    components: {SBErrors},
    props: {
      value: {
        type: [String, Number],
        required: false
      },
      rows: {
        type: [String, Number],
        required: false,
        default: () => 5
      },
      cols: {
        type: [String, Number],
        required: false,
        default: () => 10
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
      }
    },
    methods: {
      onInput(e) {
        this.$emit('input', e.target.value);
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
