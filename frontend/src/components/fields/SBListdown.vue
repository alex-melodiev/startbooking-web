<template>
  <div class="rundown"
       :class="[isOpened ? 'rundown--opened' : null]"
       v-click-outside="hide">
    <span @click="toggle" class="rundown__toggler">{{ displayLabel }}</span>
    <div v-if="isOpened" class="rundown__content">
      <div class="rundown__options">
            <span v-for="item in items"
                  @click="onSelect(item.value)"
                  class="rundown__option"
                  :key="item.value"
            >{{ item.name }}</span>
      </div>
    </div>
    <input type="hidden" :value="value ? value : ''" :name="name ? name : ''" />
  </div>
</template>

<script>
  import {isNotEmpty} from "../../utils/helpers";

  export default {
    name: "SBListdown",
    props: {
      value: {
        required: false
      },
      items: {
        type: Array,
        required: true
      },
      label: {
        type: String,
        required: true
      },
      className: {
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
    methods: {
      toggle() {
        if(this.isOpened) {
          this.hide()
        } else {
          this.show();
        }
      },
      show() {
        this.$set(this, 'isOpened', true);
      },
      hide() {
        this.$set(this, 'isOpened', false);
      },
      onSelect(val) {
        this.$emit('input', val);
        this.$set(this, 'isOpened', false);
      }
    },
    computed: {
      displayLabel() {
        let result = this.label;
        if(isNotEmpty(this.value)) {
          const item = this.items.find((item) => item.value === this.value);
          if(isNotEmpty(item)) {
            result = item.name;
          }
        }
        return result;
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
