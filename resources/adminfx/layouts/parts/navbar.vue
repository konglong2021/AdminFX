<template>
  <nav class="navbar navbar-expand navbar-light navbar-bg">
    <a
      class="sidebar-toggle js-sidebar-toggle"
      @click="this.setSidebar"
    >
      <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
      <ul class="navbar-nav navbar-align">
        <Notification />
        <SwtichLang />
        <Profile />
      </ul>
    </div>
  </nav>
</template>
<script>
import { mapActions } from 'vuex';
import Notification from '@/layouts/parts/Notification.vue';
import SwtichLang from '@/layouts/parts/SwtichLang.vue';
import Profile from '@/layouts/parts/Profile.vue';

export default {
  name: 'Navbar',
  components: {
    Notification,
    SwtichLang,
    Profile,
  },
  methods: {
    ...mapActions(['setSidebar']),
  },
};
</script>wq
