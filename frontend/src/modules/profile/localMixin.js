import profile from './store';
export default {
  created() {
    const store = this.$store;
    const name = 'profile';
    if (!(store && store.state && store.state[name])) {
      store.registerModule(name, profile);
    }
  }
}
