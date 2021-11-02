<template>
  <div class="permission">
    <ul
      v-if="is_loading_data"
      class="nav nav-pills nav-sidebar flex-column"
    >
      <li
        class="nav-item"
        v-for="key in 10"
        :key="key"
      >
        <div class="d-flex align-items-stretch">
          <input
            class="form-check-input check-all"
            disabled="disabled"
            name="checkAll"
            type="checkbox"
          >
          <span class="nav-link d-flex flex-fill">
            <i class="nav-icon bi bi-shield-shaded"></i>
            <p>
              {{$t(`setting.permission.loading.title`)}}
              <i class="bi bi-chevron-double-left right"></i>
            </p>
          </span>
        </div>
      </li>
    </ul>
    <ul
      v-else
      class="nav nav-pills nav-sidebar flex-column"
    >
      <li
        class="nav-item"
        v-for="(items,key) in modules"
        :key="key"
      >
        <div class="d-flex align-items-stretch">
          <input
            class="form-check-input check-all"
            name="checkAll"
            type="checkbox"
            :disabled="checkDisable(null,key)"
            :value="key"
            v-model="moduleStatus"
            @change="(e)=>changeCheckAll(e,items,key)"
          >
          <span
            class="nav-link d-flex flex-fill"
            @click="shows[key]=(shows[key]?false:true)"
          >
            <i class="nav-icon bi bi-shield-shaded"></i>
            <p>
              {{$t(`setting.permission.${key}.title`)}}
              <i
                v-if="shows[key]"
                class="bi bi-chevron-double-down right"
              ></i>
              <i
                v-else
                class="bi bi-chevron-double-left right"
              ></i>
            </p>
          </span>
        </div>
        <ul
          class="nav nav-treeview d-block pe-4"
          v-if="shows[key]"
        >
          <li
            class="nav-item "
            v-for="item in items"
            :key="key+'-'+item.id"
          >
            <span class="nav-link d-flex flex-fill">

              <input
                v-if="checkDisable(item.name,null)"
                class="form-check-input"
                type="checkbox"
                :disabled="true"
                checked="true"
              >
              <input
                v-else
                class="form-check-input check-one"
                type="checkbox"
                :value="item.name"
                @change="checkStatus(key)"
                v-model="permissions"
              >
              <i class="nav-icon bi bi-circle-fill"></i>
              <p>
                {{$t(`setting.permission.${item.name}`)}}
              </p>
            </span>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</template>
<script>
import objUtls from '@/utils/object';

export default {
  props: {
    modules: null,
    permissions: null,
    disablePermissions: null,
    is_loading_data: null,
  },
  methods: {
    checkDisable(permission, module) {
      if (this.disablePermissions && this.disablePermissions.length > 0) {
        const disablePermissions = objUtls.Clone(this.disablePermissions);
        if (module) {
          return this.modules[module].filter((item) => {
            return disablePermissions.indexOf(item.name) > -1;
          }).length > 0;
        }
        if (permission) {
          return disablePermissions.indexOf(permission) > -1;
        }
      }
      return false;
    },
    changeCheckAll(ev, items, key) {
      const arrItems = objUtls.Clone(this.permissions);
      if (ev.target.checked) {
        items.forEach((item) => {
          if (arrItems.indexOf(item.name) === -1) {
            arrItems.push(item.name);
          }
        });
      } else {
        items.forEach((item) => {
          const index = arrItems.indexOf(item.name);
          if (index >= 0) {
            arrItems.splice(index, 1);
          }
        });
      }
      this.$emit('update:permissions', arrItems);
      this.$nextTick(() => {
        this.checkStatus(key);
      });
    },
    checkStatus(key) {
      const items = objUtls.Clone(this.modules[key]);
      const arrItems = objUtls.Clone(this.permissions);
      const arrStatus = objUtls.Clone(this.moduleStatus);
      this.$emit('update:permissions', arrItems);
      const len = items.filter((item) => arrItems.indexOf(item.name) > -1).length;
      const index = arrStatus.indexOf(key);
      if (items.length === len && index === -1) {
        arrStatus.push(key);
        this.moduleStatus = arrStatus;
      } else if (items.length !== len && index !== -1) {
        arrStatus.splice(index, 1);
        this.moduleStatus = arrStatus;
      }
    },
    checkStatusAll() {
      const arrItems = objUtls.Clone(this.moduleStatus);
      const arrStatus = [];
      const arrmodules = objUtls.Clone(this.modules);
      Object.keys(arrmodules).forEach((key) => {
        const items = arrmodules[key];
        const len = items.filter((item) => arrItems.indexOf(item.name) > -1).length;
        if (items.length === len) {
          arrStatus.push(key);
        }
      });
      this.moduleStatus = arrStatus;
    },
  },
  data() {
    return {
      shows: [],
      moduleStatus: [],
    };
  },
  setup() {
  },
};
</script>
<style scoped>
.permission {
  max-height: 400px;
  height: 100%;
  overflow: auto;
}
.permission .nav-sidebar > .nav-item {
  position: relative;
  margin: 0;
  border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}
.permission .nav-sidebar > .nav-item > .nav {
  margin: 0px 0px 0px 15px;
}
.permission .nav-sidebar > .nav-item .nav-item,
.permission .nav-sidebar .nav-item > div {
  border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}
.permission .nav-sidebar > .nav-item > div {
  padding: 0px 1px 0px 5px;
}
.permission .nav-sidebar > .nav-item .nav-link:hover {
  cursor: pointer;
}

.permission .nav-sidebar .nav-item > div:hover,
.permission .nav-sidebar .nav-item .nav-item:hover {
  background: #ccc;
}
.permission .nav-sidebar .nav-item .check-all {
  margin: 0.9rem 0rem;
}
.permission .nav-sidebar .nav-item div p {
  margin: 0.3rem 0rem;
}
.permission .nav-sidebar .nav-item .right {
  position: absolute;
  right: 1rem;
  top: 0.7rem;
}
</style>
