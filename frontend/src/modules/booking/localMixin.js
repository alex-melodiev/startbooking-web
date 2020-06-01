import booking from './store';
export default {
  created() {
    const store = this.$store;
    const name = 'booking';
    if (!(store && store.state && store.state[name])) {
      store.registerModule(name, booking);
    }
  }
}
