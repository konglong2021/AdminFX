<template>
  <div class="auth-wrapper">
    <div class="card">
      <article class="card-body">
        <h2 class="card-title mb-4 mt-1">Register eApp</h2>
        <form @submit.prevent="authenticate">
          <span v-if="error">
            {{error.message}}
          </span>
          <div class="form-group mb-2">
            <label
              for="name"
              class="mb-2"
            >Name</label>
            <input
              id="name"
              name=""
              class="form-control"
              placeholder="name"
              type="text"
              v-model="form.name"
            >
          </div>
          <div class="form-group mb-2">
            <label
              for="email"
              class="mb-2"
            >Email</label>
            <input
              id="email"
              name=""
              class="form-control"
              placeholder="Email"
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
            >Register</button>
          </div>
        </form>
      </article>
    </div>
  </div>
</template>
<script>
import api from '@/api/auth';

export default {
  name: 'Register',
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
      },
      type: 'register',
      error: false,
    };
  },
  methods: {
    authenticate() {
      const { name, email, password } = this.form;
      if (email && password) {
        api.register({ name, email, password }).then(({ data }) => {
          console.log(data);
        }).catch((err) => {
          console.log(err);
        });
      }
    },
  },
};
</script>
