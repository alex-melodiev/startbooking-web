import favorite from './store';
export default {
  created() {
    const store = this.$store;
    const name = 'favorite';
    if (!(store && store.state && store.state[name])) {
      store.registerModule(name, favorite);
    }
  }
}
