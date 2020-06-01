export default {
  BEFORE_SEND_MESSAGE(state) {
    state.isSubmitting = true;
  },
  AFTER_SEND_MESSAGE(state) {
    state.isSubmitting = false;
  },
  SET_DIALOGS(state, payload) {
    state.dialogs = payload;
  },
  SET_MESSAGE(state, payload) {
    state.payload.message = payload;
  }
};
