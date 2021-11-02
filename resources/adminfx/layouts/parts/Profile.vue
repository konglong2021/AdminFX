<template>

  <li
    v-if="isAuth"
    class="nav-item dropdown"
  >
    <a
      class="nav-icon dropdown-toggle d-inline-block d-sm-none"
      href="#"
      data-bs-toggle="dropdown"
    >
      <i class="bi bi-email align-middle"></i>
    </a>

    <a
      class="nav-link dropdown-toggle d-none d-sm-inline-block"
      href="#"
      data-bs-toggle="dropdown"
    >
      <img
        src="https://raw.githubusercontent.com/devhau/cv.hau.xyz/master/src/assets/image.jpg"
        class="avatar img-fluid rounded me-1"
        alt="{{user?.name}}"
      />
      <span class="text-dark">{{user?.name}}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-end">
      <a
        class="dropdown-item"
        href="/"
      >
        <i class="bi bi-speedometer align-middle"></i>
        {{user?.email}}</a>
      <a
        class="dropdown-item"
        @click.prevent="showChangePasswordForm()"
      >
        <i class="bi bi-shield-lock align-middle"></i>
        Change Password
      </a>
      <div class="dropdown-divider"></div>
      <a
        class="dropdown-item"
        href="#"
        v-on:click.stop.prevent="logout()"
      >Log out</a>
    </div>
  </li>
</template>
<script>
import { mapState, mapActions } from 'vuex';

export default {
  computed: {
    ...mapState('auth', ['isAuth', 'user', 'permissions', 'isShowPasswordForm']),
  },
  methods: {
    ...mapActions('auth', ['logout', 'refreshUser', 'showChangePasswordForm']),
  },
  setup() {

  },
};
</script>
