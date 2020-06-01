<template>
  <div class="rundown" :class="[isOpened ? 'rundown--opened' : null, cssClass ? cssClass : null]">
    <label class="rundown__label">
      <input v-model="payload"
             class="rundown__control"
             :class="inputClass ? inputClass : null"
             type="text"
             :placeholder="label"
             :name="name ? name : ''"
      />
    </label>
  </div>
</template>

<script>
  import {isNotEmpty} from "../../utils/helpers";

  export default {
    name: "SBLookup",
    props: {
      value: {
        required: false
      },
      label: {
        type: String,
        required: true
      },
      className: {
        type: String,
        required: false
      },
      inputClass: {
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
        isOpened: false
      }
    },
    computed: {
      payload: {
        get() {
          return this.value;
        },
        set(val) {
          this.$emit('input', val);
        }
      },
      cssClass() {
        let result = '';
        if(isNotEmpty(this.className)) {
          const classes = this.className.split(' ');
          for(let i = 0; i < classes.length; i++) {
            result += (isNotEmpty(result) ? ' ' : '') + 'rundown--' + classes[i];
          }
        }

        if(this.isOpened) {
          result += (isNotEmpty(result) ? ' ' : '') + 'rundown--opened';
        }
        return result;
      }
    }
  }
</script>

<style scoped>

</style>
