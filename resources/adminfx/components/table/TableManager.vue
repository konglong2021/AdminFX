<template>
  <div class="table-manager">
    <slot />
    <ModalFX
      :title="FormTitle"
      v-model:isShow="isEdit"
      :size='configs.formSize'
    >
      <component
        :is="configs?.field"
        :isNew="isNew"
        v-model:dataItem="DataUpdate"
      />
      <template v-slot:footer>
        <button
          type="button"
          class="btn btn-secondary"
          data-dismiss="modal"
          @click="closeUpdateForm"
        >{{$t('manager.button.cancel')}}</button>
        <button
          type="button"
          class="btn btn-primary"
          @click="updateForm"
        > {{$t('manager.button.update')}}</button>
      </template>
    </ModalFX>
    <ModalFX
      :title="$t('manager.message.text_form_delete',{ title: this.configs.title })"
      v-model:isShow="isShowDelete"
    >
      <h3>{{$t('manager.message.text_confirm_delete')}}</h3>
      <template v-slot:footer>
        <button
          type="button"
          class="btn btn-secondary"
          data-dismiss="modal"
          @click="isShowDelete=false"
        >{{$t('manager.button.btn_no')}}</button>
        <button
          type="button"
          class="btn btn-primary"
          @click="doDelete"
        > {{$t('manager.button.btn_yes')}}</button>
      </template>
    </ModalFX>
    <div class="table-header p-2">
      <div class="row">
        <div class="col">
          <h2 class="table-title">
            <span v-html="configs?.icon"></span>
            <span v-html="configs?.title"></span>
          </h2>
        </div>
      </div>
    </div>
    <div class="table-content">
      <div class="row p-2">
        <div class="col">
          <button
            v-if="(!configs.can || $can(configs.can.store))"
            class="btn btn-success btn-action"
            @click="showUpdateForm(null)"
          >
            <i class="bi bi-plus-square"></i>
            {{$t('manager.button.add')}}
          </button>
          <button
            class="btn btn-info btn-action"
            @click="resetAll()"
          >
            <i class="bi bi-arrow-repeat"></i>
            {{$t('manager.button.reset')}}
          </button>
          <slot name="button_action_extend"></slot>
        </div>
        <div class="col-auto">
          <input
            class="form-control"
            :placeholder="$t('manager.message.text_search')"
            v-model="dataQuery.search"
          />
        </div>
        <div class="col-auto">
          <button
            class="btn btn-primary"
            @click="doFilter"
          >
            <i class="bi bi-search"></i>
            {{$t('manager.button.search')}}
          </button>
        </div>
      </div>
      <table class="table">
        <thead class="bg-primary text-white">
          <tr>
            <th
              scope="col"
              v-for="item in columns"
              :key="item"
              :style="item.headerStyle?item.headerStyle():''"
            >
              <ColumnHeader :column="item" />
            </th>
            <th
              v-if="action"
              :style="table.headerActionStyle?table.headerActionStyle():''"
            >
              {{$t('manager.message.text_action')}}
            </th>
          </tr>
        </thead>
        <tbody v-if="dataList&&dataList.length>0">
          <tr
            v-for="(data,index) in dataList"
            :key="'row-'+getRowIndex(index)"
            :style="table.rowStyle?table.rowStyle(data,getRowIndex(index)):''"
          >
            <th
              scope="row"
              v-for="item in columns"
              :key="item"
              :style="item.dataStyle?item.dataStyle(data,getRowIndex(index)):''"
              @dblclick="showUpdateForm(data)"
            >
              <span
                v-if="item.dataFormat&&item.isRaw"
                v-html="item.dataFormat(data,getRowIndex(index))"
              ></span>
              <span v-else-if="item.dataFormat&&!item.isRaw">
                {{item.dataFormat(data,getRowIndex(index))}}
              </span>
              <span v-else-if="item.isIndex">
                {{getRowIndex(index)}}
              </span>
              <span v-else>
                {{data[item.field]}}
              </span>
            </th>
            <!--Action-->
            <th v-if="action">
              <button
                v-if="(!configs.can || $can(configs.can.update))"
                class="btn btn-sm btn-primary btn-action"
                @click="showUpdateForm(data)"
              >
                <i class="bi bi-pencil-square"></i>
                {{$t('manager.button.edit')}}
              </button>
              <button
                v-if="(!configs.can || $can(configs.can.destroy))"
                class="btn btn-sm btn-danger btn-action"
                @click="showConfirnDelete(data)"
              >
                <i class="bi bi-dash-square"></i>
                {{$t('manager.button.delete')}}
              </button>
              <slot
                name="action_extend"
                :data="data"
                :index="index"
              />
            </th>
            <!--Action-->
          </tr>
        </tbody>
        <tbody v-else>
          <tr>
            <th
              :colspan="columns.length+1"
              class="text-center text-bold"
            >{{table.empty}}</th>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="table-footer p-4">
      <div class="row">
        <div
          class="col-auto p-1"
          v-if="dataList&&dataList.length>0"
        >
          <select
            class="form-select"
            v-model="this.dataQuery.per_page"
            @change="pageSizeChange($event)"
          >
            <option
              v-for="item in pages"
              :key="item"
              :value="item"
            >{{item}}</option>
          </select>
        </div>
        <div
          class="col-auto p-1"
          v-if="dataList&&dataList.length>0"
        >
          <ul class="pagination">
            <li class="page-item">
              <button
                :disabled="dataQuery.page==1"
                class="page-link"
                v-on:click="pagePrevious()"
              >
                &laquo; Previous
              </button>
            </li>
            <li
              class="page-item"
              v-for="(item) in links"
              :class="item.label==dataQuery.page?'active':''"
              :key="item"
            >
              <button
                :disabled="item.url==null"
                class="page-link"
                v-html="item.label"
                v-on:click="pageIndex(item.label)"
              ></button>
            </li>
            <li class="page-item">
              <button
                :disabled="dataQuery.page==lastPage"
                class="page-link"
                v-on:click="PageNext()"
              >
                Next &raquo;
              </button>
            </li>
          </ul>
        </div>
        <div class="col">
          <slot name="footer_extend"></slot>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import ColumnHeader from '@/components/table/ColumnHeader.vue';
