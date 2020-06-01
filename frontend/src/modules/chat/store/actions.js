import {isEmpty, isNotEmpty} from "../../../utils/helpers";

export default {
  async init({dispatch}) {
    await dispatch('getChat');
  },
  async getChat({commit}) {
    await this._vm.$api.getChat(null, (response) => {
      const { status, data } = response;
      if(status === 200) {
        const { errors } = data;
        if(isEmpty(errors) && isNotEmpty(data)) {
          commit('SET_DIALOGS', data);
        }
      }
    })
  },
  async postChat({commit, getters}, message) {
    commit('BEFORE_SEND_MESSAGE');
    await this._vm.$api.postChat({message}, (response) => {
      const { status, data } = response;
      if(status === 200) {
        if(isNotEmpty(data)) {
          const currentDate = new Date();
          const currentYear = currentDate.getFullYear();
          const currentMonth = currentDate.getMonth() < 10 ? '0' + (currentDate.getMonth() + 1) : currentDate.getMonth() + 1;
          const currentDay = currentDate.getDate() < 10 ? '0' + currentDate.getDate() : currentDate.getDate();
          const date = currentYear + '.' + currentMonth + '.' + currentDay;
          const dialogs = {...getters.dialogs};
          if(isEmpty(dialogs[date])) {
            dialogs[date] = [];
          }
          dialogs[date].push(data);
          commit('SET_DIALOGS', dialogs);
          commit('SET_MESSAGE', null);
        }
      }
      commit('AFTER_SEND_MESSAGE');
    })
  },
  onSubmit({dispatch, getters}) {
    if(isNotEmpty(getters.payload.message)) {
      const message = getters.payload.message.replace(/(?:\r\n|\r|\n)/g, '<br>');
      dispatch('postChat', message);
    }
  }
};
