import register from './store';
export default {
  created() {
    const store = this.$store;
    const name = 'register';
    if (!(store && store.state && store.state[name])) {
      store.registerModule(name, register);
    }
  }
}
