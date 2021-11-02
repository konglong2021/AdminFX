<template>
  <div class="wrapper">
    <Loading />
    <Sidebar />
    <div class="main">
      <Navbar />
      <main class="content">
        <slot />
      </main>
    </div>
    <ChangePassword />
  </div>
</template>
<script>
import Loading from '@/components/loading.vue';
import Navbar from './parts/navbar.vue';
import Sidebar from './parts/sidebar.vue';
import ChangePassword from './parts/ChangePassword.vue';

export default {
  components: {
    Loading,
    Navbar,
    Sidebar,
    ChangePassword,
  },
};
</script>
