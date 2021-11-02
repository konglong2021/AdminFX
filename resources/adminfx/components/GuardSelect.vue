<template>
  <select
    class="form-select"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value?.trim())"
  >
    <option
      v-if="!isNotOptionAll"
      value=""
    >{{$t('setting.common.option.all')}}</option>
    <option
      v-for="item in Guards"
      :key="item"
      :value="item"
    >{{item}}</option>
  </select>
</template>
<script>
export default {
  props: {
    modelValue: null,
    isNotOptionAll: null,
  },
  data() {
    return {
      Guards: [
        'api',
        'web',
        'mobile',
      ],
    };
  },
  mounted() {
    if (this.modelValue == null) {
      if (this.isNotOptionAll) {
        this.$emit('update:modelValue', 'api');
      } else {
        this.$emit('update:modelValue', '');
      }
    }
  },
  setup() {

  },
};
</script>
