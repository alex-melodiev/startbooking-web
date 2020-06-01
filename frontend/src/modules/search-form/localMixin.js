import searchForm from './store'
export default {
  created() {
    const store = this.$store;
    const name = 'searchForm';
    if (!(store && store.state && store.state[name])) {
      store.registerModule(name, searchForm);
    }
  }
}
