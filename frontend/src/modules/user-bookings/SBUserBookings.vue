<template>
  <div class="booking__container">
    <SBLoading v-if="isLoading" />
    <div v-else-if="bookings" class="booking__list">
      <SBUserBookingsCard v-for="booking in bookings" :item="booking" :key="booking.id" />
    </div>
  </div>

</template>

<script>
  import { mapActions, mapGetters } from 'vuex';
  import localMixin from './localMixin';
  import SBUserBookingsCard from "./SBUserBookingsCard";
  import SBLoading from "../../components/blocks/SBLoading";

  export default {
    name: "SBUserBookings",
    components: {SBLoading, SBUserBookingsCard},
    methods: {
      ...mapActions('userBookings', [
        'getBookings'
      ])
    },
    computed: {
      ...mapGetters('userBookings', [
        'isLoading',
        'bookings'
      ])
    },
    mounted() {
      this.getBookings();
    },
    mixins: [localMixin]
  }
</script>
