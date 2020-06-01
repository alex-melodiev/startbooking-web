export default {
  BEFORE_GET_DEALS(state) {
    state.isLoading = true;
    state.deals = null;
  },
  AFTER_GET_DEALS(state) {
    state.isLoading = false;
  },
  SET_DEALS(state, payload) {
    state.deals = payload;
  },
  SET_FILTERS(state, payload) {
    state.filters = payload;
  },
  SET_ERRORS(state, payload) {
    state.errors = payload;
  },
  BEFORE_GET_DEAL(state) {
    state.isLoading = true;
    state.deal = null;
  },
  AFTER_GET_DEAL(state) {
    state.isLoading = false;
  },
  SET_DEAL(state, payload) {
    state.deal = payload;
  }
};
