<template>
  <div class="stats">
    <div v-if="averageRating" class="stats__rating">
      <SvgIcon v-for="(star, index) in fullStars" className="icon icon--star" name="star" :key="'full-' + index" />
      <SvgIcon v-for="(star, index) in emptyStars" className="icon icon--star icon--star-outline" name="star" :key="'empty-' + index" />
    </div>
    <div v-if="overallRating || reviewsCount" class="stats__points">
      <template v-if="overallRating">
        <SvgIcon className="icon icon--like" name="like" />
        <div class="stats__value">{{ overallRating }}</div>
      </template>
      <div v-if="reviewsCount" class="stats__reviews">
        {{ $tc('Количество оценток от гостей', reviewsCount, {count: reviewsCount}) }}
      </div>
    </div>
  </div>
</template>

<script>
  import {isNotEmpty} from "../../utils/helpers";

  const maxStars = 5;

  export default {
    name: "SBStats",
    props: {
      averageRating: {
        type: [String, Number],
        required: false
      },
      overallRating: {
        type: [String, Number],
        required: false
      },
      reviewsCount: {
        type: [String, Number],
        required: false
      }
    },
    computed: {
      fullStars() {
        let result = 0;
        if(isNotEmpty(this.averageRating)) {
          result = Math.floor(this.averageRating / 2);
        }
        return result;
      },
      emptyStars() {
        let result = 5;
        if(isNotEmpty(this.averageRating)) {
          result = maxStars - this.fullStars;
        }
        return result;
      },
    }
  }
</script>
