export default {
  updateAccessToken({commit}, token) {
    commit('SET_ACCESS_TOKEN', token);
  },
  async getAccount({dispatch}) {
    await this._vm.$api.getAccount(null, (response) => {
      const { status, data } = response;
      if(status === 200) {
        dispatch('updateAccount', data);
      }
    });
  },
  async updateAccount({commit}, data) {
    commit('SET_INFO', data);
  },
  clear({commit}) {
    commit('SET_ACCESS_TOKEN', null);
    commit('SET_INFO', null);
  }
};
