<template>
  <div class="select-fx">
    <select
      ref="controlSelect"
      :disabled="disabled"
      class="form-select"
      :value="modelValue"
      :placeholder="placeholder"
      @change="SelectItem"
      @input="SelectItem"
    >
      <option
        value=""
        v-if="isEmpty"
      >{{textEmpty}}</option>
      <option
        v-for="item in DataSoure"
        :value="item[FieldId]"
        :item="item"
        :key="item[FieldId]"
      >{{item[FieldName]}}</option>
    </select>
  </div>
</template>
<script>
export default {
  props: {
    modelValue: null,
    itemSelect: null,
    disabled: null,
    placeholder: null,
    DataSoure: null,
    fieldId: null,
    fieldName: null,
    isEmpty: null,
    textEmpty: null,
  },
  data() {
    return {
      FieldId: null,
      FieldName: null,
    };
  },
  mounted() {
    if (!this.fieldId) {
      this.FieldId = 'id';
    } else {
      this.FieldId = this.fieldId;
    }
    if (!this.fieldName) {
      this.FieldName = 'name';
    } else {
      this.FieldName = this.fieldName;
    }
  },
  updated() {
    this.$nextTick(() => {
      this.setItemSelect(this.$refs.controlSelect.selectedIndex);
    });
  },
  methods: {
    setItemSelect(index) {
      if ((this.isEmpty && index === 0) || index < 0) {
        this.$emit('update:itemSelect', null);
        return;
      }
      this.$emit('update:itemSelect', this.DataSoure[this.isEmpty ? (index - 1) : index]);
    },
    SelectItem($event) {
      this.setItemSelect(this.$refs.controlSelect.selectedIndex);
      this.$emit('update:modelValue', $event.target.value);
    },
  },
  setup() {

  },
};
</script>
