<template>
  <TableManager
    :configs="manager"
    ref="manager"
  >
    <template v-slot:button_action_extend>
      <button
        v-if="$can('permission.load-router')"
        class="btn btn-danger btn-action"
        @click="loadRouter"
      >
        <i class="bi bi-shield-fill"></i>
        {{$t('permission.button.update')}}
      </button>
    </template>
  </TableManager>
</template>
<script>
import TableManager from '@/components/table/TableManager.vue';
import Field from './field.vue';
import api from '@/api/permission';
import GuardSelect from '@/components/GuardSelect.vue';
import { FormatString } from '@/utils/datetime';
import { HeaderFilterType } from '@/common/constant';

export default {
  components: {
    TableManager,
  },
  methods: {
    loadRouter() {
      api.updatePermisison().then(() => {
        this.$refs.manager.doFilter();
      });
    },
  },
  data() {
    return {
      manager: {
        icon: '<i class="bi bi-people-fill"></i> ',
        title: this.$t('permission.title'),
        field: Field,
        can: {
          store: 'permission.store',
          update: 'permission.update',
          destroy: 'permission.destroy',
        },
        table: {
          api,
          empty: this.$t('manager.empty'),
          rowStyle: (_, index) => {
            return index % 2 ? '' : '';
          },
          columns: [
            {
              title: '#',
              isIndex: true,
              isRaw: true,
              headerStyle: () => {
                return 'width:30px';
              },
              dataStyle: (_, index) => {
                return index % 2 ? '' : '';
              },
              dataFormat: (_, index) => {
                return index;
              },
            },
            {
              title: this.$t('permission.field.name'),
              field: 'name',
            },
            {
              title: this.$t('permission.field.title'),
              field: 'title',
            },
            {
              title: this.$t('permission.field.guard_name'),
              field: 'guard_name',
              filter_control: GuardSelect,
              isEqual: true,
            },
            {
              title: this.$t('permission.field.module_name'),
              field: 'module_name',
            },
            {
              title: this.$t('permission.field.created_at'),
              field: 'created_at',
              typeFilter: HeaderFilterType.RANGE_DATE,
              dataFormat: (data) => {
                return FormatString(data.created_at, 'YYYY-MM-DD HH:mm:ss');
              },
            },
          ],
        },
      },
    };
  },
};
</script>