import ModalFX from '@/components/common/ModalFX.vue';
import objUtils from '@/utils/object';

export default {
  props: {
    configs: null,
  },
  components: {
    ColumnHeader,
    ModalFX,
  },
  data() {
    return {
      pages: [10, 15, 25, 50, 100],
      isEdit: false,
      isNew: false,
      DataUpdate: {},
      FormTitle: '',
      dataList: [],
      total: 0,
      rowFrom: 1,
      lastPage: 0,
      links: [],
      isShowDelete: false,
      dataQuery: {
        page: 1,
        per_page: 10,
        filter: {},
        sort: {},
      },
    };
  },
  computed: {
    action() {
      if (this.configs.isAction === undefined && this.configs.can !== undefined) {
        const arrCan = Object.values(this.configs.can);
        const canActions = arrCan.filter((item) => item !== this.configs.can.store);
        console.log(canActions);
        return this.$can(canActions);
      }
      return this.configs.isAction === undefined || this.configs.isAction;
    },
    table() {
      return this.configs.table;
    },
    api() {
      return this.table.api;
    },
    columns() {
      return this.table.columns;
    },
  },
  methods: {
    resetAll() {
      this.dataQuery = {
        page: 1,
        per_page: 10,
        filter: {},
        sort: {},
      };
      this.doFilter();
    },
    loadData() {
      this.api.getAll(this.dataQuery).then((rs) => {
        const {
          data, links, total, from, last_page: lastPage,
        } = rs.data.data;

        this.dataList = data;
        this.total = total;
        this.rowFrom = from;
        this.lastPage = lastPage;
        links.shift();
        links.pop();
        this.links = links;
      }).catch(() => {
        this.links = [];
        this.dataList = [];
      });
    },
    doFilter() {
      this.pageIndex(1);
    },
    pageIndex(item) {
      if (item !== '...') {
        this.dataQuery.page = parseInt(item, 10);
        this.loadData();
      }
    },
    pagePrevious() {
      if (this.dataQuery.page > 1) {
        this.dataQuery.page = parseInt(this.dataQuery.page, 10) - 1;
        this.loadData();
      }
    },
    PageNext() {
      if (this.dataQuery.page < this.lastPage) {
        this.dataQuery.page = parseInt(this.dataQuery.page, 10) + 1;
        this.loadData();
      }
    },
    pageSizeChange($e) {
      this.dataQuery.per_page = $e.target.value;
      this.doFilter();
    },
    getRowIndex(index) {
      return this.rowFrom + index;
    },
    showConfirnDelete(data) {
      this.isShowDelete = true;
      this.DataUpdate = objUtils.Clone(data);
    },
    doDelete() {
      this.api.remove(this.getId(this.DataUpdate)).then(() => {
        this.isShowDelete = false;
        this.doFilter();
      }).catch((error) => {
        console.log(error);
      });
    },
    getId(data) {
      return this.configs.getId ? this.configs.getId(data) : data.id;
    },
    closeUpdateForm() {
      this.isEdit = false;
    },
    showUpdateForm(data) {
      this.isEdit = true;
      this.isNew = data === null;
      this.FormTitle = this.isNew ? this.$t('manager.message.text_form_add', { title: this.configs.title }) : this.$t('manager.message.text_form_edit', { title: this.configs.title });
      this.DataUpdate = this.isNew ? {} : objUtils.Clone(data);
    },
    updateForm() {
      if (this.isNew) {
        this.api.add(this.DataUpdate).then(() => {
          this.closeUpdateForm();
          this.doFilter();
        }).catch((error) => {
          console.log(error);
        });
      } else {
        this.api.edit(this.getId(this.DataUpdate), this.DataUpdate).then(() => {
          this.closeUpdateForm();
          this.doFilter();
        }).catch((error) => {
          console.log(error);
        });
      }
    },
  },
  mounted() {
    this.loadData();
  },
};
</script>
