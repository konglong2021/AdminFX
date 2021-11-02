<template>
  <div>
    <div class="mb-3">
      <label class="form-label">
        {{$t('permission.field.name')}}
      </label>
      <InputFX v-model="dataItem.name" />
    </div>
    <div class="mb-3">
      <label class="form-label">
        {{$t('permission.field.title')}}
      </label>
      <InputFX v-model="dataItem.title" />
    </div>
    <div class="mb-3">
      <label class="form-label">
        {{$t('permission.field.guard_name')}}
      </label>
      <GuardSelect
        v-model="dataItem.guard_name"
        :isNotOptionAll="true"
      />
    </div>
    <div class="mb-3">
      <label class="form-label">
        {{$t('permission.field.module_name')}}
      </label>
      <InputFX v-model="dataItem.module_name" />
    </div>
  </div>
</template>
<script>
import InputFX from '@/components/common/InputFX.vue';
import GuardSelect from '@/components/GuardSelect.vue';

export default {
  props: {
    isNew: null,
    dataItem: null,
  },
  components: {
    InputFX,
    GuardSelect,
  },
  setup() {

  },
};
</script>
