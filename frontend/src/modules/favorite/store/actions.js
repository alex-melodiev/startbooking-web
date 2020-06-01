export default {
  async toggleFavorite({dispatch, getters}, property_id) {
    if(getters.isFavorite(property_id)) {
      dispatch('deleteFromFavorite', property_id);
    } else {
      dispatch('addToFavorite', property_id);
    }
  },
  async addToFavorite({dispatch}, property_id) {
    await this._vm.$api.addToFavorites({property_id}, (response) => {
      const { data, status } = response;
      const { success } = data;
      if(status === 200) {
        dispatch('getFavorites');
      }
      this._vm.$toasted.show(success, {
        position: 'bottom-center',
        type: 'success',
        duration: 2000
      });
    });
  },
  async deleteFromFavorite({dispatch}, property_id) {
    await this._vm.$api.deleteFromFavorites({property_id}, (response) => {
      const { data, status } = response;
      const { success } = data;
      if(status === 200) {
        dispatch('getFavorites');
      }
      this._vm.$toasted.show(success, {
        position: 'bottom-center',
        type: 'success',
        duration: 2000
      });
    });
  },
  async getFavorites({commit}) {
    await this._vm.$api.getFavorites(null, (response) => {
      const { data, status } = response;
      if(status === 200) {
        commit('SET_ITEMS', data);
      }
    });
  },
  clear({commit}) {
    commit('SET_ITEMS', []);
  }
};
