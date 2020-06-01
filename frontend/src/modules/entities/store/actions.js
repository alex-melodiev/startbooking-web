export default {
  async entitiesInit({dispatch}, query) {
    await dispatch('getEntities', query);
  },
  async switchState({commit}, serial){
    commit('BEFORE_SWITCH_STATE');
    console.log(serial);
  },
  async getEntities({commit}, query) {
    commit('BEFORE_GET_ENTITIES');
    await this._vm.$api.getEntities(query, (response) => {
      const { status, data } = response;
      if(status === 200) {
        commit('SET_ENTITIES', data);
      }
      commit('AFTER_GET_ENTITIES');
    }, (response) => {
      const { data } = response;
      const { message } = data;
      this._vm.$toasted.show(message, {
        position: 'bottom-center',
        type: 'error',
        duration: 2000
      });
      commit('AFTER_GET_ENTITIES');
    });
  },
  async getEntity({commit}, id) {
    commit('BEFORE_GET_ENTITIES');

    await this._vm.$api.getEntity(id, (response) => {
      const { status, data } = response;
      if(status === 200) {
        commit('SET_ENTITY', data);
      }
      commit('AFTER_GET_ENTITY');
    }, (response) => {
      const { data } = response;
      const { message } = data;
      this._vm.$toasted.show(message, {
        position: 'bottom-center',
        type: 'error',
        duration: 2000
      });
      commit('AFTER_GET_ENTITY');
    });
  },
  destroyEntity({commit}) {
    commit('SET_ENTITY', null);
  }
};
