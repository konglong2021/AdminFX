<template>
  <div class="full-wrapper">
    <Loading />
    <slot />
  </div>
</template>
<script>
import Loading from '@/components/loading.vue';

export default {
  name: 'full-layout',
  components: {
    Loading,
  },
};
</script>
<style lang="scss" scoped>
.full-wrapper {
  width: 100%;
  height: 100%;
  position: absolute;
  overflow: auto;
  top: 0;
  left: 0;
}
</style>
