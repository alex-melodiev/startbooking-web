export default {
  items: (state) => state.items,
  // isFavorite: (state) => (id) => {
  //   let result = false;
  //   const item = state.items.find((item) => item.id === id);
  //   if(isNotEmpty(item)) {
  //     result = true;
  //   }
  //   return result;
  // },
  isFavorite: (state) => (id) => {
    return Boolean(state.items.find(item => item.id === id));
  },
};
