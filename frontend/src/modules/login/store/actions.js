import i18n from "../../i18n/";
import router from '../../../router'
import {objectGet} from "../../../utils/object";
import {isNotEmpty} from "../../../utils/helpers";

export default {
  async login({commit, dispatch}, payload) {
    commit('BEFORE_LOGIN');
    await this._vm.$api.login(payload, (response) => {
      const { data } = response;
      const { access_token } = data;
      if(access_token) {
        dispatch('user/updateAccessToken', access_token, { root: true }).then(() => {
          this._vm.$toasted.show(i18n.t('Вы успешно авторизовались'), {
            position: 'bottom-center',
            type: 'success',
            duration: 2000
          });
          const backto = objectGet(router, 'app.$route.query.backto');
          if(isNotEmpty(backto)) {
            router.replace({path: backto});
          } else {
            router.replace({name: 'home'});
          }
          commit('AFTER_LOGIN');
          dispatch('user/getAccount', null, { root: true });
          dispatch('favorite/getFavorites', null, { root: true });
        });
      } else {
        commit('AFTER_LOGIN');
      }
    }, (response) => {
      const { status, data } = response;
      let toast = null;
      if(status !== 422) {
        this._vm.$toasted.show(i18n.t('Ошибка при запросе'), {
          position: 'bottom-center',
          type: 'error',
          duration: 2000
        });
      } else {
        const { message, errors } = data;
        toast = message;
        this._vm.$toasted.show(toast, {
          position: 'bottom-center',
          type: 'error',
          duration: 2000
        });
        commit('SET_ERRORS', errors);
      }

      const { errors } = data;
      if(isNotEmpty(errors)) {
        commit('SET_ERRORS', errors);
      }

      commit('AFTER_LOGIN');
    });
  },
  async logout({dispatch}) {
    await this._vm.$api.logout(null, (response) => {
      const { data, status } = response;
      if(status === 200) {
        dispatch('user/clear', null, {root: true});
        dispatch('favorite/clear', null, {root: true});
        router.replace({name: 'home'});
      }

      const { message } = data;
      this._vm.$toasted.show(message, {
        position: 'bottom-center',
        duration: 2000
      });
    }, () => {
      this._vm.$toasted.show(i18n.t('Ошибка при запросе'), {
        position: 'bottom-center',
        type: 'error',
        duration: 2000
      });
    });
  }
};
