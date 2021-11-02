<template>
  <ModalFX
    :isShow="isShowPasswordForm"
    @closePopup="closeChangePasswordForm"
    title="Change Password"
  >
    <span v-if="error">
      {{error.message}}
    </span>
    <div class="form-group mb-2">
      <label
        for="password"
        class="mb-2"
      >Password</label>
      <input
        id="password"
        class="form-control"
        placeholder="******"
        type="password"
        v-model="password"
      >
    </div>
    <div class="form-group mb-2">
      <label
        for="password-new"
        class="mb-2"
      >Password New</label>
      <input
        id="password-new"
        class="form-control"
        placeholder="******"
        type="password"
        v-model="password2"
      >
    </div>
    <template v-slot:footer>
      <button
        type="button"
        class="btn btn-primary"
        @click="ChangePassword"
      >Change Password</button>
    </template>
  </ModalFX>
</template>
<script>
import { mapState, mapActions } from 'vuex';
import ModalFX from '@/components/common/ModalFX.vue';
import api from '@/api/auth';

export default {
  data() {
    return {
      password: '',
      password2: '',
      error: false,
    };
  },
  computed: {
    ...mapState('auth', ['isShowPasswordForm']),
  },
  methods: {
    ...mapActions('auth', ['closeChangePasswordForm']),
    ChangePassword() {
      api.changePassword({
        password: this.password,
        password2: this.password2,
      }).then(({ data }) => {
        if (data.OK) {
          this.closeChangePasswordForm();
        } else {
          this.error = {
            message: data.errors,
          };
        }
        console.log(data);
      }).catch((err) => {
        console.log(err);
      });
    },
  },
  components: {
    ModalFX,
  },
  setup() {

  },
};
</script>
