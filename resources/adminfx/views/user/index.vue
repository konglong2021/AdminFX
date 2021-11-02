<template>
  <TableManager :configs="manager">
    <template v-slot:default>
      <userPermission
        v-if="isShowPermission"
        v-model:isShow="isShowPermission"
        v-model="userCurrent"
      />
    </template>
    <template v-slot:action_extend="item">
      <button
        v-if="$can(manager.can.permission)"
        class="btn btn-sm btn-info btn-action"
        @click="showPermission(item.data)"
      >
        <i class="bi bi-shield-fill"></i>
        {{$t('user.button.permission')}}
      </button>
    </template>
  </TableManager>
</template>
<script>
import TableManager from '@/components/table/TableManager.vue';
import Field from './field.vue';
import userPermission from './userPermission.vue';
import api from '@/api/user';
import { FormatString } from '@/utils/datetime';
import { HeaderFilterType } from '@/common/constant';

export default {
  components: {
    TableManager,
    userPermission,
  },
  methods: {
    showPermission(item) {
      this.isShowPermission = true;
      this.userCurrent = item;
      console.log(this.userCurrent);
    },
  },
  data() {
    return {
      userCurrent: null,
      isShowPermission: false,
      manager: {
        icon: '<i class="bi bi-people-fill"></i> ',
        title: this.$t('user.title'),
        field: Field,
        can: {
          store: 'user.store',
          update: 'user.update',
          destroy: 'user.destroy',
          permission: 'user.view-permission',
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
              isSort: true,
              isFilter: true,
              title: this.$t('user.field.name'),
              field: 'name',
            },
            {
              title: this.$t('user.field.email'),
              field: 'email',
            },
            {
              title: this.$t('user.field.created_at'),
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
