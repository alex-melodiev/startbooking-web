import dealsEdit from './store';
export default {
  created() {
    const store = this.$store;
    const name = 'dealsEdit';
    if (!(store && store.state && store.state[name])) {
      store.registerModule(name, dealsEdit);
    }
  }
}
