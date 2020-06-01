export default {
  BEFORE_GET_BOOKINGS(state) {
    state.isLoading = true;
    state.bookings = null;
  },
  AFTER_GET_BOOKINGS(state) {
    state.isLoading = false;
  },
  SET_BOOKINGS(state, payload) {
    state.bookings = payload;
  },
  SET_ERRORS(state, payload) {
    state.errors = payload;
  }
};
