export default {
  async getStates({commit}) {
    commit('BEFORE_GET_STATES');
    await this._vm.$api.getStates(null, (response) => {
      const { data } = response;
      commit('SET_STATES', data);
      commit('AFTER_GET_STATES');
    }, (response) => {
      const { data } = response;
      const { message } = data;
      this._vm.$toasted.show(message, {
        position: 'bottom-center',
        type: 'error',
        duration: 2000
      });
      commit('AFTER_GET_STATES');
    });
  },
  async submitStore({commit, getters}) {
    const formData = new FormData();
    for(let key in getters.payload) {
      formData.set(key, getters.payload[key]);
    }

    commit('BEFORE_SUBMIT');
    await this._vm.$api.submitStore(formData, (response) => {
      const { data } = response;
      commit('SET_STATES', data);
      commit('AFTER_GET_STATES');
    }, (response) => {
      const { data } = response;
      const { message } = data;
      this._vm.$toasted.show(message, {
        position: 'bottom-center',
        type: 'error',
        duration: 2000
      });
      commit('AFTER_SUBMIT');
    }, () => {
      commit('AFTER_SUBMIT');
    });
  }
};
