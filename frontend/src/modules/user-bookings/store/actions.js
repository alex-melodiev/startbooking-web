import i18n from "../../i18n";

export default {
  async getBookings({commit}) {
    commit('BEFORE_GET_BOOKINGS');
    await this._vm.$api.getBookings(null, (response) => {
      const { data, status } = response;
      if(status === 200) {
        commit('SET_BOOKINGS', data);
      }
      commit('AFTER_GET_BOOKINGS');
    }, (response) => {
      const { data } = response;
      const { errors } = data;
      commit('SET_ERRORS', errors);

      this._vm.$toasted.show(i18n.t('Ошибка при бронировани'), {
        position: 'bottom-center',
        type: 'error',
        duration: 2000
      });
      commit('AFTER_GET_BOOKINGS');
    });
  }
};
