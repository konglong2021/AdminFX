<template>
  <div
    class="modal fade show modal-admin"
    v-if="isShow"
    :class="type?type:''"
    tabindex="-1"
    role="dialog"
  >
    <div class="model-face"></div>
    <div
      class="modal-dialog"
      :class="size??''"
      role="document"
    >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"> {{title}}</h5>
          <button
            type="button"
            class="close btn btn-primary btn-sm"
            data-dismiss="modal"
            aria-label="Close"
            @click="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <slot />
        </div>
        <div class="modal-footer">
          <slot name="footer"></slot>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

export default {
  name: 'ModalFX',
  props: {
    title: null,
    isShow: null,
    type: null,
    size: null,
  },
  methods: {
    Close() {
      this.$emit('update:isShow', false);
      this.$emit('closePopup');
    },
    OK() {
      this.$emit('ok');
      this.Close();
    },
  },
  setup() {
  },
};
</script>
