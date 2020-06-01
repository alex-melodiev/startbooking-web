import {isNotEmpty, isValidFile} from "../../../utils/helpers";
import i18n from "../../i18n";

export default {
  async getProfile({commit}) {
    commit('BEFORE_GET_PROFILE');
    await this._vm.$api.getAccount(null, (response) => {
      const { data, status } = response;
      if(status === 200) {
        commit('SET_PROFILE_DATA', data);
      }
      commit('AFTER_GET_PROFILE');
    });
  },
  async updateProfile({commit, dispatch, getters}, file) {
    const formData = new FormData();
    for(let key in getters.profileData) {
      if(key !== 'avatar') {
        formData.set(key, getters.profileData[key]);
      }
    }

    if(isValidFile(file)) {
      formData.append('avatar', file);
    }

    commit('BEFORE_UPDATE_PROFILE');
    await this._vm.$api.updateAccount(formData, (response) => {
      const { data, status } = response;

      if(status === 200) {
        const { update } = data;
        commit('SET_PROFILE_DATA', update);
        dispatch('user/updateAccount', update, {root: true});
        this._vm.$toasted.show(i18n.t('Данные успешно обновлены'), {
          position: 'bottom-center',
          type: 'success',
          duration: 2000
        });
      }
      commit('AFTER_UPDATE_PROFILE');

    }, (catchErrors) => {
      const { data } = catchErrors;
      const { errors } = data;
      if(isNotEmpty(errors)) {
        commit('SET_PROFILE_ERRORS', errors);
      }
      commit('AFTER_UPDATE_PROFILE');
    });
  }
};
