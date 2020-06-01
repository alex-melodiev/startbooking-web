<template>
  <div class="rundown"
       :class="[isOpened ? 'rundown--opened' : null, cssClass ? cssClass : null]"
       v-click-outside="hide">
    <span @click="toggle" class="rundown__toggler">{{ label }}</span>
    <div v-if="isOpened" class="rundown__content">
      <slot />
    </div>
  </div>
</template>

<script>
  import {isNotEmpty} from "../../utils/helpers";

  export default {
    name: "SBRundown",
    props: {
      label: {
        type: String,
        required: true
      },
      className: {
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
      }
    },
    computed: {
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
