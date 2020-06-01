<template>
  <div class="stars-select"
       :class="[size ? 'stars-select--' + size : null, centered ? 'stars-select--centered' : null]"
  >
    <button v-for="star in max" @click="onChange(star)" class="stars-select__button" type="button" role="button" :key="star">
      <SvgIcon :className="star > 0 && star <= value ? 'icon icon--star' : 'icon icon--star icon--star-outline'" name="star" />
    </button>

  </div>
</template>

<script>
  export default {
    name: "SBStarsSelect",
    props: {
      value: {
        type: [String, Number],
        required: false
      },
      name: {
        type: String,
        required: false
      },
      errors: {
        type: Array,
        required: false
      },
      size: {
        type: String,
        required: false
      },
      centered: {
        type: [String, Number, Boolean],
        required: false
      }
    },
    data() {
      return {
        max: 5
      }
    },
    methods: {
      onChange(star) {
        this.$emit('input', star);
      }
    }
  }
</script>
