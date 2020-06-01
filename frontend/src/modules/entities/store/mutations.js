export default {
  BEFORE_GET_ENTITIES(state) {
    state.isLoading = true;
    state.entities = null;
  },
  AFTER_GET_ENTITIES(state) {
    state.isLoading = false;
  },
  SET_ENTITIES(state, payload) {
    state.entities = payload;
  },
  SET_FILTERS(state, payload) {
    state.filters = payload;
  },
  SET_ERRORS(state, payload) {
    state.errors = payload;
  },
  BEFORE_GET_ENTITY(state) {
    state.isLoading = true;
    state.entity = null;
  },
  AFTER_GET_ENTITY(state) {
    state.isLoading = false;
  },
  SET_ENTITY(state, payload) {
    state.entity = payload;
  },
  BEFORE_SWITCH_STATE(state, payload){
    state.entity = payload;
  },
};
