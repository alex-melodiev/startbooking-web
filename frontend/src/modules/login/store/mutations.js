export default {
  BEFORE_LOGIN(state) {
    state.isSubmitting = true;
    state.errors = null;
  },
  AFTER_LOGIN(state) {
    state.isSubmitting = false;
  },
  SET_ERRORS(state, payload) {
    state.errors = payload;
  }
};
