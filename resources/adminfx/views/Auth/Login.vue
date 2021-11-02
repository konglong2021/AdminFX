<template>
  <div class="auth-wrapper">
    <div class="card">
      <article class="card-body">
        <h2 class="card-title mb-4 mt-1">Login eApp</h2>
        <form @submit.prevent="authenticate">
          <span v-if="error">
            {{error.message}}
          </span>
          <div class="form-group mb-2">
            <label
              for="email"
              class="mb-2"
            >Email</label>
            <input
              id="email"
              name=""
              class="form-control"
              placeholder="Email or login"
              type="email"
              v-model="form.email"
            >
          </div>
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
              v-model="form.password"
            >
          </div>
          <div class="d-grid gap-2 col-6 mx-auto mt-4">
            <button
              type="submit"
              class="btn btn-primary"
            >Login</button>
          </div>
        </form>
      </article>
    </div>
  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';

export default {
  name: 'Login',
  computed: {
    ...mapState('auth', ['error']),
  },
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
      type: 'login',
    };
  },
  methods: {
    ...mapActions('auth', ['login']),
    authenticate() {
      const { email, password } = this.form;
      if (email && password) {
        this.login({ email, password });
      }
    },
  },
};
</script>
