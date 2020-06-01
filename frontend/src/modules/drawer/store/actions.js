export default {
  toggle({commit, getters}) {
    commit('SET_VISIBILITY', !getters.isOpened);
  }
};
