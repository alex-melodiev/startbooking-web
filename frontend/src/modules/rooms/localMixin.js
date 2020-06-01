import rooms from './store';
export default {
  created() {
    const store = this.$store;
    const name = 'rooms';
    if (!(store && store.state && store.state[name])) {
      store.registerModule(name, rooms);
    }
  }
}
