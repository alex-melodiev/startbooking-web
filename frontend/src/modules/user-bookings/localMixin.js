import userBookings from './store';
export default {
  created() {
    const store = this.$store;
    const name = 'userBookings';
    if (!(store && store.state && store.state[name])) {
      store.registerModule(name, userBookings);
    }
  }
}
