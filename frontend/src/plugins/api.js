import axios from "axios";
import store from "../store";


const { getters } = store;


const api = axios.create({
  baseURL: process.env.VUE_APP_API_URI,
  withCredentials: false
});

// const { locale } = i18n;

export default {
  install(vue){
    vue.prototype.$api = {
      _axiosPost(url, body, onSuccess, onError) {
        api.post(url, body, {
          crossDomain: true,
          headers: this._getHeaders()
        })
          .then((response) => {
            onSuccess(response);
          })
          .catch((catchError) => {
            if(typeof onError === 'function') {
              onError(catchError.response);
            }
          });
      },
      _axiosPostFormData(url, body, onSuccess, onError) {
        api.post(url, body, {
          headers: this._getHeaders([
              {key: 'Content-Type', value: 'multipart/form-data'}])
        })
          .then((response) => {
            onSuccess(response);
          })
          .catch((catchError) => {
            if(typeof onError === 'function') {
              onError(catchError.response);
            }
          });
      },
      _axiosGet(url, body, onSuccess, onError) {
        api.get(url, {
          params: body,
          headers: this._getHeaders()
        })
          .then((response) => {
            onSuccess(response);
          })
          .catch((catchError) => {
            if(typeof onError === 'function') {
              onError(catchError.response);
            }
          });
      },
      _axiosDelete(url, body, onSuccess, onError) {
        api.delete(url, {
          params: body,
          headers: this._getHeaders()
        })
          .then((response) => {
            onSuccess(response);
          })
          .catch((catchError) => {
            if(typeof onError === 'function') {
              onError(catchError.response);
            }
          });
      },
      _getHeaders(replaceHeaders) {

        const headers = {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'Content-Language': store.state.locale,
        };

        if (getters['user/isGuest'] === false) {
          headers['Authorization'] = "Bearer " + getters['user/accessToken'];
        }

        if(replaceHeaders) {
          replaceHeaders.forEach((replace) => {
            headers[replace.key] = replace.value;
          });
        }

        return headers;
      },

      //Auth
      login(body, onSuccess, onError) {
        return this._axiosPost('/api/auth/login', body, onSuccess, onError);
      },
      logout(body, onSuccess, onError) {
        return this._axiosGet('/api/auth/logout', body, onSuccess, onError);
      },
      register(body, onSuccess, onError) {
        return this._axiosPost('/api/auth/register', body, onSuccess, onError);
      },

      //User
      getAccount(body, onSuccess, onError) {
        return this._axiosGet('/api/account', body, onSuccess, onError);
      },
      updateAccount(body, onSuccess, onError) {
        return this._axiosPostFormData('/api/account/update', body, onSuccess, onError);
      },

      //Deals
      getDeals(body, onSuccess, onError) {
        return this._axiosGet('/api/deals', body, onSuccess, onError);
      },
      getDeal(body, onSuccess, onError) {
        return this._axiosGet(`/api/deals/${body}/show`, null, onSuccess, onError);
      },


      // Entities
      getEntities(body, onSuccess, onError) {
          return this._axiosGet('/api/entities', body, onSuccess, onError);
      },

      switchEntityState(body, onSuccess, onError){
          return this._axiosPost(`/api/entities/state`, body, onSuccess, onError);
      },

        //Comments
      addCommentToDeal(body, onSuccess, onError) {
        const { id, payload } = body;
        return this._axiosPost(`/api/deals/${id}/comment`, payload, onSuccess, onError);
      },

      //Favorite
      getFavorites(body, onSuccess, onError) {
        return this._axiosGet('/api/wishes', body, onSuccess, onError);
      },
      addToFavorites(body, onSuccess, onError) {
        return this._axiosPost('/api/wishes', body, onSuccess, onError);
      },
      deleteFromFavorites(body, onSuccess, onError) {
        return this._axiosDelete('/api/wishes', body, onSuccess, onError);
      },

      //Chat
      getChat(body, onSuccess, onError) {
        return this._axiosGet('/api/chat', body, onSuccess, onError);
      },
      postChat(body, onSuccess, onError) {
        return this._axiosPost('/api/chat', body, onSuccess, onError);
      },

      //Booking
      bookProperty(body, onSuccess, onError) {
        return this._axiosPost('/api/booking', body, onSuccess, onError);
      },
      getBookings(body, onSuccess, onError) {
        return this._axiosGet('/api/account/bookings', body, onSuccess, onError);
      },

      //Locations
      getCountries(body, onSuccess, onError) {
        return this._axiosGet('/api/properties/countries', body, onSuccess, onError);
      },
      getCities(body, onSuccess, onError) {
        return this._axiosGet('/api/properties/cities', body, onSuccess, onError);
      },

      // Addd/Edit states
      getStates(body, onSuccess, onError) {
        return this._axiosGet('/api/properties/states', body, onSuccess, onError);
      },
      submitStore(body, onSuccess, onError) {
        return this._axiosPostFormData('/api/properties/store', body, onSuccess, onError);
      },
    };
  }
}
