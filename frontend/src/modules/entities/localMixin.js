import entities from './store';
export default {
  created() {
    const store = this.$store;
    const name = 'entities';
    if (!(store && store.state && store.state[name])) {
      store.registerModule(name, entities);
    }
  }
}
