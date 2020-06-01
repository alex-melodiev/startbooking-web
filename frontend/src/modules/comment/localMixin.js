import comment from './store';
export default {
  created() {
    const store = this.$store;
    const name = 'comment';
    if (!(store && store.state && store.state[name])) {
      store.registerModule(name, comment);
    }
  }
}
