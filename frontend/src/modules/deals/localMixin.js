import deals from './store';
export default {
  created() {
    const store = this.$store;
    const name = 'deals';
    if (!(store && store.state && store.state[name])) {
      store.registerModule(name, deals);
    }
  }
}
