<template>
  <nav
    id="sidebar"
    class="sidebar js-sidebar bg-light"
    :class="this.min_sidebar?'min-sidebar':''"
  >
    <div
      class="sidebar-content"
      style="padding: 0px"
    >
      <a
        class="sidebar-brand"
        href="/"
      > <span
          class="align-middle"
          style="color:red;"
          v-if="this.min_sidebar"
        >AFX</span>
        <span
          class="align-middle"
          v-else
        >AdminFX</span>
      </a>

      <ul class="sidebar-nav fx-scroll">
        <li
          v-for="item in menuPermission"
          :class="checkMenuItemClass(item)"
          :key="item"
        >
          <h4 v-if="item.header">{{item.header}}</h4>
          <router-link
            v-else-if="item.router"
            class="sidebar-link border-bottom"
            :to="item.router"
          >
            <i
              class=" align-middle"
              :class="item.icon"
            ></i>
            <span class="align-middle">{{item.title}}</span>
          </router-link>
          <a
            v-else-if="item.link"
            class="sidebar-link  border-bottom"
            :href="item.link"
          >
            <i
              class=" align-middle"
              :class="item.icon"
            ></i>
            <span class="align-middle">{{item.title}}</span>
          </a>
          <div
            v-else-if="item.sub"
            class="sub-menu"
          >
            <div class="sidebar-link border-bottom">
              <i
                class="align-middle"
                :class="item.icon"
              ></i>
              <span class="align-middle">{{item.title}}</span>
            </div>
            <ul class="sidebar-sub">
              <li
                v-for="subItem in item.sub"
                :key="'sub-item'+subItem.id"
                :class="checkMenuItemClass(subItem)"
              >
                <router-link
                  class="sidebar-link border-bottom"
                  :to="subItem.router"
                >
                  <i
                    class=" align-middle"
                    :class="subItem.icon"
                  ></i>
                  <span class="align-middle">{{subItem.title}}</span>
                </router-link>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</template>
<script>

import { mapState } from 'vuex';

export default {
  methods: {
    checkPermission(item) {
      return (
        item.header
        || item.sub
        || (item.router && (!item.router.can || this.$can(item.router.can)))
      );
    },
    checkMenuItemClass(item) {
      if (item.header) {
        return 'sidebar-header';
      }
      if (item.router && this.$route.name === item.router.name) {
        return 'sidebar-item active';
      }
      if (item.sub) {
        return item.sub.filter((ite) => {
          return ite.router && (this.$route.name === ite.router.name);
        }).length > 0 ? 'sidebar-item active' : 'sidebar-item';
      }
      return 'sidebar-item';
    },
  },
  data() {
    return {
      menus: [
        {
          header: this.$t('setting.common.menu.system'),
        },
        {
          icon: 'bi bi-speedometer',
          title: this.$t('dashboard.title'),
          router: {
            name: 'Home',
          },
          link: '/',
        },
        {
          icon: 'bi bi-shield-fill',
          title: this.$t('setting.common.menu.security'),
          sub: [
            {
              icon: 'bi bi-people-fill',
              title: this.$t('user.title'),
              router: {
                name: 'User',
                can: 'user.index',
              },
              link: '/',
            },
            {
              icon: 'bi bi-shield-fill',
              title: this.$t('role.title'),
              router: {
                name: 'Role',
                can: 'role.index',
              },
              link: '/',
            },
            {
              icon: 'bi bi-shield-fill',
              title: this.$t('permission.title'),
              router: {
                name: 'Permission',
                can: 'permission.index',
              },
              link: '/',
            },
          ],
        },

      ],
    };
  },
  setup() {
  },

  computed: {
    ...mapState(['min_sidebar']),
    menuPermission() {
      return this.menus.filter((item) => this.checkPermission(item));
    },
  },
};
</script>
