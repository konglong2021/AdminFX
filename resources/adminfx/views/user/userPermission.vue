<template>
  <ModalFX
    :title="$t('user.permission')"
    v-model:isShow="isShow"
    size="modal-lg"
  >
    <template v-slot:default>
      <div class="user-permission">
        <div class="row">
          <div class="col-6">
            <div class="mb-3">
              <label class="form-label">
                {{$t('user.field.name')}}
              </label>
              <InputFX
                :disabled="true"
                v-model="modelValue.name"
              />
            </div>
            <div class="mb-3">
              <label class="form-label">
                {{$t('user.field.email')}}
              </label>
              <InputFX
                v-model="modelValue.email"
                :disabled="true"
                type="email"
              />
            </div>
          </div>
          <div class="col-6">
            <div class="mb-3">
              <label class="form-label">
                {{$t('user.field.guard_name')}}
              </label>
              <GuardSelect
                v-model="guardName"
                @change="UpdateGuard"
                :isNotOptionAll="true"
              />
            </div>

            <div class="mb-3">
              <label class="form-label">
                {{$t('user.field.role')}}
              </label>
              <SelectFX
                v-model:DataSoure="allRoles"
                v-model:itemSelect="roleSelect"
                v-model="userRoles"
                :isEmpty="true"
                fieldId="name"
                fieldName="name"
                :isNotOptionAll="true"
              />
            </div>
            <div class="mb-3">
              <label class="form-label">
                {{$t('user.field.permission')}}
              </label>
              <PermissionCheckBox
                ref="permission"
                v-model:permissions="userPermissions"
                :modules="modules"
                :disablePermissions="DisablePermission"
                v-model:is_loading_data="is_loading_data"
              />
            </div>
          </div>
        </div>
      </div>
    </template>
    <template v-slot:footer>
      <button
        type="button"
        class="btn btn-secondary"
        data-dismiss="modal"
        @click="CloseForm"
      >{{$t('manager.button.cancel')}}</button>
      <button
        type="button"
        class="btn btn-primary"
        @click="updateForm"
      > {{$t('manager.button.update')}}</button>
    </template>
  </ModalFX>
</template>
<script>
import ModalFX from '@/components/common/ModalFX.vue';
import InputFX from '@/components/common/InputFX.vue';
import SelectFX from '@/components/common/SelectFX.vue';
import GuardSelect from '@/components/GuardSelect.vue';
import PermissionCheckBox from '@/components/PermissionCheckBox.vue';
import api from '@/api/user';

export default {
  props: {
    isShow: null,
    modelValue: null,
  },
  components: {
    ModalFX,
    InputFX,
    SelectFX,
    PermissionCheckBox,
    GuardSelect,
  },
  computed: {
    DisablePermission() {
      return this.roleSelect ? this.roleSelect.permissions.map((item) => item.name) : [];
    },
  },
  data() {
    return {
      is_loading_data: false,
      roleSelect: null,
      guardName: null,
      modules: [],
      userPermissions: [],
      allRoles: [],
      userRoles: [],
    };
  },
  mounted() {
    this.UpdateGuard();
  },
  methods: {
    UpdateGuard() {
      this.is_loading_data = true;
      api.getPermission(this.modelValue.id, this.guardName).then((rs) => {
        const {
          modules,
          userPermissions,
          allRoles,
          userRoles,
        } = rs.data.data;
        console.log(rs);
        this.modules = modules;
        this.allRoles = allRoles;
        this.userPermissions = userPermissions ?? [];
        this.userRoles = userRoles ?? [];
        this.$nextTick(() => {
          this.$refs.permission.checkStatusAll();
        });
        this.is_loading_data = false;
      }).catch((error) => {
        console.log(error);
        this.modules = [];
        this.allRoles = [];
        this.userPermissions = [];
        this.userRoles = [];
        this.$nextTick(() => {
          this.$refs.permission.checkStatusAll();
        });
        this.is_loading_data = false;
      });
    },
    CloseForm() {
      this.$emit('update:isShow', false);
    },
    updateForm() {
      api.putPermission(this.modelValue.id, {
        userPermissions: this.userPermissions,
        userRoles: this.userRoles,
        guardName: this.guardName,
      }).then((data) => {
        console.log(data);
      });
      this.$emit('update:isShow', false);
    },
  },
  watch: {
    isShow: {
      handler(val) {
        this.$emit('update:isShow', val);
      },
      deep: true,
    },
  },
  setup() {

  },
};
</script>
