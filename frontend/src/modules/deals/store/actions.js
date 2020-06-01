export default {
  async dealsInit({dispatch}, query) {
    await dispatch('getDeals', query);
  },
  async getDeals({commit}, query) {
    commit('BEFORE_GET_DEALS');
    await this._vm.$api.getDeals(query, (response) => {
      const { status, data } = response;
      if(status === 200) {
        const { deals, filters } = data;
        commit('SET_DEALS', deals);
        commit('SET_FILTERS', filters);
      }
      commit('AFTER_GET_DEALS');
    }, (response) => {
      const { data } = response;
      const { message } = data;
      this._vm.$toasted.show(message, {
        position: 'bottom-center',
        type: 'error',
        duration: 2000
      });
      commit('AFTER_GET_DEALS');
    });
  },
  async getDeal({commit}, id) {
    commit('BEFORE_GET_DEALS');

    await this._vm.$api.getDeal(id, (response) => {
      const { status, data } = response;
      if(status === 200) {
        commit('SET_DEAL', data);
      }
      commit('AFTER_GET_DEAL');
    }, (response) => {
      const { data } = response;
      const { message } = data;
      this._vm.$toasted.show(message, {
        position: 'bottom-center',
        type: 'error',
        duration: 2000
      });
      commit('AFTER_GET_DEAL');
    });
  },
  destroyDeal({commit}) {
    commit('SET_DEAL', null);
  }
};
