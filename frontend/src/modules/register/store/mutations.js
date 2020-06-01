export default {
  BEFORE_REGISTER(state) {
    state.isSubmitting = true;
    state.errors = true;
  },
  AFTER_REGISTER(state) {
    state.isSubmitting = false;
  },
  SET_ERRORS(state, payload) {
    state.errors = payload;
  }
};
