import i18n from '../../i18n'
import router from "../../../router";

export default {
  async init({dispatch}, id) {
    await dispatch('getDeal', id);
  },
  async getDeal({commit}, id) {
    commit('BEFORE_GET_DEAL');
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
  async bookProperty({commit}, payload) {
    const query = {};
    for(let key in payload) {
      if(key === 'check_in' || key === 'check_out') {
        const date = new Date(payload[key]);
        const year = date.getFullYear();
        const month = date.getMonth() < 10 ? '0' + (date.getMonth() + 1) : date.getMonth();
        const day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
        const payloadDate = year + '-' + month + '-' + day;
        query[key] = payloadDate;
      } else {
        query[key] = payload[key];
      }
    }

    commit('BEFORE_BOOK');
    await this._vm.$api.bookProperty(query, (response) => {
      const { data, status } = response;
      if(status === 200) {
        const { succcess } = data;
        this._vm.$toasted.show(succcess, {
          position: 'bottom-center',
          type: 'success',
          duration: 2000
        });
        router.push({name: 'user-bookings'})
      }
      commit('AFTER_BOOK');
    }, (response) => {
      const { data } = response;
      const { errors } = data;
      commit('SET_ERRORS', errors);

      this._vm.$toasted.show(i18n.t('Ошибка при бронировани'), {
        position: 'bottom-center',
        type: 'error',
        duration: 2000
      });
      commit('AFTER_BOOK');
    });
  },

  async setDaysCount({commit}, data) {
    let result = null;
    let payload = data.payload;
    let fee_starts_from = data.price;
    if(payload && payload.check_out) {
      const check_out = new Date(payload.check_out);
      const check_in = new Date(payload.check_in);
      result = Math.round((check_out-check_in)/(1000*60*60*24))
    }
    console.log(data);


    // amount, subtotal, nds, total, total_now, total_after
    if(fee_starts_from) {
      //console.log(fee_starts_from);
      let amount = fee_starts_from * result;
      let nds = fee_starts_from * 0.2;
      let subtotal = amount + nds;
      let total_now = subtotal * 0.3;
      let total_after = subtotal * 0.7;
      let pld = {amount, nds, subtotal, total_now, total_after, 'daysCount': result};
      console.log(pld);
      commit('SET_BOOKING_DETAILS', pld);
    }
    commit('SET_DAYS_COUNT', result);

    //this.daysCount = result;
    //return result;
  },
};
