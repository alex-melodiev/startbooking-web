export default {
  BEFORE_GET_PROFILE(state) {
    state.isProfileLoading = true;
    state.profileIsSubmitting = false;
    state.profileData = null;
    state.profileErrors = null;
  },
  AFTER_GET_PROFILE(state) {
    state.isProfileLoading = false;
  },
  SET_PROFILE_DATA(state, payload) {
    state.profileData = payload;
  },
  SET_PROFILE_ERRORS(state, payload) {
    state.profileErrors = payload;
  },
  BEFORE_UPDATE_PROFILE(state) {
    state.profileIsSubmitting = true;
  },
  AFTER_UPDATE_PROFILE(state) {
    state.profileIsSubmitting = false;
  }
};
