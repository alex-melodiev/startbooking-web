import i18n from "../../i18n/";

export default {
  async register({commit, dispatch}, payload) {
    commit('BEFORE_REGISTER');
    await this._vm.$api.register(payload, (response) => {
      const { data } = response;
      const { message } = data;
      this._vm.$toasted.show(message, {
        position: 'bottom-center',
        type: 'success',
        duration: 2000
      });
      const loginPayload = {
        email: payload.email,
        password: payload.password
      };
      dispatch('login/login', loginPayload, {root: true});
      commit('AFTER_REGISTER');
    }, (response) => {
      const { data } = response;
      const { errors } = data;
      commit('SET_ERRORS', errors);

      this._vm.$toasted.show(i18n.t('Ошибка при регистрации'), {
        position: 'bottom-center',
        type: 'error',
        duration: 2000
      });
      commit('AFTER_REGISTER');
    });
  }
};
