<template>
  <component :is="layout">
    <router-view />
  </component>
</template>
<script>
import { mapState, mapActions } from 'vuex';

export default {
  computed: {
    ...mapState('auth', ['isDone', 'isAuth']),
    layout() {
      return `${this.$route.meta.layout ?? 'default'}-layout`;
    },
  },
  created() {
    this.refreshUser();
    setTimeout(() => {
      if (this.isAuth) {
        this.refreshUser();
      }
    }, 10000);
  },
  updated() {
    if (this.isDone) {
      this.checkRouter();
    }
  },
  methods: {
    ...mapActions('auth', ['refreshUser', 'checkRouter']),
  },
};
</script>
<style lang="scss">
body,
html {
  padding: 0;
  margin: 0;
}
</style>
