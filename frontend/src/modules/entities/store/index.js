import actions from './actions';
import getters from './getters';
import mutations from './mutations';
const state = {
  isLoading: false,
  entities: null,
  entity: null,
  errors: null,
  filters: null
};
export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
