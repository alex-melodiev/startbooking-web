import actions from './actions';
import getters from './getters';
import mutations from './mutations';
const state = {
  accessToken: null,
  info: null
};
export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
