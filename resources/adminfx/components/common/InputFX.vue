<template>
  <input
    :disabled="disabled"
    :type="InputType"
    class="form-control"
    :value="modelValue"
    :placeholder="placeholder"
    @input="$emit('update:modelValue', $event.target.value?.trim())"
  />
</template>
<script>
export const InputType = {
  text: 'text',
  number: 'number',
  email: 'email',
  password: 'password',
  search: 'search',
  url: 'url',
  tel: 'tel',
  date: 'date',
  time: 'time',
  range: 'range',
  color: 'color',
};

export default {
  props: {
    type: InputType,
    modelValue: null,
    disabled: null,
    placeholder: null,
  },
  computed: {
    InputType() {
      return this.type;
    },
  },
  setup() {
  },
};
</script>
