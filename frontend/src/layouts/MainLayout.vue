<template>
  <div class="page__wrapper">
    <div class="page__sidebar" role="complementary">
      <Sidebar />
    </div>
    <div class="page__body">
      <main class="page__main" role="main">
        <router-view />
      </main>
      <div class="page__footer" role="contentinfo">
        <Footer />
      </div>
    </div>
    <SBDrawer :menu="$route.meta.partner ? partnerMenu : allMenu" />
  </div>
</template>

<script>
  import Sidebar from "../components/general/Sidebar";
  import Footer from "../components/general/Footer";
  import SBDrawer from "../modules/drawer/SBDrawer";
  import Model from "../models/home";

  export default {
    name: "MainLayout",
    data() {
      return {
        allMenu: Model.menu.all,
        partnerMenu: Model.menu.partner
      }
    },
    components: {
      SBDrawer,
      Sidebar,
      Footer
    },
  }
</script>

<style scoped>

</style>
