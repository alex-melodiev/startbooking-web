import payment from './store';
export default {
  created() {
    const store = this.$store;
    const name = 'payment';
    if (!(store && store.state && store.state[name])) {
      store.registerModule(name, payment);
    }
  }
}
