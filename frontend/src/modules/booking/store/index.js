import actions from './actions';
import getters from './getters';
import mutations from './mutations';
const state = {
  isLoading: false,
  isSubmitting: false,
  errors: null,
  deal: null,
  daysCount: null,
};
export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
