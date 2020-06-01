import actions from './actions';
import getters from './getters';
import mutations from './mutations';
const state = {
  profileData: null,
  profileErrors: null,
  isProfileLoading: false,
  profileIsSubmitting: false

};
export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
