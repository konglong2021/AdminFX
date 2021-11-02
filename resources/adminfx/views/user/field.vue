<template>
  <div>
    <div class="mb-3">
      <label class="form-label">
        {{$t('user.field.name')}}
      </label>
      <InputFX v-model="dataItem.name" />
    </div>
    <div class="mb-3">
      <label class="form-label">
        {{$t('user.field.email')}}
      </label>
      <InputFX
        v-model="dataItem.email"
        type="email"
      />
    </div>
    <div
      class="mb-3"
      v-if="isNew"
    >
      <label class="form-label">
        {{$t('user.field.password')}}
      </label>
      <InputFX
        v-model="dataItem.password"
        type="password"
      />
    </div>
  </div>
</template>
<script>
import InputFX from '@/components/common/InputFX.vue';

export default {
  props: {
    isNew: null,
    dataItem: null,
  },
  components: {
    InputFX,
  },
  setup() {

  },
};
</script>
