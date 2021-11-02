<template>
  <div class="column-header">
    <span>{{column.title}} <span v-if="CacheFilterValue">[{{CacheFilterValue}}]</span></span>
    <div
      class="column-action"
      v-if="!column.isIndex"
    >
      <span v-if="!(column.isSort===false)">
        <i
          class="bi bi-sort-up-alt"
          @click="doSort(0)"
          v-if="dataQuery.sort[this.column.field]"
        ></i>
        <i
          class="bi bi-sort-down-alt"
          @click="doSort(1)"
          v-else
        ></i>
      </span>

      <i
        class="bi bi-filter"
        v-if="!(column.isFilter===false)"
        @click="isFilter=!isFilter"
      ></i>
    </div>
    <div
      class="column-filter"
      v-if="isFilter"
    >

      <div class="row p-2 text-primary">
        <div class="col">
          <label class="pb-2">{{$t('manager.message.text_filter',{'title':column.title})}}</label>
          <component
            v-if="column.filter_control"
            :is="column.filter_control"
            v-model="FilterValue"
          />
          <InputFX
            v-else
            :type="FilterType"
            v-model="FilterValue"
          />
        </div>
      </div>
      <div class="row">
        <div class="col">
          <button
            class="btn btn-primary w-100"
            @click="doFilter()"
          >{{$t('manager.button.apply')}}</button>
        </div>
        <div class="col">
          <button
            class="btn btn-danger w-100"
            @click="doCancel()"
          >{{$t('manager.button.cancel')}}</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import InputFX, { InputType } from '@/components/common/InputFX.vue';
import objUtls from '@/utils/object';

export default {
  props: {
    column: null,
    isEqual: null,
  },
  components: {
    InputFX,
  },
  computed: {
    dataQuery() {
      return this.$parent.dataQuery;
    },
    FilterType() {
      return InputType.text;
    },
  },
  data() {
    return {
      isFilter: false,
      FilterValue: null,
      CacheFilterValue: null,
    };
  },
  methods: {
    doFilter() {
      delete this.dataQuery.filter[this.column.field];
      if (this.FilterValue !== null && this.FilterValue !== '') {
        if (this.isEqual) {
          this.dataQuery.filter[this.column.field] = {
            equal: this.FilterValue,
          };
        } else {
          this.dataQuery.filter[this.column.field] = {
            like: this.FilterValue,
          };
        }
      }
      this.CacheFilterValue = objUtls.Clone(this.FilterValue);
      this.isFilter = false;
      this.$parent.doFilter();
    },
    doCancel() {
      this.FilterValue = objUtls.Clone(this.CacheFilterValue);
      this.isFilter = false;
    },
    doSort(sort) {
      this.dataQuery.sort = {};
      this.dataQuery.sort[this.column.field] = sort;
      this.$parent.doFilter();
    },
  },
  setup() {

  },
  watch: {
    dataQuery: {
      handler(val, oldVal) {
        if (oldVal.filter[this.column.field] !== undefined
          && val.filter[this.column.field] === undefined
          && this.CacheFilterValue !== undefined) {
          this.CacheFilterValue = null;
          this.FilterValue = null;
        }
      },
      deep: true,
    },
  },
};
</script>
