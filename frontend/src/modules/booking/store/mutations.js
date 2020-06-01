export default {
  BEFORE_GET_DEAL(state) {
    state.isLoading = true;
    state.deal = null;
  },
  AFTER_GET_DEAL(state) {
    state.isLoading = false;
  },
  SET_DEAL(state, payload) {
    state.deal = payload;
  },
  BEFORE_BOOK(state) {
    state.isSubmitting = true;
    state.errors = null;
  },
  AFTER_BOOK(state) {
    state.isSubmitting = false;
  },
  SET_ERRORS(state, payload) {
    state.errors = payload;
  },
  SET_DAYS_COUNT(state, daysCount) {
    state.daysCount = daysCount;
  },
  SET_BOOKING_DETAILS(state, payload) {
    state.amount = payload.amount;
    state.nds = payload.nds;
    state.subtotal = payload.subtotal;
    state.total_now = payload.total_now;
    state.total_after = payload.total_after;
    state.total = payload.total;
  }
};
