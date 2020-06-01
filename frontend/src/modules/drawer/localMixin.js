import drawer from './store';
export default {
  created() {
    const store = this.$store;
    const name = 'drawer';
    if (!(store && store.state && store.state[name])) {
      store.registerModule(name, drawer);
    }
  }
}
