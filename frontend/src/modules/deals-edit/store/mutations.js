export default {
  BEFORE_GET_STATES(state) {
    state.isLoading = true;
    state.errors = null;
    state.states = null;
  },
  AFTER_GET_STATES(state) {
    state.isLoading = false;
  },
  SET_ERRORS(state, payload) {
    state.errors = payload;
  },
  SET_STATES(state, payload) {
    state.states = payload;
  },
  BEFORE_SUBMIT(state) {
    state.isSubmitting = true;
  },
  AFTER_SUBMIT(state) {
    state.isSubmitting = false;
  },
};
