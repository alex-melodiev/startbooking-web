<template>
  <div class="hint" :class="[isOpened ? 'hint--opened' : null]" v-click-outside="hide">
    <button @click.prevent="toggle" class="hint__toggler" type="button" role="button">
      <slot />
    </button>
    <div v-if="isOpened" class="hint__body" v-html="content"></div>
  </div>
</template>

<script>
  export default {
    name: "SBHint",
    props: {
      content: {
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
          this.hide();
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
    }
  }
</script>

<style scoped>

</style>
