import actions from './actions';
import getters from './getters';
import mutations from './mutations';
const state = {
  isSubmitting: false,
  errors: null
};
export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
