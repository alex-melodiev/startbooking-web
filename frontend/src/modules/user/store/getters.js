export default {
  isGuest: (state) => {
    let result = true;
    if(state.accessToken) {
      result = false;
    }
    return result;
  },
  accessToken: (state) => state.accessToken,
  userInfo: (state) => state.info
};
