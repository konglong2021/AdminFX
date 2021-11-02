<template>
  <TableManager :configs="manager" />
</template>
<script>
import TableManager from '@/components/table/TableManager.vue';
import Field from './field.vue';
import api from '@/api/role';
import { FormatString } from '@/utils/datetime';
import { HeaderFilterType } from '@/common/constant';
import GuardSelect from '@/components/GuardSelect.vue';

export default {
  components: {
    TableManager,
  },
  data() {
    return {
      manager: {
        icon: '<i class="bi bi-people-fill"></i> ',
        title: this.$t('role.title'),
        field: Field,
        formSize: 'modal-lg',
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
              isSort: true,
              isFilter: true,
              title: this.$t('role.field.name'),
              field: 'name',
            },
            {
              title: this.$t('role.field.title'),
              field: 'title',
            },
            {
              title: this.$t('role.field.guard_name'),
              field: 'guard_name',
              filter_control: GuardSelect,
              isEqual: true,
            },
            {
              title: this.$t('role.field.created_at'),
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
