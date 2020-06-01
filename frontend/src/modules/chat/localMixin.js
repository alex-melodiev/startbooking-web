import chat from './store';
export default {
  created() {
    const store = this.$store;
    const name = 'chat';
    if (!(store && store.state && store.state[name])) {
      store.registerModule(name, chat);
    }
  }
}
