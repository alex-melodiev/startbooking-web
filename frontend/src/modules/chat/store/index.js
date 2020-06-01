import actions from './actions';
import getters from './getters';
import mutations from './mutations';
const state = {
  dialogs: null,
  payload: {
    message: null
  },
  isSubmitting: false
};
export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
