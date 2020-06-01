import login from './store';
export default {
  created() {
    const store = this.$store;
    const name = 'login';
    if (!(store && store.state && store.state[name])) {
      store.registerModule(name, login);
    }
  }
}
