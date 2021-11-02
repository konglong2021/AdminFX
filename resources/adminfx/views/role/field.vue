<template>
  <div class="row">
    <div class="col-lg-5 col-md-12">
      <div class="mb-3">
        <label class="form-label">
          {{$t('role.field.name')}}
        </label>
        <InputFX v-model="dataItem.name" />
      </div>
      <div class="mb-3">
        <label class="form-label">
          {{$t('role.field.title')}}
        </label>
        <InputFX v-model="dataItem.title" />
      </div>
      <div class="mb-3">
        <label class="form-label">
          {{$t('role.field.guard_name')}}
        </label>
        <GuardSelect
          v-model="dataItem.guard_name"
          @change="UpdateGuard"
          :isNotOptionAll="true"
        />
      </div>
    </div>
    <div class="col-lg-7 col-md-12">
      <label class="form-label">
        {{$t('role.field.permission')}}
      </label>
      <PermissionCheckBox
        ref="permission"
        v-model:permissions="dataItem.permissions"
        :modules="modules"
        v-model:is_loading_data="is_loading_data"
      />
    </div>
  </div>
</template>
<script>
import InputFX from '@/components/common/InputFX.vue';
import GuardSelect from '@/components/GuardSelect.vue';
import PermissionCheckBox from '@/components/PermissionCheckBox.vue';
import roleApi from '@/api/role';

export default {
  props: {
    isNew: null,
    dataItem: null,
  },
  components: {
    InputFX,
    GuardSelect,
    PermissionCheckBox,
  },
  computed: {},
  methods: {
    UpdateGuard() {
      const id = this.isNew ? 0 : this.dataItem.id;
      roleApi.permission(id, this.dataItem.guard_name).then(({ data }) => {
        const { permissions, modules } = data.data;
        this.dataItem.permissions = permissions;
        this.modules = modules;
        this.$nextTick(() => {
          this.$refs.permission.checkStatusAll();
        });
        this.is_loading_data = false;
      }).catch((error) => {
        console.log(error);
        this.dataItem.permissions = [];
        this.modules = [];
        this.$nextTick(() => {
          this.$refs.permission.checkStatusAll();
        });
        this.is_loading_data = false;
      });
    },
  },
  data() {
    return {
      is_loading_data: false,
      modules: [],
    };
  },
  created() {
    this.is_loading_data = true;
    if (this.dataItem.permissions === undefined) {
      this.dataItem.permissions = [];
    }
    if (this.dataItem.guard_name === undefined) {
      this.dataItem.guard_name = 'api';
    }
    this.UpdateGuard();
  },
  setup() {

  },
};
</script>
